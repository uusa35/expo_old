<?php

namespace App\Http\Controllers\CP;

use App\Models\EventOffers;
use App\Models\EventOffersTranslation;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventOffersController extends Controller
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

        $items = EventOffers::query();
        if ($request->has('details')) {
            if ($request->get('details') != null)
                $items->whereHas('translations', function ($query) use ($request) {
                    $query->where('locale', app()->getLocale())
                        ->where('details', 'like', '%' . $request->get('details') . '%');
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
        return view('cp.event_offers.home', [
            'items' => $items,
        ]);

    }

    public function create()
    {
        return view('cp.event_offers.create');
    }

    public function store(Request $request)
    {
        $roles = [
            'image' => 'required|image|mimes:jpeg,jpg,png',
            'type' => 'required',
            'order' => 'numeric',
        ];
        foreach ($this->locales as $locale) {
            $roles['details_' . $locale->lang] = 'required';
        }
        $this->validate($request, $roles);
        $image = $request->file('image')->store('uploads/images/events_offers');

        $item = EventOffers::query()->create([
            'type' => $request->type,
            'order_by' => $request->order,
            'image' => $image,
            'createdBy' => auth()->id(),
        ]);
        foreach ($this->locales as $locale) {
            $item->translateOrNew($locale->lang)->details = $request->get('details_' . $locale->lang);
        }
        $item->save();
        return redirect()->back()->with('status', __('common.create'));
    }

    public function show($id)
    {
        return EventOffers::query()->findOrFail($id);
    }

    public function edit($id)
    {
        $item = $this->show($id);
        return view('cp.event_offers.edit', [
            'item' => $item,
        ]);
    }

    public function update(Request $request, $id)
    {
        $roles = [
            'image' => 'image|mimes:jpeg,jpg,png',
            'type' => 'required',
            'order' => 'numeric',
        ];
        foreach ($this->locales as $locale) {
            $roles['details_' . $locale->lang] = 'required';
        }
        $this->validate($request, $roles);
        $item = EventOffers::query()->where('id', $id)->firstOrFail();
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('uploads/images/events_offers');
            $item->image = $image;
        }
        $item->order_by = $request->get('order');
        $item->type = $request->get('type');
        $item->createdBy = auth()->id();

        foreach ($this->locales as $locale) {
            $item->translateOrNew($locale->lang)->details = $request->get('details_' . $locale->lang);
        }
        $item->save();
        return redirect()->back()->with('status', __('common.update'));


    }

    public function destroy($id)
    {
        $item = EventOffers::query()->findOrFail($id);
        if ($item) {
            EventOffers::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }

    public function changeStatus(Request $request)
    {
        if ($request->event == 'delete') {
            EventOffers::query()->whereIn('id', $request->IDsArray)->delete();
        } else {
            EventOffers::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);
        }
        return $request->event;
    }
}
