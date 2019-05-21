<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CareerApply extends Model
{
    use  SoftDeletes;
    protected $table = 'career_apply';
    protected $fillable = ['fullname', 'email', 'career_id', 'mobile', 'file'];

    public function career()
    {
        return $this->belongsTo(Career::class, 'career_id', 'id');
    }

    public function getFileAttribute($value)
    {
        return url($value);
    }


}
