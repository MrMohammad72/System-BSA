<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class coupon extends Model
{
  protected $fillable=['code','percent','limit','expire_time','couponable_id','couponable_type'];
    public function isExpired()
    {
      return carbon::now()->isAfter(carbon::parse($this->expire_time));
    }

    public function store($request)
    {
     
      return $this->create(['code'=>$request->code,
                     'percent'=>$request->percent,
                     'limit'=>$request->limit,
                     'expire_time'=>$request->expire_time,
      ]);
      
    }
    public function index()
    { 
      return $this->all();
    }

    public function search($request)
    {
      return $this::where('code',$request->coupon)->firstorfail();
    }
    public function couponable_id($id)
    {
      return $this::where('couponable_id',$id)->firstorfail();
    }
}
