<?php
namespace App\Repositories;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
use App\Models\{
	Product,
	ProductCategory,
	ProductBrand,
	ProductImage,
	ProductTag,
	Tag,
	Category,Attribute,
	ProductAttribute,
	ProductAttributeCombination,
	Cart,CartItem,
	Order,OrderItem
};
use Str,Session;
use Auth,File,DB;
class OrderRepository
{
	
	public function createNewOrder($request)
	{
	    $order=Order::create([
	    	'sessionId'=>Session::getId(),
	    	'status'=>0,
	    	'subTotal'=>$request->totalprice,
	    	'total'=>$request->totalprice,
	    	'firstName'=>Auth::user()->firstName,
	    	'lastName'=>Auth::user()->lastName,
	    	'email'=>Auth::user()->email,
	    	'line1'=>$request->line1,
	    	'line2'=>$request->line2,
	    	'city'=>$request->city,
	    	'state'=>$request->state,
	    	'country'=>$request->country,
	    	'content'=>$request->content,
	    	'user_id'=>Auth::id(),
	    ]);
	    $user=Auth::user();
	    $cartItems=$user->userCart->cartItems;
	    $data=[];
	    foreach ($cartItems as $cartItem) {
	        $data[]=[
	        	'sku'=>$cartItem->sku,
	        	'price'=>$cartItem->price,
	        	'quantity'=>$cartItem->quantity,
	        	'discount'=>$cartItem->discount,
	        	'content'=>$cartItem->content,
	        	'product_attribute_id'=>$cartItem->product_attribute_id,
	        	'product_id'=>$cartItem->product_id,
	        	'order_id'=>$order->id,
	        ];
	    }

	    $order->orderItems()->createMany($data);
	    $user->userCart->delete();
	    return $order;
	}

	public function getAllOrders()
	{
	    return Order::all();
	}
}