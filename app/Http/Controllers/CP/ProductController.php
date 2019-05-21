<?php

namespace App\Http\Controllers\CP;

use App\Models\ProductImages;
use App\Models\ProductClothingType;
use App\Models\ProductColor;
use App\Models\ProductMaterial;
use App\Models\ProductSize;
use App\Models\ProductCategory;
use App\Models\Expo;
use App\Models\Color;
use App\Models\Size;
use App\Models\Material;
use App\Models\ClothingType;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Language;
use App\Models\Product;
use App\Models\Publish;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
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
        $items = Product::query();
        if ($request->has('title')) {
            if ($request->get('title') != null)
                $items->whereHas('translations', function ($query) use ($request) {
                    $query->where('locale', app()->getLocale())
                        ->where('title', 'like', '%' . $request->get('title') . '%');
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
        return view('cp.product.home', [
            'items' => $items,
        ]);

    }

    public function create()
    {
        $expo = Expo::all();
        $colors = Color::all();
        $sizes = Size::all();
        $clothing_types = ClothingType::all();
        $materials = Material::all();
        $categories = Category::all();
        $publishes = Publish::all();
        return view('cp.product.create', [
            'categories' => $categories,
            'publishes' => $publishes,
            'sizes' => $sizes,
            'clothing_types' => $clothing_types,
            'materials' => $materials,
            'colors' => $colors,
            'expo' => $expo,
        ]);
    }

    public function store(Request $request)
    {
//        return $request->all();
        $roles = [
            'image' => 'required|image|mimes:jpeg,jpg,png',
            'order' => 'numeric',
            'category_id' => 'required',
            'expo_id' => 'required',
          //  'size_id' => 'required',
        //    'colors' => 'required',
          //  'material_id' => 'required',
            //'clothing_id' => 'required',
            //'publish_type_id' => 'required|numeric',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
        ];
        foreach ($this->locales as $locale) {
            $roles['title_' . $locale->lang] = 'required';
            $roles['details_' . $locale->lang] = 'required';
        }
        $this->validate($request, $roles);
        $highlight = 0;
        $image = $request->file('image')->store('uploads/images/products');
        if ($request->has('highlight')) {
            if ($request->highlight == 'on')
                $highlight = 1;
        }
        
        $is_sale = 0;
        $price_after = $request->price;
        $price_before = 0;
        
        if ($request->has('is_sale')) {
            if ($request->is_sale == 'on') {
                $is_sale = 1;
            $price_before = $request->price;
            $discount = (100 - $request->discount) / 100;
            $price_after = $request->price * $discount;
        } // end if
        }
        
        $item = Product::query()->create([
            'discount_percentage' => ($request->discount) ? $request->discount : 0,
            'old_price' => $price_before,
            'size_id' => 1,
            'is_sale' => $is_sale,
            'expo_id' => $request->expo_id,
            'current_price' => $price_after,
            'quantity' => $request->quantity,
            'clothing_id' => 1,
            'material_id' => 1,
            'color' => 1,
            'order_by' => $request->order,
            'cover_image' => $image,
            //'category_id' => $request->category_id,
            'type_id' => 0,
           // 'publish_type_id' => $request->publish_type_id,
            //'old_price' => $request->old_price,
            'highlight' => 0,
            'createdBy' => auth()->id(),
            'currency_id' => 1,
        ]);
        foreach ($this->locales as $locale) {
            $item->translateOrNew($locale->lang)->title = ucwords($request->get('title_' . $locale->lang));
            $item->translateOrNew($locale->lang)->details = $request->get('details_' . $locale->lang);
        }
        $done = $item->save();

        if ($done) {
            Expo::find($request->expo_id)->increment('product_no');
        }

        $category_ids = $request->category_id;
        foreach ($category_ids as $category) {
            $cat = ProductCategory::query()->create([
                'product_id' => $item->id,
                'category_id' => $category,
            ]);
        }
        //////increament///////

        $countries = Category::whereIn('id', $category_ids)->increment('product_no');
        ///////////////////////
        $size_ids = $request->size_id;
        if($size_ids) {
        foreach ($size_ids as $size) {
            $size = ProductSize::query()->create([
                'product_id' => $item->id,
                'size_id' => $size,
            ]);
        }
        }
        $material_ids = $request->material_id;
        if($material_ids) {
        foreach ($material_ids as $material) {
            $material = ProductMaterial::query()->create([
                'product_id' => $item->id,
                'material_id' => $material,
            ]);
        }
        }
        $colors_ids = $request->colors;
        if($colors_ids) {
        foreach ($colors_ids as $color) {
            $color = ProductColor::query()->create([
                'product_id' => $item->id,
                'color_id' => $color,
            ]);
        }
}
        $type_ids = $request->clothing_id;
        if($type_ids) {
        foreach ($type_ids as $type) {
            $clothing = ProductClothingType::query()->create([
                'product_id' => $item->id,
                'clothing_type_id' => $type,
            ]);
        }
        }

        if (!empty($request->file('product_images'))) {
            $product_images = [];
            foreach ($request->file('product_images') as $sub_image) {
                $sub = $sub_image->store('uploads/images/Product/images');
                array_push($product_images, [
                    'product_id' => $item->id,
                    'image' => $sub,
                    'type' => 'image',
                    'thumb' => '',
                ]);
            }
            ProductImages::query()->insert($product_images);
        }

        $product_videos = $request->product_videos;
        if (count($product_videos) >= 1) {
            if (!empty($product_videos[0])) {
                for ($i = 0; $i <= count($product_videos) - 1; $i++) {
                    $p_images = new ProductImages();
                    $p_images->product_id = $item->id;
                    $p_images->image = $product_videos[$i];
                    $p_images->type = 'video';
                    $p_images->thumb = 'http://img.youtube.com/vi/' . substr($product_videos[$i], -11) . '/0.jpg';
                    $finish = $p_images->save();
                }
            }
        }


        return redirect()->back()->with('status', __('common.create'));
    }

    public function show($id)
    {
        return Product::query()->findOrFail($id);
    }

    public function edit($id)
    {
        $item = $this->show($id);
        $p_colors = ProductColor::where('product_id', $id)->get();
        $in0 = array();
        foreach ($p_colors as $colors) {
            $in0[] = $colors->color_id;
        }

        $p_categories = ProductCategory::where('product_id', $id)->get(['category_id']);
        $in = array();
        foreach ($p_categories as $category) {
            $in[] = $category->category_id;
        }
        $p_sizes = ProductSize::where('product_id', $id)->get();
        $in2 = array();
        foreach ($p_sizes as $size) {
            $in2[] = $size->size_id;
        }
        $p_materials = ProductMaterial::where('product_id', $id)->get();
        $in3 = array();
        foreach ($p_materials as $material) {
            $in3[] = $material->material_id;
        }
        $p_clothing_types = ProductClothingType::where('product_id', $id)->get();
        $in4 = array();
        foreach ($p_clothing_types as $types) {
            $in4[] = $types->clothing_type_id;
        }
        $colors = Color::all();
        $categories = Category::all();
        $publishes = Publish::all();
        $sizes = Size::all();
        $clothing_types = ClothingType::where('status', 'active')->get();
        $materials = Material::all();
        $videos = ProductImages::where('Product_id', $id)->where('type', 'video')->get();
        $expo = Expo::all();
        //return $clothing_types;
        return view('cp.product.edit', [
            'categories' => $categories,
            'publishes' => $publishes,
            'item' => $item,
            'sizes' => $sizes,
            'clothing_types' => $clothing_types,
            'materials' => $materials,
            'videos' => $videos,
            'colors' => $colors,
            'p_colors' => $in0,
            'p_sizes' => $in2,
            'p_categories' => $in,
            'p_materials' => $in3,
            'p_clothing_types' => $in4,
            'expo' => $expo,
        ]);
    }

    public function update(Request $request, $id)
    {
        $roles = [
            'order' => 'numeric',
            'category_id' => 'required',
           // 'publish_type_id' => 'required|numeric',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
        ];
        foreach ($this->locales as $locale) {
            $roles['title_' . $locale->lang] = 'required';
            $roles['details_' . $locale->lang] = 'required';
        }
        $this->validate($request, $roles);
        $item = Product::query()->where('id', $id)->firstOrFail();
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('uploads/images/products');
            $item->cover_image = $image;
        }
        $highlight = 0;
        if ($request->has('highlight')) {
            if ($request->highlight == 'on')
                $highlight = 1;
        }
       // $item->highlight = $highlight;
       
       
        $is_sale = 0;
        $price_after = $request->price;
        $price_before = $item->old_price;  
        
        if ($request->has('is_sale')) {
            if ($request->get('is_sale') == 'on') {
                
                if($item->discount_percentage != $request->get('discount') || $item->current_price != $request->price ) {
                
                $is_sale = 1;
            $price_before = $request->get('price');
            $discount = (100 - $request->get('discount')) / 100;
            $price_after = $request->get('price') * $discount;
        } // end if
        
            }
            else
            {
                $price_before = 0;
            }
        }
        
        $item->discount_percentage = ($request->get('discount')) ? $request->get('discount') : 0;
        $item->is_sale  = $is_sale;
        $item->old_price = $price_before;
        $item->current_price = $price_after;
        $item->quantity = $request->get('quantity');
        $item->order_by = $request->get('order');
        $item->category_id = 1;
       // $item->publish_type_id = $request->get('publish_type_id');
        $item->createdBy = auth()->id();

        foreach ($this->locales as $locale) {
            $item->translateOrNew($locale->lang)->title = ucwords($request->get('title_' . $locale->lang));
            $item->translateOrNew($locale->lang)->details = $request->get('details_' . $locale->lang);
        }
        $item->save();
        $old_category = ProductCategory::where('product_id', $item->id)->forceDelete();
        $category_ids = $request->category_id;
        foreach ($category_ids as $category) {
            $cat = ProductCategory::query()->create([
                'product_id' => $item->id,
                'category_id' => $category,
            ]);
        }
        $size_ids = $request->size_id;
        

            $old_size = ProductSize::where('product_id', $item->id)->forceDelete();
        if ($size_ids) {
            foreach ($request->size_id as $size) {
                $size = ProductSize::query()->create([
                    'product_id' => $item->id,
                    'size_id' => $size,
                ]);
            }
        }
        $material_ids = $request->material_id;
        
            $old_material = ProductMaterial::where('product_id', $item->id)->forceDelete();

            if ($material_ids) {
            foreach ($material_ids as $material) {
                $material = ProductMaterial::query()->create([
                    'product_id' => $item->id,
                    'material_id' => $material,
                ]);
            }
        }
        $colors_ids = $request->colors;
        
            $old_colors = ProductColor::where('product_id', $item->id)->forceDelete();
        
        if ($colors_ids) {
            foreach ($colors_ids as $color) {
                $color = ProductColor::query()->create([
                    'product_id' => $item->id,
                    'color_id' => $color,
                ]);
            }
        }
        $type_ids = $request->clothing_id;
        
            $clothing = ProductClothingType::where('product_id', $item->id)->forceDelete();
            
            if ($type_ids) {
            foreach ($type_ids as $type) {
                $clothing = ProductClothingType::query()->create([
                    'product_id' => $item->id,
                    'clothing_type_id' => $type,
                ]);
            }
        }

        if (!empty($request->file('product_images'))) {
            $product_images = [];
            foreach ($request->file('product_images') as $sub_image) {
                $sub = $sub_image->store('uploads/images/Product/images');
                array_push($product_images, [
                    'product_id' => $item->id,
                    'image' => $sub,
                    'type' => 'image',
                    'thumb' => '',
                ]);
            }
            ProductImages::query()->insert($product_images);
        }

        $old_video = ProductImages::where('type', 'video')->where('product_id', $item->id)->forceDelete();
        $product_videos = $request->product_videos;
        for ($i = 0; $i <= count($product_videos) - 1; $i++) {
            if (!empty($product_videos[$i])) {
                $p_images = new ProductImages();
                $p_images->product_id = $item->id;
                $p_images->image = $product_videos[$i];
                $p_images->type = 'video';
                $p_images->thumb = 'http://img.youtube.com/vi/' . substr($product_videos[$i], -11) . '/0.jpg';
                $finish = $p_images->save();
            }
        }


        return redirect()->back()->with('status', __('common.update'));


    }

    public function destroy($id)
    {
        $item = Product::query()->findOrFail($id);
        if ($item) {
            Product::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }

    public function changeStatus(Request $request)
    {
        if ($request->event == 'delete') {
            Product::query()->whereIn('id', $request->IDsArray)->delete();
        } else {
            Product::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);
        }
        return $request->event;
    }
}

