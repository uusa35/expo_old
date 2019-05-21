<?php

namespace App\Http\Controllers\API;

use App\Models\Setting;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
  
    public function index()
    {
        $data = Setting::query()->where('allow','yes')->get();
        return mainResponse(true, 'api.ok', $data, []);
    }
}
