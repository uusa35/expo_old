<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Field;


class FieldController extends Controller
{
    public function index()
    {
        $data = Field::query()->get();
        return mainResponse(true, 'api.ok', $data, []);
    }
}
