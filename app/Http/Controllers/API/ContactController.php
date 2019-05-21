<?php

namespace App\Http\Controllers\API;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'fullname' => 'required',
            'mobile' => 'required',
            'comment' => 'required',
        ]);
        if ($validator->fails()) {
            return mainResponse(false, '', [], $validator);
        }

        Contact::query()->create([
            'email' => $request->get('email'),
            'fullname' => $request->get('fullname'),
            'mobile' => $request->get('mobile'),
            'comment' => $request->get('comment')
        ]);

        return mainResponse(true, 'api.ok', [], []);

    }

}
