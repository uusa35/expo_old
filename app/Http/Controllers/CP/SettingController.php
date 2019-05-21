<?php

namespace App\Http\Controllers\CP;

use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Language;
use App\Models\Publish;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\SliderImages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->settings = Setting::query()->get();
        view()->share([
            'settings' => $this->settings,
        ]);
    }

    public function index()
    {
//        return $this->settings;
        $publishes = Publish::query()->get();
        return view('cp.settings.home', ['publishes' => $publishes]);
    }

    public function update(Request $request)
    {
        try {

//            return $request->all();
            foreach (request()->all() as $key => $value) {

                if (isset($key)) {
                    Setting::where('key', $key)->update(['value' => $value]);
                }
            }

            if ($request->hasFile('site_logo')) {
                $image = $request->file('site_logo')->store('/uploads/images/settings/');
                Setting::query()->where('key', 'site_logo')->update(['value' => $image]);
            }
            return redirect()->back()->with('status', __('common.update'));


        } catch (Exception $e) {
            return redirect()->back()->withErrors('errors', $e->getMessage());
        }


    }

}
