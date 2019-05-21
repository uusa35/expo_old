<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class MessageContact extends Model
{
    protected $table = 'message_contacts';
    protected $fillable = ['sender_id', 'receiver_id'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
