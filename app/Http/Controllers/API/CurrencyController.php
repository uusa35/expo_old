<?php

namespace App\Http\Controllers\API;

use App\Models\Currency;
use App\Models\Category;
use App\Models\CategoryList;
use App\Models\Product;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CurrencyController extends Controller
{
    public function index()
    {
        $data = Currency::query()->public()->get();
        return mainResponse(true, 'api.ok', $data, []);
    }
}
