<?php

namespace App\Http\Controllers\payment_BSA;

use App\Http\Controllers\Controller;
use App\product;
use App\Services\Storage\Basket\Basket;
use App\Session;
use App\Services\Payment\Transaction;
use App\Services\Storage\Contracts\SessionStorage;
use Illuminate\Http\Request;


class BasketController extends Controller
{
  private $basket;
  private $session;
  private $transaction;
  public function __construct(Basket $basket,Session $session,Transaction $transaction)
  {
   $this->basket=$basket;
   $this->session=$session;
   $this->transaction=$transaction;
  $this->middleware('auth')->only(['checkoutForm']);
 }
    public function add(product $product)
    {
  
          if ($this->basket->add($product,1)) {
             
          return response()->json(['message'=>'sucess','status'=>200,'result'=> resolve(SessionStorage::class)->all()]);
          }return response()->json(['message'=>'error','status'=>500]);
    
    }



     public function update(product $product,$quantity)
    {
     
     $result= $this->session->replace($product, $quantity);
     if ($result) {
      return response()->json(['message'=>'sucess','status'=>200]);
    }return response()->json(['message'=>'error','status'=>500]);
       
    }
    public function remove(product $product)
    {
     if ($product) {
      if ($this->session->remove($product->id)) {
        return response()->json(['message'=>'sucess','status'=>200]);
      }return response()->json(['message'=>'error','status'=>500]);
     }return response()->json(['message'=>'error','status'=>400]);
     
    }
    public function checkout(Request $request)
    {
      
        if ($this->validateCheckout($request)) {
          $order=$this->transaction->checkout($request);
         if ($order) {
            return response()->json(['status'=>['message'=>'sucess','status'=>200], 'message'=>'payment your order has been Registered','orderNum'=>$order->id]);
         }
        
         
        }
       
    }

    public function validateCheckout($request)
    {
        $request->validate([
            'method'=>['required'],
            'gateway'=>['required_if:method,online']
        ]);
        return true;
    }
    public function clear()
    {
      if ($this->session->clear()) {
        return response()->json(['message'=>'sucess','status'=>200]);
      }return response()->json(['message'=>'error','status'=>500]);
    }
    
}
