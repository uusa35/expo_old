<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductMaterial extends Model
{
    use SoftDeletes;
    protected $fillable = ['product_id','material_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];    
}


