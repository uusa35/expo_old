<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Notifications\ResetPassword;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use App\User;
use Psy\Util\Json;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        $rules = [
            'email' => 'required|string|email|max:255',
        ];

        return Validator::make($data, $rules);
    }
    public function sendResetLinkEmail(Request $request)
    {


        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return mainResponse(false, $validator->errors()->first(), [], $validator->errors()->messages());
        }

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($response, $request->wantsJson())
            : $this->sendResetLinkFailedResponse($request, $response, $request->wantsJson());
    }


    protected function sendResetLinkResponse($response, $json = false)
    {

        if ($json){
            return mainResponse(true, $response, [], []);
        }
        return back()->with('status', trans($response));
    }

    protected function sendResetLinkFailedResponse(Request $request, $response, $json = false)
    {
        if ($json){
            return mainResponse(true, $response, [], []);
        }
        return back()->withErrors(
            ['email' => trans($response)]
        );
    }
    
    
    
    function mainResponse($status, $message, $data, $code, $key,$validator)
    {
        try {
            $result['status'] = $status;
            $result['code'] = $code;
            $result['message'] = $message;
            

            if ($validator && $validator->fails()) {
                $errors = $validator->errors();
                $errors = $errors->toArray();
                $message = '';
                foreach ($errors as $key => $value) {
                    $message .= $value[0] . ',';
                }
                $result['message'] = $message;
                return response()->json($result, $code);
            }elseif (!is_null($data)) {


                if ($status) {
                    if ($data != null && array_key_exists('data', $data)) {
                        $result[$key] = $data['data'];
                    } else {
                        $result[$key] = $data;
                    }
                } else {
                    $result[$key] = $data;
                }
            }
            
            return response()->json($result, $code);
        } catch (Exception $ex) {
            return response()->json([
                'line' => $ex->getLine(),
                'message' => $ex->getMessage(),
                'getFile' => $ex->getFile(),
                'getTrace' => $ex->getTrace(),
                'getTraceAsString' => $ex->getTraceAsString(),
            ], $code);
        }
    }
    
    public function forgetpasswordForWeb(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        if ($request->get('email')) { // accept Json header
            $user = User::where('email', $request->input('email'))->first();
            if (!$user) {
                $message = (app()->getLocale() == 'ar') ? ' البريد الإلكتروني المدخل غير مسجل  ' : 'We cant find a user with that e-mail address';

                 return redirect()->back()->with('error',$message)->withInput();
            }
            
            $token = $this->broker()->createToken($user);
            //$url = url('/password/reset/' . $token);
            $user->notify(new ResetPassword($token));
          //  return "hhh";
            $message = (app()->getLocale() == 'ar') ? 'تم إرسال رابط تعيين كلمة المرور للبريد الإلكتروني المدخل' : 'Reset password link have been sent to your email address';
            return $token;
            
            return redirect()->back()->with('status',$message);
        }else{
            $message = (app()->getLocale() == 'ar') ? ' البريد الإلكتروني المدخل غير مسجل  ' : 'We cant find a user with that e-mail address';
            return redirect()->back()->with('error',$message)->withInput();
        }
    }
    
    public function forgetpassword(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return $this->mainResponse(false, '' , null, 203, 'items',$validator);
        }
        
        if ($request->get('email')) { // accept Json header
            $user = User::where('email', $request->input('email'))->first();
            if (!$user) {
                $message = (app()->getLocale() == 'ar') ? ' البريد الإلكتروني المدخل غير مسجل  ' : 'We cant find a user with that e-mail address';
                return $this->mainResponse(false, $message, null, 203, 'items','');
            }
            
            $token = $this->broker()->createToken($user);
            //$url = url('/password/reset/' . $token);
            $user->notify(new ResetPassword($token));
          //  return "hhh";
            $message = (app()->getLocale() == 'ar') ? 'تم إرسال رابط تعيين كلمة المرور للبريد الإلكتروني المدخل' : 'Reset password link have been sent to your email address';
            
            return $this->mainResponse(true, $message, null, 200, 'items','');
        }else{
            $message = (app()->getLocale() == 'ar') ? ' البريد الإلكتروني المدخل غير مسجل  ' : 'We cant find a user with that e-mail address';
            return $this->mainResponse(false, $message, null, 203, 'items','');
        }
    }


}
