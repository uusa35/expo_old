<?php

namespace App\Http\Controllers\CP;

use App\User;
use App\Models\UserOrder;
use App\Models\Order;
use App\Models\City;
use App\Models\Category;
use App\Models\ExpoCategory;
use App\Models\ExpoCountry;
use App\Models\Expo;
use App\Models\Country;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
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

    }

    public function orders(Request $request)
    {
        $List = UserOrder::query()->orderBy('id', 'desc');
        if ($request->has('name')) {
            if ($request->get('name') != null)
                $List->whereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->get('name') . '%');
                });
        }
        if ($request->has('status')) {
            if ($request->get('status') != null)
                $List->where('status', $request->get('status'));
        }

        if ($request->has('order_id')) {
            if ($request->get('order_id') != null)
                $List->where('order_id', $request->get('order_id'));
        }
        if ($request->has('created_at')) {
            if ($request->get('created_at') != null)
                $List->whereBetween('created_at', [date('Y-m-d H:i:s', strtotime($request->get('created_at') . '00:00:00')),
                    date('Y-m-d H:i:s', strtotime($request->get('created_at') . '23:59:59'))]);
        }
        $List = $List->paginate(20);
        return view('cp.orders.home', [
            'items' => $List,
        ]);
    }

    public function myOrders(Request $request)
    {
        $item = Expo::query()->where('user_id', Auth::id())->first();
        //$orderList = Order::where('expo_id',$item->id)->with(['size','color','material','user_order'])->orderBy('id','desc')->paginate(7);
        //return $orderList;
        // $orderList = Order::where('expo_id',$item->id)->with(['user_order']);
        // $orderList->groupBy('order_id')->orderBy('id','desc')->paginate(7);
        /*$orderList = Order::where('expo_id',$item->id)->get();
        dd($orderList);
        $in=array();
        foreach ($orderList as $item) {
            $in[]=$item->order_id;
        }*/
        $List = UserOrder::whereHas('orders', function ($q) use ($item) {
            $q->where('expo_id', $item->id);
        })->orderBy('id', 'desc')->paginate(7);
        //return $List;
        return view('cp.orders.my_orders', [
            'items' => $List,
        ]);

    }


    public function order_details($id, Request $request)
    {
        $item = Expo::query()->where('user_id', Auth::id())->first();
        $orderList = Order::where('order_id', $id)->where('expo_id', $item->id)->with(['size', 'color', 'material', 'user_order'])->orderBy('id', 'desc')->paginate(20);
        // $orderList = Order::where('expo_id',$item->id)->with(['user_order']);
        // $orderList->groupBy('order_id')->orderBy('id','desc')->paginate(7);

        //return $List;
        return view('cp.orders.order_details', [
            'items' => $orderList,
        ]);

    }

    public function order_view($id, Request $request)
    {
        $item = Expo::query()->where('user_id', Auth::id())->first();
        $orderList = Order::where('order_id', $id)->with(['size', 'color', 'material', 'user_order'])->orderBy('id', 'desc')->paginate(7);
        // $orderList = Order::where('expo_id',$item->id)->with(['user_order']);
        // $orderList->groupBy('order_id')->orderBy('id','desc')->paginate(7);

        //return $List;
        return view('cp.orders.order_details', [
            'items' => $orderList,
        ]);

    }

    public function changeStatus(Request $request)
    {
        if ($request->event == 'delete') {
            UserOrder::query()->whereIn('id', $request->IDsArray)->delete();
        } else {
            UserOrder::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);
        }
        return $request->event;
    }


}
