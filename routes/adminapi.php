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

Route::post('admin_login','App\Http\Controllers\ApiControllers\AdminControllers\LoginController@adminsignin')->name('admin.login');

Route::middleware('auth:adminapi')->namespace('App\Http\Controllers\ApiControllers\AdminControllers')->group(function () {

    Route::get('/Admin', function (Request $request) {
        return $request->user();
    });

//Admin Routes


################### End Login & SignUp Routes  #######################

############################ Start Admin  Routes ###################################

    Route::get('Dashboard','DashboardController@Dashboard')->name('Dashboard');

    Route::get('all_users','UsersController@allusers')->name('all.users');
    Route::post('delete_users','UsersController@dltuser')->name('dlt.user');




    Route::get('all_comments','CommentsController@allcomments')->name('all.comments');
    Route::post('delete_comments','CommentsController@dltcomment')->name('dlt.comment');


    Route::get('all_reports','ReportsController@allreports')->name('all.reports');
    Route::post('dlt_reports','ReportsController@dltreport')->name('dlt.report');


    Route::get('all_posts','PostsController@allposts')->name('all.posts');
    Route::post('delete_post','PostsController@dltpost')->name('dlt.post');

    Route::post('logout','LoginController@adminlogout')->name('logout');

});
############################ End User Routes ###################################





// Personal access client created successfully.
// Client ID: 1
// Client secret: 0BoBEH5n65SOfnZ3qu2SmAb4TvPD904XgZYH7rK3
// Password grant client created successfully.
// Client ID: 2
// Client secret: fdsqZpI3qE3a0QzbUm2ImvqODZJhyBkLYQB9mzmO
