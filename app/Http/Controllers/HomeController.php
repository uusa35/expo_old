<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Hash;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
     //   $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    
    
      public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
    
    public function restPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'email' => 'required|email|exists:users,email',
          'token' => 'required',
          'password'=>'required|min:6',
          'password_confirmation'=>'required|same:password|min:6',
        ]);
          if ($validator->fails()) {
               return redirect()->back()->withErrors($validator)->withInput();
          }
          $emailUser  = \DB::table('password_resets')->where('email', $request->email)->first();
          if($emailUser){
              if (Hash::check($request->token, $emailUser->token)) {
                   $row = \DB::table('password_resets')->where('email', $request->email)->delete();
                    $user = User::where('email',$request->email)->first();
                    $user->password = bcrypt($request->password);
                    $done = $user->save();
                    if($done){
                      return redirect()->back()->with('status', __('common.update'));
                    }else{
                      return redirect()->back()->with('error',__('api.whoops'))->withInput();
                    }
                }
                else{
                    return redirect()->back()->with('error',__('api.wrongToken'))->withInput();
                  }
            
          }
          else{
            return redirect()->back()->with('error',__('api.wrongEmail'))->withInput();
          }
        
    }

}
