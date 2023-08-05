<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function allcomments(){
        $data['all_comments']=Comment::with('post','user')->ORDERBY('created_at','Desc')->paginate(15);
        
        $data['comments']=Comment::count();

        $data['comments_per_day']=Comment::where('created_at','LIKE',['%'.\Carbon\Carbon::now()->format('Y-m-d').'%'])->count();

        return view('Admin.all-comments',$data);


    }

    public function dltcomment(Request $req){
        $comment=Comment::find($req->id);

        $comment->delete();

        return response()->json(["status" =>true,
        'msg'=>'Comment Deleted Successfully',
        'id'=>$req->id]);
        
    }
}
