<?php

namespace App\Http\Controllers\API;

use App\Models\Setting;
use App\Models\Category;
use App\Models\CategoryList;
use App\Models\Product;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function index(Request $request)
    {
    	//var_dump($request->header('Accept-Language'));exit;
    	 if($request->header('Accept-Language')=='ar'){
         $about = Setting::query()->where('key','about_ar')->first();
         $terms = Setting::query()->where('key','terms_ar')->first();
         $privacy = Setting::query()->where('key','privacy_ar')->first();
         }else{
         $about = Setting::query()->where('key','about_en')->first();
         $terms = Setting::query()->where('key','terms_en')->first();
         $privacy = Setting::query()->where('key','privacy_en')->first();
         }
         $data['about']=strip_tags($about->value);
         $data['terms']=strip_tags($terms->value);
         $data['privacy']=strip_tags($privacy->value);
         $data['social'] = Setting::query()->where('allow','yes')->pluck('value', 'key');
        return mainResponse(true, 'api.ok', $data, []);
    }

  
    
}
