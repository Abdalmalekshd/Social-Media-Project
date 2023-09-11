<?php

namespace App\Http\Controllers\ApiControllers\AdminControllers;

use App\Http\Controllers\ApiControllers\ResponseController;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Support\Facades\File;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UsersController extends ResponseController
{
    public function allusers(){
        $data=[];
        $data['all_users']=User::withCount('post')->withCount('comments')->withCount('followers')->withCount('follow')->ORDERBY('created_at','Desc')->paginate(15);

        $data['users']=User::count();

        $data['users_per_day']=User::where('created_at','LIKE',['%'.Carbon::now()->format('Y-m-d').'%'])->count();

        return $this->sendResponse($data,'All Users Page Data'); 

    }

    

    public function dltuser(Request $req){
        $user=User::find($req->id);

        if(!$user)
        return $this->sendError('This User Does Not Exist'); 


        $des =  'Images/Avatar/' . $user->avatar;
        if (File::exists($des)) {
            File::delete($des);
        }


        $user->delete();

        return $this->sendResponse($user,'User Deleted Successfully'); 
        
    }
    
    

}
