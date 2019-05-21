<?php

namespace App\Http\Controllers\API;

use App\Models\ClothingType;
use App\Models\Category;
use App\Models\CategoryList;
use App\Models\Product;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClothingTypeController extends Controller
{
    public function index()
    {
        $data = ClothingType::query()->public()->get();
        return mainResponse(true, 'api.ok', $data, []);
    }
}
