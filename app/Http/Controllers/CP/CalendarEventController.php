<?php

namespace App\Http\Controllers\CP;
use App\Models\Expo;

use App\Models\CalendarEvent;
use App\Models\Category;
use App\Models\Cafe;
use App\Models\CafeImages;
use App\Models\CategoryTranslation;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CalendarEventController extends Controller
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
        $items = CalendarEvent::query();
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
        return view('cp.events.home', [
            'items' => $items,
        ]);
    }
    public function create()
    {
        $categories = Category::all();
         $expo = Expo::all();
        return view('cp.events.create', [
            'categories' => $categories,
             'expo' => $expo ,
        ]);
    }
    public function store(Request $request)
    {
        $roles = [
            'type' => 'numeric|required',
            'order' => 'numeric',
            'start_date' => 'before:end_date',
            'end_date' => 'after:start_date',
        ];
        foreach ($this->locales as $locale) {
            $roles['title_' . $locale->lang] = 'required';
        }
        $this->validate($request, $roles);
        $user_id=Auth::id();
        $item = CalendarEvent::query()->create([
            'order_by' => $request->order,
            'user_id' => $user_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'type' => $request->type,
            'expo_id' => $request->expo_id,
            'createdBy' =>  $user_id
        ]);
        foreach ($this->locales as $locale) {
            $item->translateOrNew($locale->lang)->title = ucwords($request->get('title_' . $locale->lang));
            $item->translateOrNew($locale->lang)->description = ucwords($request->get('description_' . $locale->lang));
        }
       
        $item->save();
        return redirect()->back()->with('status', __('common.create'));
    }
    public function show($id)
    {
        return CalendarEvent::query()->findOrFail($id);
    }
    public function edit($id)
    {
        $expo = Expo::all();
        $item = $this->show($id);
        return view('cp.events.edit', [
            'item' => $item,
            'expo' => $expo ,
        ]);
    }
    public function update(Request $request, $id)
    {
        $roles = [
            'order' => 'numeric',
        ];
        foreach ($this->locales as $locale) {
            $roles['title_' . $locale->lang] = 'required';
        }
        $this->validate($request, $roles);
        $item = CalendarEvent::query()->where('id',$id)->firstOrFail();
       
        $item->order_by = $request->get('order');
        $item->start_date =  $request->get('start_date');
        $item->end_date =$request->get('end_date');
        $item->type =$request->get('type');
        $item->expo_id=$request->get('expo_id');
        $item->createdBy = Auth::id();

        foreach ($this->locales as $locale) {
            $item->translateOrNew($locale->lang)->title = ucwords($request->get('title_' . $locale->lang));
            $item->translateOrNew($locale->lang)->description = ucwords($request->get('description_' . $locale->lang));
            
        }
        $item->save();
        return redirect()->back()->with('status', __('common.update'));
    }
    public function destroy($id)
    {
        $item = CalendarEvent::query()->findOrFail($id);
        if ($item) {
            CalendarEvent::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }
    public function changeStatus(Request $request)
    {
        if ($request->event == 'delete') {
            CalendarEvent::query()->whereIn('id', $request->IDsArray)->delete();
        } else {
            CalendarEvent::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);
        }
        return $request->event;
    }
}
