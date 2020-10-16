<?php
namespace UgurAkcil\VoyagerBooster\Libraries;

class FrontRecursiveCategories{
    private $originalCategories = [];
    private $recursiveCategories = [];
    private $categoryMap = [];
    private $breadCrumbCats = [];

    public function init(){
        $this->originalCategories = [];
        $this->recursiveCategories = [];
        $this->categoryMap = [];
        $this->breadCrumbCats = [];
    }

    public function setOriginalCategories($categories){
        $this->originalCategories = $categories;
    }

    public function getRecursiveCategories(){
        return $this->recursiveCategories;
    }

    public function getRoots(){
        return $this->categoryMap['root'];
    }

    public function getMap(){
        return $this->categoryMap;
    }

    public function createRecursive($parentID = null, $level = -1){
        $level++;

        foreach($this->originalCategories as $catKey => $catRow){
            if($catRow->parent_id === $parentID){
                $this->recursiveCategories[$catRow->id] = $catRow;
                $this->recursiveCategories[$catRow->id]->level = $level;

                $mapParentID = ($parentID === null) ? 'root': $parentID;

                if(! isset($this->categoryMap[$mapParentID]))
                    $this->categoryMap[$mapParentID] = [];

                $this->categoryMap[$mapParentID][$catRow->id] = $this->recursiveCategories[$catRow->id];

                $this->createRecursive($catRow->id, $level);
            }
        }
    }

    public function getTemplate($routeName, $routeParameters = []){
        return $this->createTemplateNode('root', $routeName, $routeParameters);
    }

    private function createTemplateNode($parentID = 'root', $routeName = 'categories', $routeParameters = []){
        $template = '<ul>';
        foreach($this->categoryMap[$parentID] as $el){
            $template .= '<li>';

            $routeData = [];
            foreach($routeParameters as $param){
                $routeData[$param] = $el[$param];
            }

            $template .= '<a href="'.route($routeName, $routeData).'" title="'.$el->name.'">'.$el->name.'</a>';

            if(isset($this->categoryMap[$el->id]) && count($this->categoryMap[$el->id]) >= 1){
                $template .= $this->createTemplateNode($el->id, $routeName, $routeParameters);
            }

            $template .= '</li>';
        }
        $template .= '</ul>';

        return $template;
    }

    public function breadcrumb($categoryID, $categories = []){
        if($categories > 1)
            $this->breadCrumbCats = $categories;
        else
            $this->breadCrumbCats = $this->recursiveCategories;

        return array_reverse($this->createBreadcrumb($categoryID));
    }

    private function createBreadcrumb($categoryID, $breadcrumb = []){
        $breadcrumb[] = $this->breadCrumbCats[$categoryID];

        if($this->breadCrumbCats[$categoryID]->parent_id !== null){
            return $this->createBreadcrumb($this->breadCrumbCats[$categoryID]->parent_id, $breadcrumb);
        }

        return $breadcrumb;
    }

    public function generate($categories){
        $this->init();
        $this->setOriginalCategories($categories);
        $this->createRecursive();

        return $this;
    }
}

// Uğur AKÇIL
