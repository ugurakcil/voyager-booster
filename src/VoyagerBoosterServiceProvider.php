<?php
namespace UgurAkcil\VoyagerBooster;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use UgurAkcil\VoyagerBooster\Facades\FrontRecursiveCategories as FacadesFrontRecursiveCategories;
use UgurAkcil\VoyagerBooster\Facades\VoyagerCustom as FacadesVoyagerCustom;
use UgurAkcil\VoyagerBooster\Facades\VoyagerRecursiveCategories as FacadesVoyagerRecursiveCategories;
use UgurAkcil\VoyagerBooster\Http\Middleware\Locale;
use UgurAkcil\VoyagerBooster\Libraries\FrontRecursiveCategories;
use UgurAkcil\VoyagerBooster\Libraries\VoyagerCustom;
use UgurAkcil\VoyagerBooster\Libraries\VoyagerRecursiveCategories;

class VoyagerBoosterServiceProvider extends ServiceProvider
{
    /**
     * The path is src's full directory address of the package.
     *
     * @var string
     */
    protected $srcPath;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->srcPath = dirname(__DIR__).'/src';

        $loader = AliasLoader::getInstance();
        $loader->alias('VoyagerRecursiveCategories', FacadesVoyagerRecursiveCategories::class);

        $this->app->singleton('VoyagerRecursiveCategories', function () {
            return new VoyagerRecursiveCategories();
        });

        $loader->alias('FrontRecursiveCategories', FacadesFrontRecursiveCategories::class);

        $this->app->singleton('FrontRecursiveCategories', function () {
            return new FrontRecursiveCategories();
        });

        $loader->alias('VoyagerCustom', FacadesVoyagerCustom::class);

        $this->app->singleton('VoyagerCustom', function () {
            return new VoyagerCustom();
        });

        // $this->registerConfigs();
        $this->loadHelpers();
        $this->registerPublishableResources();
    }

    /**
     * Bootstrap the application services.
     *
     * @param \Illuminate\Routing\Router $router
     */
    public function boot(Router $router, Kernel $kernel)
    {
        $kernelMake = app()->make(Kernel::class);
        $kernelMake->pushMiddleware(Locale::class);

        $this->loadMigrationsFrom("{$this->srcPath}/database/migrations");
        $this->loadViewsFrom("{$this->srcPath}/views", 'voyagerbooster');
    	$this->loadRoutesFrom("{$this->srcPath}/routes.php");
    }

    /**
     * Load helpers.
     */
    protected function loadHelpers()
    {
        foreach (glob($this->srcPath . '/Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }

    /**
     * Register the publishable files.
     */
    private function registerPublishableResources()
    {
        $publishable = [
            'controllers' => [
                "{$this->srcPath}/Publishable/Controllers/" => app_path('Http/Controllers'),
            ],
            'models' => [
                "{$this->srcPath}/Publishable/Models/" => app_path('Models'),
            ],
            'traits' => [
                "{$this->srcPath}/Publishable/Traits/" => app_path('Traits'),
            ],
        ];

        foreach ($publishable as $group => $paths) {
            $this->publishes($paths, $group);
        }
    }

    /*
    * Merge the config files
    */
    public function registerConfigs()
    {
        $this->mergeConfigFrom(
            $this->srcPath.'/Publishable/config/voyagerbooster.php',
            'voyagerbooster'
        );
    }
}
