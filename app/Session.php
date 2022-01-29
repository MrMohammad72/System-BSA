<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable=['user_id','product_id','quantity'];

   public function ProductId()
   {
   
       return $this->where('user_id',auth('api')->user()->id)->pluck('product_id');
   }
   public function replace($product, $quantity)
   {
       $this->where('product_id',$product->id)->update([
           'quantity'=>$quantity
       ]);
       return true;
   }
   public function remove($product)
   {
    $this->where('product_id',$product)->delete(); 
    return true;
   }
   public function clear()
   {
     $this->where('user_id',auth('api')->user()->id)->delete();
       return true;
   }
}
