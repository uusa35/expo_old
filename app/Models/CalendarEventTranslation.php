<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CalendarEventTranslation extends Model
{
    use  SoftDeletes;
    public $fillable = ['title'];
}
