<?php

namespace App\Http\Controllers\API;

use App\Models\Occasion;
use App\Models\Category;
use App\Models\CategoryList;
use App\Models\Product;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OccasionController extends Controller
{
    public function index()
    {
        $data = Occasion::query()->public()->get();
        return mainResponse(true, 'api.ok', $data, []);
    }
}
