<?php

namespace App\Http\Controllers\API;

use App\Models\Material;
use App\Models\Category;
use App\Models\CategoryList;
use App\Models\Product;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
  
    public function index()
    {
        $data = Material::query()->public()->get();
        return mainResponse(true, 'api.ok', $data, []);
    }

   

   

    // public function getCategoryForUser()
    // {
    //     return $user = Auth::guard('api')->user()->categories;

    // }


}
