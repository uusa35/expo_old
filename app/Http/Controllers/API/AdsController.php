<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use App\Http\Controllers\Controller;


class AdsController extends Controller
{
    public function index()
    {
        $data = Category::query()->public()->get();
        return mainResponse(true, 'api.ok', $data, []);
    }
}
