<?php

namespace App\Http\Controllers\payment_BSA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\product;
use App\Services\Storage\Basket\Basket;

class productController extends Controller
{
    private $product;
    public function __construct(product $product)
    {
        $this->product=$product;  
    }
    
        
    
    public function index()
    {
        
        $products=$this->product->index();
      if ($products) {
          return response()->json(['message'=>'sucess','state'=>200,['products'=>$products]]);
      }   return response()->json(['message'=>'erorr','state'=>500]);
    }
}
