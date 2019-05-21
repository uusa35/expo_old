<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationMessage extends Model
{
    use SoftDeletes ;
    public $table = 'notification_message';
    protected $fillable = ['message'];
    protected $hidden = ['created_at','updated_at','deleted_at'];

}
