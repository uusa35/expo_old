<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function show()
    {
        $ad = Ad::query()->where('status', 1)->get();
        if (count($ad)) {
            $ad = $ad->random();
            return mainResponse(true, 'api.ok', $ad, []);
        }
        return mainResponse(false, 'api.no_ads', [], []);
    }

}
