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

Route::group(['namespace'=>'App\Http\Controllers\AdminControllers','prefix'=>'admin','middleware'=>'guest:admin'],function(){

    Route::get('adminlogin','LoginController@adminLogin')->name('admin.get.login');

    Route::post('admin_login','LoginController@adminsignup')->name('admin.login');


    Route::get('admin_ForgetPassword','LoginController@forgetpass')->name('Admin.forgetpass');

    Route::post('admin_ForgetPass','LoginController@forgetpassword')->name('Admin.forgetpassword');


    Route::get('admin_ResetPassword/{email}','LoginController@Resetpass')->name('admin.Resetpass');

    Route::post('admin_setnewPassword','LoginController@setnewpass')->name('admin.setnewpass');

    });


################### End Login & SignUp Routes  #######################

############################ Start Admin  Routes ###################################
Route::group(['prefix'=>'SocialMedia/admin','namespace'=>'App\Http\Controllers\AdminControllers','middleware' => ['admin_auth']],function(){

    Route::get('Dashboard','DashboardController@Dashboard')->name('Dashboard');

    Route::get('all_users','UsersController@allusers')->name('all.users');
    Route::post('delete_users','UsersController@dltuser')->name('dlt.user');




    Route::get('all_comments','CommentsController@allcomments')->name('all.comments');
    Route::post('delete_comments','CommentsController@dltcomment')->name('dlt.comment');


    Route::get('all_reports','ReportsController@allreports')->name('all.reports');
    Route::post('dlt_reports','ReportsController@dltreport')->name('dlt.report');


    Route::get('all_posts','PostsController@allposts')->name('all.posts');
    Route::post('delete_post','PostsController@dltpost')->name('dlt.post');



    Route::get('logout','LoginController@adminlogout')->name('admin.logout');
});


});
