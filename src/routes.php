<?php
use UgurAkcil\VoyagerBooster\VoyagerBoosterController;

Route::get(
    '/voyager-booster',
    [VoyagerBoosterController::class, 'index']
)->name('voyager-booster');

