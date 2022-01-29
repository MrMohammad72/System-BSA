<?php
namespace App\Services\Storage\Contracts;


use App\Services\Storage\Contracts\storageInterface;
use App\Session;
use Countable;


class SessionStorage implements storageInterface,Countable {

    private $bucket;
    
    public function __construct($bucket='default')
    {
           $this->bucket=$bucket;
    }

    public function count()
    {
      //  
    }

    public function set($index, $value)
    {
       
   
         Session::create([
            'user_id'=>auth('api')->user()->id
            ,'product_id'=>$index->id
            ,'quantity'=>1
        ]);
        return true;
    }

    public function increment($product, $value)
    {
        $session=Session::where('product_id',$product->id)->first(); 
        $session->quantity++;
        $session->save(); 
        return true;
      
        
    }
  
    public function get($index)
    {

        return Session::where('product_id',$index)->value('quantity');
    
    }

    public function all()
    {
        return ['Number of shopping cart products'=>$this->countBasketSession(), $this->basketSession()];
    }
    public function basketSession()
    {   
        
        return Session::select('user_id','product_id','quantity')->get();

    }
    public function countBasketSession()
    {
        return Session::count('product_id'); 
    }

    public function exists($index)
    {
        if ( Session::where('product_id',$index)->first()) {
            return true;
        }return false;
       
    }

    public function unset($index)
    {
       return Session::where('product_id',$index)->delete();
 
    }

    public function clear()
    {
        Session::where('user_id','==',auth('api')->id)->delete();
        return true;
    }

  
    
}
