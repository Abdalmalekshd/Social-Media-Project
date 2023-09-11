<?php

namespace App\Http\Controllers\ApiControllers\AdminControllers;

use App\Http\Controllers\ApiControllers\ResponseController;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\File;

use Illuminate\Http\Request;

class PostsController extends ResponseController
{
    public function allposts(){
        $data['all_posts']=Post::with('images','user')->withCount('user')->withCount('images')->withCount('comments')->withCount('like')->withCount('reports')->ORDERBY('created_at','Desc')->paginate(15);

        $data['posts']=Post::count();


        $data['posts_per_day']=Post::where('created_at','LIKE',['%'.\Carbon\Carbon::now()->format('Y-m-d').'%'])->count();

        return $this->sendResponse($data,'All Posts Page Data'); 

    }
    
    
    public function dltpost(Request $req){
        $post=Post::find($req->id);

        if(!$post)
        return $this->sendError('This Post Does Not Exist'); 

        foreach($post->images as $image){
                
            $des = 'Images/posts/' . $image->photo;
if (File::exists($des)) {

        File::delete($des);
}

    }

        $post->delete();


        return $this->sendResponse($post,'Post Deleted Successfully'); 

        
    }
}
