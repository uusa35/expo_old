<?php

namespace App\Http\Controllers\CP;

use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Language;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\SliderImages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SliderController extends Controller
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
        $items = Slider::query();
        if ($request->has('title')) {
            if ($request->get('title') != null)
                $items->whereHas('translations', function ($query) use ($request) {
                    $query->where('locale', app()->getLocale())
                        ->where('title', 'like', '%' . $request->get('title') . '%');
                });
        }
        // if ($request->has('details')) {
        //     if ($request->get('details') != null)
        //         $items->whereHas('translations', function ($query) use ($request) {
        //             $query->where('locale', app()->getLocale())
        //                 ->where('details', 'like', '%' . $request->get('details') . '%');
        //         });
        // }
        if ($request->has('status')) {
            if ($request->get('status') != null)
                $items->where('status', $request->get('status'));
        }
        $items = $items->orderBy('id', 'desc')->paginate($this->settings->value);
        return view('cp.slider.home', [
            'items' => $items,
        ]);

    }

    public function create()
    {
        return view('cp.slider.create');
    }

    public function store(Request $request)
    {
        $roles = [
            'image' => 'required|image|mimes:jpeg,jpg,png',
            'order' => 'numeric',
        ];
        foreach ($this->locales as $locale) {
            $roles['title_' . $locale->lang] = 'required';
           // $roles['details_' . $locale->lang] = 'required';
        }
        $this->validate($request, $roles);
        $image = $request->file('image')->store('uploads/images/sliders');

        $item = Slider::query()->create([
           // 'link' => $request->link,
            'order_by' => $request->order,
            'image' => $image,
            'createdBy' => auth()->id(),
        ]);
        foreach ($this->locales as $locale) {
            $item->translateOrNew($locale->lang)->title = ucwords($request->get('title_' . $locale->lang));
           // $item->translateOrNew($locale->lang)->details = $request->get('details_' . $locale->lang);
        }
        $item->save();
        // $sub_images = [];
        // foreach ($request->file('sub_images') as $sub_image) {
        //     $sub = $sub_image->store('uploads/images/sliders/images');
        //     array_push($sub_images, [
        //         'slider_id' => $item->id,
        //         'image' => $sub
        //     ]);
        // }
        // SliderImages::query()->insert($sub_images);
        return redirect()->back()->with('status', __('common.create'));
    }

    public function show($id)
    {
        return Slider::query()->findOrFail($id);
    }

    public function edit($id)
    {
        $item = $this->show($id);
        return view('cp.slider.edit', [
            'item' => $item,
        ]);
    }

    public function update(Request $request, $id)
    {
        $roles = [
            'image' => 'image|mimes:jpeg,jpg,png',
            'order' => 'numeric',
        ];
        foreach ($this->locales as $locale) {
            $roles['title_' . $locale->lang] = 'required';
            //$roles['details_' . $locale->lang] = 'required';
        }
        $this->validate($request, $roles);
        $item = Slider::query()->where('id', $id)->firstOrFail();
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('uploads/images/sliders');
            $item->image = $image;
        }
       // $item->link = $request->get('link');
        $item->order_by = $request->get('order');
        $item->createdBy = auth()->id();

        foreach ($this->locales as $locale) {
            $item->translateOrNew($locale->lang)->title = ucwords($request->get('title_' . $locale->lang));
            //$item->translateOrNew($locale->lang)->details = $request->get('details_' . $locale->lang);
        }
        $item->save();
        // if ($request->hasFile('sub_images')) {
        //     $sub_images = [];
        //     foreach ($request->file('sub_images') as $sub_image) {
        //         $sub = $sub_image->store('uploads/images/sliders/images');
        //         array_push($sub_images, [
        //             'slider_id' => $item->id,
        //             'image' => $sub
        //         ]);
        //     }
        //     SliderImages::query()->insert($sub_images);
        // }
        return redirect()->back()->with('status', __('common.update'));


    }

    public function destroy($id)
    {
        $item = Slider::query()->findOrFail($id);
        if ($item) {
            Slider::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }

    public function changeStatus(Request $request)
    {
        if ($request->event == 'delete') {
            Slider::query()->whereIn('id', $request->IDsArray)->delete();
        } else {
            Slider::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);
        }
        return $request->event;
    }

    public function deleteImage($image_id)
    {
//        return $image_id;
        $image = SliderImages::query()->findOrFail($image_id);
        if ($image->delete()) {
            return 'success';
        }
        return 'fail';
    }
}
