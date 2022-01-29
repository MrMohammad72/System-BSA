<?php

namespace App\Http\Controllers;

use App\order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    private $order;
    public function __construct(order $order)
    {
     $this->middleware('auth');   
     $this->order=$order;
    }

    public function index()
    {

        if (auth('api')->user()->orders) {
    
            return response()->json(['message'=>'sucess','status'=>200,['orders'=>auth('api')->user()->orders,'status'=>$this->order->paid]]);
     
          }return response()->json(['message'=>'error','status'=>500]);
      
        
    }
}
