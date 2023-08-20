<?php

namespace App\Http\Controllers\Admin\FormFields;

use TCG\Voyager\FormFields\AbstractHandler;

class BulkListFormField extends AbstractHandler
{
    protected $codename = 'bulk_list';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('vendor.voyager.formfields.bulk_list', [
            'row' => $row,
            'options' => $options,
            'dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent
        ]);
    }
}