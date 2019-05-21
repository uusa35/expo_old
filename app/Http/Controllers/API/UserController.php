<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Expo;
use App\Models\ExpoCategory;
use App\Models\ExpoTranslation;
use App\Models\Language;
use App\Models\Package;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Subscription;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
//use Mail;

class UserController extends Controller
{

    public function __construct()
    {
        $this->locales = Language::all();
        view()->share([
            'locales' => $this->locales,

        ]);
    }

    public function signUp(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');
        if (!empty($password)) {
            $password = bcrypt($password);
        }
        $name = $request->get('name');
        $mobile = $request->get('mobile');
        $FCM_token = $request->get('FCM_token');
        $device_type = $request->get('device_type');
        $validator1 = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
        ]/*,[
            'email.unique' => 'Your entered email address is already registered.'
        ]*/);
        $validator2 = Validator::make($request->all(), [
            'mobile' => 'required|min:6|max:15|unique:users',
        ]);
        $validator3 = Validator::make($request->all(), [
            'password' => 'required',
            'name' => 'required',
            // 'FCM_token' => 'required',
            'device_type' => 'required|in:ios,android',
        ]);
        if ($validator1->fails()) {
            return mainResponse(false, '', null, $validator1);
        } elseif ($validator2->fails()) {
            return mainResponse(false, '', null, $validator2);
        } elseif ($validator3->fails()) {
            return mainResponse(false, '', null, $validator3);
        } else {
            $newUser = new User();
            $newUser->email = $email;
            $newUser->name = $name;
            $newUser->password = $password;
            $newUser->mobile = $mobile;
            $newUser->device_type = $device_type;
            //$newUser->FCM_token = $FCM_token;
            $newUser->api_token = str_random(180);
            if (!empty($request->get('FCM_token'))) {
                $newUser->FCM_token = $FCM_token;
            } else {
                $newUser->FCM_token = null;
            }
            $done = $newUser->save();
            if ($done) {
                return $this->login($request);
            } else {
                $tmp = ["fieldname" => 'email', "message" => __('api.whoops')];
                return mainResponse(false, 'api.whoops', [], $tmp, 1);
            }
        }
    }

    public function login(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');
        $FCM_token = $request->get('FCM_token');
        $device_type = $request->get('device_type');
        $validator1 = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'FCM_token' => 'required',
            'device_type' => 'required|in:ios,android',
        ]);
        if ($validator1->fails()) {
            return mainResponse(false, '', null, $validator1);
        }
        if ($user = Auth::guard('web')->attempt(['email' => $email, 'password' => $password])) {
            $user = User::query()->find(Auth::id());
            $user->update(['FCM_token' => $FCM_token, 'device_type' => $device_type]);
            return mainResponse(true, 'api.ok', $user, []);
        } else {
            $EmailData = User::query()->where(['email' => $email])->first();
            if (count($EmailData) > 0) {
                $tmp = ["fieldname" => 'password', "message" => __('api.wrong_password')];
                return mainResponse(false, 'api.wrong_password', null, $tmp, 1);
            } else {
                $tmp = ["fieldname" => 'email', "message" => __('api.wrong_email2')];
                return mainResponse(false, 'api.wrong_email2', null, $tmp, 1);
            }
        }
    }

    public function editUser(Request $request)
    {
        $user = Auth::user();
        $newUser = User::query()->where('id', $user->id)->first();
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('uploads/images/users');
            $newUser->image = $image;
        }
        $name = ($request->has('name')) ? $request->get('name') : $user->name;
        $mobile = ($request->has('mobile')) ? $request->get('mobile') : $user->mobile;

        $newUser->name = $name;
        $newUser->mobile = $mobile;
        $done = $newUser->save();
        if ($done) {
            return mainResponse(true, 'api.ok', $newUser, []);
        } else {
            $tmp = ["fieldname" => 'email', "message" => __('api.whoops')];
            return mainResponse(false, 'api.whoops', [], $tmp, 1);
        }
    }

    public function logout()
    {
        $user = Auth::user();
        $newUser = User::query()->where('id', $user->id)->first();
        $newUser->api_token = str_random(60);
        $done = $newUser->save();
        if ($done) {
            return mainResponse(true, 'api.ok', [], []);
        } else {
            $tmp = ["fieldname" => 'email', "message" => __('api.whoops')];
            return mainResponse(false, 'api.whoops', [], $tmp, 1);
        }
    }

    public function changePassword(Request $request)
    {
        $rules = [
            'old_password' => 'required|min:6',
            'password' => 'required|min:6',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return mainResponse(false, '', [], $validator);
        }
        $user = auth('api')->user();
        if (!Hash::check($request->get('old_password'), $user->password)) {
            $tmp = ["fieldname" => 'email', "message" => __('api.old_password')];
            return mainResponse(false, 'api.old_password', [], $tmp, 1);
        }
        $user->password = bcrypt($request->get('password'));
        if ($user->save()) {
            return mainResponse(true, 'api.ok', [], []);
        }
        $tmp = ["fieldname" => 'email', "message" => __('api.whoops')];
        return mainResponse(false, 'api.whoops', [], $tmp, 1);
    }

    public function join_expo(Request $request)
    {


        $email = $request->get('email');
        $password = $request->get('password');
        if (!empty($password)) {
            $password = bcrypt($password);
        }
        $name = $request->get('name');
        $mobile = $request->get('mobile');
        $FCM_token = $request->get('FCM_token');
        $device_type = $request->get('device_type');
        $validator1 = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
        ]);
        $validator2 = Validator::make($request->all(), [
            'mobile' => 'required|min:6|max:15|unique:users',
        ]);
        $validator3 = Validator::make($request->all(), [
            'category_id' => 'required',
            // 'civil_id' => 'required',
            'country_id' => 'required',
            'city_name' => 'required',
            'password' => 'required',
            'designer_name' => 'required',
            'type_id' => 'required',
            'expo_name' => 'required',
            'p1_title' => 'required',
            'p2_title' => 'required',
            //'FCM_token' => 'required',
            'device_type' => 'required|in:ios,android',
        ]);
        if ($validator1->fails()) {
            return mainResponse(false, '', 0, $validator1);
        } elseif ($validator2->fails()) {
            return mainResponse(false, '', 0, $validator2);
        } elseif ($validator3->fails()) {
            return mainResponse(false, '', 0, $validator3);
        } else {
            $newUser = new User();
            $newUser->email = $email;
            $newUser->name = $request->designer_name;
            $newUser->password = $password;
            $newUser->mobile = $mobile;
            $newUser->device_type = $device_type;
            $newUser->user_type = 2;
            $newUser->admin = 1;

            //$newUser->FCM_token = $FCM_token;
            $newUser->api_token = str_random(180);
            if ($request->hasFile('designer_image')) {
                $designer_image = $request->file('designer_image')->store('uploads/images/user');
                $newUser->image = $designer_image;
            }
            $newUser->lan = $request->longitude;
            $newUser->lat = $request->latitude;

            if (!empty($request->get('FCM_token'))) {
                $newUser->FCM_token = $FCM_token;
            } else {
                $newUser->FCM_token = 'test';
            }

            $done = $newUser->save();
            Mail::send('emails.email',
                [
                    'title' => 'MyExpo - Registration Successfully',
                    'content' => 'Your account has been created successfully. Please wait admin approval' ,
                ],
                function ($message) use ($email) {
                    $message->from('MyExpoME@gmail.com', 'My Expo');
                    $message->subject('My Expo Registration Successfully');
                    $message->to($email);
                }
            );

            if ($done) {
                $user_id = $newUser->id;
                $item = new Expo();
                $item->createdBy = $user_id;
                $item->type_id = $request->type_id;
                $item->designer_name = $request->designer_name;
                $item->details = null;
                $item->category_id = 1;
                $item->user_id = $user_id;
                $item->country_id = $request->country_id;
                $item->city_name = $request->city_name;
                $item->address = $request->address;
                $item->longitude = $request->longitude;
                $item->latitude = $request->latitude;
                //$item->delivery_country_id=$request->delivery_country_id;
                $item->delivery_city_id = 1;
                $item->delivery_service = $request->delivery_service;;

                if ($request->hasFile('civil_id')) {
                    $civil_id = $request->file('civil_id')->store('uploads/images/expo');
                    $item->civil_id = $civil_id;
                }
                //  if ($request->hasFile('designer_image')) {
                //    $designer_image = $request->file('designer_image')->store('uploads/images/expo');
                //    $item->designer_image=$designer_image;
                // }

                if ($request->hasFile('booth_image')) {
                    $booth_image = $request->file('booth_image')->store('uploads/images/expo');
                    $item->booth_image = $booth_image;
                } else {
                    $item->booth_image = null;
                }
                $finish = $item->save();


                $item1 = new ExpoTranslation();
                $item1->locale = 'en';
                $item1->expo_id = $item->id;
                $item1->name = $request->expo_name;
                $item1->save();

                $item2 = new ExpoTranslation();
                $item2->locale = 'ar';
                $item2->expo_id = $item->id;
                $item2->name = $request->expo_name;
                $item2->save();


                $category_ids = explode(",", $request->category_id);
                foreach ($category_ids as $category) {
                    $cat = ExpoCategory::query()->create([
                        'expo_id' => $item->id,
                        'category_id' => $category,
                    ]);
                }
                $package_id = $request->get('package_id');
                Subscription::query()->create([
                    'user_id' => $newUser->id,
                    'package_id' => $package_id,
                    'from' => Carbon::now(),
                    'to' => Carbon::now()->addMonths(Package::query()->find($package_id)->duration),
                ]);

                // $countries_ids=explode(",",$request->delivery_country_id);
                // foreach($countries_ids as $country){
                //    $cat = ExpoCountry::query()->create([
                //     'expo_id' => $item->id,
                //     'country_id' => $country,
                //   ]);
                // }

                /////////add product1/////////////
                $p1 = new Product();
                if ($request->hasFile('p1_image')) {
                    $p1_image = $request->file('p1_image')->store('uploads/images/product');
                    $p1->cover_image = $p1_image;
                }
                foreach ($this->locales as $locale) {
                    $p1->translateOrNew($locale->lang)->title = ucwords($request->p1_title);
                }
                $p1->expo_id = $item->id;
                $p1->type_id = $request->type_id;
                $p1->createdBy = $newUser->id;
                $p1->save();
                $product_cats = explode(",", $request->p1_category_id);
                foreach ($product_cats as $category) {
                    $pcat1 = ProductCategory::query()->create([
                        'product_id' => $p1->id,
                        'category_id' => $category,
                    ]);
                }

                Expo::find($item->id)->increment('product_no');

                ////////////////////////////////


                /////////add product2/////////////
                $p2 = new Product();
                if ($request->hasFile('p2_image')) {
                    $p2_image = $request->file('p2_image')->store('uploads/images/product');
                    $p2->cover_image = $p2_image;
                }
                foreach ($this->locales as $locale) {
                    $p2->translateOrNew($locale->lang)->title = ucwords($request->p2_title);
                }
                $p2->expo_id = $item->id;
                $p2->type_id = $request->type_id;
                $p2->createdBy = $newUser->id;
                $p2->save();
                $product_cats2 = explode(",", $request->p2_category_id);
                foreach ($product_cats2 as $category) {
                    $pcat2 = ProductCategory::query()->create([
                        'product_id' => $p2->id,
                        'category_id' => $category,
                    ]);
                }

                Expo::find($item->id)->increment('product_no');

                ////////////////////////////////


            } else {
                $finish = false;
            }
            if ($finish) {
                return mainResponse(true, 'api.ok', $item->id, []);
            } else {
                $tmp = ["fieldname" => 'email', "message" => __('api.whoops')];
                return mainResponse(false, 'api.whoops', [], $tmp, 1);
            }
        }

    }


    public function validate_mobile_phone(Request $request)
    {
        $email = $request->get('email');
        $mobile = $request->get('mobile');
        $validator1 = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
        ]);
        $validator2 = Validator::make($request->all(), [
            'mobile' => 'required|min:6|max:15|unique:users',
        ]);

        if ($validator1->fails()) {
            return mainResponse(false, 'email is exist', null, $validator1);
        } elseif ($validator2->fails()) {
            return mainResponse(false, 'mobile is exist', null, $validator2);
        } else {
            return mainResponse(true, '', null, null);
        }
    }


}