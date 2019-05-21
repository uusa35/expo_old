<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\Cart;
use App\Models\Expo;
use App\Models\Order;
use App\Models\Product;
use App\Models\Slider;
use App\Models\UserOrder;
use App\User;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $data['slider'] = Slider::query()->public()->get();
        $data['expo'] = Expo::query()->public()->take(12)->get();
        return mainResponse(true, 'api.ok', $data, []);
    }


    public function create_order(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'required',
            'mobile' => 'required',
            'address' => 'required',
        ]);
        if ($validator->fails()) {
            return mainResponse(false, '', [], $validator);
        }
        $user_id = 0;
        if(auth()->guard('api')->check())
        {
            $user_id = auth()->guard('api')->user()->id;
        }
        $device_id=app('request')->header('deviceId');
       
        if($device_id != ""){
            
            $carts = Cart::query()->where('device_id', $device_id)->select('expo_id', 'product_id', 'quantity', 'price',
                'size_id', 'size_type', 'custom_size', 'color_id', 'material_id', 'total')->get();
               
                
            $expo_ids = $carts->pluck('expo_id')->toArray();
            $user_ids = Expo::query()->whereIn('id', $expo_ids)->pluck('user_id')->toArray();
             
            $tokensAndroid = User::query()->where('device_type','android')->whereIn('id', $user_ids)->pluck('FCM_token')->toArray();
            $tokensIOS = User::query()->where('device_type','ios')->whereIn('id', $user_ids)->pluck('FCM_token')->toArray();
            
            foreach ($user_ids as $id){
                Alert::query()->create([
                        'user_id' => $id,
                        'object_id' => $user_id,
                        'title' => $request->name,
                        'content' => 'http://myexpo.shop/en/login',
                        'type' => 2
                    ]
                );
            }
            
            $this->send($tokensAndroid,$tokensIOS, $user_id, $request->name, 'http://myexpo.shop/en/login', 2);
    
    //        dd($user_ids);
            $cart_total = $carts->sum('total');
           
            $status = 'new';
            $order_id = 'Order_' . mt_rand(100000000, 999999999);
    //        $data = json_decode($request->getContent(), true);
    
            $user_order = new UserOrder();
            $user_order->user_id = $user_id;
            $user_order->device_id = $device_id;
            $user_order->status = $status;
            $user_order->order_id = $order_id;
            $user_order->total_cost = $cart_total;
            $user_order->name = $request->name;
            $user_order->email = $request->email;
            $user_order->mobile = $request->mobile;
            $user_order->address = $request->address;
            $user_order->save();
             
    
            $carts->map(function ($cart) use ($user_order) {
                $cart->setAppends([]);
                $cart['order_id'] = $user_order->id;
                return $cart;
            });
                Order::query()->insert($carts->toArray());
                $data22 = array(
                    'order' => $carts,
                    'order_id' => $order_id,
                  //  'order_date' => $user_order->created_at,
                    'status' => $status,
                    'name' => $request->name,
                    'mobile' => $request->mobile,
                    'address' => $request->address,
                    'total_cost' => $cart_total
                );
                $email_data = array(
                     'from' => env('MAIL_FROM_ADDRESS'),
                     'to' => $request->email);
                Mail::send('emails.invoice', $data22, function ($message) use ($email_data) {
                    $message->to($email_data['to'])
                        ->subject('Expo Application ')
                        ->replyTo('support@myexpo.shop', 'Expo Application')
                        ->from('support@myexpo.shop', 'support@myexpo.shop');
                });
                /****************** Send email to Expos *********************/
               
            foreach($expo_ids as $exp_id)
            {
                    $expo_cart = Cart::query()->where('device_id', $device_id)->where('expo_id', $exp_id)->get();
                    
                    $expo_detail = Expo::query()->where('id', $exp_id)->first();
                    $user_detail = User::query()->where('id', $expo_detail->user_id)->first();
                    $cart_total = $expo_cart->sum('total');
                    
                    $data_expo = array(
                    'order' => $expo_cart,
                    'order_id' => $order_id,
                    'name' => $request->name,
                    'mobile' => $request->mobile,
                    'address' => $request->address,
                    'expo_name' => $user_detail->name,
                    'total_cost' => $cart_total
                );
               
                    
                
                     Mail::send('emails.invoice_expo', $data_expo, function ($message) use ($email_data, $user_detail) {
                    $message->to($user_detail->email)
                        ->subject('MyExpo - Purchase Process')
                        ->replyTo('support@myexpo.shop', 'Expo Application')
                        ->from('support@myexpo.shop', 'support@myexpo.shop');
                });
                     
            }
            $cc = Cart::query()->where('device_id', $device_id)->pluck('id')->toArray();
            Cart::destroy($cc);
            return mainResponse(true, 'api.ok', $carts, []);
        }
        else{
            return mainResponse(false, 'api.error', [], []);
        }
    }






    public function my_orders(Request $request)
    {
        $user = auth('api')->user();
        $user_id = $user->id;
        // $orders= UserOrder::query()->where('user_id',$user_id)->get();
        /* $in=array();
         foreach($orders as $order){
          $in[]=$order->id;
         }*/

        // $data = UserOrder::query()->where('user_id',$user_id)->with(['user','orders'])->get();
        //$data = Order::query()->whereIn('order_id',$in)->get();
        // return $data ;
        $data = UserOrder::query()->where('user_id', $user_id)->orderByDesc('id')->with('orders')->get();
        return mainResponse(true, 'api.ok', $data, []);
    }


    public function order_details($order_id, Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $data = Order::query()->where('id', $order_id)->with('product')->get();
        return mainResponse(true, 'api.ok', $data, []);
    }

    public function change_status(Request $request)
    {
        $order_id = $request->order_id;
        $user = Auth::user();
        $user_id = $user->id;
        $rules = [
            'status' => 'required|in:new,pending,delivered,On-delivery,canceled',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return mainResponse(false, '', [], $validator);
        }
        $item = UserOrder::query()->where('id', $order_id)->first();
        if (!empty($item)) {
            $item->status = $request->status;
            $item->save();
            return mainResponse(true, 'api.ok', [], []);
        } else {
            return mainResponse(false, 'api.error', [], []);
        }
    }

    function send($tokenAndroid,$tokensIOS, $id, $title, $content, $type)
    {
        
        try {
            $headers = [
                'Authorization: key=' . 'AAAAGiavZk0:APA91bEXTUQfpGAQbKBu9jTBbDWjb16tM0NgSFE-MV7UbFyLCv7V58EuAUEbgNkrYw9CW9S47a13eMAHaVV-CDaMqCWnOkT7BzI4r_u69x8fdBkv0_zlE7Ga31pR11haAoLfkXtS3I1-',
            'Content-Type: application/json'
            ];

            if(!empty($tokensIOS)) {
                $dataForIOS = [
                    "registration_ids" => $tokensIOS,
                    "notification" => [
                        'id' => $id,
                        'title' => $title,
                        'content' => $content,
                        'body' => 'New Order',
                        'type' => $type,
                        'sound' => 1,//Default sound
                        'icon' => 1,//Default Icon
                        
                        ],
                        'data' => [
                        'id' => $id,
                        'title' => $title,
                        'content' => $content,
                        'body' => 'New Order',
                        'type' => $type,
                        'sound' => 1,//Default sound
                        'icon' => 1,//Default Icon
                        
                        ],
                ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataForIOS));
                $result = curl_exec($ch);
                curl_close($ch);
            }
            if(!empty($tokenAndroid)) {
                $dataForAndroid = [
                    "registration_ids" => $tokenAndroid,
                    "data" => [
                        'id' => $id,
                        'title' => $title,
                        'content' => $content,
                        'body' => 'New Order',
                        'type' => $type,
                        'sound' => 1,//Default sound
                        'icon' => 1,//Default Icon
                    ]
                ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataForAndroid));
                $result = curl_exec($ch);
                curl_close($ch);
    
                
            }
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
        
        
        
        
        
        
        
        
        
        
        // $registrationIds = $token;

        // $msg = [
        //     'id' => $id,
        //     'title' => $title,
        //     'content' => $content,
        //     'body' => 'New Order',
        //     'type' => $type,
        //     'sound' => 1,//Default sound
        //     'icon' => 1,//Default Icon
        // ];
        // if ($device == 'ios'){
        //     $fields = [
        //         'registration_ids' => $registrationIds,
        //         'notification' => $msg,
        //         'data' => $msg,
        //     ];
        // }else{
        //     $fields = [
        //         'registration_ids' => $registrationIds,
        //         'data' => $msg,
        //     ];
        // }

        // $headers = [
        //     'Authorization: key=' . 'AAAAGiavZk0:APA91bEXTUQfpGAQbKBu9jTBbDWjb16tM0NgSFE-MV7UbFyLCv7V58EuAUEbgNkrYw9CW9S47a13eMAHaVV-CDaMqCWnOkT7BzI4r_u69x8fdBkv0_zlE7Ga31pR11haAoLfkXtS3I1-',
        //     'Content-Type: application/json'
        // ];

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // $result = curl_exec($ch);
        // curl_close($ch);
    }


}
