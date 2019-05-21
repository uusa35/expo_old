<?php

namespace App\Http\Controllers\API;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function index()
    {
        $data = Company::query()->public()->with('images')->get();
        return mainResponse(true, 'api.ok', $data, []);
    }

}
