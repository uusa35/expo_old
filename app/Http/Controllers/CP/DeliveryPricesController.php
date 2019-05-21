<?php

namespace App\Http\Controllers\CP;
use App\Models\ExpoCountry;
use App\Models\Expo;
use App\Models\Country;

use App\Models\DeliveryPrice;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DeliveryPricesController extends Controller
{
    public function __construct()
    {
        $this->locales = Language::all();
        $this->settings = Setting::query()->where('key', 'per_page')->select(['value'])->first();
        view()->share([
            'locales' => $this->locales,
            'settings' => $this->settings,

        ]);
    }

    public function index(Request $request)
    {
        $exp= Expo::query()->where('user_id',Auth::id())->first();
        $items = DeliveryPrice::query()->where('expo_id',$exp->id);
        if ($request->has('name')) {
            if ($request->get('name') != null)
                $items->whereHas('translations', function ($query) use ($request) {
                    $query->where('locale', app()->getLocale())
                        ->where('name', 'like', '%' . $request->get('name') . '%');
                });
        }
        $items = $items->orderBy('id', 'desc')->paginate($this->settings->value);
        return view('cp.prices.home', [
            'items' => $items,
        ]);
    }

    public function create()
    {
     $item= Expo::query()->where('user_id',Auth::id())->first();
     $ex_countries = ExpoCountry::where('expo_id',$item->id)->get(['country_id']);
     $in = array();
     foreach($ex_countries as $country){
     $in[]=$country->country_id;
     }
     $list= array_unique($in);
     $countries = Country::whereIn('id',$list)->get();
          return view('cp.prices.create', [
            'countries' => $countries,
            'expo_id' => $item->id,
        ]);
    }

    public function store(Request $request)
    {
         $roles = [
            'country_id' => 'numeric|required',
            'price' => 'numeric|required',
            'expo_id' => 'numeric|required',
        ];
        $this->validate($request, $roles);
        $expo_id=$request->expo_id;
        $country_id=$request->country_id;
        $price=$request->price;
        $found= DeliveryPrice::query()->where('expo_id',$expo_id)->where('country_id',$country_id)->first();
	if(empty($found)){
	$item = new DeliveryPrice();
        $item->country_id=$country_id;
        $item->expo_id=$expo_id;
        $item->price=$price;
        $item->save();
	}else{
	 $item = DeliveryPrice::query()->where('id',$found->id)->firstOrFail();
         $item->price=$price;
         $item->save();
	}
        
        return redirect()->back()->with('status', __('common.create'));
    }
    public function show($id)
    {
        return DeliveryPrice::query()->findOrFail($id);
    }
    public function edit($id)
    {
        $item = $this->show($id);
        return view('cp.prices.edit', [
            'item' => $item,
        ]);
    }
    public function update(Request $request, $id)
    {
         $roles = [
            'price' => 'numeric|required',
        ];
        $this->validate($request, $roles);
        $item = DeliveryPrice::query()->where('id', $id)->firstOrFail();
       
        $item->price=$request->price;
        $item->save();
        return redirect()->back()->with('status', __('common.update'));
    }

    public function destroy($id)
    {
        $item = DeliveryPrice::query()->findOrFail($id);
        if ($item) {
            DeliveryPrice::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }

    public function changeStatus(Request $request)
    {
        if ($request->event == 'delete') {
            DeliveryPrice::query()->whereIn('id', $request->IDsArray)->delete();
        }else {
            DeliveryPrice::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);
        }
        return $request->event;
    }
}
