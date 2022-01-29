<?php

namespace App\Services\Storage\Discount;

use App\product;
use App\Services\Storage\Basket\Basket;
use App\Services\Storage\Cost\BasketCost;
use App\Services\Storage\Cost\DiscountCalculator;
use App\coupon;
use App\Session_coupon;

class DiscountManager {

    private $discountCalculator;
    private $basketCost;
    public function __construct(BasketCost $basketCost, DiscountCalculator $discountCalculator)
    {

        $this->discountCalculator=$discountCalculator;
        $this->basketCost=$basketCost;
    }
    public function calculateUserDiscount()
    {
     
      $code=session_coupon::where('user_id',auth('api')->user()->id)->value('code');

      if (!$code){return 0;}
      $coupon=coupon::firstwhere('code',$code);
    
      return $this->discountCalculator->discountAmount($coupon,$this->basketCost->getTotalCosts());
    }
}
