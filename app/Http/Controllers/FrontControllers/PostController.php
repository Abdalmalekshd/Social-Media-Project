<?php

namespace App\Http\Controllers\FrontControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\PostRequest;
use App\Models\BookmarkPost;
use App\Models\Comment;
use App\Models\Image;
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
class PostController extends Controller
{

    use UplaodImageTraits;

    public function showpost($id){
        $data=[];
        $data['post']=Post::with('user','images')->withCount('comments')->withCount('like')->find($id);
        
        if(!$data['post'])
        return redirect()->route('user.home')->with(['error'=>'This Post Does Not Exist']);
        $postId=$data['post']->id;
        $data['comments']=Comment::with('user')->Where('post_id',$data['post']->id)->get();
        return view('user.Posts.single',$data);

    }
        

    public function create(){
        
    return view('user.Posts.createpost');
    }


    public function store(PostRequest $req){
        
        try{
            DB::beginTransaction();
        $content=filter_var($req->content,FILTER_SANITIZE_STRING);
        
    
        $post=Post::create([
            'content'=>$req->content,'user_id'=>Auth::user()->id]);
            
            foreach ($req->file('image') as $imagefile) {     
                
            $image= $this->UploadImage('posts', $imagefile);

            $image=Image::create(['photo'=>$image,'post_id'=>$post->id]);

                
            }
            
            

            
            
            Alert::Success('Success', 'Post Added Successfully');
            DB::commit();

            
        return redirect()->route('user.home');
            
            
        }catch(\Exception $ex){
            DB::rollBack();
            Alert::error('Error Title', 'Error Message');
            return redirect()->route('user.home');

        }

        }

        public function edit($id){
            $post=Post::with('images')->whereHas('images',function($q){
                $q->select('photo','video');
            })->find($id);
        return view('User.Posts.edit',compact('post'));

        }


        public function update(Request $req){
            try{
                DB::beginTransaction();


                $post=Post::with('images')->whereHas('images',function($q){
                    $q->select('photo','video');
                })->find($req->postid);

            $content=filter_var($req->content,FILTER_SANITIZE_STRING);
            

            

            $post->update(['content'=>$req->content]);

            //update Photo Code
    if ($req->hasFile('image')) {
        foreach($post->images as $image){
                
            $des = 'Images/posts/' . $image->photo;
    if (File::exists($des)) {

        File::delete($des);
}

    }
    

foreach ($req->file('image') as $imagefile) {     
                
    $photo= $this->UploadImage('posts', $imagefile);

    $images=$image->update(['photo'=>$photo]);

        
    }
}


Alert::Success('Success', 'Post Updated Successfully');
DB::commit();


return redirect()->route('user.home');

}catch(\Exception $ex){
    DB::rollBack();
    Alert::error('Error Title', 'Error Message');
    return redirect()->route('user.home');

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



            Alert::Success('Success', 'Post Deleted Successfully');

            return redirect()->route('user.home');

        }





        
        public function showbookmarkedPosts(){
            $data=[];
            $user=Auth::user()->id;
            // $data['showpost']=DB::select("SELECT 
            // posts.id,posts.content,posts.created_at,bookmark_posts.id as bookmarkid,bookmark_posts.post_id,
            // bookmark_posts.user_id,users.id,users.avatar,users.name,images.photo ,images.post_id 
            // FROM posts,bookmark_posts,users,images WHERE 
            // posts.user_id=users.id AND bookmark_posts.post_id=posts.id 
            // AND images.post_id=posts.id AND bookmark_posts.user_id=?",[$user]);
            $data['showpost']=BookmarkPost::with(['post'=>function($q){
                $q->with('images','user')->withCount('comments')->withCount('like');
            }])->where('user_id',$user)->get();

            
        return view('User.Posts.Saved.index',$data);
        }




        public function bookmark($id){
            $bookmark_post=Post::find($id);

            if(!$bookmark_post)
            return redirect()->route('user.home')->with(['error'=>'This Post Does Not Exist']);

            BookmarkPost::create([
            'user_id'=>Auth::user()->id,
            'post_id'=>$bookmark_post->id
            ]);

        return redirect()->route('user.home');

        }
        
        public function DeletebookmarkedPosts($id){
        $post=BookmarkPost::where('user_id',auth()->id())->where('post_id',$id)->first();
        if(!$post)
        return redirect()->route('user.home')->with(['error'=>'This Post Does Not Exist']);

        $post->delete();
        Alert::Success('Success', 'Post Has Been Deleted From Saved Posts Successfully');
        return redirect()->route('user.home');

        }


        public function like($id){
            auth()->user()->like()->attach($id);

        return redirect()->route('user.home');

        }

        public function unlike($id){
            auth()->user()->like()->detach($id);

        return redirect()->route('user.home');

        }


        public function retweet($id){
            
            auth()->user()->retweet()->attach($id);

        return redirect()->route('user.home');

        }

        public function unretweet($id){
            auth()->user()->retweet()->detach($id);

        return redirect()->route('user.home');

        }

        public function comment(CommentRequest $req){
            
            try{
                if($req->comment1 == null){
                $comment=Comment::create([
                    'comment'=>$req->comment,
                    'post_id'=>$req->post_id,
                    'user_id'=>auth()->id()
                ]);
            }else{
                $comment=Comment::create([
                    'parent_id'=>$req->parent_id,
                    'comment'=>$req->comment1,
                    'post_id'=>$req->post_id,
                    'user_id'=>auth()->id()
                ]);
            }
                

            }catch(\Exception $ex){

            }
        }

        public function destroycomment($id){
            $comment=Comment::find($id);

            if(!$comment)
            return redirect()->route('user.home')->with(['error'=>'This Post Does Not Exist']);

            $comment->delete();

            return redirect()->back();
        }

        




}