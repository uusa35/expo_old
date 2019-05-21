<?php

namespace App\Http\Controllers\API;

use App\Models\Alert;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class AlertController extends Controller
{
    public function index()
    {
        $data = Alert::query()->orderByDesc('id')->where('user_id', Auth::id())->get();
        return mainResponse(true, 'api.ok', $data, []);
    }
}
