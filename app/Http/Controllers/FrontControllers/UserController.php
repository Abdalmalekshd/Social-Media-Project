<?php

namespace App\Http\Controllers\FrontControllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Follower;
use App\Models\Image;
use App\Models\Post;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function UserProfile($id){
        $data=[];
        $data['user']=User::find($id);
        if(!$data['user'])
        return redirect()->route('user.home');

        $data['post']=Post::with('images','user')->whereHas('images',function($img){
            $img->select('photo','video');
        })->withCount('comments')->withCount('like')->whereHas('user')->where('user_id',$data['user']->id)->get();
        

        
        //if The Current User Follow The User That He Enetred His Profile
    $data['follower']=Follower::where('user_id',Auth::user()->id)->where('followed_id',$id)->where('status',0)->first();

    $data['blockeduser']=Follower::where('user_id',Auth::user()->id)->where('followed_id',$id)->where('status',1)->first();


    $data['blocked']=Follower::where('followed_id',Auth::user()->id)->where('user_id',$id)->where('status',1)->first();



    $data['countFollowing']=Follower::where('user_id',$id)->where('status',0)->count();


    $data['countFollowers']=Follower::where('followed_id',$id)->where('status',0)->count();

    $data['countposts']=Post::where('user_id',$id)->count();

        return view('User.UsersToFollow.UserProfile',$data);
    }

    public function follow(Request $req){
        
        $user=User::find($req->id);

        if(!$user)
        return redirect()->route('user.home')->with(['error'=>'This User Does Not Exist']);

        Follower::create([
        'user_id'=>Auth::user()->id,
        'followed_id'=>$user->id
        ]);

        return response()->json([
            "status" => true,
            'msg' => 'User followed Success'
        ]);
    }
    
    public function cancelfollow(Request $req){
        $follower=Follower::where('user_id',Auth::user()->id)->where('followed_id',$req->id)->first();

        if(!$follower)
        return redirect()->route('user.home')->with(['error'=>'You Dont Follow This User']);

        $follower->delete();

        return response()->json([
            "status" => true,
            'msg' => 'User Unfollowed Success'
        ]);
    }

    public function Block($id){
        $block=Follower::where('user_id',Auth::user()->id)->where('followed_id',$id)->first();

        if(!$block)
        return redirect()->route('user.home')->with(['error'=>'This User Does Not Exist']);
        
        $block->update([
            'status' => 1,
        ]);

        return redirect()->back();

    }

    public function UnBlock($id){
        $unblock=Follower::where('user_id',Auth::user()->id)->where('followed_id',$id)->where('status',1)->first();

        if(!$unblock)
        return redirect()->route('user.home')->with(['error'=>'This User Does Not Exist']);
        
        $unblock->update([
            'status' => 0,
        ]);

        return redirect()->back();

    }


    public function getreport($id){
        $data=[]; 
$data['post']=Post::find($id);
$data['user']=User::find($id);
$data['comment']=Comment::find($id);


if(!$data)
return redirect()->route('user.home')->with(['error'=>'This ID Does Not Exist']);



return view('User.Reports.create',$data);

}

public function report(Request $req){

    
try{
    DB::beginTransaction();
    $id='';
if($req->postId == null && $req->commentId == null)
{
$id=$req->userId;

Report::create([
'user'=>$id,
'reason'=>$req->reason,
'user_id'=>auth()->id(),
]);

}elseif($req->userId == null && $req->commentId == null){
$id=$req->postId;


Report::create([
'post_id'=>$id,
'reason'=>$req->reason,
'user_id'=>auth()->id(),
]);

}else{
$id=$req->commentId;

Report::create([
'comment_id'=>$id,
'reason'=>$req->reason,
'user_id'=>auth()->id(),
]);

}

Alert::Success('Success', 'Thank You For Helping Us Make Our Community Safer ');
DB::commit();

return redirect()->route('user.home');


}catch(\Exception $ex){
DB::rollBack();
Alert::error('Error Title', 'Error Message');
return redirect()->route('user.home');
}

}


public function users(){

    $data['suggested_users']=User::whereDoesntHave('followers',function($q){
        $q->where('user_id','=',auth()->id());
    })->where('id','<>',auth()->id())->inRandomOrder()->paginate(10);

    $data['user']='';

return view('User.UsersToFollow.Users',$data);
}


public function search(Request $req){
    $data['user'] = User::where(DB::raw('concat(name," ",phone)') , 'LIKE' , '%' . $req->search . '%')->get();
    
    
    $data['suggested_users']='';
    return view('User.UsersToFollow.Users',$data);


}

}
