<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NotificationMessage;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class NotificationMessageController extends Controller
{


    public function index(Request $request)
    {
        $items = NotificationMessage::query()->orderBy('id', 'Desc')->paginate(10);
        //return $items;
        return view('cp.notifications.home', [
            'items' => $items,
        ]);
    }

    public function create()
    {
        $notifications = NotificationMessage::all();
        return view('cp.notifications.create',['notifications'=>$notifications]);
    }

    public function store(Request $request)
    {
            //return $request->all();            
            $notifications= New NotificationMessage ;
           
            $notifications->message = $request->message;
            $notifications->save();
            
            $message = $request->message ;
        //      $token_android = Token::where('accept',1)->where('type','android')->pluck('token')->toArray();
        //      $token_iphone = Token::where('accept',1)->where('type','ios')->pluck('token')->toArray();
        //   // return $token_android;
            
        //      if ($token_android == '' and $token_iphone == '') {
	       //     exit();
	       // }
       
	        return $this->fcmPush($message);
            return back()->with('status','Saved Successfully');
    }

    public function destroy($id)
    {
        //dd($id);
        $notifications = NotificationMessage::query()->findOrFail($id);
        if ($notifications->delete()) {
            return 'success';
        }
        return 'fail';
    }








  function fcmPush($message)

{ 
//return $type[0];
    
    try {

        
       $API_ACCESS_KEY = 'AAAAGiavZk0:APA91bEXTUQfpGAQbKBu9jTBbDWjb16tM0NgSFE-MV7UbFyLCv7V58EuAUEbgNkrYw9CW9S47a13eMAHaVV-CDaMqCWnOkT7BzI4r_u69x8fdBkv0_zlE7Ga31pR11haAoLfkXtS3I1-';

        
        $headers = [
            'Authorization: key=' . $API_ACCESS_KEY,
            'Content-Type: application/json'
        ];
        
       
        $notification= [
            "to"=> '/topics/expo',
            "notification"=>[
            'body' => $message,
                'type' => "notify",
                'title' => 'Expo App',
                'icon' => 'myicon',//Default Icon
                'sound' => 'mySound'//Default sound
            ]
        ];
        //return $notification;
       // return json_encode($data);
       
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notification));
        
        
        $result = curl_exec($ch);
        curl_close($ch);
        //return json_decode($result, true);
        return back()->with('status','Saved Successfully');
    } catch (\Exception $ex) {
        return $ex->getMessage();
}
}

   

}
