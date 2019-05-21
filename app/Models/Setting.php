<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $primaryKey = 'key';
    public $incrementing = false;
    public $timestamps = false;
    public $guarded = [];

    protected $hidden = ['allow'];

}
