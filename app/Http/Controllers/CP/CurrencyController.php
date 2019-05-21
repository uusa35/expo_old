<?php

namespace App\Http\Controllers\CP;

use App\Models\Currency;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurrencyController extends Controller
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
        $items = Currency::query();
        if ($request->has('name')) {
            if ($request->get('name') != null)
                $items->whereHas('translations', function ($query) use ($request) {
                    $query->where('locale', app()->getLocale())
                        ->where('name', 'like', '%' . $request->get('name') . '%');
                });
        }
        $items = $items->orderBy('id', 'desc')->paginate($this->settings->value);
        return view('cp.currency.home', [
            'items' => $items,
        ]);
    }

    public function create()
    {
        return view('cp.currency.create');
    }

    public function store(Request $request)
    {
        foreach ($this->locales as $locale) {
            $roles['name_' . $locale->lang] = 'required';
        }
        $this->validate($request, $roles);
        $item = new Currency();
        foreach ($this->locales as $locale) {
            $item->translateOrNew($locale->lang)->name = ucwords($request->get('name_' . $locale->lang));
        }
        $item->createdBy=auth()->id();
        $item->shortcut=$request->shortcut;
        $item->order_by=$request->order;
        $item->price=$request->price;
        $item->save();
        return redirect()->back()->with('status', __('common.create'));
    }

    public function show($id)
    {
        return Currency::query()->findOrFail($id);
    }

    public function edit($id)
    {
        $item = $this->show($id);
        return view('cp.currency.edit', [
            'item' => $item,
        ]);
    }

    public function update(Request $request, $id)
    {

        foreach ($this->locales as $locale) {
            $roles['name_' . $locale->lang] = 'required';
        }
        $this->validate($request, $roles);
        $item = Currency::query()->where('id', $id)->firstOrFail();
        foreach ($this->locales as $locale) {
            $item->translateOrNew($locale->lang)->name = ucwords($request->get('name_' . $locale->lang));
        }
        $item->order_by=$request->order;
        $item->createdBy=auth()->id();
        $item->shortcut=$request->shortcut;
        $item->save();
        return redirect()->back()->with('status', __('common.update'));
    }

    public function destroy($id)
    {
        $item = Currency::query()->findOrFail($id);
        if ($item) {
            Currency::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }

    public function changeStatus(Request $request)
    {
        if ($request->event == 'delete') {
            Currency::query()->whereIn('id', $request->IDsArray)->delete();
        }else {
            Currency::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);
        }
        return $request->event;
    }
}
