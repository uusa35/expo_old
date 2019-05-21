<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alert extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $appends = ['image'];

    public function getImageAttribute(){

        return User::find($this->object_id)->image;
    }

}
