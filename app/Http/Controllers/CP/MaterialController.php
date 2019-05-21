<?php

namespace App\Http\Controllers\CP;

use App\Models\Material;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MaterialController extends Controller
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
        $items = Material::query();
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
        $items = $items->orderBy('id', 'desc')->paginate($this->settings->value);
        return view('cp.material.home', [
            'items' => $items,
        ]);
    }

    public function create()
    {
        return view('cp.material.create');
    }

    public function store(Request $request)
    {
        foreach ($this->locales as $locale) {
            $roles['name_' . $locale->lang] = 'required';
        }
        $this->validate($request, $roles);
        $item = new Material();
        foreach ($this->locales as $locale) {
            $item->translateOrNew($locale->lang)->name = ucwords($request->get('name_' . $locale->lang));
        }
        $item->createdBy=auth()->id();
        $item->order_by=$request->order;
        $item->save();
        return redirect()->back()->with('status', __('common.create'));
    }
    public function show($id)
    {
        return Material::query()->findOrFail($id);
    }
    public function edit($id)
    {
        $item = $this->show($id);
        return view('cp.material.edit', [
            'item' => $item,
        ]);
    }
    public function update(Request $request, $id)
    {
        foreach ($this->locales as $locale) {
            $roles['name_' . $locale->lang] = 'required';
        }
        $this->validate($request, $roles);
        $item = Material::query()->where('id', $id)->firstOrFail();
        foreach ($this->locales as $locale) {
            $item->translateOrNew($locale->lang)->name = ucwords($request->get('name_' . $locale->lang));
        }
        $item->order_by=$request->order;
        $item->createdBy=auth()->id();
        $item->save();
        return redirect()->back()->with('status', __('common.update'));
    }

    public function destroy($id)
    {
        $item = Material::query()->findOrFail($id);
        if ($item) {
            Material::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }

    public function changeStatus(Request $request)
    {
        if ($request->event == 'delete') {
            Material::query()->whereIn('id', $request->IDsArray)->delete();
        }else {
            Material::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);
        }
        return $request->event;
    }
}
