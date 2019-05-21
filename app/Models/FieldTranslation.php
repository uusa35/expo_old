<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FieldTranslation extends Model
{
    use SoftDeletes;
    public $fillable = ['title'];
}
