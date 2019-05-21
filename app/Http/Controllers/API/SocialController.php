<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use App\Models\CategoryList;
use App\Models\Product;
use App\Models\SocialCategory;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    public function index()
    {
        $twitter = SocialCategory::query()->public()->where('id',1)->with('accounts')->get();
        $snapChat = SocialCategory::query()->public()->where('id',2)->with('accounts')->get();
        $instagram  = SocialCategory::query()->public()->where('id',3)->with('accounts')->get();
        $data = ['twitter'=>$twitter,'snapChat'=>$snapChat,'instagram'=>$instagram];
        return mainResponse(true, 'api.ok', $data, []);
    }


}
