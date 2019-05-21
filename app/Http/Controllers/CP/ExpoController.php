<?php

namespace App\Http\Controllers\CP;

use App\User;
use App\Models\City;
use App\Models\Category;
use App\Models\ExpoCategory;
use App\Models\ExpoCountry;
use App\Models\Expo;
use App\Models\Country;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ExpoController extends Controller
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
        $items = Expo::query();
        if ($request->has('name')) {
            if ($request->get('name') != null)
                $items->whereHas('translations', function ($query) use ($request) {
                    $query->where('locale', app()->getLocale())
                        ->where('name', 'like', '%' . $request->get('name') . '%');
                });
        }
        if ($request->has('status')) {
            if ($request->get('status') != null)
                $items->where('status', $request->get('status'));
        }
        if ($request->has('type')) {
            if ($request->get('type') != null)
                $items->where('type_id', $request->get('type'));
        }
        $items = $items->orderBy('id', 'desc')->paginate($this->settings->value);
        return view('cp.expo.home', [
            'items' => $items,
        ]);
    }

    public function create()
    {
        $cities = City::all();
        $countries = Country::all();
        $categories = Category::all();
        return view('cp.expo.create', [
            'countries' => $countries,
            'categories' => $categories,
            'cities' => $cities,
        ]);
    }

    public function store(Request $request)
    {

//        $request->request->add(['main_image'])
        $roles = [
            'booth_image' => 'required|image|mimes:jpeg,jpg,png',
            'designer_image' => 'required|image|mimes:jpeg,jpg,png',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|min:6|max:15|unique:users',
            'password' => 'required',
        ];
         foreach ($this->locales as $locale) {
            $roles['name_' . $locale->lang] = 'required';
        }
        $this->validate($request, $roles);


        $newUser = new User();
        $newUser->email = $request->email;
        $newUser->name = $request->designer_name;
        $newUser->mobile = $request->mobile;
        $newUser->FCM_token = '';
        $newUser->api_token = str_random(180);
        $newUser->user_type = 2;
        $newUser->admin = 1;
        $newUser->password = bcrypt($request->password);

        if ($request->hasFile('designer_image')) {
           $designer_image = $request->file('designer_image')->store('uploads/images/user');
           $newUser->image =$designer_image;
        }
        $newUser->save();
        
        $in_slider = 0;
        if ($request->has('in_slider')) {
            if ($request->in_slider == 'on')
                $in_slider = 1;
        }
        
        $item = new Expo();
        $item->createdBy=$newUser->id;
        $item->order_by=$request->order;
        $item->type_id=$request->type;
        $item->designer_name=$request->designer_name;
        $item->details=$request->details;
        $item->user_id=$newUser->id;
        $item->country_id=$request->country_id;
        $item->city_name=$request->city_name;
        $item->address=$request->address;
        $item->delivery_city_name=1;
        $item->booth_image=$request->booth_image;
        $item->in_slider = $in_slider;
        
       if($request->delivery_service=='yes'){
        $item->delivery_service='yes';
       
            }else{
        $item->delivery_service='no';
        }

        /*  return $item->id;
         if($request->delivery_service==1){
        $item->delivery_service='yes';
       
         $delivery_countries = $request->delivery_country_id;
         $delivery_cites= $request->cities;
            for ($i = 0; $i <= count($delivery_countries)-1;$i++) {
                if(!empty($delivery_cites[$i])){
            $co = new ExpoCountry();
            $co->expo_id=$item->id;
            $co->country_id=$delivery_countries[$i];
            $co->cities=$delivery_cites[$i];
            $finish=$co->save();
            }

        }

        }else{
        $item->delivery_service='no';
        }*/
        
       
        if ($request->hasFile('designer_image')) {
           $designer_image = $request->file('designer_image')->store('uploads/images/expo');
           $item->designer_image=$designer_image;
        }
        if ($request->hasFile('civil_id')) {
           $civil_id = $request->file('civil_id')->store('uploads/images/expo');
           $item->civil_id =$civil_id;
        }
        if ($request->hasFile('booth_image')) {
           $booth_image = $request->file('booth_image')->store('uploads/images/expo');
           $item->booth_image=$booth_image;
        }

         foreach ($this->locales as $locale) {
            $item->translateOrNew($locale->lang)->name = ucwords($request->get('name_' . $locale->lang));
        }

        $item->save();

        $category_ids=$request->category_id;
         foreach($category_ids as $category){
               $cat = ExpoCategory::query()->create([
                'expo_id' => $item->id,
                'category_id' => $category,           
              ]);
            }

        //////increament///////
        $plus = Category::whereIn('id',$category_ids)->increment('expo_no');
        ///////////////////////
        ///
            
       if($request->delivery_service=='yes'){
        $item->delivery_service='yes';
       
         $delivery_countries = $request->delivery_country_id;
         $delivery_cites= $request->cities;
            for ($i = 0; $i <= count($delivery_countries)-1;$i++) {
                if(!empty($delivery_cites[$i])){
            $co = new ExpoCountry();
            $co->expo_id=$item->id;
            $co->country_id=$delivery_countries[$i];
            $co->cities=$delivery_cites[$i];
            $finish=$co->save();
            }
        }

        }else{
        $item->delivery_service='no';
        }
        

      /*  $countries_ids=$request->delivery_country_id;
        foreach($countries_ids as $country){
           $cat = ExpoCountry::query()->create([
            'expo_id' => $item->id,
            'country_id' => $country,           
          ]);
        }*/




        return redirect()->back()->with('status', __('common.create'));
    }

    public function show($id)
    {
        return Expo::query()->with('user')->findOrFail($id);
    }

    public function edit($id)
    {
        $cities = City::all();
        $countries = Country::all();
        $categories = Category::all();
        $ex_categories = ExpoCategory::where('expo_id',$id)->get(['category_id']);
        $in=array();
        foreach ($ex_categories as $category) {
            $in[]=$category->category_id;
        }

        $item = $this->show($id);
        $ex_countries = ExpoCountry::where('expo_id',$item->id)->get();

        return view('cp.expo.edit', [
            'item' => $item,
             'countries' => $countries,
            'categories' => $categories,
            'cities' => $cities,
            'ex_categories'=>$in,
            'ex_countries' => $ex_countries,
        ]);

    }

    public function update(Request $request, $id)
    {
        $roles = [
           // 'booth_image' => 'required|image|mimes:jpeg,jpg,png',
            'category_id' => 'required',
        ];

         foreach ($this->locales as $locale) {
            $roles['name_' . $locale->lang] = 'required';
        }
        $this->validate($request, $roles);
        
        $in_slider = 0;
        if ($request->has('in_slider')) {
            if ($request->in_slider == 'on')
                $in_slider = 1;
        }
        
        $item = Expo::query()->where('id', $id)->firstOrFail();
        $item->order_by=$request->order;
        $item->createdBy=1;
        $item->type_id=$request->type;
        $item->details=$request->details;
        $item->country_id=$request->country_id;
        $item->city_name=$request->city_name;
        $item->address=$request->address;
        $item->delivery_country_id=1;
        $item->delivery_city_id=1;
        $item->delivery_city_name=1;
        $item->in_slider = $in_slider;
        
        if ($request->hasFile('designer_image')) {
           $designer_image = $request->file('designer_image')->store('uploads/images/expo');
           $item->designer_image=$designer_image;
        }
        
        if ($request->hasFile('civil_id')) {
           $civil_id= $request->file('civil_id')->store('uploads/images/expo');
           $item->civil_id=$civil_id;
        }
        
        if ($request->hasFile('booth_image')) {
           $booth_image = $request->file('booth_image')->store('uploads/images/expo');
           $item->booth_image=$booth_image;
        }
         foreach ($this->locales as $locale) {
            $item->translateOrNew($locale->lang)->name = ucwords($request->get('name_' . $locale->lang));
        }
        if($request->delivery_service=='yes'){
        $item->delivery_service='yes';
       
         $old_delivery_countries = ExpoCountry::where('expo_id',$item->id)->forceDelete();
         $delivery_countries = $request->delivery_country_id;
         $delivery_cites= $request->cities;
            for ($i = 0; $i <= count($delivery_countries)-1;$i++) {
                if(!empty($delivery_cites[$i])){
            $co = new ExpoCountry();
            $co->expo_id=$item->id;
            $co->country_id=$delivery_countries[$i];
            $co->cities=$delivery_cites[$i];
            $finish=$co->save();
            }

        }

        }else{
        $item->delivery_service='no';
            $old_delivery_countries = ExpoCountry::where('expo_id',$item->id)->forceDelete();
        }
        $item->save();
        
        
         $old_category = ExpoCategory::where('expo_id',$item->id)->forceDelete();
             $category_ids=$request->category_id;
            foreach($category_ids as $category){
               $cat = ExpoCategory::query()->create([
                'expo_id' => $item->id,
                'category_id' => $category,           
              ]);
            } 
            
           $user= User::query()->where('id', $item->user_id)->firstOrFail();
           if ($request->hasFile('designer_image')) {
           $designer_image= $request->file('designer_image')->store('uploads/images/user');
           $user->image=$designer_image;
           $user->name=$request->designer_name;
        }
         $user->save();

            
        return redirect()->back()->with('status', __('common.update'));
    }

    public function destroy($id)
    {
        $item = Expo::query()->findOrFail($id);
        if ($item) {
            Expo::query()->where('id', $id)->delete();
            User::query()->where('id', $item->user_id)->delete();
            return "success";
        }
        return "fail";
    }

    public function changeStatus(Request $request)
    {
        if ($request->event == 'delete') {
            Expo::query()->whereIn('id', $request->IDsArray)->delete();
        }else {
            Expo::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);
        }
        return $request->event;
    }

    public function myExpo(Request $request){

        $cities = City::all();
        $countries = Country::all();
        $categories = Category::all();
        $item= Expo::query()->where('user_id',Auth::id())->first();
        $ex_countries = ExpoCountry::where('expo_id',$item->id)->get();

        $e_categories = ExpoCategory::where('expo_id',$item->id)->get(['category_id']);
        $in=array();
        foreach ($e_categories as $category) {
            $in[]=$category->category_id;
        }
        if(!empty($item)){
        return view('cp.my_expo.edit', [
            'item' => $item,
            'countries' => $countries,
            'categories' => $categories,
            'cities' => $cities,
            'e_categories' => $in,
            'ex_countries' => $ex_countries,
        ]);
    }else{
        return 'no expo found';
    }
    }


    public function update_my_expo(Request $request)
    {
         foreach ($this->locales as $locale) {
            $roles['name_' . $locale->lang] = 'required';
        }
        $this->validate($request, $roles);
        $item = Expo::query()->where('user_id',Auth::id())->firstOrFail();
        $item->details=$request->details;
        $item->category_id=1;
        $item->country_id=$request->country_id;
        $item->city_name=$request->city_name;
        $item->address=$request->address;
        if ($request->hasFile('booth_image')) {
           $booth_image = $request->file('booth_image')->store('uploads/images/expo');
           $item->booth_image=$booth_image;
        }
        if ($request->hasFile('civil_id')) {
           $civil_id = $request->file('civil_id')->store('uploads/images/expo');
           $item->civil_id=$civil_id;
        }
         foreach ($this->locales as $locale) {
            $item->translateOrNew($locale->lang)->name = ucwords($request->get('name_' . $locale->lang));
        }
        if($request->delivery_service=='yes'){
        $item->delivery_service='yes';
       
         $old_delivery_countries = ExpoCountry::where('expo_id',$item->id)->forceDelete();
         $delivery_countries = $request->delivery_country_id;
         $delivery_cites= $request->cities;
            for ($i = 0; $i <= count($delivery_countries)-1;$i++) {
                if(!empty($delivery_cites[$i])){
            $co = new ExpoCountry();
            $co->expo_id=$item->id;
            $co->country_id=$delivery_countries[$i];
            $co->cities=$delivery_cites[$i];
            $finish=$co->save();
            }

        }

        }else{
            $old_delivery_countries = ExpoCountry::where('expo_id',$item->id)->forceDelete();
            $item->delivery_service='no';
        }
        $item->save();
         $old_expo_categories = ExpoCategory::where('expo_id',$item->id)->forceDelete();
         $category_ids=$request->category_id;
         foreach($category_ids as $category){
               $cat = ExpoCategory::query()->create([
                'expo_id' => $item->id,
                'category_id' => $category,           
              ]);
            }
        return redirect()->back()->with('status', __('common.update'));
    }
}
