<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CareerTranslation extends Model
{
    use  SoftDeletes;
    protected $fillable = ['company_title', 'job_title', 'details'];
}
