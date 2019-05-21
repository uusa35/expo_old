<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Expo;
use App\Models\MessageContact;
use App\Models\Language;
use App\Models\Message;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyMessageController extends Controller
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
        $user_id = Auth::id();
        $items = MessageContact::query()->where('receiver_id',$user_id)->groupBy('sender_id')->get();
     //   paginate($this->settings->value);
        return view('cp.inbox.messages', [
            'items' => $items,
        ]);
    }

    public function create(Request $request)
    {
        $user_id = Auth::id();
        if ($request->user_id){
            $user_id = $request->user_id;
        }
       /* if (\auth()->user()->user_type == 3){
            \App\Models\MessageContact::query()->
            where('receiver_id', $user_id)->
           // where('type', 0)->
            where('status', 0)->update(['status' => 1]);
        }else{*/
            \App\Models\MessageContact::query()->
            where('sender_id', $request->user_id)->
          //  where('type', 1)->
            where('status', 0)->update(['status' => 1]);
      //  }
        $contacts = Message::query()->where('sender_id', $request->user_id)->orWhere('receiver_id', $request->user_id)->orderBy('id','asc')->get();
        return view('cp.inbox.create', compact('contacts'));
    }

    public function store(Request $request)
    {
        $roles = [
            'message' => 'required',
        ];
        $user_id = Auth::id();
        $this->validate($request, $roles);
        $item = new MessageContact();
       // if ($request->user_id){
        //    $user_id = $request->user_id;
            $item->type = 2;
      //  }
        $item->sender_id = $user_id;
        $item->receiver_id = $request->user_id;
      //  $item->message = $request->message;
        $item->save();
        
        
        $message = Message::query()->create([
            'message_contact_id' => $item->id,
            'sender_id' => $user_id,
            'receiver_id' => $request->user_id,
            'message' => $request->get('message')
        ]);
        
        
        return redirect()->back()->with('status', __('common.create'));
    }

    public function destroy($id)
    {
        $item = Material::query()->findOrFail($id);
        if ($item) {
            Material::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }

    public function changeStatus(Request $request)
    {
//        if ($request->event == 'delete') {
//            Material::query()->whereIn('id', $request->IDsArray)->delete();
//        }else {
//            Material::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);
//        }
//        return $request->event;
    }

    public function view_details($id, Request $request)
    {
        $items = ExpoMessage::query()->where('id', $id)->with(['message', 'expo'])->first();
        $items->status = "read";
        $items->save();
        return view('cp.inbox.view', [
            'items' => $items,
        ]);
    }

    public function view_details_admin($id, Request $request)
    {
        $items = ExpoMessage::query()->where('id', $id)->with(['message', 'expo'])->first();
        $items->admin_status = "read";
        $items->save();
        return view('cp.inbox.admin_view', [
            'items' => $items,
        ]);
    }

    public function messages(Request $request)
    {
        $items = ExpoContact::query()->
//        orderBy('id', 'asc')->
        groupBy('user_id')->get();
        return view('cp.inbox.messages', [
            'items' => $items,
        ]);
    }

    public function reply($id, Request $request)
    {
        return view('cp.inbox.admin_reply_form', [
            'id' => $id,
        ]);
    }

    public function store_reply(Request $request)
    {
        $msg_id = $request->msg_id;
        $expo = ExpoMessage::query()->where('id', $msg_id)->firstOrFail();
        $expo->status = 'unread';
        $expo->save();
        $roles = [
            'message' => 'required',
        ];
        $this->validate($request, $roles);

        $msg = new Message();
        $msg->msg_id = $expo->id;
        $msg->message = $request->message;
        $msg->sender_admin = 1;
        $msg->save();

        return redirect()->back()->with('status', __('common.create'));
    }
}
