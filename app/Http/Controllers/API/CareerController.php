<?php

namespace App\Http\Controllers\API;

use App\Models\Career;
use App\Models\CareerApply;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CareerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Career::query()->public()->get();
        return mainResponse(true, 'api.ok', $data, []);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'fullname' => 'required',
            'mobile' => 'required',
            'career_id' => 'required|numeric',
            'file' => 'required',
        ]);
        if ($validator->fails()) {
            return mainResponse(false, '', [], $validator);
        }
        $count = Career::query()->where('id', $request->get('career_id'))->count();
        if ($count == 0) {
            return mainResponse(false, 'api.numberNotFound', [], []);
        }
        if ($request->hasFile('file')) {
            $file = $request->file('file')->store('/uploads/files/careers');
        }
        CareerApply::query()->create([
            'fullname' => $request->get('fullname'),
            'email' => $request->get('email'),
            'mobile' => $request->get('mobile'),
            'career_id' => $request->get('career_id'),
            'file' => $file
        ]);
        return mainResponse(true, 'api.ok', [], []);
    }

}
