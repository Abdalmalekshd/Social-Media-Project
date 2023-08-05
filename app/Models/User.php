<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'avatar',
        'email',
        'gender',
        'phone',
        'description',
        'password',
        'country_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        
    ];


    public function post(){
        return $this->hasMany('App\Models\Post','user_id');
    }


    public function bookmarkposts()
    {
        return $this->hasMany(BookmarkPost::class, 'user_id');
    }


    public function followers(){
        return $this->hasMany(Follower::class,'followed_id');
    }


    
    public function follow(){
        return $this->hasMany(Follower::class,'user_id');
    }
    

    public function comments(){
        return $this->hasMany(Comment::class,'user_id');
    }

    public function like(){
        return $this->belongsToMany(Post::class,'likes')->withTimestamps();
    }


    

    public function reportpost(){
        return $this->belongsToMany(Post::class,'reports')->withTimestamps();
    }


    public function reportcomment(){
        return $this->belongsToMany(Comment::class,'reports')->withTimestamps();
    }

    public function reportuser(){
        return $this->hasMany(Report::class,'user_id');
    }

    public function report(){
        return $this->hasMany(Report::class,'user');
    }
}
