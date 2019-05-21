<?php

namespace App\Http\Controllers\CP;

use App\Models\Currency;
use App\Models\Country;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryController extends Controller
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
        $items = Country::query();
        if ($request->has('name')) {
            if ($request->get('name') != null)
                $items->whereHas('translations', function ($query) use ($request) {
                    $query->where('locale', app()->getLocale())
                        ->where('name', 'like', '%' . $request->get('name') . '%');
                });
        }
        $items = $items->orderBy('id', 'desc')->paginate($this->settings->value);
        return view('cp.country.home', [
            'items' => $items,
        ]);
    }

    public function create()
    {
        $currency = Currency::all();
        return view('cp.country.create', [
            'currency' => $currency,
        ]);
    }

    public function store(Request $request)
    {
        $roles = [
            'flag_icon' => 'required|image|mimes:jpeg,jpg,png',
            'name' => 'required',
        ];
        $this->validate($request, $roles);
        $image = $request->file('flag_icon')->store('uploads/images/country');
        $item = new Country();
        $item->createdBy=auth()->id();
        $item->order_by=$request->order;
        $item->flag_icon=$image;
        $item->name=$request->name;
        $item->currency_id=$request->currency_id;
        $item->save();
        return redirect()->back()->with('status', __('common.create'));
    }

    public function show($id)
    {
        return Country::query()->findOrFail($id);
    }

    public function edit($id)
    {
        $currency = Currency::all();
        $item = $this->show($id);
        return view('cp.country.edit', [
            'item' => $item,
            'currency' => $currency,
        ]);
    }

    public function update(Request $request, $id)
    {

       $roles = [
            'name' => 'required',
        ];
        $this->validate($request, $roles);
        $item = Country::query()->where('id', $id)->firstOrFail();
         if ($request->hasFile('flag_icon')) {
           $flag_icon = $request->file('flag_icon')->store('uploads/images/country');
           $item->flag_icon=$flag_icon;
        }
        $item->name=$request->name;
        $item->order_by=$request->order;
        $item->createdBy=auth()->id();
        $item->currency_id=$request->currency_id;
        $item->save();
        return redirect()->back()->with('status', __('common.update'));
    }

    public function destroy($id)
    {
        $item = Country::query()->findOrFail($id);
        if ($item) {
            Country::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }

    public function changeStatus(Request $request)
    {
        if ($request->event == 'delete') {
            Country::query()->whereIn('id', $request->IDsArray)->delete();
        }else {
            Country::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);
        }
        return $request->event;
    }
}
