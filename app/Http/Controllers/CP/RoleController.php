<?php

namespace App\Http\Controllers\CP;

use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\JobTitle;
use App\Models\Language;
use App\Models\Permission;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->locales = Language::all();
        $this->settings = Setting::query()->first();
        view()->share([
            'locales' => $this->locales,
            'settings' => $this->settings,

        ]);
    }

    public function image_extensions(){

        return array('jpg','png','jpeg','gif','bmp');

    }


    public function index(Request $request)
    {



        $items = Permission::query();


        $items = $items->orderBy('id', 'desc')->get();
        //return $items;

        return view('cp.role.home', [
            'items' => $items,
        ]);

    }

    public function create()
    {
        return view('cp.role.create');
    }

    public function store(Request $request)
    {

        foreach ($this->locales as $locale) {
            $roles['title_' . $locale->lang] = 'required';
            //$roles['details_' . $locale->lang] = 'required';
        }
        $this->validate($request, $roles);

        $item = New Permission();


        foreach ($this->locales as $locale) {
            $item->translateOrNew($locale->lang)->name = ucwords($request->get('title_' . $locale->lang));
            //$item->translateOrNew($locale->lang)->details = $request->get('details_' . $locale->lang);
        }
        //$text = iconv('utf-8', 'us-ascii//TRANSLIT', $request->title_en);
        $slug=strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title_en));

        $item->roleSlug=$slug;
        $item->save();


        return redirect()->back()->with('status', __('common.create'));
    }

    public function show($id)
    {
        return Permission::query()->findOrFail($id);
    }

    public function edit($id)
    {
        $item = $this->show($id);
        return view('cp.role.edit', [
            'item' => $item,
        ]);
    }

    public function update(Request $request, $id)
    {

        foreach ($this->locales as $locale) {
            $roles['title_' . $locale->lang] = 'required';
            //$roles['details_' . $locale->lang] = 'required';
        }
        $this->validate($request, $roles);

        $item = Permission::findOrFail($id);
        foreach ($this->locales as $locale) {
            $item->translateOrNew($locale->lang)->name = ucwords($request->get('title_' . $locale->lang));
            //$item->translateOrNew($locale->lang)->details = $request->get('details_' . $locale->lang);
        }

        $item->save();
        return redirect()->back()->with('status', __('common.update'));


    }

    public function destroy($id)
    {
        $item = Permission::query()->findOrFail($id);
        if ($item) {
            Permission::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }


}
