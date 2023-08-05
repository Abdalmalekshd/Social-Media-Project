<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Support\Facades\File;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function allusers(){
        $data=[];
        $data['all_users']=User::withCount('post')->withCount('comments')->withCount('followers')->withCount('follow')->ORDERBY('created_at','Desc')->paginate(15);

        $data['users']=User::count();

        $data['users_per_day']=User::where('created_at','LIKE',['%'.Carbon::now()->format('Y-m-d').'%'])->count();

        return view('Admin.all-users',$data);
    }

    

    public function dltuser(Request $req){
        $user=User::find($req->id);

        $des =  'Images/Avatar/' . $user->avatar;
        if (File::exists($des)) {
            File::delete($des);
        }


        $user->delete();

        return response()->json(["status" =>true,
        'msg'=>'User Deleted Successfully',
        'id'=>$req->id]);
        //AJAX
    }
    
    

}
