<?php

namespace App\Http\Controllers\CP;

use App\Models\Color;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ColorController extends Controller
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
        $items = Color::query();
        if ($request->has('status')) {
            if ($request->get('status') != null)
                $items->where('status', $request->get('status'));
        }
        $items = $items->orderBy('id', 'desc')->paginate($this->settings->value);
        return view('cp.colors.home', [
            'items' => $items,
        ]);
    }

    public function create()
    {
        return view('cp.colors.create');
    }

    public function store(Request $request)
    {

        $request->request->add(['color' => str_replace('#','',$request->color)]);
        $this->validate($request, [
            'color' => 'required|unique:colors'
        ]);
        $item = new Color();
        $item->color=str_replace('#','',$request->color);
        $item->createdBy=auth()->id();
        $item->order_by=$request->order;
        $item->status='active';
        $item->save();
        return redirect()->back()->with('status', __('common.create'));
    }
    public function show($id)
    {
        return Color::query()->findOrFail($id);
    }
    public function edit($id)
    {
        $item = $this->show($id);
        return view('cp.colors.edit', [
            'item' => $item,
        ]);
    }
    public function update(Request $request, $id)
    {

        $request->request->add(['color' => str_replace('#','',$request->color)]);
        $this->validate($request, [
            'color' => 'required|unique:colors,color,'.$id
        ]);
        $item = Color::query()->findOrFail($id);
        $item->order_by=$request->order;
        $item->createdBy=auth()->id();
        $item->color=str_replace('#','',$request->color);
        $item->save();
        return redirect()->back()->with('status', __('common.update'));
    }

    public function destroy($id)
    {
        $item = Color::query()->findOrFail($id);
        if ($item) {
            Color::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }

    public function changeStatus(Request $request)
    {
        if ($request->event == 'delete') {
            Color::query()->whereIn('id', $request->IDsArray)->delete();
        }else {
            Color::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);
        }
        return $request->event;
    }
}
