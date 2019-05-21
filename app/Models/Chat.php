<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use SoftDeletes;
    public $table = 'chats';
    protected $fillable = ['user_id','message','relation_id','read_at'];

     protected $appends = ['user_name'];
    
    
    public function getUserNameAttribute()
	{
	  return \App\User::where('id',$this->user_id)->pluck('name')->first();
	
	}
}




Route::get('/chat_user', 'WEB\Admin\HomeController@chat_all_user')->name('chat_user.all');
Route::get('/new_message/{id}/response', 'WEB\Admin\HomeController@new_message')->name('new_message.response');
Route::post('/new_message', 'WEB\Admin\HomeController@new_message_admin')->name('new_message');