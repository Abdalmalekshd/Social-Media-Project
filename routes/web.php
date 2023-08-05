<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){

################### Start Login & SignUp Routes  #######################

Route::group(['namespace'=>'App\Http\Controllers\FrontControllers','middleware'=>'guest:web'],function(){

    Route::get('login','LoginController@getLoginPage')->name('get.login');

    Route::post('login','LoginController@Login')->name('login');
    
    Route::get('signup','LoginController@getSigninPage')->name('signup');

    Route::post('Createaccount','LoginController@Signin')->name('create.account');


    Route::get('ForgetPassword','LoginController@forgetpass')->name('forgetpass');

    Route::post('ForgetPass','LoginController@forgetpassword')->name('forgetpassword');


    Route::get('ResetPassword/{email}','LoginController@Resetpass')->name('Resetpass');

    Route::post('setnewPassword','LoginController@setnewpass')->name('setnewpass');

    });
    

################### End Login & SignUp Routes  #######################


Route::group(['prefix'=>'SocialMedia','namespace'=>'App\Http\Controllers\FrontControllers'],function(){

    Route::get('Aboutus','HomeController@Aboutus')->name('AboutUs');


################### Start User Routes  #######################

Route::group(['middleware'=>'auth:web'],function(){

    Route::get('/','HomeController@home')->name('user.home');

    
############################ Start Profile Routes ###################################
Route::group(['prefix'=>'Profile'],function(){
    
    Route::get('/MyProfile','ProfileController@Myprofile')->name('user.profile');//Logged In User Profile


    Route::get('Edit-Profile','ProfileController@editProfile')->name('user.profile.edit');


    Route::Post('Update-Profile','ProfileController@updateProfile')->name('user.profile.update');

    Route::get('delete-Profile/{id}','ProfileController@deleteProfile')->name('user.profile.dlt');

    Route::get('delete-avatar/{id}','ProfileController@deleteProfileAvatar')->name('user.avatar.dlt');
    
    
    Route::get('changePassword','ProfileController@changePassword')->name('changePassword');

    Route::post('changeoldpassword','ProfileController@changeoldpassword')->name('changeoldpassword');
});
############################ End Profile Routes ###################################


############################ Start Post Routes ###################################

Route::group(['prefix'=>'Post'],function(){

    Route::get('single/{id}','PostController@showpost')->name('show.single.post');

    Route::get('create','PostController@create')->name('create.post');

    Route::post('store','PostController@store')->name('store.post');//ajax

    Route::get('edit/{id}','PostController@edit')->name('edit.post');

    Route::post('update','PostController@update')->name('update.post');

    Route::get('delete/{id}','PostController@destroy')->name('delete.post');


    Route::get('User/Bookmark','PostController@showbookmarkedPosts')->name('show.bookmarked.posts');

    Route::get('bookmark/{id}','PostController@bookmark')->name('bookmark.post');//Ajax

    Route::get('User/Bookmark/dlt/{id}','PostController@DeletebookmarkedPosts')->name('delete.bookmarked.post');//Ajax

    

    Route::get('like/{id}','PostController@like')->name('like.post');//Ajax

    Route::get('unlike/{id}','PostController@unlike')->name('delete.like.post');//Ajax



    Route::post('comment','PostController@comment')->name('comment.post');//Ajax

    Route::get('dltcomment/{id}','PostController@destroycomment')->name('dlt.comment');//Ajax

    


});
############################ End Post Routes ###################################


############################ Start User Routes ###################################

Route::group(['prefix'=>'User'],function(){

    Route::get('Profile/{id}','UserController@UserProfile')->name('Show.User.Profile'); //others Users

    Route::get('follow/{id}','UserController@follow')->name('User.follow');
    
    Route::get('cancelfollow/{id}','UserController@cancelfollow')->name('User.follow.cancel');
    

    Route::get('Block/{id}','UserController@Block')->name('User.block');

    Route::get('UnBlock/{id}','UserController@UnBlock')->name('User.UnBlock');



    Route::get('getreport/{id}','UserController@getreport')->name('get.report');

    Route::post('report','UserController@report')->name('report');


    Route::get('users','UserController@users')->name('users');


    Route::get('Search-users','UserController@search')->name('search.users');


});
############################ End User Routes ###################################


    Route::get('logout','LoginController@userlogout')->name('logout');



});
################### End User Routes  #######################


});


});