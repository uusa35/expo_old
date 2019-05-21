<?php

namespace App\Http\Controllers\Cp;


use App\User;
use App\Models\City;
use App\Models\Permission;
use App\Models\Setting;
use App\Models\UserPermission;

use Carbon\Carbon;
use function Couchbase\defaultDecoder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Notifications\NewPostNotification;

use Illuminate\Validation\Rule;
use Mockery\Exception;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    public function image_extensions()
    {

        return array('jpg', 'png', 'jpeg', 'gif', 'bmp', 'pdf');

    }


    public function __construct()
    {
        $this->settings = Setting::query()->first();
        view()->share([
            'settings' => $this->settings,
        ]);
    }

    public function index(Request $request)
    {


        //   dd(auth()->guard('admin')->user()->permission);


        // permission
        $items = User::query()->where('user_type', 3);
        if ($request->has('email')) {
            if ($request->get('email') != null)
                $items->where('email', 'like', '%' . $request->get('email') . '%');
        }

        if ($request->has('mobile')) {
            if ($request->get('mobile') != null)
                $items->where('mobile', 'like', '%' . $request->get('mobile') . '%');
        }


        $items = $items->orderBy('id', 'desc');

        // dd($items->get());
        //  dd($items->get());
        return view('cp.admin.home', [
            'items' => $items->get(),
        ]);

    }

    public function destroy($id)
    {
        $item = User::query()->findOrFail($id);
        if ($item && $item->admin_type != 1) {
            User::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }


    public function create()
    {
        $users = User::all();
        $role = Permission::where('id', '>', 0)->get();
        return view('cp.admin.create', compact('users', 'role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


       
        $users_rules = array(
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            //  'mobile'=>'nullable|integer',
            'confirm_password' => 'required|same:password|min:6',
            'mobile' => 'required|digits_between:8,12',
            'admin_type' => 'required',
            'permissions' => 'required',


        );


        if (app()->getLOcale() == 'en') {
            $customMessages = [
                'email' => 'The email must be a valid email address.',
                'integer' => 'The mobile must be a valid integer number.'
            ];
        } else {
            $customMessages = [
                'email' => 'عنوان البريد الالكتروني يجب ان يكون صحيحا',
                'integer' => 'الموبايل يجب ان يكون عددا صحيحا',
            ];

        }


        $users_validation = Validator::make($request->all(), $users_rules, $customMessages);

        if ($users_validation->fails()) {
            return redirect()->back()->withErrors($users_validation)->withInput();
        }


        $user = '';


        $request->merge([
            'password' => app('hash')->make($request->input('password')),
            'user_type' => 3,
            'admin'=>1

        ]);


        $admin = User::create($request->only([
            'name',
            'password',
            'mobile',
            'admin',
            'email',
            'admin_type',
            'admin',
            'user_type'
        ]));

        $adminDone = User::find($admin->id);
        $roles = '';
        if ($request->permissions) {
            $arr = [];
            foreach ($request->permissions as $permission) {
                $roles .= $permission . ',';
            }
            UserPermission::create([
                'user_id' => $admin->id,
                'permission' => substr($roles, 0, -1)
            ]);
        }


        return redirect()->back()->with('status', __('common.create'));
    }


    public function edit($id)
    {
        //dd($id);
        $item = User::findOrFail($id);
        $role = Permission::where('id', '>', 0)->get();
        $userRole = UserPermission::where('user_id', $item->id)->first();


        $userRoleItem = [];
        if ($userRole) {
            $userRoleItem = explode(',', $userRole->permission);
        }


        //   dd($userRoleItem);
        //  dd($userRoleItem);
        return view('cp.admin.edit', compact('item', 'role', 'userRoleItem'));
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());
        $users_rules = array(
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,id,' . $id,
            //  'location'=>'required|integer',
            'mobile' => 'required|digits_between:8,12',
            'admin_type' => 'required'
        );


        if (app()->getLocale() == 'en') {
            $customMessages = [
                'email' => 'The email must be a valid email address.',
                'integer' => 'The mobile must be a valid integer number.'
            ];
        } else {
            $customMessages = [
                'email' => 'عنوان البريد الالكتروني يجب ان يكون صحيحا',
                'integer' => 'الموبايل يجب ان يكون عددا صحيحا',
            ];

        }


        $users_validation = Validator::make($request->all(), $users_rules, $customMessages);

        if ($users_validation->fails()) {
            return redirect()->back()->withErrors($users_validation)->withInput();
        }


        $user = '';


        //  $confirmation_code = str_random(20);
        $admin = User::findOrFail($id);


        $request->merge([

            'user_type' => 3,
            'admin'=>1

        ]);


        User::find($admin->id)
            ->update($request->only([
                'name',
                'mobile',
                'admin_type',
                'email',
                'user_type',
                'admin'
            ]));

        $adminDone = User::find($admin->id);
        $roles = '';
        if ($request->permissions) {
            $arr = [];
            foreach ($request->permissions as $permission) {
                $roles .= $permission . ',';
            }


            $userPermission = UserPermission::where('user_id', $admin->id)->first();

            if ($userPermission)
                $userPermission->delete();

            UserPermission::create([
                'user_id' => $admin->id,
                'permission' => substr($roles, 0, -1)
            ]);


        }


        return redirect()->back()->with('status', __('common.update'));

    }


    public function edit_password(Request $request, $id)
    {
        //dd($id);
        $item = User::findOrFail($id);
        return view('cp.admin.edit_password', ['item' => $item]);
    }


    public function update_password(Request $request, $id)
    {
        //dd($request->all());
        $users_rules = array(
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password|min:6',
        );
        $users_validation = Validator::make($request->all(), $users_rules);

        if ($users_validation->fails()) {
            return redirect()->back()->withErrors($users_validation)->withInput();
        }
        $user = User::findOrFail($id);
        $user->password = Hash::make($request->password);
        $user->save();


        return redirect()->back()->with('status', __('common.update'));
    }


    public function changeStatus(Request $request)
    {


        if ($request->event == 'delete') {
            User::query()->whereIn('id', $request->IDsArray)->delete();
        } else {


            if ($request->event) {

                $user = User::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);

            }
        }
        return $request->event;
    }

}
