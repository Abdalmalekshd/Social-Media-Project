<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;

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


    public function adminlogout(){
        auth('admin')->logout();
        
        return redirect()->route('admin.get.login');
        
        }
}
