<?php

namespace App\Http\Controllers\API;

use App\Models\Ads;
use App\Models\ProductSize;
use App\Models\ProductColor;
use App\Models\ProductClothingType;
use App\Models\ProductOccasion;
use App\Models\Favourite;
use App\Models\Like;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\Rate;
use App\Models\Slider;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MyProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads_top = Ads::query()->public()->where('position', 'home_top')->first();
        $ads_down = Ads::query()->public()->where('position', 'home_down')->first();
        $ads_middle = Ads::query()->public()->where('position', 'home_middle')->take(2)->get();
        $slider = Slider::query()->public()->with('images')->first();
        $ids = Product::query()->public()->pluck('id')->toArray();
        Product::query()->whereIn('id', $ids)->increment('views');
        $products = Product::query()->public()->
        where('highlight', 1)->
        with(['images', 'currency', 'category', 'publish'])->take(7)->get();
        $data = [
            'ads_top' => $ads_top, 'ads_down' => $ads_down,
            'ads_middle' => $ads_middle, 'products' => $products, 'slider' => $slider,
        ];
        return mainResponse(true, 'api.ok', $data, []);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_ar' => 'required',
            'title_en' => 'required',
            'details_ar' => 'required',
            'details_en' => 'required',
            'category_id' => 'required|numeric',
            'publish_type_id' => 'required|numeric',
            'current_price' => 'required|numeric',
            'cover_image' => 'required|image|mimes:jpg,png,jpeg',
            'images.*' => 'required|image|mimes:jpg,png,jpeg',
        ]);
        if ($validator->fails()) {
            return mainResponse(false, '', [], $validator);
        }

        $user = Auth::guard('api')->user();

        if ($request->hasFile('cover_image')) {
            $cover_image = $request->file('cover_image')->store('/uploads/images/products');
        }

        $productData = new Product();
        $productData->category_id = $request->get('category_id');
        $productData->publish_type_id = $request->get('publish_type_id');
        $productData->current_price = $request->get('current_price');
        $productData->old_price = $request->get('old_price');
        $productData->cover_image = $cover_image;
        $productData->createdBy = $user->id;
        if ($productData->save()) {
            $sub_images = [];
            foreach ($request->file('images') as $sub_image) {
                $sub = $sub_image->store('/uploads/images/products/images');
                array_push($sub_images, [
                    'product_id' => $productData->id,
                    'image' => $sub
                ]);
            }

            ProductImages::query()->insert($sub_images);
            return mainResponse(true, 'api.ok', [], []);
        }


//        Product::query()->create([
//            'title' => $request->get('title'),
//            'details' => $request->get('details'),
//            'category_id' => $request->get('category_id'),
//            'publish_type_id' => $request->get('publish_type_id'),
//            'current_price' => $request->get('current_price'),
//            'old_price' => $request->get('old_price'),
//            'cover_image' => $cover_image,
//        ]);
//

    }

    public function likeProduct($product_id)
    {
        $user = Auth::guard('api')->user();
        $product = Product::query()->where('id', $product_id)->first();
        if ($product) {
            $newLike = Like::query()->firstOrCreate(['user_id' => $user->id, 'product_id' => $product_id]);
            if ($newLike->wasRecentlyCreated) {
                return mainResponse(true, 'api.like', [], []);
            } else {
                return mainResponse(true, 'api.foundLike', [], []);
            }
        } else {
            return mainResponse(false, 'api.numberNotFound', [], []);
        }
    }

    public function unLikeProduct($product_id)
    {
        $user = Auth::guard('api')->user();
        $product = Product::query()->where('id', $product_id)->first();
        if ($product) {
            $unLike = Like::query()->where(['user_id' => $user->id, 'product_id' => $product_id])->delete();
            if ($unLike) {
                return mainResponse(true, 'api.unlike', [], []);
            } else {
                return mainResponse(true, 'api.notFoundLike', [], []);
            }
        } else {
            return mainResponse(false, 'api.numberNotFound', [], []);
        }
    }

    public function favouriteProduct($product_id)
    {
        $user = Auth::guard('api')->user();
        $product = Product::query()->where('id', $product_id)->first();
        if ($product) {
            $newFavourite = Favourite::query()->firstOrCreate(['user_id' => $user->id, 'product_id' => $product_id]);
            if ($newFavourite->wasRecentlyCreated) {
                return mainResponse(true, 'api.favourite', [], []);
            } else {
                return mainResponse(true, 'api.foundFavourite', [], []);
            }
        } else {
            return mainResponse(false, 'api.numberNotFound', [], []);
        }
    }

    public function unFavouriteProduct($product_id)
    {
        $user = Auth::guard('api')->user();
        $product = Product::query()->where('id', $product_id)->first();
        if ($product) {
            $unFavourite = Favourite::query()->where(['user_id' => $user->id, 'product_id' => $product_id])->delete();
            if ($unFavourite) {
                return mainResponse(true, 'api.unFavourite', [], []);
            } else {
                return mainResponse(true, 'api.notFoundFavourite', [], []);
            }
        } else {
            return mainResponse(false, 'api.numberNotFound', [], []);
        }
    }

    public function rateProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
            'rate' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return mainResponse(false, '', [], $validator);
        }
        $user = Auth::guard('api')->user();
        $product_id = $request->get('product_id');
        $rate = $request->get('rate');
        $comment = $request->get('comment');
        $product = Product::query()->where('id', $product_id)->first();
        if ($product) {
            $countRate = Rate::query()->where(['user_id' => $user->id, 'product_id' => $product_id,])->count();
            if ($countRate > 0) {
                Rate::query()->where(['user_id' => $user->id, 'product_id' => $product_id,])->update(
                    ['rate' => $rate, 'comment' => $comment]
                );
                return mainResponse(true, 'api.foundRate', [], []);
            } else {
                Rate::query()->create([
                    'user_id' => $user->id, 'product_id' => $product_id,
                    'rate' => $rate, 'comment' => $comment
                ]);
                return mainResponse(true, 'api.rate', [], []);
            }
        } else {
            return mainResponse(false, 'api.numberNotFound', [], []);
        }
    }

    public function salePage()
    {
        $ads = Ads::query()->public()->where('position', 'sale_page')->get();
        $ids = Product::query()->public()->where('old_price', '!=', null)
            ->where('current_price', '!=', null)->pluck('id')->toArray();
        Product::query()->whereIn('id', $ids)->increment('views');
        $products = Product::query()->where('old_price', '!=', null)
            ->where('current_price', '!=', null)->
            with(['images', 'currency', 'category', 'publish'])->get();

        $data = ['ads' => $ads, 'products' => $products];
        return mainResponse(true, 'api.ok', $data, []);
    }


     public function filter_products(Request $request){
        $clothing_type=explode(",",$request->clothing_type);
        $occasion=explode(",",$request->occasion);
        $size=$request->size;
        $color=$request->color;
        $from_price=$request->from_price;
        $to_price=$request->to_price;
        $expo_id=$request->expo_id;
        $items = ProductClothingType::query(); 
        if (!empty($clothing_type)) {
            if ($clothing_type != null)
                $items->whereIn('clothing_type_id',$clothing_type);
        }
        $items = $items->get();
        $in=array();
        if(!empty($items)){
            foreach($items as $item){
                $in[]=$item->product_id;
            }
        }else{
            $in=null;
        }
        $items2 = ProductOccasion::query(); 
        if (!empty($occasion)) {
            if ($occasion != null)
                $items2->whereIn('occasion_id',$occasion);
        }
        $items2 = $items2->get();
        $in2=array();
        if(!empty($items2)){
            foreach($items2 as $item){
                $in2[]=$item->product_id;
            }
        }else{
            $in2=null;
        }
        $items3 = ProductSize::query(); 
        if (!empty($size)) {
            if ($size != null)
                $items3->where('size_id',$size);
        }
        $items3 = $items3->get();
        $in3=array();
        if(!empty($items3)){
            foreach($items3 as $item){
                $in3[]=$item->product_id;
            }
        }else{
            $in3=null;
        } 
        $items4 = ProductColor::query(); 
        if (!empty($color)) {
            if ($color != null)
                $items4->where('color_id',$color);
        }
        $items4 = $items4->get();
        $in4=array();
        if(!empty($items4)){
            foreach($items4 as $item){
                $in4[]=$item->product_id;
            }
        }else{
            $in4=null;
        }
        $p_ids=array_unique(array_merge($in,$in2,$in3,$in4));
        $items = Product::query()->whereIn('id',$p_ids)->public();
        if($from_price!=0){
            $items->whereBetween('old_price', [$from_price, $to_price]);
        }
        $items->where('expo_id',$expo_id);
        $data = $items->orderBy('id','desc')->paginate(10);
        return mainResponse(true, 'api.ok', $data, []);
     
    }

}
