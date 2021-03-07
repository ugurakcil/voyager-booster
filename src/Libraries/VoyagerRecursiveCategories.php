<?php
namespace UgurAkcil\VoyagerBooster\Libraries;

class VoyagerRecursiveCategories{
    private $originalCategories = [];
    private $recursiveCategories = [];

    public function setOriginalCategories($categories){
        $this->originalCategories = $categories;
    }

    public function getRecursiveCategories(){
        return $this->recursiveCategories;
    }

    public function getRecursive($parentID = null, $level = -1){
        $level++;

        foreach($this->originalCategories as $catKey => $catRow){
            if($catRow->parent_id === $parentID){
                $this->recursiveCategories[$catRow->id] = $catRow;
                $this->recursiveCategories[$catRow->id]->name = str_repeat('-', $level).' '.$this->recursiveCategories[$catRow->id]->name;
                $this->recursiveCategories[$catRow->id]->level = $level;
                $this->getRecursive($catRow->id, $level);
            }
        }
    }

    public function generate($categories){
        $this->setOriginalCategories($categories);
        $this->getRecursive();

        return $this->getRecursiveCategories();
    }
}
