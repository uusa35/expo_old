<?php

namespace App\Http\Controllers\CP;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Contact;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        $items = User::query()->whereIn('user_type', [1,2]);
        if ($request->has('email')) {
            if ($request->get('email') != null)
                $items->where('email', 'like', '%' . $request->get('email') . '%');
        }
        if ($request->has('name')) {
            if ($request->get('name') != null)
                $items->where('name', 'like', '%' . $request->get('name') . '%');
        }
        if ($request->has('user_type')) {
            if ($request->get('user_type') != null)
                $items->where('user_type', $request->get('user_type'));
        }
        $items = $items->where('admin','!=' , 3)->orderBy('id', 'desc')->paginate($this->settings->value);
        return view('cp.users.home', [
            'items' => $items,
        ]);

    }

    public function destroy($id)
    {
        $item = User::query()->findOrFail($id);
        if ($item) {
            User::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }

    public function myProfile()
    {
        $id=Auth::id();
        $item = User::query()->findOrFail($id);
        return view('cp.users.my_profile', [
            'user' => $item,
        ]);
    }

     public function update_profile(Request $request)
    {

         $roles = [
             'mobile' => 'required|min:6|max:15',
             'name' => 'required|min:6|max:15',
        ];
       
        $this->validate($request, $roles);

       $User = User::query()->where('id', Auth::id())->first();
       $User->name = $request->name;
       $User->mobile = $request->mobile;
       if ($request->hasFile('image')) {
            $image = $request->file('image')->store('uploads/images/users');
            $User->image = $image;
        }
       $done = $User->save();
       if($done){
        return redirect()->back()->with('status', 'updated successfullty');
       }else{
       return redirect()->back()->with('status', 'error');
       }

    }

    public  function  change_password(){
        return view('cp.users.change_password');
    }

    public  function  password_store(Request $request){

            if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
                return redirect()->back()->with("error",__('common.wrong_password'));
            }
            if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
                return redirect()->back()->with("error",__('common.same_password'));
            }
            $roles= [
                'current-password' => 'required',
                'new-password' => 'required|string|min:6|confirmed',
            ];
            $this->validate($request, $roles);
            $user = Auth::user();
            $user->password = bcrypt($request->get('new-password'));
            $user->save();
            return redirect()->back()->with('success',__('common.password_success'));
        }


}
