<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\DeliveryPrice;
use App\Models\Expo;
use App\Models\Order;
use App\Models\Product;
use App\Models\Slider;
use App\Models\UserOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Validator;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request,[
            'country_id' => 'required'
        ]);
        $user = '';
        if(auth()->check())
        {
            $user = Auth::id();
        }
        $device_id=app('request')->header('deviceId');
        if($device_id != ""){
            $cart = Cart::query()->where('device_id', $device_id)->get();
            $total = $cart->sum('total');

//            $deliverPrice = DeliveryPrice::query()
//                ->where('country_id',$request->get('country_id'))->

            $total = number_format((float)$total, 3, '.', '');
            if(empty($cart)){
                $cart = [];
            }
            return mainResponse(true, 'api.ok', ['cart' => $cart, 'total' => $total], []);
        }else{
             return mainResponse(false, 'api.error', [], []);
        }
    }


    public function store(Request $request)
    {
        $user = 0;
        if(auth()->check())
        {
            $user = Auth::id();
        }
        $device_id=app('request')->header('deviceId');
        if($device_id != ""){
            $data = $request->all();
            $data['device_id'] = $device_id;
            $data['user_id'] = $user;
            $data['total'] = $request->get('quantity') * $request->get('price');
            Cart::query()->create($data);
            $cart = Cart::query()->where('user_id', $user)->get();
            return mainResponse(true, 'api.ok', $cart, []);
        }else{
             return mainResponse(false, 'api.error', [], []);
        }
    }
    
    public function update($id, Request $request)
    {
        $user = 0;
        if(auth()->check())
        {
            $user = Auth::id();
        }
        $device_id=app('request')->header('deviceId');
        if($device_id != ""){
            if ($cart = Cart::query()->where('device_id', $device_id)->find($id)){
                $data = $request->all();
                $data['device_id'] = $device_id;
                $data['total'] = $request->get('quantity') * $request->get('price');
                $cart->update($data);
            }
            $cart = Cart::query()->where('user_id', $user)->get();
            return mainResponse(true, 'api.ok', $cart, []);
        }
        else{
            return mainResponse(false, 'api.error', [], []);
        }
    }
    
    public function destroy(Request $request)
    {
         $user = 0;
        if(auth()->check())
        {
            $user = Auth::id();
        }
        $device_id=app('request')->header('deviceId');
        if($device_id != ""){    
            $cart= Cart::query()->where('device_id', $device_id);
            if (!$request->cart_id){
                $cart = $cart->pluck('id')->toArray();
                Cart::destroy($cart);
            }else{
                if ($cart = $cart->find($request->cart_id)){
                    $cart->delete();
                }
            }
            $cart = Cart::query()->where('device_id', $device_id)->get();
            return mainResponse(true, 'api.ok', $cart, []);
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
        $data = UserOrder::query()->where('user_id', $user_id)->with('orders')->get();
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


}
