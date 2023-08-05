<?php

namespace App\Http\Controllers\FrontControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\OldPasswordRequest;
use App\Http\Requests\ProfileRequest;
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

class ProfileController extends Controller
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

        return view('User.Profile.index',$data);
    }


    public function editProfile(){

        $user=User::where('id',Auth::user()->id)->first();
        $countries=Country::select(
            'id',
        'name_'. LaravelLocalization::getCurrentLocale() . ' as Name'
        )->get();
            return view('User.Profile.edit',compact('user','countries'));
        }

        public function updateProfile(ProfileRequest $req)
        {
            
            
            try{
                DB::beginTransaction();


                $user=User::find($req->user_id);

                
                $user->update([
                    
                    'name'=>$req->name,
                    'phone'=>$req->phone,
                    'email'=>$req->email,
                    'description'=>$req->description,
                    'country_id'  =>$req->country_id,

                ]);


              //update Photo Code
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
                return redirect()->route('user.home')->with('success','Profile Updated Successfully');
                
            }catch(\Exception $ex){
                DB::rollBack();
                return redirect()->route('user.home')->with('Error','This profile Does Not Exist');

            }
            
}

public function changePassword(){
    $user=User::where('id',Auth::user()->id)->first();
    return view('User.Profile.editpassword',compact('user'));

}

public function changeoldpassword(OldPasswordRequest $req){
    $user=User::where('id',Auth::user()->id)->first();
    
    if(Hash::check($req->old_password, $user->password)){
        $user->update(['password'=>Hash::Make($req->new_password)]); 
    }
    
    return redirect()->route('user.profile.edit')->with('success','Password Updated Successfully');

}

public function deleteProfile($id){

    $user=User::where('id',$id)->first();

    $des = 'Images/Avatar/' . $user->avatar;

    if (File::exists($des)) {
        File::delete($des);
    }

    $user->delete();

    // confirmDelete('Delete Account','Are You Sure You Want to Delete Your Account');
        
    return redirect()->route('user.home');
    }



    public function deleteProfileAvatar($id){

        $user=User::where('id',$id)->first();
    
    $des = 'Images/Avatar/' . $user->avatar;
    if (File::exists($des)) {
        File::delete($des);
    }
        
    $user->update(['avatar'=>null]);
        // confirmDelete('Delete Account','Are You Sure You Want to Delete Your Account');
            
        return redirect()->route('user.home');
        }

    
}
