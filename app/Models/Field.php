<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Field extends Model
{
    use SoftDeletes, Translatable;
    public $translatedAttributes = ['title'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'translations'];
}
