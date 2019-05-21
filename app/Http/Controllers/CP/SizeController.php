<?php

namespace App\Http\Controllers\CP;

use App\Models\Size;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SizeController extends Controller
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
        $items = Size::query();
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
        return view('cp.size.home', [
            'items' => $items,
        ]);
    }

    public function create()
    {
        return view('cp.size.create');
    }

    public function store(Request $request)
    {
        foreach ($this->locales as $locale) {
            $roles['name_' . $locale->lang] = 'required';
        }
        $this->validate($request, $roles);
        $item = new Size();
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
        return Size::query()->findOrFail($id);
    }

    public function edit($id)
    {
        $item = $this->show($id);
        return view('cp.size.edit', [
            'item' => $item,
        ]);
    }

    public function update(Request $request, $id)
    {

        foreach ($this->locales as $locale) {
            $roles['name_' . $locale->lang] = 'required';
        }
        $this->validate($request, $roles);
        $item = Size::query()->where('id', $id)->firstOrFail();
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
        $item = Size::query()->findOrFail($id);
        if ($item) {
            Size::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }

    public function changeStatus(Request $request)
    {
        if ($request->event == 'delete') {
            Size::query()->whereIn('id', $request->IDsArray)->delete();
        }else {
            Size::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);
        }
        return $request->event;
    }
}
