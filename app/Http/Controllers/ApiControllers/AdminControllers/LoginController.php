<?php

namespace App\Http\Controllers\ApiControllers\AdminControllers;

use App\Http\Controllers\ApiControllers\ResponseController;
use Illuminate\Support\Facades\Hash;


use App\Models\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LoginController extends ResponseController
{
    
    
    public function adminsignup(Request $req){
    
    if(auth()->guard('admin')->attempt(['email'=>$req->email,'password'=>$req->password])){
        $token = auth('admin')->user()->createToken('MyApp')->accessToken;

        return $this->sendResponse($token,'Logged In');
    }
    return $this->sendError('Please Check Your Data');

    
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
        
        return $this->sendResponse('','You Logged Out');
        
        
        }
}
