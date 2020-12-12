<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\OrderRepository;
class OrderController extends Controller
{
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository=$orderRepository;
    }

    public function getAllOrders()
    {
        $orders=$this->orderRepository->getAllOrders();
        return view('back/orders/listorders')->with(['orders'=>$orders]);
    }

    public function getOrderDetails($id)
    {
        $order=$this->orderRepository->getOrderDetails($id);
        $orderStatus=[0=>['text'=>'Pending','color'=>'badge-info'],
        	1=>['text'=>'Processing','color'=>'badge-secondary'],
        	2=>['text'=>'Cancelled','color'=>'badge-danger'],
        	3=>['text'=>'Completed','color'=>'badge-success']
        ];
        return view('back/orders/order-details')
        ->with([
        	'order'=>$order,
        	'orderStatus'=>$orderStatus
        ]);
    }

    public function changeOrderStatus(Request $request,$id)
    {
        $result=$this->orderRepository->changeOrderStatus($request,$id);
        return $result;
    }
}
