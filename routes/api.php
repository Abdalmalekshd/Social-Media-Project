<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

//User Routes

Route::group(['namespace'=>'App\Http\Controllers\ApiControllers\FrontControllers'],function(){




    Route::get('/home','HomeController@home')->name('user.home');

    
############################ Start Profile Routes ###################################
    
    Route::get('/MyProfile','ProfileController@Myprofile')->name('user.profile');//Logged In User Profile


    
    Route::post('Update-Profile/{id}','ProfileController@updateProfile')->name('user.profile.update');

    Route::delete('delete-Profile/{id}','ProfileController@deleteProfile')->name('user.profile.dlt');

    Route::delete('delete-avatar/{id}','ProfileController@deleteProfileAvatar')->name('user.avatar.dlt');
    
    
    Route::post('changepassword','ProfileController@changeoldpassword')->name('changeoldpassword');

############################ End Profile Routes ###################################


############################ Start Post Routes ###################################


    Route::post('single/{id}','PostController@showpost')->name('show.single.post');

    Route::post('store','PostController@store')->name('store.post');

    

    Route::put('update/{id}','PostController@update')->name('update.post');

    Route::get('delete/{id}','PostController@destroy')->name('delete.post');


    Route::get('User/Bookmark','PostController@showbookmarkedPosts')->name('show.bookmarked.posts');

    Route::post('bookmark','PostController@bookmark')->name('bookmark.post');//Ajax

    Route::post('User/Bookmark/dlt','PostController@DeletebookmarkedPosts')->name('delete.bookmarked.post');//Ajax

    

    // Route::post('like','PostController@like')->name('like.post');

    // Route::post('unlike','PostController@unlike')->name('delete.like.post');



    // Route::post('comment','PostController@comment')->name('comment.post');//Ajax

    // Route::get('dltcomment/{id}','PostController@destroycomment')->name('dlt.comment');//Ajax

    



############################ End Post Routes ###################################


############################ Start User Routes ###################################


    // Route::get('Profile/{id}','UserController@UserProfile')->name('Show.User.Profile'); //others Users

    // Route::post('follow','UserController@follow')->name('User.follow');
    
    // Route::post('cancelfollow','UserController@cancelfollow')->name('User.follow.cancel');
    

    // Route::post('Block','UserController@Block')->name('User.block');

    // Route::post('UnBlock','UserController@UnBlock')->name('User.UnBlock');



    // Route::get('getreport/{id}','UserController@getreport')->name('get.report');

    // Route::post('report','UserController@report')->name('report');


    // Route::get('users','UserController@users')->name('users');


    // Route::get('Search-users','UserController@search')->name('search.users');


});
############################ End User Routes ###################################


    // Route::get('logout','LoginController@userlogout')->name('logout');


});
// Personal access client created successfully.
// Client ID: 1
// Client secret: 0BoBEH5n65SOfnZ3qu2SmAb4TvPD904XgZYH7rK3
// Password grant client created successfully.
// Client ID: 2
// Client secret: fdsqZpI3qE3a0QzbUm2ImvqODZJhyBkLYQB9mzmO