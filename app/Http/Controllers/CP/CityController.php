<?php

namespace App\Http\Controllers\CP;

use App\Models\City;
use App\Models\Country;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CityController extends Controller
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
        $items = City::query();
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
        return view('cp.city.home', [
            'items' => $items,
        ]);
    }

    public function create()
    {
        $country = Country::all();
        return view('cp.city.create', [
            'country' => $country,
        ]);
    }

    public function store(Request $request)
    {
        $roles = [
            'name' => 'required',
        ];
        $this->validate($request, $roles);
        $item = new City();
        $item->createdBy=auth()->id();
        $item->order_by=$request->order;
        $item->name=$request->name;
        $item->country_id=$request->country_id;
        $item->save();
        return redirect()->back()->with('status', __('common.create'));
    }

    public function show($id)
    {
        return City::query()->findOrFail($id);
    }

    public function edit($id)
    {
        $country = Country::all();
        $item = $this->show($id);
        return view('cp.city.edit', [
            'item' => $item,
            'country' => $country,
        ]);
    }

    public function update(Request $request, $id)
    {

       $roles = [
            'name' => 'required',
        ];
        $this->validate($request, $roles);
        $item = City::query()->where('id', $id)->firstOrFail();
        $item->name=$request->name;
        $item->order_by=$request->order;
        $item->createdBy=auth()->id();
        $item->country_id=$request->country_id;
        $item->save();
        return redirect()->back()->with('status', __('common.update'));
    }

    public function destroy($id)
    {
        $item = City::query()->findOrFail($id);
        if ($item) {
            City::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }

    public function changeStatus(Request $request)
    {
        if ($request->event == 'delete') {
            City::query()->whereIn('id', $request->IDsArray)->delete();
        }else {
            City::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);
        }
        return $request->event;
    }
}
