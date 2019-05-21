<?php

namespace App\Http\Controllers\API;
use App\Models\Product;
use App\Models\WishList;
use App\User;
use App\Models\Language;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class WishListController extends Controller
{

     public function __construct()
    {
        $this->locales = Language::all();
        view()->share([
            'locales' => $this->locales,
        ]);
    }

     public function add_wish_list(Request $request)
    {
        $product_id = $request->product_id;
        $user_id = $request->user_id;
       
        $validator1 = Validator::make($request->all(), [
            'product_id' => 'required',
            'user_id' => 'required',
        ]);
        if ($validator1->fails()) {
            return mainResponse(false, '', [], $validator1);
        } else {
            $product = Product::query()->where('id',$product_id)->first();
            if(!empty($product)){
                $found = WishList::query()->where('product_id',$product_id)->where('user_id',$user_id)->first();

                if(empty($found)){
                    $wish = new WishList();
                    $wish->product_id = $product_id;
                    $wish->user_id = $user_id;
                    $done = $wish->save();

//                    $product = Product::query()->where('id',$product_id)->firstOrFail();
//                    $product->is_fav = 1;
//                    $product->save();

                    if ($done) {
                        return mainResponse(true, 'api.ok', [], []);
                    } else {
                        $tmp = ["message" => __('api.whoops')];
                        return mainResponse(false, '', [],$tmp,1);
                    }
                }else{
                    $tmp = ["message" =>  'this product added before'];
                    return mainResponse(false, '', [],$tmp,1);
                }

            }else{
                $tmp = ["message" =>  'this product not found before'];
                return mainResponse(false, 'not exist', [],$tmp,1);
            }

        }
    } 


         public function delete_wish_list(Request $request)
    {
        $product_id = $request->product_id;
        $user_id = $request->user_id;
       
        $validator1 = Validator::make($request->all(), [
            'product_id' => 'required',
            'user_id' => 'required',
        ]);
        if ($validator1->fails()) {
            return mainResponse(false, '', [], $validator1);
        } else {
            $done = WishList::query()->where('product_id',$product_id)->where('user_id',$user_id)->delete();
            $product = Product::query()->where('id',$product_id)->firstOrFail();
            $product->is_fav = 0;
            $product->save();

            if ($done==true) {
                return mainResponse(true, 'api.ok', [], []);
            } else {
                 $tmp = ["message" => __('api.whoops')];
                return mainResponse(false, '', [],$tmp,1);
            }
         
        }
    }
      public function my_wish_list(Request $request)
    {
        $user = Auth::user();
        $user_id=$user->id;
        $items = WishList::query()->where('user_id',$user_id)->with('product');
        $data = $items->orderBy('id','desc')->paginate(10);
        return mainResponse(true, 'api.ok', $data, []);
    }


}