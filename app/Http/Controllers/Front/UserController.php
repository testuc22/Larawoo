<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Repositories\OrderRepository;
use Auth;
class UserController extends Controller
{

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository=$orderRepository;
    }

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

    public function getMyAccountPage()
    {
        return view('front/myaccount');
    }

    public function getMyAddressesPage()
    {
        $UserAddresses=UserAddress::where('user_id','=',Auth::id())->get();
        return view('front/myaddresses')->with(['userAddresses'=>$UserAddresses]);
    }

    public function saveUserAddress(Request $request)
    {
        $formArray=[];
        $form=parse_str($request->form,$formArray);
        // return $formArray;
        $validator=Validator::make($formArray,[
            'line1'=>'required|string',
            'line2'=>'required'
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors()->toArray(),422);
        }
        else {
            $user=UserAddress::create([
                'line1'=>$formArray['line1'],
                'line2'=>$formArray['line2'],
                'city'=>$formArray['city'],
                'state'=>$formArray['state'],
                'country'=>$formArray['country'],
                'pincode'=>$formArray['pincode'],
                'phone'=>$formArray['phone'],
                'active'=>0,
                'user_id'=>Auth::id()
            ]);
            return response()->json(['user'=>$user],200);
        }
    }

    public function createNewOrder(Request $request)
    {
        $order=$this->orderRepository->createNewOrder($request);
        return view('front/thanku')->with(['order'=>$order]);
    }
}
