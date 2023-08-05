<?php

namespace App\Http\Controllers\AdminControllers;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function Dashboard(){
        $data=[];
        $data['users']=User::count();
        $data['posts']=Post::count();
        $data['comments']=Comment::count();
        $data['reports']=Report::count();

        $data['all_users']=User::withCount('post')->withCount('comments')->withCount('followers')->withCount('follow')->ORDERBY('created_at','Desc')->Limit(5)->get();

        $data['all_posts']=Post::with('images','user')->withCount('user')->withCount('images')->withCount('comments')->withCount('like')->withCount('reports')->ORDERBY('created_at','Desc')->limit(5)->get();


        $data['all_comments']=Comment::with('post','user')->ORDERBY('created_at','Desc')->limit(5)->get();


        $data['all_reports']=Report::with('post','comment','user_reported','userwhoreported')->ORDERBY('created_at','Desc')->limit(5)->get();

        $data['users_per_day']=User::where('created_at','LIKE',['%'.\Carbon\Carbon::now()->format('Y-m-d').'%'])->count();

        $data['posts_per_day']=Post::where('created_at','LIKE',['%'.\Carbon\Carbon::now()->format('Y-m-d').'%'])->count();

        $data['reports_per_day']=Report::where('created_at','LIKE',['%'.\Carbon\Carbon::now()->format('Y-m-d').'%'])->count();

        $data['comments_per_day']=Comment::where('created_at','LIKE',['%'.\Carbon\Carbon::now()->format('Y-m-d').'%'])->count();
        
        return view('Admin.Dashboard',$data);
    }


}
