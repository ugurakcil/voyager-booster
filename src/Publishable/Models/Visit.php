<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Visit extends Model
{
    protected $fillable = ['ip', 'created_at', 'visitable_id', 'visitable_type'];
    protected $dates = ['created_at'];
}
