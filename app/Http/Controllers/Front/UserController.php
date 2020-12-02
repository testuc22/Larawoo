<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
class UserController extends Controller
{
    public function registerUser(Request $request)
    {
        $validator=Validator::make($request->all(), [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors()->toArray(),422);
        }
        else {
        	$user=User::create([
	            'firstName' => $request->firstname,
	            'lastName' => $request->lastname,
	            'email' => $request->email,
	            'role' => 'Customer',
	            'password' => Hash::make($request->password)
	        ]);
	        Auth::login($user);
        	return response()->json(['redirectTo'=>route('home')],200);
        }
    }

    public function userLogin(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'email'=>'required|string',
            'password'=>'required'
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors()->toArray(),422);
        }
        else {
        	$credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $page='home';
                return response()->json(['redirectTo'=>route($page)],200);
            }
            else {
                return response()->json(['invalid'=>['Invalid Credentials']],422);
            }
        }
    }

    public function userLogOut(Request $request)
    {
        Auth::guard()->logout();
        return redirect()->route('home');
    }
}
