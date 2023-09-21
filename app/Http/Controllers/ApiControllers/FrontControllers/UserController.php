<?php

namespace App\Http\Controllers\ApiControllers\FrontControllers;

use App\Http\Controllers\ApiControllers\ResponseController;
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

class UserController extends ResponseController
{
    public function UserProfile($id){
        $data=[];
        $data['user']=User::find($id);
        if(!$data['user'])
        return $this->sendError('This User Does Not Exists');


        $data['post']=Post::with('images','user')->whereHas('images',function($img){
            $img->select('photo');
        })->withCount('comments')->withCount('like')->whereHas('user')->where('user_id',$data['user']->id)->get();



        //if The Current User Follow The User That He Enetred His Profile
    $data['follower']=Follower::where('user_id',Auth::user()->id)->where('followed_id',$id)->where('status',0)->first();

    $data['blockeduser']=Follower::where('user_id',Auth::user()->id)->where('followed_id',$id)->where('status',1)->first();


    $data['blocked']=Follower::where('followed_id',Auth::user()->id)->where('user_id',$id)->where('status',1)->first();



    $data['countFollowing']=Follower::where('user_id',$id)->where('status',0)->count();


    $data['countFollowers']=Follower::where('followed_id',$id)->where('status',0)->count();

    $data['countposts']=Post::where('user_id',$id)->count();

    return $this->sendResponse($data,'Others Users Profile Page');

    }

    public function follow(Request $req){

        $user=User::find($req->id);

        if(!$user)
        return $this->sendError('This User Does Not Exists');
        if(!Follower::where('user_id',auth()->id())->where('followed_id',$req->id)->first()){
        Follower::create([
        'user_id'=>Auth::user()->id,
        'followed_id'=>$user->id
        ]);

        return $this->sendResponse($user,'You Started Following ' .User::where('id',$req->id)->first()->name);
    }
    else{
        return $this->sendError('You Already Following '.User::where('id',$req->id)->first()->name);

    }
    }

    public function cancelfollow(Request $req){
        $follower=Follower::where('user_id',Auth::user()->id)->where('followed_id',$req->id)->first();

        if(!$follower)
        return $this->sendError('You Dont Follow This User');

        $follower->delete();

        return $this->sendResponse(User::where('id',$req->id)->first(),'You Unfollowed '.User::where('id',$req->id)->first()->name);

    }

    public function Block(Request $req){
        $block=Follower::where('user_id',Auth::user()->id)->where('followed_id',$req->id)->first();

        if(!$block)
        return $this->sendError('User Does Not Exists');

        if(Follower::where('user_id',Auth::user()->id)->where('followed_id',$req->id)->where('status',0)->first()){

        $block->update([
            'status' => 1,
        ]);
        return $this->sendResponse(User::where('id',$req->id)->first(),'You Blocked '.User::where('id',$req->id)->first()->name);

    }else{
        return $this->sendError('You Already Blocked '.User::where('id',$req->id)->first()->name);

    }


    }

    public function UnBlock(Request $req){
        $unblock=Follower::where('user_id',Auth::user()->id)->where('followed_id',$req->id)->where('status',1)->first();

        if(!$unblock)
        return $this->sendError('You Did Not Block '. User::where('id',$req->id)->first()->name);


        $unblock->update([
            'status' => 0,
        ]);

        return $this->sendResponse(User::where('id',$req->id)->first(),'You UnBlocked '.User::where('id',$req->id)->first()->name);


    }



public function report(Request $req){


try{
    DB::beginTransaction();
    $data=[];
    $id='';
    if($req->postId == null && $req->commentId == null)
    {
    $id=$req->userId;
        if(User::where('id',$req->userId)->first()){
    $data['user']=Report::create([
    'user'=>$id,
    'reason'=>$req->reason,
    'user_id'=>auth()->id(),
    ]);

}else{
    return $this->sendError('This User Account You Reported Does Not Exist Any More');

}
    }elseif($req->userId == null && $req->commentId == null){
    $id=$req->postId;

    if(Post::where('id',$req->postId)->first()){

    $data['post']=Report::create([
    'post_id'=>$id,
    'reason'=>$req->reason,
    'user_id'=>auth()->id(),
    ]);
}else{
    return $this->sendError('This Post You Reported Has Been Deleted');

}
    }else{
    $id=$req->commentId;

    if(Comment::where('id',$req->commentId)->first()){

    $data['comment']=Report::create([
    'comment_id'=>$id,
    'reason'=>$req->reason,
    'user_id'=>auth()->id(),
    ]);
}else{
    return $this->sendError('This Comment You Reported Has Been Deleted');

}

}

    DB::commit();

    return $this->sendResponse($data,'Thank you for your contribution to improving our community');



}catch(\Exception $ex){
    DB::rollBack();
    return $this->sendError('There Was An Error Please Try Again Later');

}

}


public function users(){

    $data['suggested_users']=User::whereDoesntHave('followers',function($q){
        $q->where('user_id','=',auth()->id());
    })->where('id','<>',auth()->id())->inRandomOrder()->paginate(10);

    return $this->sendResponse($data,'Users To Follow Page');

}


public function search(Request $req){
    $data['user'] = User::where(DB::raw('concat(name," ",phone)') , 'LIKE' , '%' . $req->search . '%')->where('id','!=',auth()->id())->get();


    return $this->sendResponse($data,'We Found '. User::where(DB::raw('concat(name," ",phone)') , 'LIKE' , '%' . $req->search . '%')->where('id','!=',auth()->id())->count() . ' Result For You');


}


public function userlogout(){
    auth('web')->logout();

    return $this->sendResponse('','You Just Logged Out Please Login To Get To Your Account');

    }

}
