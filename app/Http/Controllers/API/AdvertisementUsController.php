<?php

namespace App\Http\Controllers\API;

use App\Models\AdvertisementUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class AdvertisementUsController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'fullname' => 'required',
            'mobile' => 'required',
            'comment' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png',
        ]);
        if ($validator->fails()) {
            return mainResponse(false, '', [], $validator);
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('/uploads/images/AdvertisementUs/');
        }

        AdvertisementUs::query()->create([
            'email' => $request->get('email'),
            'fullname' => $request->get('fullname'),
            'mobile' => $request->get('mobile'),
            'comment' => $request->get('comment'),
            'image' => $image
        ]);

        return mainResponse(true, 'api.ok', [], []);

    }
}
