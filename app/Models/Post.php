<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable=['id','content','status','user_id'];


    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }


    public function images(){
        return $this->hasMany('App\Models\Image','post_id');
    }


    public function userbookmarked(){
        return $this->hasMany(BookmarkPost::class,  'post_id');
    }


    public function comments(){
        return $this->hasMany(Comment::class,'post_id');
    }


    public function like(){
        return $this->belongsToMany(User::class,'likes')->withTimestamps();
    }



    public function reports(){
        return $this->hasMany(Report::class,'post_id');
    }

}
