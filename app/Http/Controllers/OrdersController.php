<?php

namespace App\Http\Controllers;

use App\order;
use App\Services\Payment\Transaction;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    private $order;
    private $transaction;
    public function __construct(order $order,Transaction $transaction)
    {
     $this->middleware('auth');   
     $this->order=$order;
     $this->transaction=$transaction;
    }

    public function index()
    {

        if (auth('api')->user()->orders) {
    
            return response()->json(['message'=>'sucess','status'=>200,['orders'=>auth('api')->user()->orders,'status'=>$this->order->paid]]);
     
          }return response()->json(['message'=>'error','status'=>500]);
      
        
    }
    public function pay(order $order)
    {
        return $this->transaction->pay($order);
    }
}
