<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
class AdminController extends Controller
{
    public function getAdminLoginPage()
    {
    	return view('back/login');
    }

    public function doAdminLogin(Request $request)
    {
    	$request->validate([
    		'email'=>'required|email',
    		'password'=>'required'
    	]);
    	$credentials = $request->only('email', 'password');
        if (Auth::guard('admins')->attempt($credentials)) {
        	return redirect()->route('dashboard');
        }
        else {
        	return redirect()->back()->with('message','Credentials Do not match');
        }
    }

    public function getAdminHomePage()
    {
        return view('back/home');
    }

    public function doAdminLogout()
    {
        Auth::guard('admins')->logout();
        return redirect()->route('alogin');
    }
}
