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
}
