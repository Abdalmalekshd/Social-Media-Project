<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

protected $fillable=['reason','user_id','comment_id','post_id','user'];

public function post(){
    return $this->belongsTo('App\Models\Post','post_id');
    }

    public function userwhoreported(){
        return $this->belongsTo('App\Models\User','user_id');
        }// Users Who Reported An Post Or Comment Or other User


        public function comment(){
            return $this->belongsTo('App\Models\Comment','comment_id');
            }


            
        public function user_reported(){
            return $this->belongsTo('App\Models\User','user');
            } // Users Who Is Reported By Others

}
