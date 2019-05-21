<?php

namespace App\Http\Controllers\CP;

use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Contact;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
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
        $items = Contact::query();
        if ($request->has('email')) {
            if ($request->get('email') != null)
                $items->where('email', 'like', '%' . $request->get('email') . '%');
        }
        if ($request->has('comment')) {
            if ($request->get('comment') != null)
                $items->where('comment', 'like', '%' . $request->get('comment') . '%');
        }
        if ($request->has('mobile')) {
            if ($request->get('mobile') != null)
                $items->where('mobile', 'like', '%' . $request->get('mobile') . '%');
        }
        $items = $items->orderBy('id', 'desc')->paginate($this->settings->value);
        return view('cp.contacts.home', [
            'items' => $items,
        ]);

    }

    public function destroy($id)
    {
        $item = Contact::query()->findOrFail($id);
        if ($item) {
            Contact::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }
}
