<?php

namespace App\Http\Controllers\CP;

use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Language;
use App\Models\Package;
use App\Models\Subscription;
use App\Models\Setting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
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
        $items = Subscription::query();
        if ($request->has('duration')) {
            if ($request->get('duration') != null)
                $items->where('duration', $request->get('duration'));
        }
        if ($request->get('user')) {
            $items->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->get('user') . '%');
            });
        }
        if ($request->has('package_id')) {
            if ($request->get('package_id') != null)
                $items->where('package_id', $request->get('package_id'));
        }
        $items = $items->orderBy('id', 'desc')->paginate($this->settings->value);
        $packages = Package::query()->where('status', 'active')->get();
        return view('cp.subscription.home', [
            'items' => $items,
            'packages' => $packages,
        ]);

    }

    public function create()
    {
        $users = User::query()->where('user_type', 2)->get();
        $packages = Package::query()->where('status', 'active')->get();
        return view('cp.subscription.create', compact('users', 'packages'));
    }

    public function store(Request $request)
    {
        $roles = [
            'user_id' => 'required|numeric',
            'package_id' => 'required|numeric',
        ];
        $this->validate($request, $roles);
        Subscription::query()->create([
            'user_id' => $request->user_id,
            'package_id' => $request->package_id,
            'from' => Carbon::now(),
            'to' => Carbon::now()->addMonths(Package::query()->find($request->package_id)->duration),
        ]);
        return redirect()->back()->with('status', __('common.create'));
    }

    public function destroy($id)
    {
        $item = Subscription::query()->findOrFail($id);
        if ($item) {
            Subscription::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }

    public function changeStatus(Request $request)
    {
        if ($request->event == 'delete') {
            Subscription::query()->whereIn('id', $request->IDsArray)->delete();
        } else {
            Subscription::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);
        }
        return $request->event;
    }
}
