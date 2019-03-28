<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('frontEnd.index');
});


/*
|--------------------------------------------------------------------------
| API routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'api', 'namespace' => 'API'], function () {
    Route::group(['prefix' => 'v1'], function () {
        require config('infyom.laravel_generator.path.api_routes');
    });
});


Route::auth();

Route::get('/home', 'Home1Controller@index');
Route::get('/dashboard', 'HomeController@index');
Route::get('/Messages', 'HomeController@Messages');
Route::get('/register/{id}', 'Home1Controller@showRegisterForm');
Route::post('send/message', 'HomeController@sendMessage');

//********from here************************

Route::get('Userpackages', 'HomeController@package');
Route::post('changeLogo', 'HomeController@changeLogo');
Route::get('paypalCredentialsUser', 'HomeController@paypal');
Route::get('view/packages', 'Home1Controller@viewPackage');
Route::post('logout', 'Auth\LoginController@logout');
Route::get('/getPackageDetails/{val}', 'distributor_linkController@getPackageDetails');
Route::post('/share/link', 'distributor_linkController@shareLink');

//*********************************paypal****************************
// route for view/blade file
// route for view/blade file
Route::get('paywithpaypal', array('as' => 'paywithpaypal','uses' => 'PaypalController@payWithPaypal',));
// route for post request
Route::post('paypal', array('as' => 'paypal','uses' => 'PaypalController@postPaymentWithpaypal',));
// route for check status responce
Route::get('paypal', array('as' => 'status','uses' => 'PaypalController@getPaymentStatus',));
Route::resource('packages', 'packagesController');
Route::resource('paypalCredentials', 'paypalCredentialsController');
Route::resource('paypalClientCredentials', 'paypalDetailsController');
Route::get('activateCard/{id}', 'paypalDetailsController@activateCard');
Route::resource('landings', 'landingController');
Route::get('SocialLink', 'HomeController@SocialLink');
Route::get('Headers', 'HomeController@EditHeaders');
Route::post('editHeader', 'HomeController@updateHeader');
Route::post('editLinks', 'HomeController@updateLink');
Route::post('landingPage', 'landingController@update');
Route::get('DeleteImg/{id}', 'landingController@DeleteImg');
Route::get('users/edit/{id}', 'usersController@editProfile');
Route::post('editProfile/{id}', 'usersController@update');
Route::post('editUser/{id}', 'usersController@update2');
Route::resource('distributors', 'distributorController');
Route::get('exportAll/{id}', 'distributorController@exportAll');
Route::get('exportNew/{id}', 'distributorController@exportNew');
Route::get('distributorPayout/{id}', 'distributorController@distributorPayout');
Route::get('distributorPayoutDone/{id}', 'distributorController@distributorPayoutDone');
Route::resource('users', 'usersController');
Route::resource('rememberMessage', 'defaultMessageController');

//*******route for distributor***************

Route::get('Updatedistributorpay/{id}', 'distributorController@Updatepayment');

//*****************for user*****
Route::resource('usermessages', 'usermessageController');
Route::resource('adddistributors', 'adddistributorController');

//Route::get('getpackamt/{val}', 'Home1Controller@calculateamt');

//*********************************************************************Distributor************************************************
Route::get('/Register/Distributor', 'Home1Controller@register');

Route::get('/register/{id}/{code}', 'Home1Controller@registerFromLink');
Route::post('/Distributor/Register', 'Home1Controller@store');
Route::get('/checkCode/{code}', 'Home1Controller@checkCode');
Route::get('/checkCodeEntered/{code}', 'Home1Controller@checkCode2');
Route::get('/checkCode1/{code}/{id}', 'Home1Controller@checkCode1');
Route::get('/registered/users', 'HomeController@regUsers');
Route::get('/view/user/{id}', 'HomeController@viewUser');
Route::get('/terminate/profile/{id}', 'Home1Controller@deleteProfile');
Route::get('/set/disable/time', 'Home1Controller@disableTime');
Route::post('/edit/disable/time', 'Home1Controller@editDisableTime');
Route::get('/set/disable/day', 'Home1Controller@editDisableDay');
Route::get('/disabled/users', 'Home1Controller@disabledUser');
Route::get('/changeType/{val}', 'HomeController@changeType');
Route::get('/disabled/user/details/{id}', 'Home1Controller@disabledUserShow');
Route::get('/disableUser', 'Home1Controller@disableUser');

//**********************************************************database check****************************************

Route::get('/sql', 'Home1Controller@sql');
Route::get('/changePackage/{id}', 'HomeController@changePackage');
Route::get('/changeData/{id}/{package}', 'HomeController@changeData');
Route::get('/CancelChange/{id}', 'HomeController@CancelChange');
Route::get('/packageChange/{id}', 'HomeController@CancelChange');
Route::get('/change/pakage', 'HomeController@packageChange');
Route::post('/save/change/message', 'HomeController@changePAckge');
Route::get('/change/pakage/message', 'HomeController@changePAckgeMsg');


//***************************************************************CRON ************************************************
Route::get('reminder', 'scheduleMessegeController@reminder');
Route::get('/checkExpiry', 'scheduleMessegeController@disableUser');

Route::get('/encryptData', 'scheduleMessegeController@encryptData');

Route::resource('distributorLinks', 'distributor_linkController');