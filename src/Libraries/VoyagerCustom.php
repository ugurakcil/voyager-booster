<?php
namespace UgurAkcil\VoyagerBooster\Libraries;

class VoyagerCustom{
    public function test(){
        return 2 * 3 . ' : TEST COMPLETED';
    }

    public function findFieldRelation($fields, $baseCategoryName){
        foreach($fields as $field) {
            if(isset($field->details->column) && $field->details->column = $baseCategoryName){
                return $field->field;
            }
        }
        return false;
    }
}
