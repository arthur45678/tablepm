<?php
/*Phone*/
//Home related routes



/*Test Facebook authentication*/
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
/*end Test Facebook authentication*/





Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ],
       // 'namespace' => '',
    ],
    function() {

        Route::get('/', ['uses' => 'Site\IndexController@index', 'as' => 'homeIndex']);
        Route::get('/search', ['uses' => 'Site\SearchAdvancedController@searchByDistrict', 'as' => 'searchByDistrict']);

        Route::resource('/contacts', 'Site\ContactsController', ['names' => 'contacts']);
        Route::resource('/restaurantshops', 'Site\RestaurantShopsController', ['names' => 'restaurantShops']);


        Route::get('/register/', ['uses' => 'Advertisers\Auth\RegisterController@showRegistrationForm', 'as' => 'register']);


        Route::get('search-advanced/', ['uses' => 'Site\SearchAdvancedController@index', 'as' => 'searchAdvanced.index']);
        Route::get('search-advanced-result/',  ['uses' => 'Site\SearchAdvancedController@show', 'as' => 'searchAdvanced.show']);




        Route::get('/register/email', ['uses' => 'Advertisers\Auth\RegisterController@showRegistrationFormEmail', 'as' => 'advertiser.register.email']);
        Route::post('/register/email', ['uses' => 'Advertisers\Auth\RegisterController@registerByEmail', 'as' => 'advertiser.register.email']);
        Route::get('/register/email/showregisterpreconfirmmessage', ['uses' => 'Advertisers\Auth\RegisterController@showRegisterPreConfirmMessage', 'as' => 'advertiser.register.showRegisterPreConfirmMessage']);

        Route::get('/register/phone', ['uses' => 'Advertisers\Auth\RegisterController@showRegistrationFormPhone', 'as' => 'advertiser.register.phone']);
        Route::post('/register/phone', ['uses' => 'Advertisers\Auth\RegisterController@registerByPhone', 'as' => 'advertiser.register.phone']);
        Route::get('/register/phoneverifycodeform', ['uses' => 'Advertisers\Auth\RegisterController@phoneVerifyCodeForm', 'as' => 'advertiser.register.phoneVerifyCodeForm']);




        Route::get('/bookmarks/{id}/addRestaurantShopBookmark', ['uses' => 'Site\BookmarkedController@addRestaurantShopBookmark','as' => 'bookmarked.addRestaurantShopBookmark']);
        Route::get('/bookmarks/getRestaurantShopBookmarked', ['uses' => 'Site\BookmarkedController@getRestaurantShopBookmarked','as' => 'bookmarked.getRestaurantShopBookmarked']);
        Route::get('/bookmarks/{id}/deleteRestaurantShopBookmarked', ['uses' => 'Site\BookmarkedController@deleteRestaurantShopBookmarked','as' => 'bookmarked.deleteRestaurantShopBookmarked']);




        /*     Route::get('/register/phone', ['uses' => 'Advertisers\Auth\TwilioSMSRegisterController@showRegistrationFormPhone', 'as' => 'advertiser.register.phone']);
             Route::post('/register/phone/createnewuser', ['uses' => 'Advertisers\Auth\TwilioSMSRegisterController@createNewUser', 'as' => 'advertiser.register.createNewUser']);*/
});

/*Advertisers client side*/
Route::group(['prefix' => 'advertiser', 'namespace' => 'Advertisers'], function () {

    Route::get('/index', ['uses' => 'IndexController@index', 'as' => 'advertisIndex']);
    Route::get('/login', ['uses' => 'Auth\LoginController@showLoginForm', 'as' => 'advertisers.login']);
    Route::post('/login', ['uses' => 'Auth\LoginController@login', 'as' => 'advertisers.login']);

    Route::get('/user/confirmation/{token}', ['uses' => 'Auth\RegisterController@confirmation', 'as' => 'confirmation.advertisersUser']);
    Route::get('/logout', ['uses' => 'Auth\LoginController@logout', 'as' => 'advertisers.logout']);

});
/*end Client side*/



Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['ViewAdmin', 'auth']], function () {

    Route::get('/index', ['uses' => 'IndexController@index', 'as' => 'adminIndex']);
    Route::resource('/users', 'UsersController', ['names' => 'admin.users']);
    Route::resource('/permissions', 'PermissionsController', ['names' => 'admin.permissions']);

    Route::get('/advertisercompanies-search', ['uses' => 'AdvertiserCompaniesController@search', 'as' => 'admin.advertiserCompanies.search']);
    Route::resource('/advertisercompanies', 'AdvertiserCompaniesController', ['names' => 'admin.advertiserCompanies']);
    Route::get('/advertisercompanies/{id}/getsearched',  ['uses' => 'AdvertiserCompaniesController@getSearched', 'as' => 'admin.advertiserCompanies.getSearched']);

    Route::resource('/restaurantcompanies', 'RestaurantCompaniesController', ['names' => 'admin.RestaurantCompanies']);
    Route::get('/restaurantcompanies-search',  ['uses' => 'RestaurantCompaniesController@search', 'as' => 'admin.RestaurantCompanies.search']);
    Route::get('/restaurantcompanies/{id}/getsearched',  ['uses' => 'RestaurantCompaniesController@getSearched', 'as' => 'admin.RestaurantCompanies.getSearched']);


  /*  Route::get('viewrestaurantlocations', ['uses' => 'RestaurantCompaniesController@viewRestaurantLocations', 'as' => 'admin.RestaurantCompanies.viewRestaurantLocations']);
    Route::get('getallrestaurantlocations', ['uses' => 'RestaurantCompaniesController@getAllRestaurantLocations', 'as' => 'admin.RestaurantCompanies.getAllRestaurantLocations']);
    Route::get('showallrestaurantlocations/{sendData}', ['uses' => 'RestaurantCompaniesController@showAllRestaurantLocations', 'as' => 'admin.RestaurantCompanies.showAllRestaurantLocations']);*/

    Route::resource('/industriesadvertscompanies', 'IndustriesAdvertsCompaniesController', ['names' => 'admin.IndustriesAdvertsCompanies']);



    Route::resource('/restaccounttype', 'RestAccountTypeController', ['names' => 'admin.restAccountType']);
    Route::resource('/tasksforadvertiserscompanies', 'TasksForAdvertisersCompaniesController', ['names' => 'admin.tasksForAdvertisers']);
    Route::resource('/tasksforrestaurantcompanies', 'TasksForRestaurantCompaniesController', ['names' => 'admin.tasksForRestaurantCompanies']);

    Route::resource('/shops', 'ShopsController', ['names' => 'admin.shops']);




    Route::resource('/dish', 'DishController', ['names' => 'admin.dish']);

    Route::resource('/districts', 'DistrictController', ['names' => 'admin.districts']);

    Route::resource('/restaurantcuisine', 'RestaurantCuisineController', ['names' => 'admin.restaurantcuisine']);
    Route::resource('/restaurantType', 'RestaurantTypeController', ['names' => 'admin.restaurantType']);

    Route::resource('/customertypesrestaurants', 'CustomerTypesRestaurantsController', ['names' => 'admin.customerTypesRestaurants']);

    Route::get('/bookmarks/{id}/addRestaurantCompaniesBookmark', ['uses' => 'BookmarkedController@addRestaurantCompaniesBookmark','as' => 'admin.bookmarked.addRestaurantCompaniesBookmark']);
    Route::get('/bookmarks/getRestaurantCompaniesBookmarked', ['uses' => 'BookmarkedController@getRestaurantCompaniesBookmarked','as' => 'admin.bookmarked.getRestaurantCompaniesBookmarked']);
    Route::get('/bookmarks/{id}/deleteRestaurantCompaniesBookmarked', ['uses' => 'BookmarkedController@deleteRestaurantCompaniesBookmarked','as' => 'admin.bookmarked.deleteRestaurantCompaniesBookmarked']);


    Route::get('/bookmarks/{id}/addAdvertiserCompaniesBookmark', ['uses' => 'BookmarkedController@addAdvertiserCompaniesBookmark','as' => 'admin.bookmarked.addAdvertiserCompaniesBookmark']);
    Route::get('/bookmarks/getAdvertiserCompaniesBookmarked', ['uses' => 'BookmarkedController@getAdvertiserCompaniesBookmarked','as' => 'admin.bookmarked.getAdvertiserCompaniesBookmarked']);
    Route::get('/bookmarks/{id}/deleteAdvertiserCompaniesBookmarked', ['uses' => 'BookmarkedController@deleteAdvertiserCompaniesBookmarked','as' => 'admin.bookmarked.deleteAdvertiserCompaniesBookmarked']);


    Route::get('/searchrestaurant', ['uses' => 'RestaurantShopProfileController@searchRestaurant', 'as' => 'admin.searchRestaurant']);
    Route::resource('/restaurantshopprofile', 'RestaurantShopProfileController', ['names' => 'admin.restaurantShopProfile']);

    Route::get('viewrestaurantshopslocations', ['uses' => 'RestaurantShopProfileController@viewRestaurantShopsLocations', 'as' => 'admin.restaurantShopProfile.viewRestaurantShopsLocations']);
    Route::get('/getrestaurantshopsbyrestaurantid/{id}', ['uses' => 'RestaurantShopProfileController@getRestaurantShopsByRestaurantID','as' => 'admin.restaurantShopProfile.getRestaurantShopsByRestaurantID']);

    Route::get('new-users', 'UsersController@getNewAdvertisers');
    Route::post('new-users', 'UsersController@approveNewUsers');

    // homeMenuImage



});

//Route::resource('/map', 'MapController', ['names' => 'map']);

//Route::get('/map/show/{sendData}', 'MapController@show')->name('show');
Route::get('/show/{sendData}', 'MapController@show')->name('show');
Route::get('/map/', 'MapController@index')->name('index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
