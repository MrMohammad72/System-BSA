<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session_coupon extends Model
{
    
    protected $fillable=['user_id','code','percent','limit','expire_time'];


    public function store($request)
    { 
       return $this->create([
                     'user_id'=>auth('api')->user()->id,
                     'code'=>$request->coupon
                
                     ]);
       
    }

    public function clear()
    {
      $this->where('user_id',auth('api')->user()->id)->delete();
        return true;
    }
}
