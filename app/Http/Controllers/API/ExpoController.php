<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Expo;
use App\Models\ExpoCountry;
use App\Models\Product;
use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class ExpoController extends Controller
{
    public function index()
    {
        $data['slider'] = Slider::query()->public()->get();
        $data['expo'] = Expo::query()->public()->take(12)->get();
        return mainResponse(true, 'api.ok', $data, []);
    }

    public function expo(Request $request)
    {
        $items = Expo::query()->where('type_id', 1)->where('status', 'active')->public();
        if ($request->has('name')) {
            if ($request->get('name') != null)
                $items->whereHas('translations', function ($query) use ($request) {
                    $query->where('locale', app()->getLocale())
                        ->where('name', 'like', '%' . $request->get('name') . '%');
                });
        }
        $data = $items->orderBy('id', 'desc')->paginate(10);
        return mainResponse(true, 'api.ok', $data, []);
    }

    public function business(Request $request)
    {
        $items = Expo::query()->where('type_id', 2)->where('status', 'active')->public();
        if ($request->has('name')) {
            if ($request->get('name') != null)
                $items->whereHas('translations', function ($query) use ($request) {
                    $query->where('locale', app()->getLocale())
                        ->where('name', 'like', '%' . $request->get('name') . '%');
                });
        }
        $data = $items->orderBy('id', 'desc')->paginate(10);
        return mainResponse(true, 'api.ok', $data, []);
    }

    public function expo_details($expo_id, Request $request)
    {
        $data = Expo::query()->where('id', $expo_id)->with(['category', 'country', 'hisCountry', 'user'])->first();
        if ($data) {
            foreach ($data->country as $country) {
                $country['cities'] = $country->pivot->cities;
            }
            return mainResponse(true, 'api.ok', $data, []);
        } else {
            return mainResponse(false, 'api.failed', '', []);
        }
    }

    public function product_details($product_id, Request $request)
    {
        $data = Product::query()->where('id', $product_id)->with(['category', 'colors', 'materials', 'sizes', 'images', 'clothingTypes', 'occasions'])->first();
        if ($data) {
            return mainResponse(true, 'api.ok', $data, []);
        } else {
            return mainResponse(false, 'api.failed', '', []);
        }
    }

    public function expo_products($expo_id, Request $request)
    {
        $items = Product::query()->where('expo_id', $expo_id);
        if ($request->has('title')) {
            if ($request->get('title') != null)
                $items->whereHas('translations', function ($query) use ($request) {
                    $query->where('locale', app()->getLocale())
                        ->where('title', 'like', '%' . $request->get('title') . '%');
                });
        }
        if ($request->sort == 1) {
            $items->orderBy('current_price', 'asc');
        }
        elseif ($request->sort == 2) {
            $items->orderBy('current_price', 'desc');
        }
        elseif ($request->sort == 3) {
            $items = $items->
            join('product_translations as t', function ($join) {
                $join->on('t.product_id', '=', 'products.id')
                    ->where('t.locale', '=', app()->getLocale());
            })
                ->groupBy('products.id')
                ->orderBy('t.title', 'asc')->select('products.*');
        }
        elseif ($request->sort == 4) {
            $items = $items->
            join('product_translations as t', function ($join) {
                $join->on('t.product_id', '=', 'products.id')
                    ->where('t.locale', '=', app()->getLocale());
            })
                ->groupBy('products.id')
                ->orderBy('t.title', 'desc')->select('products.*');
        }
        else{
            $items->orderBy('id', 'desc');
        }
        $data = $items->paginate(8);
        if ($data) {
            return mainResponse(true, 'api.ok', $data, []);
        } else {
            return mainResponse(false, 'api.failed', '', []);
        }
    }


    public function expos(Request $request)
    {
        $type_id = $request->type_id;
        $country_id = $request->country_id;
        $category_id = $request->category_id;
        $expos = Expo::query()->whereHas('user', function ($q){
            $q->whereHas('subscriptions', function ($q){
                $q->where('to', '<=', Carbon::today()->toDateString());
            });
        });
        if ($request->sort == 1) {
            $expos = $expos->
            join('expo_translations as t', function ($join) {
                $join->on('t.expo_id', '=', 'expos.id')
                    ->where('t.locale', '=', app()->getLocale());
            })
                ->groupBy('expos.id')
                ->orderBy('t.name', 'asc')->select('expos.*');
        }
        elseif ($request->sort == 2) {
            $expos = $expos->
            join('expo_translations as t', function ($join) {
                $join->on('t.expo_id', '=', 'expos.id')
                    ->where('t.locale', '=', app()->getLocale());
            })
                ->groupBy('expos.id')
                ->orderBy('t.name', 'desc')->select('expos.*');
        }
        else{
            $expos->orderBy('id', 'desc');
        }
        if (($country_id)) {
            $expos->whereHas('country', function ($q) use ($country_id) {
                $q->where('country_id', $country_id);
            })->Orwhere('country_id', $country_id);
        }

        if (($category_id)) {
            $expos->whereHas('category', function ($q) use ($category_id) {
                $q->where('category_id', $category_id);
            });
        }
        if (($type_id)) {
            $expos->where('type_id', $type_id);
        }

        if ($request->has('name')) {
            if ($request->get('name') != null)
                $expos->whereTranslationLike('name', '%'.$request->get('name').'%')->orWhereHas('products', function ($q) use($request){
                    $q->whereTranslationLike('title', '%'.$request->get('name').'%');
                });
        }
        $data = $expos->where('status', 'active')->orderBy('id', 'desc')->paginate(10);
        return mainResponse(true, 'api.ok', $data, []);
    }

    public function expo_new(Request $request)
    {
        $country_id = $request->country_id;
        $category_id = $request->category_id;
        $expos = Expo::query();
        if ($request->sort == 1) {
            $expos = $expos->
            join('expo_translations as t', function ($join) {
                $join->on('t.expo_id', '=', 'expos.id')
                    ->where('t.locale', '=', app()->getLocale());
            })
                ->groupBy('expos.id')
                ->orderBy('t.name', 'asc')->select('expos.*');
        }
        elseif ($request->sort == 2) {
            $expos = $expos->
            join('expo_translations as t', function ($join) {
                $join->on('t.expo_id', '=', 'expos.id')
                    ->where('t.locale', '=', app()->getLocale());
            })
                ->groupBy('expos.id')
                ->orderBy('t.name', 'desc')->select('expos.*');
        }
        else{
            $expos->orderBy('id', 'desc');
        }
        if (($country_id)) {
            $expos->where('country_id', $country_id)->orWhereHas('country', function ($q) use ($country_id) {
                $q->where('country_id', $country_id);
            });
        }

        if (($category_id)) {
            $expos->whereHas('category', function ($q) use ($category_id) {
                $q->where('category_id', $category_id);
            });
        }

        /*        $country_id = $request->country_id;
                $category_id = $request->category_id;
                $items = ExpoCountry::query();
                if (!empty($country_id)) {
                    if ($country_id != null)
                        $items->where('country_id', $country_id);
                }
                $items = $items->get();
                $in = array();
                if (!empty($items)) {
                    foreach ($items as $item) {
                        $in[] = $item->expo_id;
                    }
                } else {
                    $in = null;
                }*/

        /*        $items2 = ExpoCategory::query();
                if (!empty($category_id)) {
                    if ($category_id != null)
                        $items2->where('category_id', $category_id);
                }
                $items2 = $items2->get();
                $in2 = array();
                if (!empty($items2)) {
                    foreach ($items2 as $item) {
                        $in2[] = $item->expo_id;
                    }
                } else {
                    $in2 = null;
                }*/

//        $ex_ids = array_unique(array_merge($in, $in2));

//        $items = Expo::query()->whereIn('id', $ex_ids)->Orwhere('country_id', $country_id)->public();
        if ($request->has('name')) {
            if ($request->get('name') != null)
                $expos->whereHas('translations', function ($query) use ($request) {
                    $query->where('locale', app()->getLocale())
                        ->where('name', 'like', '%' . $request->get('name') . '%');
                });
        }
        $data = $expos->where('type_id', 1)->where('status', 'active')->paginate(10);
        return mainResponse(true, 'api.ok', $data, []);
    }

    public function business_new(Request $request)
    {
        $country_id = $request->country_id;
        $category_id = $request->category_id;
        $expos = Expo::query();

        if ($request->sort == 1) {
            $expos = $expos->
            join('expo_translations as t', function ($join) {
                $join->on('t.expo_id', '=', 'expos.id')
                    ->where('t.locale', '=', app()->getLocale());
            })
                ->groupBy('expos.id')
                ->orderBy('t.name', 'asc')->select('expos.*');
        }
        elseif ($request->sort == 2) {
            $expos = $expos->
            join('expo_translations as t', function ($join) {
                $join->on('t.expo_id', '=', 'expos.id')
                    ->where('t.locale', '=', app()->getLocale());
            })
                ->groupBy('expos.id')
                ->orderBy('t.name', 'desc')->select('expos.*');
        }
        else{
            $expos->orderBy('id', 'desc');
        }

        if (($country_id)) {
            $expos->where('country_id', $country_id)->orWhereHas('country', function ($q) use ($country_id) {
                $q->where('country_id', $country_id);
            });
        }

        if (($category_id)) {
            $expos->whereHas('category', function ($q) use ($category_id) {
                $q->where('category_id', $category_id);
            });
        }

        /*        $items = ExpoCountry::query();
                if (!empty($country_id)) {
                    if ($country_id != null)
                        $items->where('country_id', $country_id);
                }
                $items = $items->get();
                $in = array();
                if (!empty($items)) {
                    foreach ($items as $item) {
                        $in[] = $item->expo_id;
                    }
                } else {
                    $in = null;
                }*/

        /*        $items2 = ExpoCategory::query();
                if (!empty($category_id)) {
                    if ($category_id != null)
                        $items2->where('category_id', $category_id);
                }
                $items2 = $items2->get();
                $in2 = array();
                if (!empty($items2)) {
                    foreach ($items2 as $item) {
                        $in2[] = $item->expo_id;
                    }
                } else {
                    $in2 = null;
                }

                $ex_ids = array_unique(array_merge($in, $in2));
        */

//        $items = Expo::query()->whereIn('id', $ex_ids)->Orwhere('country_id', $country_id)->public();
        if ($request->has('name')) {
            if ($request->get('name') != null)
                $expos->whereHas('translations', function ($query) use ($request) {
                    $query->where('locale', app()->getLocale())
                        ->where('name', 'like', '%' . $request->get('name') . '%');
                });
        }
        $data = $expos->where('type_id', 2)->where('status', 'active')->paginate(10);
        return mainResponse(true, 'api.ok', $data, []);
    }

    public function expo_update($expo_id, Request $request)
    {
        // $user = Auth::user();
        //$user_id=$user->id;
        $data = json_decode($request->getContent(), true);
        //return  $data;
        $expo = Expo::query()->where('id', $expo_id)->first();
        if (!empty($expo)) {
            foreach ($data['countries'] as $country) {
                $cat = ExpoCountry::query()->create([
                    'expo_id' => $expo_id,
                    'country_id' => $country['country_id'],
                    'cities' => $country['city'],
                ]);
            }
            return mainResponse(true, 'api.ok', [], []);
        } else {
            return mainResponse(true, 'invalid expo id', [], []);
        }


    }


}
