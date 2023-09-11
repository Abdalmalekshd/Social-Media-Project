<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Follower extends Model
{
    use HasFactory,Notifiable;

    protected $fillable=['id','user_id','followed_id','status'];


    public function user(){
        return $this->belongsTo(User::class,'followed_id');
    }

    public function follower(){
        return $this->belongsTo(User::class,'user_id');
    }
    
}
