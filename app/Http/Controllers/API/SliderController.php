<?php

namespace App\Http\Controllers\API;

use App\Models\ExpoCountry;
use App\Models\Expo;
use App\Models\Slider;
use App\Models\Category;
use App\Models\CategoryList;
use App\Models\Product;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SliderController extends Controller
{
  
    public function index()
    {
        $data['slider'] = Slider::query()->public()->get();
        $data['expo'] = Expo::query()->public()->take(12)->get();
    	//$data['business'] = Expo::query()->public()->where('type_id',2)->get();
        return mainResponse(true, 'api.ok', $data, []);
    }


    public function home($country_id,Request $request)
    {
    	$items = ExpoCountry::query(); 
        if (!empty($country_id)) {
            if ($country_id != null)
                $items->where('country_id', $country_id);
        }
        $items = $items->get();
        $in=array();
        if(!empty($items)){
            foreach($items as $item){
                $in[]=$item->expo_id;
            }
        }else{
            $in=null;
        }
        $expo = Expo::query()->whereIn('id',$in)->Orwhere('country_id',$country_id)->Orwhere('in_slider',1)->public();
        $data['expo'] = $expo->where('type_id',1)->orderBy('id','desc')->take(6)->get();
        $business = Expo::query()->whereIn('id',$in)->Orwhere('country_id',$country_id)->Orwhere('in_slider',1)->public();
        $data['business'] = $business->where('type_id',2)->orderBy('id','desc')->take(6)->get();
        $data['slider'] = Slider::query()->public()->get();
        return mainResponse(true, 'api.ok', $data, []);
    }


}
