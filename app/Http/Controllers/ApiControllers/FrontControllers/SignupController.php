<?php

namespace App\Http\Controllers\ApiControllers\FrontControllers;

use App\Http\Controllers\ApiControllers\ResponseController;
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

class SignUpController extends ResponseController
{

            public function Signup(Request $req){
                
                    $input=$req->all();
                    $input['password']=bcrypt($input['password']);
                    $user=User::create($input);
                    $success['token']=$user->createToken('')->accessToken;
                    $success['name']=$user->name;
                    $success['gender']=$user->gender;
                    $success['phone']=$user->phone;
                    $success['email']=$user->email;
                    $success['country_id']=$user->country;

                    return $this->sendResponse($success,'User Created Successfully');
                    

                    
                
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




    