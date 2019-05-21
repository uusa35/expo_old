<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialAccount extends Model
{
    use SoftDeletes;
    protected $table = 'social_accounts';
    protected $fillable = ['image', 'bio', 'title', 'social_category_id'];
    protected $hidden = ['createdBy', 'created_at', 'updated_at', 'deleted_at', 'status', 'order_by'];

    public function scopePublic($query, $isActive = 'active', $orderBy = 'asc')
    {
        return $query->where(['status' => $isActive])->orderBy('order_by', $orderBy);
    }

    public function getImageAttribute($value)
    {
        return url($value);
    }

}
