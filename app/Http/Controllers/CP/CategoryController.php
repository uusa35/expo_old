<?php

namespace App\Http\Controllers\CP;

use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
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

        $items = Category::query();
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
                $items->where('type', $request->get('type'));
        }

        $items = $items->orderBy('id','desc')->paginate($this->settings->value);
        return view('cp.category.home', [
            'items' => $items,
        ]);

    }

    public function create()
    {
        return view('cp.category.create');
    }

    public function store(Request $request)
    {
        $roles = [
            'order' => 'numeric',
            'image' => 'required|image|mimes:jpeg,jpg,png',
        ];
        foreach ($this->locales as $locale) {
            $roles['title_' . $locale->lang] = 'required';
            $roles['details_' . $locale->lang] = 'required';
        }
        $this->validate($request, $roles);
        $image = $request->file('image')->store('uploads/images/category');

        $item = Category::query()->create([
            'order_by' => $request->order,
            'type' => $request->type,
            'createdBy' => auth()->id(),
            'image' => $image,
        ]);
        foreach ($this->locales as $locale) {
            $item->translateOrNew($locale->lang)->title = ucwords($request->get('title_' . $locale->lang));
            $item->translateOrNew($locale->lang)->details = $request->get('details_' . $locale->lang);
        }
        $item->save();
        return redirect()->back()->with('status', __('common.create'));
    }

    public function show($id)
    {
        return Category::query()->findOrFail($id);
    }

    public function edit($id)
    {
        $item = $this->show($id);
        return view('cp.category.edit', [
            'item' => $item,
        ]);
    }

    public function update(Request $request, $id)
    {
        $roles = [
            'order' => 'numeric',
        ];
        foreach ($this->locales as $locale) {
            $roles['title_' . $locale->lang] = 'required';
            $roles['details_' . $locale->lang] = 'required';
        }
        $this->validate($request, $roles);
        $item = Category::query()->where('id', $id)->firstOrFail();
        $item->order_by = $request->get('order');
        $item->type = $request->get('type');
        $item->createdBy = auth()->id();
        foreach ($this->locales as $locale) {
            $item->translateOrNew($locale->lang)->title = ucwords($request->get('title_' . $locale->lang));
            $item->translateOrNew($locale->lang)->details = $request->get('details_' . $locale->lang);
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('uploads/images/category');
            $item->image = $image;
        }    
        $item->save();
        return redirect()->back()->with('status', __('common.update'));
    }
    public function destroy($id)
    {
        $item = Category::query()->findOrFail($id);
        if ($item) {
            Category::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }
    public function changeStatus(Request $request)
    {
        if ($request->event == 'delete') {
            Category::query()->whereIn('id', $request->IDsArray)->delete();
        } else {
            Category::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);
        }
        return $request->event;
    }
}
