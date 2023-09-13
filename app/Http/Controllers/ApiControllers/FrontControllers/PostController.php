<?php

namespace App\Http\Controllers\ApiControllers\FrontControllers;

use App\Http\Controllers\ApiControllers\ResponseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\PostRequest;
use App\Models\BookmarkPost;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Like;
use App\Models\Post;
use App\Models\Report;
use App\Models\User;
use App\Traits\UplaodImageTraits;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
class PostController extends ResponseController
{

    use UplaodImageTraits;

    public function showpost($id){
        $data=[];
        $data['post']=Post::with('user','images')->withCount('comments')->withCount('like')->find($id);
        
        if(!$data['post'])
        return $this->sendError('This Post Does Not Exists','');
        $postId=$data['post']->id;
        $data['comments']=Comment::with('user')->Where('post_id',$data['post']->id)->where('parent_id','=',null)->get();
        return $this->sendResponse($data,'Single Post Page');

    }
        

    


    public function store(Request $req){
        
        try{
            DB::beginTransaction();
        $content=filter_var($req->content,FILTER_SANITIZE_STRING);
        
    
        $post=Post::create([
            'content'=>$req->content,'user_id'=>Auth::user()->id]);
            
            foreach ($req->file('image') as $imagefile) {     
                
            $image= $this->UploadImage('posts', $imagefile);

            $image=Image::create(['photo'=>$image,'post_id'=>$post->id]);
                
            }
            
            
            DB::commit();

            
    return $this->sendResponse($post,'Post Added Successfully');
        
            
        }catch(\Exception $ex){
            DB::rollBack();
    return $this->sendError('Please Check Your Data ');
            
        }

        }

        


        public function update(Request $request,$id){
            
            try{
                DB::beginTransaction();
                

                $post=Post::with('images')->whereHas('images',function($q){
                    $q->select('photo','video');
                })->find($id);

            
            

            

            $post->update(['content'=>$request->content]);

            //update Photo Code
    if ($request->hasFile('image')) {
        foreach($post->images as $image){
                
            $des = 'Images/posts/' . $image->photo;
    if (File::exists($des)) {

        File::delete($des);
}
    Image::where('photo', $image->photo)->delete();
    
    }
    

    foreach ($request->file('image') as $imagefile) {     
                
        $image= $this->UploadImage('posts', $imagefile);

        $image=Image::create(['photo'=>$image,'post_id'=>$post->id]);
            
        }

}



$post->save();

Db::commit();

return $this->sendResponse($post,'Post succefully Updated');


}catch(\Exception $ex){
    DB::rollBack();
    return $this->sendError('This Post Does Not Exists');


}

        }


        public function destroy($id){
            $post=Post::with('images')->whereHas('images',function($q){
                $q->select('photo','video');
            })->find($id);
            
            foreach($post->images as $image){
                
                $des = 'Images/posts/' . $image->photo;
    if (File::exists($des)) {

            File::delete($des);
    }
    
        }
            $post->delete();



            return $this->sendResponse($post,'Post deleted succefully');


        }





        
        public function showbookmarkedPosts(){
            $data=[];
            $user=Auth::user()->id;
            $data['showpost']=BookmarkPost::with(['post'=>function($q){
                $q->with('images','user')->withCount('comments')->withCount('like');
            }])->where('user_id',$user)->get();

            
            return $this->sendResponse($data,'Bookmarked Posts Page For User '.Auth::user()->name);

        }




        public function bookmark(Request $req){
            $bookmark_post=Post::find($req->id);

            if(!$bookmark_post)
            return $this->sendError('This Post Does Not Exists');

            if(! BookmarkPost::where('post_id',$bookmark_post->id)->where('user_id',Auth::user()->id)->first()){
            BookmarkPost::create([
            'user_id'=>Auth::user()->id,
            'post_id'=>$bookmark_post->id
            ]);
        }else
        {
            return $this->sendError('You Already Saved This Post');
        }
            return $this->sendResponse($bookmark_post,'Post Bookmarked Successfully');
            

        }
        
        public function DeletebookmarkedPosts(Request $req){
        $post=BookmarkPost::where('user_id',auth()->id())->where('post_id',$req->id)->first();
        if(!$post)
        return $this->sendError('This Post Does Not Exist In Your Bookmarked Posts');

        $post->delete();
        
        return $this->sendResponse($post,'Post Bookmarke Deleted Successfully');

        }


        public function like(Request $req){
            
            if(!Post::where('id',$req->id)->first())
            return $this->sendError('This Post Does Not Exists');
            if(!Like::where('post_id',$req->id)->where('user_id',auth()->user()->id)->first())
            {
                $like=auth()->user()->like()->attach($req->id);

            }else{
                auth()->user()->like()->detach($req->id);

                return $this->sendResponse('','User '. Auth::user()->name .' UnLiked Post Successfully');

            }


            return $this->sendResponse('','User '. Auth::user()->name .' Liked Post Successfully');


        }

        

        public function comment(Request $req,$id){
            
            
            if(Post::where('id',$id)->first()){
                
                $comment=Comment::create([
                    'comment'=>$req->comment,
                    'post_id'=>$id,
                    'user_id'=>auth()->id()
                ]);
            
            
            return $this->sendResponse($comment,'User '. Auth::user()->name .' Commented In ' . Post::find($id)->user->name. ' Post');
        }else{
            return $this->sendError('This Post Does Not Exists');
        }

            

            
        }

        public function destroycomment($id){
        $comment=Comment::where('id',$id)->first();
            
            

            if(!$comment)
            return $this->sendError('This Post Does Not Exists');

            $comment->delete();

            return $this->sendResponse($comment,'Comment In ' . Post::find($comment->post_id)->user->name. ' Post Deleted Successfully');
            
        }

        




}
