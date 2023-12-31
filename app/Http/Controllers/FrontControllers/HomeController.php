<?php

namespace App\Http\Controllers\FrontControllers;

use App\Http\Controllers\Controller;
use App\Models\Follower;
use App\Models\Post;
use App\Models\Image;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
 
    

    public function home(){

        $data['followed_users']=Follower::with(['user' =>function($q){
                    $q->with(['post'=>function($qq){
                        $qq->with('images')->withCount('comments')->withCount('like');
                    }]);
                }])->whereHas('user',function($qqq){
                    $qqq->whereHas('post');
                })->where('user_id',auth()->id())->where('status',0)->get();
                

                $data['suggested_users']=User::whereDoesntHave('followers',function($q){
                    $q->where('user_id','=',auth()->id());
                })->where('id','<>',auth()->id())->limit(3)->inRandomOrder()->get();
                
            $data['current_user']=User::where('id',Auth::user()->id)->first();

            
        return view('user.home',$data);
    }


    public function markNotification(Request $request)
    {
        auth()->user()
            ->unreadNotifications
            ->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })
            ->markAsRead();

        return response()->noContent();
    }

    public function Aboutus(){
        
    return view('AboutUs');
    }
}
