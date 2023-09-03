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

Route::group(['namespace'=>'App\Http\Controllers\ApiControllers\AdminControllers'],function(){




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


});
############################ End User Routes ###################################

    Route::post('logout','App\Http\Controllers\ApiControllers\FrontControllers\UserController@userlogout')->name('logout');

// بقيان باليوزر (Chatify)
});
// Personal access client created successfully.
// Client ID: 1
// Client secret: 0BoBEH5n65SOfnZ3qu2SmAb4TvPD904XgZYH7rK3
// Password grant client created successfully.
// Client ID: 2
// Client secret: fdsqZpI3qE3a0QzbUm2ImvqODZJhyBkLYQB9mzmO