<?php

namespace App\Providers;
use App\Models\Language;
use App\Models\UserOrder;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        view()->share([
            //'settings'=>Setting::query()->first(),
            'locales'=>Language::all(),
          //  'contact' => Contact::query()->where('readed',0)->count(),
            'orders_count' => UserOrder::query()->where('status','new')->count()
        ]);
        //view()->share(['locales'=> Language::all()]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
