<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductOccasion extends Model
{
    use SoftDeletes;
    protected $fillable = ['product_id','occasion_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];    
}


