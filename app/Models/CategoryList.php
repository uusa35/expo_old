<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryList extends Model
{
    use SoftDeletes;
    protected $fillable = ['category_id', 'user_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];


}
