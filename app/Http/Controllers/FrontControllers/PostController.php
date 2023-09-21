<?php

namespace App\Http\Controllers\FrontControllers;

use App\Events\NewPost as EventsNewPost;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\PostRequest;
use App\Models\BookmarkPost;
use App\Models\Comment;
use App\Models\Follower;
use App\Models\Image;
use App\Models\Post;
use App\Models\Report;
use App\Models\User;
use App\Notifications\NewCommentNotify;
use App\Notifications\NewCommentReplayNotify;
use App\Traits\UplaodImageTraits;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Notifications\NewPostNotify;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
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
         $data['comments']=Comment::parent()->with(['childrens'=>function($q){
            $q->with('user');
            $q->with(['user'],['childrens'=>function($qq){ ;
                $qq->select('id','parent_id','comment');
            }]);
    }])->with('user')->Where('post_id',$data['post']->id)->get();

    $data['replaycomments']=Comment::with('user')->Where('post_id',$data['post']->id)->where('parent_id','!=',null)->get();
        $data['comme']=null;

        $data['comm']=null;
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

            $users=User::whereHas('follow',function($q){
                $q->where('followed_id',auth()->id());
            })->get();


            Notification::send($users,new NewPostNotify($post));


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
    Image::where('photo', $image->photo)->delete();

    }


foreach ($req->file('image') as $imagefile) {

    $photo= $this->UploadImage('posts', $imagefile);

    $images=$image->create(['photo'=>$photo,'post_id'=>$post->id]);


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




        public function bookmark(Request $req){
            $bookmark_post=Post::find($req->id);

            if(!$bookmark_post)
            return redirect()->route('user.home')->with(['error'=>'This Post Does Not Exist']);

            if(! BookmarkPost::where('post_id',$bookmark_post->id)->where('user_id',Auth::user()->id)->first()){
                BookmarkPost::create([
                'user_id'=>Auth::user()->id,
                'post_id'=>$bookmark_post->id
                ]);
            }else
            {
                return response()->json([
                    "status" => false,
                    'msg' => 'You Already Saved This Post'
                ]);
            }

            return response()->json([
                "status" => true,
                'msg' => 'Post Bookmarked Success'
            ]);

        }

        public function DeletebookmarkedPosts(Request $req){
        $post=BookmarkPost::where('user_id',auth()->id())->where('post_id',$req->id)->first();
        if(!$post)
        return redirect()->route('user.home')->with(['error'=>'This Post Does Not Exist']);

        $post->delete();

        return response()->json([
            "status" => true,
            'msg' => 'Delete Bookmarked Post Success'
        ]);
        }


        public function like(Request $req){
            auth()->user()->like()->attach($req->id);

            return response()->json([
                "status" => true,
                'msg' => 'Like Success'
            ]);

        }

        public function unlike(Request $req){
            auth()->user()->like()->detach($req->id);

            return response()->json([
                "status" => true,
                'msg' => 'Remove Like '
            ]);

        }





        public function comment(CommentRequest $req){

            try{
                DB::beginTransaction();

                $comment=Comment::create([
                    'comment'=>$req->comment,
                    'post_id'=>$req->post_id,
                    'user_id'=>auth()->id()
                ]);


                // $users=User::with('post')->whereHas('follow',function($q){
                //     $q->where('followed_id',auth()->id());
                // })->whereHas('post')->get();
                $postid=$req->post_id;

                  $users=User::with('post')->whereHas('follow',function($q){
                    $q->where('followed_id',auth()->id());
                })->whereHas('post',function($qq) use($postid){
                    $qq->where('id',$postid);
                })->get();

                Notification::send($users,new NewCommentNotify($comment));

                DB::commit();

            return redirect()->back()->with(['success' => 'Comment Added successfully']);


                }catch(\Exception $ex){
            DB::rollBack();
            Alert::error('Error Title', 'Error Message');
            return redirect()->route('user.home');

            }

        }


        public function editcomment(Request $req){

            $data=[];
         $data['comm']=Comment::with('post')->find($req->comment_id);

        $data['post']=Post::with('user','images')->withCount('comments')->withCount('like')->find($data['comm']->post->id);

        $data['comme']=null;

        $data['comments']=Comment::with('user')->Where('post_id',$data['post']->id)->get();
        $data['replaycomments']=Comment::with('user')->Where('post_id',$data['post']->id)->where('parent_id','!=',null)->get();


            return view('user.Posts.single',$data);

        }



        public function updatecomment(CommentRequest $req){

            $data['comment']=Comment::with('post')->find($req->comment_id);


            if(!$data['comment'])
            return redirect()->route('show.single.post')->with(['error'=>'This Comment Does Not Exist']);



            $data['comment']->update(['comment'=>$req->comment]);



    return redirect()->route('show.single.post',$data['comment']->post->id);

        }


        public function replaycommentform(Request $req){

            $data=[];
            $data['comme']=Comment::with('post')->find($req->id);



        $data['post']=Post::with('user','images')->withCount('comments')->withCount('like')->find($data['comme']->post->id);

        $data['comments']=Comment::with('user')->Where('post_id',$data['post']->id)->get();

        $data['comm']=Comment::with('post')->find($req->id);

        $data['replaycomments']=Comment::with('user')->Where('post_id',$data['post']->id)->where('parent_id','!=',null)->get();


            return view('user.Posts.single',$data);

        }


        public function replaycomment(Request $req){

            try{

                DB::beginTransaction();

                $comment=Comment::create([
                    'parent_id'=>$req->parent_id,
                    'comment'=>$req->replay,
                    'post_id'=>$req->post_id,
                    'user_id'=>auth()->id()
                ]);

                $parentid=$req->parent_id;

                $users=User::with('comments')->whereHas('comments',function($q) use($parentid){
                    $q->where('id',$parentid);
                })->get();

                Notification::send($users,new NewCommentReplayNotify($comment));

        DB::commit();

            return redirect()->route('show.single.post',$req->post_id);


                }catch(\Exception $ex){
            DB::rollBack();
            Alert::error('Error Title', 'Error Message');
            return redirect()->route('user.home');

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
