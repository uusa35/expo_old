<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Publish;


class PublishController extends Controller
{
    public function index()
    {
        $data = Publish::query()->get();
        return mainResponse(true, 'api.ok', $data, []);
    }
}
