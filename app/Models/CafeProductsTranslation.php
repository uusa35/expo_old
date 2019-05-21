<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CafeProductsTranslation extends Model
{
    use  SoftDeletes;
    public $fillable = ['title', 'details'];
}
