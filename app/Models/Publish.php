<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publish extends Model
{
    use SoftDeletes;
    protected $table = 'publish_type';
    protected $fillable = ['points', 'title'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
