<?php

namespace App\Http\Controllers\AdminControllers;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Admin;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function adminLogin(){
        return view('Admin.Login');
        }
    
    
    public function adminsignup(LoginRequest $req){
    
    if(auth()->guard('admin')->attempt(['email'=>$req->email,'password'=>$req->password])){
        return redirect()->intended(route('Dashboard'));
    }
    return redirect()->back()->withInput($req->only('email'));
    
    }


    public function forgetpass(){
        return view('admin.ForgetPassword');
            }

            public function forgetpassword(Request $req){
                $data=[];
                $data['admin']=Admin::where('email',$req->email)->first();
                if(!$data['admin'])
                return redirect()->route('Admin.forgetpass')->with(['error'=>'This Email Does/nt Exists']);

                Mail::send('Admin.Mail.forgetpassword', $data, function($message) use($data){

                    $message->to($data['admin']->email)->subject('Reset Password');
                
                });
                
                
                return redirect()->route('Admin.forgetpass');
                    }
            

            public function Resetpass($email){
                $admin=Admin::where('email',$email)->first();
                return view('Admin.Resetpassword',compact('admin'));
                    }

                    public function setnewpass(Request $req){
                    $admin=Admin::where('email',$req->email)->first();
                        $admin->update([
                            'password'=>Hash::Make($req->password),
                        ]);

                        return redirect()->route('admin.get.login')->with(['success'=>'password Has Been Reset']);

                        }



    public function adminlogout(){
        auth('admin')->logout();
        
        return redirect()->route('admin.get.login');
        
        }
}
