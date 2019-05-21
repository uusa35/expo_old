<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = [
        'id' => 'integer',
        'sender_id' => 'integer',
        'receiver_id' => 'integer',
    ];

    public function getImageAttribute($value)
    {
        if($value != null){
            return url($value);
        }else{
            return "";
        }

    }
    
    public function getVideoAttribute($value)
    {
        if($value != null){
            return url($value);
        }else{
            return "";
        }

    }
    
}
