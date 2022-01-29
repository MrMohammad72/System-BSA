<?php
namespace App\Services\Traits;

use App\coupon;
use Carbon\Carbon;

trait couponable{

    public function coupons()
    {
        return $this->morphMany(coupon::class,'couponable');
    }

    public function validCoupons()
    {
      return  $this->coupons()->where('expire_time','>',carbon::now());
    }

}
