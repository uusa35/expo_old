<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return redirect('/admin/home');
});


 /*Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.reset');
 Route::post('/password/email', 'Auth\ForgotPasswordController@send_email')->name('admin.password.email');*/
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {


    Route::get('/get_currencies', function () {
        //return currencyConverter('KWD','AED',10);
        $currencies = json_decode(file_get_contents('http://www.apilayer.net/api/live?access_key=1163e4d98c82c00439d2b63411e33114'), true);
        if ($currencies['success']) {
            foreach ($currencies['quotes'] as $country => $amount) {
                \App\Models\Currency::query()->where('name', substr($country, 3, 3))->update([
                    'usd_value' => $amount
                ]);
                //return [substr($country,3,3), $amount];
            }
        }
    })->name('get_currencies');

    //////////end frontend///////// 
    Route::get('/home', function () {
        return redirect('/admin/home');
    });
  //  Auth::routes();
    
    
   Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    Route::post('password/email', 'Auth\ForgotPasswordController@forgetpasswordForWeb')->name('password.email');

    Route::get('password/reset/{token}', 'HomeController@showResetForm');
    Route::post('password/reset', 'HomeController@restPassword');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
    
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    


    
    
    
    
    //Route::get('/privacy','CP\HomeController@privacy');
    //Route::get('/terms','CP\HomeController@terms');
    Route::group(array('prefix' => 'admin', 'middleware' => ['auth', 'admin']), function () {
        Route::get('/', function () {
            return redirect('/admin/home');
        });
        //Route::get('/home', 'CP\HomeController@index');
        Route::get('/home', 'CP\HomeController@index');

        Route::group(array('middleware' => ['auth', 'userAdmin']), function () {
            if (can('role')) {
                Route::resource('/role', 'CP\RoleController');
            }




         //   Route::resource('/career', 'CP\CareerController');
          //  Route::resource('/field', 'CP\FieldController');



           // Route::resource('/cafe', 'CP\CafeController');
            Route::resource('/events_offers', 'CP\EventOffersController');
           // Route::resource('/cafe_products', 'CP\CafeProductsController');




            if (can('orders')) {
                Route::get('/orders', 'CP\OrderController@orders');
                Route::post('/orders/changeStatus', 'CP\OrderController@changeStatus');
                Route::get('/order_view/{id}', 'CP\OrderController@order_view');
            }

            if (can('messages')) {
                Route::post('/myMessages/changeStatus', 'CP\ExpoController@changeStatus');
                Route::get('/messages/reply/{msg_id}', 'CP\MyMessageController@reply')->name('reply');
                Route::post('/messages/store_reply', 'CP\MyMessageController@store_reply')->name('store_reply');

                Route::get('/messages', 'CP\MyMessageController@messages')->name('messages');
                Route::get('/messageView/{id}', 'CP\MyMessageController@view_details_admin')->name('messageView');
            }
            if (can('contacts')) {

                Route::get('/contact', 'CP\ContactController@index');
                Route::delete('/contact/{id}', 'CP\ContactController@destroy');
            }
            
            if (can('push-notification')) {

                Route::get('/notifications', 'CP\NotificationMessageController@index');
                Route::get('/notifications/create', 'CP\NotificationMessageController@create')->name('create');
                Route::post('/notifications/store', 'CP\NotificationMessageController@store')->name('store');
                Route::delete('/notification/{id}', 'CP\NotificationMessageController@destroy');
            }
            


            if (can('advertisements')) {
                Route::resource('/ads', 'CP\AdController');
                Route::get('/advertisement', 'CP\AdvertisementController@index');
                Route::delete('/advertisement/{id}', 'CP\AdvertisementController@destroy');
                Route::post('/ads/changeStatus', 'CP\AdController@changeStatus');
            }
            if (can('categories')) {
                Route::resource('/category', 'CP\CategoryController');
            }
            if (can('admins')) {
                //////////////////admins
                Route::get('/admins/{id}/edit', 'CP\AdminController@edit')->name('admins.edit');
                Route::post('/admins/{id}', 'CP\AdminController@update')->name('users.update');
                Route::get('/admins/{id}/edit_password', 'CP\AdminController@edit_password')->name('admins.edit_password');
                Route::post('/admins/{id}/edit_password', 'CP\AdminController@update_password')->name('admins.edit_password');

                Route::get('/admins', 'CP\AdminController@index')->name('admins.all');
                Route::post('/admins/changeStatus', 'CP\Admin\AdminController@changeStatus')->name('admin_changeStatus');

                Route::delete('admins/{id}', 'CP\AdminController@destroy')->name('admins.destroy');

                Route::post('/admins', 'CP\AdminController@store')->name('admins.store');
                Route::get('/admins/create', 'CP\AdminController@create')->name('admins.create');
                /////////
            }
            if (can('settings')) {
                Route::get('setting', 'CP\SettingController@index');
                Route::post('setting', 'CP\SettingController@update');
            }
            if (can('slider')) {
                Route::resource('/slider', 'CP\SliderController');
                Route::delete('slider/image/{image_id}', 'CP\SliderController@deleteImage');
                Route::post('/slider/changeStatus', 'CP\SliderController@changeStatus');

            }
            if (can('expo')) {
                Route::resource('/company', 'CP\CompanyController');
                Route::resource('/expo', 'CP\ExpoController');

                Route::post('/expo/changeStatus', 'CP\ExpoController@changeStatus');
            }
            if (can('packages')) {
                Route::resource('/package', 'CP\PackageController');
                Route::post('/package/changeStatus', 'CP\PackageController@changeStatus');
            }
            if (can('users')) {
                Route::resource('/users', 'CP\UserController');
            }
            if (can('clothing')) {
                Route::resource('/clothing_types', 'CP\ClothingTypeController');
                Route::post('/clothing_types/changeStatus', 'CP\ClothingTypeController@changeStatus');

            }
            if (can('occasion')) {
                Route::resource('/occasion', 'CP\OccasionController');
                Route::post('/occasion/changeStatus', 'CP\OccasionController@changeStatus');

            }
            if (can('material')) {
                Route::resource('/material', 'CP\MaterialController');
                Route::post('/material/changeStatus', 'CP\MaterialController@changeStatus');

            }
            if (can('colors')) {
                Route::resource('/colors', 'CP\ColorController');
                Route::post('/colors/changeStatus', 'CP\ColorController@changeStatus');
            }
            if (can('size')) {
                Route::resource('/size', 'CP\SizeController');

                Route::post('/size/changeStatus', 'CP\SizeController@changeStatus');

            }
            if (can('currency')) {
                Route::resource('/currency', 'CP\CurrencyController');
                Route::post('/currency/changeStatus', 'CP\CurrencyController@changeStatus');

            }
            if (can('calendar')) {
                Route::resource('/calendar_event', 'CP\CalendarEventController');
                Route::post('/calendar_event/changeStatus', 'CP\CalendarEventController@changeStatus');

            }
            if (can('products')) {
                Route::resource('/product', 'CP\ProductController');
                Route::post('/product/changeStatus', 'CP\ProductController@changeStatus');

            }
            if (can('subscriptions')) {
                Route::resource('/subscription', 'CP\SubscriptionController');
            }
            if (can('country')) {
                Route::resource('/country', 'CP\CountryController');
                Route::post('/country/changeStatus', 'CP\CountryController@changeStatus');
            }
            if (can('city')) {
                Route::resource('/city', 'CP\CityController');
                Route::post('/city/changeStatus', 'CP\CityController@changeStatus');
            }

        });

        Route::group(array('middleware' => ['auth', 'customer']), function () {
            Route::resource('/myProduct', 'CP\MyProductController');
            Route::post('/myProduct/changeStatus', 'CP\MyProductController@changeStatus');
            Route::get('/myProfile', 'CP\UserController@myProfile');
            Route::get('/myExpo', 'CP\ExpoController@myExpo');
            Route::post('/update_profile', 'CP\UserController@update_profile');
            Route::post('/update_my_expo', 'CP\ExpoController@update_my_expo');
            Route::get('/myOrders', 'CP\OrderController@myOrders');
             Route::post('/myOrders/changeStatus', 'CP\OrderController@changeStatus');
            Route::get('/order_details/{id}', 'CP\OrderController@order_details');
            Route::resource('/deliveryPrices', 'CP\DeliveryPricesController');
            Route::post('/deliveryPrices/changeStatus', 'CP\DeliveryPricesController@changeStatus');
            Route::delete('/deliveryPrices/{id}', 'CP\DeliveryPricesController@destroy');
            Route::get('/viewMessage/{id}', 'CP\MyMessageController@view_details')->name('viewMessage');
            Route::get('/password/change', 'CP\UserController@change_password')->name('change_password');
            Route::post('change_password', 'CP\UserController@password_store')->name('password_store');
            
            Route::resource('/messages', 'CP\MyMessageController');
        });
        

    });
    Route::get('/customer_login', 'Main@login')->name('customer_login');
    Route::get('/customer_register', 'Main@register')->name('customer_register');
    Route::get('/register', 'Main@register')->name('register');

    // Route::group(array('prefix' => 'customer','middleware' => ['auth','customer']), function () {
    // Route::get('/profile', 'Main@profile')->name('profile');
    // Route::get('/add_cafe', 'Main@add_cafe')->name('add_cafe');
    // Route::post('/store_cafe', 'Main@store_cafe')->name('store_cafe');
    // //Route::get('/packages', 'Main@packages')->name('packages');
    // Route::post('/store_package', 'Main@store_package')->name('store_package');
    // Route::get('/payment', 'Main@payment')->name('payment');
    // Route::get('/profile/edit', 'Main@edit_profile')->name('edit_profile');
    // Route::post('/profile/store', 'Main@store_profile')->name('store_profile');
    // Route::get('/contract', 'Main@contract')->name('contract');
    // Route::post('/contract/store', 'Main@store_contract')->name('store_contract');
    // });
    Route::group(array('prefix' => 'user', 'middleware' => ['auth', 'user']), function () {
        Route::get('/profile', 'Main@user_profile')->name('user_profile');
    });
});




