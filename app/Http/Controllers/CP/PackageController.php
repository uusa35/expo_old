<?php

namespace App\Http\Controllers\CP;

use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Language;
use App\Models\Package;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PackageController extends Controller
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
        $items = Package::query();
        if ($request->has('duration')) {
            if ($request->get('duration') != null)
                $items->where('duration', $request->get('duration'));
        }
        if ($request->has('price')) {
            if ($request->get('price') != null)
                $items->where('price', $request->get('price'));
        }
        if ($request->has('status')) {
            if ($request->get('status') != null)
                $items->where('status', $request->get('status'));
        }
        $items = $items->orderBy('id','desc')->paginate($this->settings->value);
        return view('cp.package.home', [
            'items' => $items,
        ]);

    }

    public function create()
    {
        return view('cp.package.create');
    }

    public function store(Request $request)
    {
        $roles = [
            'price' => 'required|numeric',
            'duration' => 'required|numeric',
            'order' => 'numeric',
            'image' => 'required|image|mimes:jpeg,jpg,png',

        ];
         foreach ($this->locales as $locale) {
            $roles['title_' . $locale->lang] = 'required';
        }
        $this->validate($request, $roles);
        $image = $request->file('image')->store('uploads/images/package');
        $item = Package::query()->create([
            'price' => $request->price,
            'image' => $image,
            'duration' => $request->duration,
            'order_by' => $request->order,
            'createdBy' => auth()->id(),
        ]);
        foreach ($this->locales as $locale) {
            $item->translateOrNew($locale->lang)->title = ucwords($request->get('title_' . $locale->lang));
        }
        $item->save();
        return redirect()->back()->with('status', __('common.create'));
    }

    public function show($id)
    {
        return Package::query()->findOrFail($id);
    }

    public function edit($id)
    {
        $item = $this->show($id);
        return view('cp.package.edit', [
            'item' => $item,
        ]);
    }

    public function update(Request $request, $id)
    {
        $roles = [
            'image' => 'image|mimes:jpeg,jpg,png',
            'price' => 'required|numeric',
            'duration' => 'required|numeric'
        ];
         foreach ($this->locales as $locale) {
            $roles['title_' . $locale->lang] = 'required';
        }
        $this->validate($request, $roles);
        $item = Package::query()->where('id', $id)->firstOrFail();
        $item->price = $request->get('price');
        $item->duration = $request->get('duration');
        $item->order_by = $request->get('order');
        $item->createdBy = auth()->id();
        foreach ($this->locales as $locale) {
            $item->translateOrNew($locale->lang)->title = ucwords($request->get('title_' . $locale->lang));
        }
         if ($request->hasFile('image')) {
            $image = $request->file('image')->store('uploads/images/package');
            $item->image = $image;
        } 
        $item->save();
        return redirect()->back()->with('status', __('common.update'));
    }

    public function destroy($id)
    {
        $item = Package::query()->findOrFail($id);
        if ($item) {
            Package::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }

    public function changeStatus(Request $request)
    {
        if ($request->event == 'delete') {
            Package::query()->whereIn('id', $request->IDsArray)->delete();
        } else {
            Package::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);
        }
        return $request->event;
    }
}
