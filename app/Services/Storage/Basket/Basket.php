<?php

namespace App\Services\Storage\Basket;

use App\Exceptions\QuantityExceededException;
use App\product;
use App\Services\Storage\Contracts\storageInterface;
use App\Session;


class Basket {

private $storage;
    public function __construct(storageInterface $storage)
    {
      $this->storage=$storage;
    }

    public function itemCount()
    {
      return  $this->storage->count();
    }

    public function clear()
    {
      session::where('user_id',auth('api')->user()->id)->delete();
    }

    public function has($product)
    {
   
        return $this->storage->exists($product->id);
    }
    public function add($product,$quantity)
    {
      
      if ($this->has($product))
      {
        $quantity=$this->get($product);
     
         
        return $this->update($product, $quantity);  
         
        }
     
        return $this->storage->set($product,$quantity);

      }
      
      public function update($product,$quantity)
      {
        if (!$product->hasProduct($quantity)){
          throw new QuantityExceededException();  
        }
        if (!$quantity){
          
          return $this->storage->unset($product->id);
        } 
        return $this->storage->increment($product,$quantity);
    }
  

    public function get($product)
    {
      
      
        return $this->storage->get($product->id);
    }

    public function all()
    {

      $session=resolve(Session::class);
     

      $products=[];
      foreach ($session->productId() as $key => $value) {
      
        $products[$key]=product::find($value);
      }
      
      foreach ($products as $product){
        
        $product->quantity=$this->get($product);
        
      }
     
        return $products;
    }

    public function subTotal()
    {

       $total=0;
       foreach ($this->all() as $item){
         
         $total+=$item->price * $item->quantity;
        }
        return $total;
    }

}
