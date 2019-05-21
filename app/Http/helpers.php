<?php
use Illuminate\Support\Facades\Cache;

function can($permission)
{
    //  $user = auth()->user();
    //Cache::flush();

    $userCheck = auth()->guard()->check();
    $user='';

    if($userCheck==false)
    {
        return redirect('admin/login');
    }
    else
    {
        $user=  auth()->guard()->user();
    }


// Cache::forget('permissions_' . $user->id);


    /*
        $users = User::where('status', 1)->get();
        $users->map(function ($item, $key) {
            return ucfirst($item->name);
        });
        dd($users);
    */


    if ($user->admin_type == 1 && $user->user_type==3) {
        return true;
    }



    $minutes = 1200;
    $permissions = Cache::remember('permissions_' . $user->id, $minutes, function () use ($user) {

        return explode(',', $user->permission->permission);

    });


    $permissions = array_flatten($permissions);
    return in_array($permission, $permissions);

    //@if(can('reservations.panel'))
}


function currencyConverter($from_Currency, $to_Currency, $amount)
{

    $from_Currency = \App\Models\Currency::query()->where('shortcut', $from_Currency)->first()->price;
    $to_Currency = \App\Models\Currency::query()->where('shortcut', $to_Currency)->first()->price;
    return round((float)(($amount / $from_Currency) * $to_Currency), 2);
}

function admin_assets($dir)
{
    return url('/admin_assets/assets/' . $dir);
}

function frontend_assets($dir)
{
    return url('/public/frontend_assets/' . $dir);
}


function getLocal()
{
    return app()->getLocale();
}


function mainResponse($status, $msg, $items, $validator, $is_validator = 0)
{

    $aryErrors = [];
    if ($is_validator == 0) {
        if ($validator != []) {
            $errors = ($validator->errors()->toArray());
            foreach ($errors as $key => $value) {
                $tmp = ["fieldname" => $key, "message" => $value[0]];
                array_push($aryErrors, $tmp);
            }
        }
    } else {
        $aryErrors = array($validator);
    }
    $newData = ['status' => $status, 'message' => __($msg), 'items' => $items, 'errors' => $aryErrors];
    return response()->json($newData);
}

function convertAr2En($string)
{
    $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
    $num = range(0, 9);
    $convertedPersianNums = str_replace($persian, $num, $string);
    $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);
    return $englishNumbersOnly;
}

