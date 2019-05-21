<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WishList extends Model
{
    use SoftDeletes;
    protected $fillable = ['product_id', 'user_id'];
    protected $hidden = ['pivot','created_at', 'updated_at', 'deleted_at', 'status'];

   
   public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

}


