<?php

namespace App\Http\Controllers\ApiControllers\AdminControllers;

use App\Http\Controllers\ApiControllers\ResponseController;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentsController extends ResponseController
{
    public function allcomments(){
        $data['all_comments']=Comment::with('post','user')->ORDERBY('created_at','Desc')->paginate(15);
        
        $data['comments']=Comment::count();

        $data['comments_per_day']=Comment::where('created_at','LIKE',['%'.\Carbon\Carbon::now()->format('Y-m-d').'%'])->count();

        return $this->sendResponse($data,'All Comments Page Data'); 


    }

    public function dltcomment(Request $req){
        $comment=Comment::find($req->id);
        if(!$comment)
        return $this->sendError('This Comment Does Not Exist'); 

        $comment->delete();


        return $this->sendResponse($comment,'Comment Deleted Successfully'); 
        
        
    }
}
