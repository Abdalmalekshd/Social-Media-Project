<?php

namespace App\Http\Controllers\FrontControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignInRequest;
use App\Mail\ForgetPassword;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LoginController extends Controller
{
    public function getLoginPage(){
    return view('User.Login');
    }


public function Login(LoginRequest $req){
// $userinfo=[($req->all())];

if(auth()->guard('web')->attempt(['email'=>$req->email,'password'=>$req->password])){
    return redirect()->intended(route('user.home'));
}
return redirect()->back()->withInput($req->only('email'));


}

    

    public function getSigninPage(){
        $countries=Country::select(
            'id',
        'name_'. LaravelLocalization::getCurrentLocale() . ' as name'
        )->get();
        return view('User.Signup',compact('countries'));
            }    

            public function Signin(SignInRequest $req){
                try{

                    $user=User::create([
                        'name'=>$req->name,
                        'email'=>$req->email,
                        'gender'=>$req->gender,
                        'phone'=>$req->phone,
                        'password'=>bcrypt($req->password),
                        'lives_in'=>$req->lives_in,
                        'country_id'=>$req->country,

                    ]);

                    return redirect()->route('user.home')->with(['success'=>'You Are Regestired']);

                }catch(\Exception $ex){

                }
                    }    
        

                public function forgetpass(){
            return view('User.ForgetPassword');
                }

                public function forgetpassword(Request $req){
                    $data=[];
                    $data['user']=User::where('email',$req->email)->first();
                    if(!$data['user'])
                    return redirect()->route('forgetpass')->with(['error'=>'This Email Does/nt Exists']);

                    Mail::send('User.Mail.ForgetPass', $data, function($message) use($data){

                        $message->to($data['user']->email)->subject('Reset Password');
                    
                    });
                    
                    
                    return redirect()->route('forgetpass');
                        }
                

                public function Resetpass($email){
                    $user=User::where('email',$email)->first();
                    return view('User.Resetpassword',compact('user'));
                        }

                        public function setnewpass(Request $req){
                        $user=User::where('email',$req->email)->first();
                            $user->update([
                                'password'=>Hash::Make($req->password),
                            ]);

                    return redirect()->route('login')->with(['success'=>'password Has Been Reset']);

                        }

            public function userlogout(){
                auth('web')->logout();
                
                return redirect()->route('get.login');
                
                }
            



        }




    