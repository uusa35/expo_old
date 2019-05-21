<?php

namespace App\Http\Controllers\API;

use App\Models\Field;
use App\Models\Publish;
use App\Models\Seeker;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SeekerController extends Controller
{

    public function index()
    {
        $data = Seeker::query()->with(['field', 'publish', 'user'])->get();
        return mainResponse(true, 'api.ok', $data, []);
    }

    public function store(Request $request)
    {
        $user = Auth::guard('api')->user();

        $validator = Validator::make($request->all(), [
            'year_experience' => 'required|numeric',
            'field_id' => 'required|numeric',
            'publish_type_id' => 'required',
            'file' => 'required',
            'name' => 'required',
            'bio' => 'required',
        ]);
        if ($validator->fails()) {
            return mainResponse(false, '', [], $validator);
        }

        $countPublish = Publish::query()->where('id', $request->get('publish_type_id'))->count();
        if ($countPublish == 0) {
            return mainResponse(false, 'api.numberNotFound', [], []);
        }

        $publish = Publish::query()->where('id', $request->get('publish_type_id'))->first();
        if ($user->balance <= $publish->points) {
            return mainResponse(false, 'api.points', [], []);
        }
        $countField = Field::query()->where('id', $request->get('field_id'))->count();
        if ($countField == 0) {
            return mainResponse(false, 'api.numberNotFound', [], []);
        }
        if ($request->hasFile('file')) {
            $file = $request->file('file')->store('/uploads/files/seekers');
        }
        Seeker::query()->create([
            'year_experience' => $request->get('year_experience'),
            'field_id' => $request->get('field_id'),
            'user_id' => $user->id,
            'publish_type_id' => $request->get('field_id'),
            'name' => $request->get('name'),
            'bio' => $request->get('bio'),
            'file' => $file
        ]);
        return mainResponse(true, 'api.ok', [], []);
    }



}
