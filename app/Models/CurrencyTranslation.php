<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurrencyTranslation extends Model
{
    use SoftDeletes;
    public $fillable = ['name'];
}
