<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentProcess extends Model
{
    use SoftDeletes;
    protected $fillable = ['transaction', 'package_id','user_id'];
    protected $hidden = ['created_at'];
    public $table='payment_process';
}