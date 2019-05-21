<?php

use Illuminate\Http\Request;

// Route::post('reset_password', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::post('reset_password', 'Auth\ForgotPasswordController@forgetpassword');
Route::post('forgetpassword', 'Auth\ForgotPasswordController@forgetpassword');
 
/*Route::get('sends', function (){
    \Illuminate\Support\Facades\Mail::send('emails.email',
        [
            'title' => 'Registration Successfully',
            'content' => 'You can manage your expo till admin approve your account from this link http://myexpo.shop/en/login' ,
        ],
        function ($message) {
            $message->from('MyExpoME@gmail.com', 'My Expo');
            $message->subject('My Expo Registration Successfully');
            $message->to('atallah@email.com');
        }
    );

});*/
Route::get('ad', 'API\AdController@show');
Route::get('category/{type}', 'API\CategoryController@index');
Route::get('material', 'API\MaterialController@index');
Route::get('size', 'API\SizeController@index');
Route::get('slider', 'API\SliderController@index');
Route::get('home/{country_id}', 'API\SliderController@home');
Route::get('currency', 'API\CurrencyController@index');
Route::get('clothing', 'API\ClothingTypeController@index');
Route::get('occasion', 'API\OccasionController@index');
Route::get('pages', 'API\PageController@index');
Route::get('events/{date}', 'API\EventController@calenderEvent');
Route::get('event_days', 'API\EventController@eventDaysIOS');
Route::get('event_days2', 'API\EventController@eventDaysAndroid');
Route::get('country', 'API\CountryController@index');
Route::get('expo', 'API\ExpoController@expo');
Route::get('expos', 'API\ExpoController@expos');
//Route::get('expo_new/{expo_id}', 'API\ExpoController@expo_new');
Route::get('expo_new', 'API\ExpoController@expo_new');
Route::get('business_new', 'API\ExpoController@business_new');
//Route::get('business_new/{business_id}', 'API\ExpoController@business_new');
Route::get('business', 'API\ExpoController@business');
Route::get('test', 'API\ExpoController@test');
Route::get('expo_details/{expo_id}', 'API\ExpoController@expo_details');
Route::get('product_details/{product_id}', 'API\ExpoController@product_details');
Route::get('expo_products/{expo_id}', 'API\ExpoController@expo_products');
Route::get('settings', 'API\SettingController@index');
Route::get('filters', 'API\SizeController@getFilters');
Route::get('filter_products', 'API\ProductController@filter_products');



Route::post('/login', 'API\UserController@login');
Route::post('/signUp', 'API\UserController@signUp');
Route::post('/join', 'API\UserController@join_expo');
Route::post('/expo_update/{expo_id}', 'API\ExpoController@expo_update');
Route::post('/validate_mobile_phone', 'API\UserController@validate_mobile_phone');







Route::get('company', 'API\CompanyController@index');
Route::get('products', 'API\ProductController@index');
Route::get('ProductsOfCategory', 'API\CategoryController@ProductsOfCategory');
Route::get('packages', 'API\PackageController@index');
Route::post('AdvertisementUs', 'API\AdvertisementUsController@store');
Route::post('ContactUs', 'API\ContactController@store');

Route::get('/career', 'API\CareerController@index');
Route::get('/field', 'API\FieldController@index');
Route::get('/publish', 'API\PublishController@index');
Route::post('/career', 'API\CareerController@store');
Route::get('seeker', 'API\SeekerController@index');
Route::get('social', 'API\SocialController@index');
Route::get('salePage', 'API\ProductController@salePage');
Route::get('/send', 'API\MessageController@send');




    Route::get('/my_cart', 'API\CartController@index');
    Route::get('/my_cart2', 'API\CartController@index2');
    Route::post('/create_cart', 'API\CartController@store');
    Route::post('/update_cart/{id}', 'API\CartController@update');
    Route::post('/delete_cart', 'API\CartController@destroy');

    Route::post('/create_order', 'API\OrderController@create_order');


Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/editUser', 'API\UserController@editUser');
    Route::post('/changePassword', 'API\UserController@changePassword');

    Route::post('/add_wish_list', 'API\WishListController@add_wish_list');
    Route::post('/delete_wish_list', 'API\WishListController@delete_wish_list');
    Route::get('/my_wish_list', 'API\WishListController@my_wish_list');
    Route::get('/my_orders', 'API\OrderController@my_orders');
    Route::get('/order_details/{order_id}', 'API\OrderController@order_details');
    Route::get('/change_status', 'API\OrderController@change_status');
    Route::get('/my_messages', 'API\MessageController@index');
    Route::post('/send_message/{id}', 'API\MessageController@store');
    Route::get('/user_messages/{id}', 'API\MessageController@userMessages');
    Route::post('/delete_message/{id}', 'API\MessageController@destroy');
    Route::get('/notifications', 'API\AlertController@index');



    // Route::post('addProduct', 'API\ProductController@store');
    // Route::post('seeker', 'API\SeekerController@store');
    // Route::post('addToBestCategory', 'API\CategoryController@addToBestCategory');
    // Route::post('removeFromBestCategory', 'API\CategoryController@removeFromBestCategory');
    // Route::get('getCategoryForUser', 'API\CategoryController@getCategoryForUser');
    // Route::post('/rateProduct', 'API\ProductController@rateProduct');
    // Route::post('/likeProduct/{product_id}', 'API\ProductController@likeProduct');
    // Route::post('/unLikeProduct/{product_id}', 'API\ProductController@unLikeProduct');
    // Route::post('/favouriteProduct/{product_id}', 'API\ProductController@favouriteProduct');
    // Route::post('/unFavouriteProduct/{product_id}', 'API\ProductController@unFavouriteProduct');
    Route::get('/logout', 'API\UserController@logout');
});
