<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\Message;
use App\Models\MessageContact;
use App\User;
use Illuminate\Http\Request;
use Mockery\Exception;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$contacts = MessageContact::query()->where('sender_id', auth('api')->id())
            ->orWhere('receiver_id', auth('api')->id())->with('sender', 'receiver')->get();
            */
            
            $contacts = MessageContact::query()->where('sender_id', auth('api')->id())->with('sender', 'receiver')->groupBy('receiver_id')->orderBy('id','desc')->get();
            
        foreach ($contacts as $contact) {
            if ($contact->sender_id == auth('api')->id()) {
                $contact->contact = $contact->receiver;
            } else {
                $contact->contact = $contact->sender;
            }
            unset($contact->sender);
            unset($contact->receiver);
            $ids = [$contact->contact->id, auth('api')->id()];
           // $contact->last_message = Message::query()->where('message_contact_id', $contact->id)->get()->last();
            
            $lst1 = Message::query()->where('sender_id', auth('api')->id())->where('receiver_id', $contact->receiver_id)->get()->last();
            
            $lst2 = Message::query()->where('receiver_id', auth('api')->id())->where('sender_id', $contact->receiver_id)->get()->last();
            
            $contact->last_message = ($lst2) ? $lst2 : $lst1;
            
            
        }
        $message_ar = 'تم الطلب بنجاح';
        $message_en = 'Request succeeded';
        return mainResponse(true, $message_ar, $contacts, []);
    }

    /*
     * Show messages with specific user
     */

    public function userMessages($id)
    {
        $ids = [intval($id), auth('api')->id()];
        $messages = Message::query()->orderBy('id', 'desc')->where(function ($q) use ($id) {
            $q->where('sender_id', $id)->where('receiver_id', auth('api')->id());
        })->Orwhere(function ($q) use ($id) {
            $q->where('sender_id', auth('api')->id())->where('receiver_id', $id);
        })->get();
        $message_ar = 'تم الطلب بنجاح';
        $message_en = 'Request succeeded';
        return mainResponse(true, $message_ar, ['messages' => $messages, 'contact' => User::query()->find($id)], []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($id, Request $request)
    {
      //  return $request->file('video2');
        $ids = [intval($id), auth('api')->id()];
        $message_contact = MessageContact::query()->whereIn('sender_id', $ids)->whereIn('receiver_id', $ids)->first();
        if (!$message_contact) {
            $message_contact = MessageContact::query()->create([
                'sender_id' => auth('api')->id(),
                'receiver_id' => $id,
            ]);
        }
        $message = Message::query()->create([
            'message_contact_id' => $message_contact->id,
            'sender_id' => auth('api')->id(),
            'receiver_id' => $id,
            'message' => $request->get('message'),
            'image' => $request->hasFile('image') ? $request->file('image')->store('uploads/images/messages')
                : '',
            'video' => $request->hasFile('video') ? $request->file('video')->store('uploads/images/messages')
                : ''
        ]);
        if ($message) {
            //todo push notification
            $message_ar = 'تم ارسال الرسالة بنجاح';
            $message_en = 'Message sent successfully';
            $user = User::query()->find($id);
            $token = [$user->FCM_token];
            $content = $request->message ? $request->message : 'Photo sent';
            Alert::query()->create([
                    'user_id' => $id,
                    'object_id' => auth('api')->id(),
                    'title' => auth('api')->user()->name,
                    'content' => $content,
                    'type' => 1
                ]
            );
            $this->send($token,
                auth('api')->id(),
                auth('api')->user()->name,
                $content,
                1,
                $user->device_type
            );
            return mainResponse(true, $message_en, $message, []);
        }
        $message_ar = 'لم يتم ارسال الرسالة';
        $message_en = 'Message does not delivered, something went wrong!';
        return mainResponse(false, $message_en, [], []);
        /*        } catch (\Exception $e) {
                    return mainResponse(true, $e->getMessage(), [], []);

                    return mainResponse(false, [$e->getMessage()], null, $e->getCode(), 'messages');
                }*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $message = Message::query()->findOrFail($id);
            if ($message->sender_id == auth('api')->id()) {
                $message->delete();
                $message_ar = 'تم حذف الرسالة بنجاح';
                $message_en = 'Message deleted successfully';
                return mainResponse(true, $message_ar, [], []);
            }
            $message_ar = 'لا تمتلك صلاحية حذف الرسالة';
            $message_en = 'You do not have permission to delete this message';
            return mainResponse(false, $message_ar, [], []);
        } catch (Exception $e) {
            return mainResponse(false, $e->getMessage(), [], []);
        }
    }

    /*    function fcmPush($token, $message, $chat_obj, $type)

        {
    //return $type[0];

            try {


                $API_ACCESS_KEY = 'AAAAGiavZk0:APA91bGp1AXOgZrvx80GJzIUL1UtEb33aK-SmqF3F5r_xRhbVBz2V9nLiAW0UEBBfmfyTqil8QgmAZ5tGv0PNB_87BQK0SVwp9q0iI6_be0Mwg5pWJwUnNnHbaLi5gLY1KUslVgEGQS7';

                $msg = [
                    'body' => $message,
                    'order' => $chat_obj,
                    'title' => 'Euroticket',
                    'icon' => 'myicon',//Default Icon
                    'sound' => 'mySound'//Default sound
                ];
                //return $msg;
                $fields = [
                    'registration_ids' => ["e0nICLJ4RJ4:APA91bHTZpsGARUbSsZsi73urSC4McO6_4cQ1yxTLwEffyRfUXP8Qp5oFO4WxX0_NQCf8hwbFJjc2dB8hpWRRkHRMIPulXlkJb8BuwEk_yLKagWHU98c9yNaqb3OSsE2pOeO20HyOOJt"],
                    'data' => $msg
                ];
                $headers = [
                    'Authorization: key=' . $API_ACCESS_KEY,
                    'Content-Type: application/json'
                ];


                $data = [
                    "registration_ids" => $token[0],
                    "data" => [
                        'body' => $message,
                        'type' => "chat",
                        'title' => 'myExpo',
                        'icon' => 'myicon',//Default Icon
                        'sound' => 'mySound'//Default sound
                    ]
                ];

                //return $data;
                $notification = [
                    "registration_ids" => $token[0],
                    "notification" => [
                        'body' => $message,
                        'type' => "chat",
                        'title' => 'myExpo',
                        'icon' => 'myicon',//Default Icon
                        'sound' => 'mySound'//Default sound
                    ]
                ];

                if ($type[0] == 1) {

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n   \"to\": \"$token[0]\",\n\n   \"data\": {\n         \"sound\": \"default\"\n\n    \"body\": \"$message\",\n    \"title\": \"Euroticket.\"\n  ,\n    \"type\": \"chat\"\n  }\n     \"priority\" : \"high\"\n\n   }");

                } else {

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n   \"to\": \"$token[0]\",\n\n   \"notification\": {\n         \"sound\": \"default\"\n\n    \"body\": \"$message\",\n    \"title\": \"Euroticket.\"\n ,\n    \"type\": \"chat\"\n   }\n     \"priority\" : \"high\"\n\n   }");


                }
                $result = curl_exec($ch);
                curl_close($ch);
                //return json_decode($result, true);
                return back()->with('success', 'Edit SuccessFully');
            } catch (\Exception $ex) {
                return $ex->getMessage();
            }
        }*/

    function send($token, $id, $title, $content, $type, $device)

    {
        $registrationIds = $token;

        $msg = [
            'id' => $id,
            'title' => $title,
            'content' => $content,
            'body' =>$content ,
            'type' => $type,
            'sound' => 1,//Default sound
            'icon' => 1,//Default Icon
        ];
        if ($device == 'ios'){
            $fields = [
                'registration_ids' => $registrationIds,
                'notification' => $msg,
                'data' => $msg,
            ];
        }else{
            $fields = [
                'registration_ids' => $registrationIds,
                'data' => $msg,
            ];
        }

        $headers = [
            'Authorization: key=' . 'AAAAGiavZk0:APA91bEXTUQfpGAQbKBu9jTBbDWjb16tM0NgSFE-MV7UbFyLCv7V58EuAUEbgNkrYw9CW9S47a13eMAHaVV-CDaMqCWnOkT7BzI4r_u69x8fdBkv0_zlE7Ga31pR11haAoLfkXtS3I1-',
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
    }
/*    function send($token, $id, $title, $content, $type, $device)

    {
        $registrationIds = $token;

        $msg = array
        (
            'id' => $id,
            'title' => $title,
            'content' => $content,
            'body' =>$content ,
            'type' => $type,
            'sound' => 1,//Default sound
            'icon' => 1,//Default Icon
        );
        if ($device == 'android'){
            $fields = array
            (
                'registration_ids' => $registrationIds,
                'data' => $msg,
            );
        }else{
            $fields = array
            (
                'registration_ids' => $registrationIds,
                'notification' => $msg,
                'data' => $msg,
            );
        }

        $headers = array
        (
            'Authorization: key=' . 'AAAAGiavZk0:APA91bEXTUQfpGAQbKBu9jTBbDWjb16tM0NgSFE-MV7UbFyLCv7V58EuAUEbgNkrYw9CW9S47a13eMAHaVV-CDaMqCWnOkT7BzI4r_u69x8fdBkv0_zlE7Ga31pR11haAoLfkXtS3I1-',
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
    }*/


}
