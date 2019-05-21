<?php

namespace App\Http\Controllers;
use App\Models\Contact;
use App\Models\Category;
use App\Models\Cafe;
use App\Models\Slider;
use App\Models\Setting;
use App\Models\Package;
use App\Models\EventOffers;
use App\Models\CafeImages;
use App\Models\CafeRating;
use App\Models\CafeProducts;
use App\Models\PaymentProcess;
use App\Models\CategoryTranslation;
use App\Models\Language;
use App\User;
use Carbon\Carbon;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App;
use Response;

class Main extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
       
    }
    public function index(Request $request)
    {
      return redirect(app()->getLocale().'/login');

    } 
  
}