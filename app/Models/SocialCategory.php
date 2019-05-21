<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialCategory extends Model
{
    use SoftDeletes, Translatable;
    protected $table = 'social_category';
    protected $fillable = ['image'];
    protected $hidden = ['createdBy', 'translations', 'created_at', 'updated_at', 'deleted_at', 'status'];
    public $translatedAttributes = ['title'];

    public function scopePublic($query, $isActive = 'active', $orderBy = 'asc')
    {
        return $query->where(['status' => $isActive])->orderBy('order_by', $orderBy);
    }

    public function getImageAttribute($value)
    {
        return url($value);
    }

    public function accounts()
    {
        return $this->hasMany(SocialAccount::class, 'social_category_id', 'id');
    }
}
