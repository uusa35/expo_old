<?php

namespace App\Http\Controllers\API;

use App\Models\Color;
use App\Models\ClothingType;
use App\Models\Occasion;
use App\Models\Size;
use App\Models\Category;
use App\Models\CategoryList;
use App\Models\Product;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SizeController extends Controller
{
  
    public function index()
    {
        $data = Size::query()->public()->get();
        return mainResponse(true, 'api.ok', $data, []);
    } 

    public function getFilters()
    {
        $data['sizes'] = Size::query()->public()->get();
        $data['occasions'] = Occasion::query()->public()->get();
        $data['clothings'] = ClothingType::query()->public()->get();
        $data['colors'] = Color::query()->public()->get();
        return mainResponse(true, 'api.ok', $data, []);
    }


}
