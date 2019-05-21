<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CafeRating extends Model
{
    protected $fillable = ['cafe_id', 'value','ip_address'];
    protected $hidden = [ 'ip_address','updated_at','deleted_at'];
    protected $appends = ['user'];


    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

}
