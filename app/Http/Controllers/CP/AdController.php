<?php

namespace App\Http\Controllers\Cp;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdController extends Controller
{

    public function __construct()
    {
        $this->settings = Setting::query()->where('key', 'per_page')->select(['value'])->first();
        view()->share([
            'settings' => $this->settings,
        ]);
    }
    public function index(Request $request)
    {
        $items = Ad::query();

        if ($request->get('status') || $request->get('status') === '0') {
            $items->where('status', $request->get('status'));
        }
        if ($request->get('search')) {
            $items->where('desc', 'like', '%'.$request->get('search').'%');
        }
        $items = $items->orderBy('id', 'desc')->paginate($this->settings->value);
        return view('cp.ads.home', [
            'items' => $items,
        ]);

    }

    public function create()
    {
        return view('cp.ads.create');
    }

    public function store(Request $request)
    {
        $roles = [
            'image' => 'required|image|mimes:jpeg,jpg,png',
        ];
        $this->validate($request, $roles);
        $image = $request->file('image')->store('uploads/images/ads');

        $item = Ad::query()->create([
            'image' => $image,
            'createdBy' => auth()->id(),
        ]);

        $item->save();
        return redirect()->back()->with('status', __('common.create'));
    }


    public function edit($id)
    {
        $item = Ad::query()->findOrFail($id);
        return view('cp.ads.edit', [
            'item' => $item,
        ]);
    }

    public function update(Request $request, $id)
    {
        $roles = [
            'image' => 'image|mimes:jpeg,jpg,png',
        ];

        $data = $request->all();
        $this->validate($request, $roles);
        $item = Ad::query()->where('id', $id)->firstOrFail();
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('uploads/images/ads');
            $data['image'] = $image;
        }

        $item->update($data);

        return redirect()->back()->with('status', __('common.update'));


    }

    public function destroy($id)
    {
        $item = Ad::query()->findOrFail($id);
        if ($item) {
            Ad::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }

    public function changeStatus(Request $request)
    {
        if ($request->get('event') == 'delete') {
            Ad::query()->whereIn('id', $request->get('IDsArray'))->delete();
        } else {
            Ad::query()->whereIn('id', $request->get('IDsArray'))->update(['status' => $request->get('event')]);
        }
        return $request->get('event');
    }
}
