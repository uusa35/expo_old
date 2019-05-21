<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Seeker extends Model
{
    protected $fillable = ['user_id', 'field_id', 'publish_type_id', 'year_experience', 'file','bio','name'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function field()
    {
        return $this->belongsTo(Field::class, 'field_id', 'id');
    }

    public function publish()
    {
        return $this->belongsTo(Publish::class, 'publish_type_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getFileAttribute($value)
    {
        return url($value);
    }


}
