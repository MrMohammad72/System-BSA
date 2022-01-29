<?php

namespace App\Http\Controllers\payment_BSA;

use App\Http\Controllers\Controller;
use App\Services\Payment\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $transaction;
    public function __construct(Transaction $transaction)
    {
       $this->transaction=$transaction; 
    }
   
    
    public function verify(Request $request)
    {
        $result=$this->transaction->verify();
      
        
       return $result? $this->sendSecessRespone():$this->sendFailedResponse();
    }

    public function sendSecessRespone()
    {
        return response()->json(['message'=>'Your order has been successfully completed.','status'=>200]);
    }
    public function sendFailedResponse ()
    {
        return response()->json(['message'=>'There was a problem registering the order.','status'=>500]);
    }
}
