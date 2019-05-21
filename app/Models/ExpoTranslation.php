<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpoTranslation extends Model
{
    use  SoftDeletes;
    public $fillable = ['name'];
}
