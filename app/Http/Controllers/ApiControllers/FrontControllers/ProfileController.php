<?php

namespace App\Http\Controllers\ApiControllers\FrontControllers;

use App\Http\Controllers\ApiControllers\ResponseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\OldPasswordRequest;
use App\Http\Requests\OldPasswordRequestApi;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\ProfileRequestApi;
use App\Models\Country;
use App\Models\Follower;
use App\Models\Image;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Traits\UplaodImageTraits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Symfony\Component\HttpKernel\Profiler\Profile;

class ProfileController extends ResponseController
{

    use UplaodImageTraits;

    public function Myprofile(){

        $data['post']=Post::with('images','user')->whereHas('images',function($img){
            $img->select('photo','video');
        })->withCount('comments')->withCount('like')->whereHas('user')->where('user_id',auth()->id())->get();
        
        $data['user']=User::where('id',auth()->id())->first();

        $id=$data['user']->id;
        
        $data['countFollowing']=Follower::where('user_id',$id)->where('status',0)->count();


        $data['countFollowers']=Follower::where('followed_id',$id)->where('status',0)->count();
    
        $data['countposts']=Post::where('user_id',$id)->count();


        return $this->sendResponse($data,'Logged User Profile');
    }



        public function updateProfile(ProfileRequestApi $req,$id)
        {
            
            
            try{
                DB::beginTransaction();


                $user=User::find($id);

                
                $user->update(
                    [
                    
                    'name'=>$req->name,
                    'phone'=>$req->phone,
                    'email'=>$req->email,
                    'description'=>$req->description,
                    'country_id'  =>$req->country_id,

                ]
            );


            if ($req->hasFile('avatar')) {
                $des = 'Images/avatar/' . $user->avatar;
                if (File::exists($des)) {
                    File::delete($des);
                }

    $image= $this->UploadImage('avatar', $req->avatar);
    $user->avatar=$image;

    }


            $user->save();

                DB::commit();
                return $this->sendResponse($user,'Profile succefully Updated');

            }catch(\Exception $ex){
                DB::rollBack();
                return $this->sendError('This Id Does Not Exists');
                
                
            }
            
}



public function changeoldpassword(OldPasswordRequestApi $req){
    $user=User::where('id',auth()->id())->first();
    
    if(Hash::check($req->old_password, $user->password)){
        $user->update(['password'=>Hash::Make($req->new_password)]); 
    }else{
        return $this->sendError('Please Enter Your Old Password Correctly');
    }
    
    return $this->sendResponse($user,'Password succefully Updated');

}

public function deleteProfile($id){

    $user=User::where('id',$id)->first();

    $des = 'Images/Avatar/' . $user->avatar;

    if (File::exists($des)) {
        File::delete($des);
    }

    $user->delete();


    return $this->sendResponse($user->name,'User Profile Deleted');

    }



    public function deleteProfileAvatar($id){

        $user=User::where('id',$id)->first();
    
    $des = 'Images/Avatar/' . $user->avatar;
    if (File::exists($des)) {
        File::delete($des);
    }
        
    $user->update(['avatar'=>null]);

    return $this->sendResponse($user,'User Avatar Deleted');

        }

    
}
