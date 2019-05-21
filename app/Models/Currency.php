<?php

namespace App\Models;
use App\User;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use SoftDeletes, Translatable;
    protected $fillable = ['name', 'order_by', 'createdBy'];
    public $translatedAttributes = ['name'];
    protected $hidden = ['createdBy', 'translations', 'created_at', 'updated_at', 'deleted_at', 'status'];

public function scopePublic($query, $isActive = 'active', $orderBy = 'asc')
    {
        return $query->where(['status' => $isActive])->orderBy('order_by', $orderBy);
    }
    
 public function user()
    {
        return $this->belongsTo(User::class, 'createdBy', 'id');
    }
}
