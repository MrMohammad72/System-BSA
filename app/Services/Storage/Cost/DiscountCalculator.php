<?php
namespace App\Services\Storage\Cost;


class DiscountCalculator{

   public function discountAmount($coupon,$amount)
    {

            $discountAmount=(int)  (($coupon->percent/100)*$amount);
      
            return $this->isExceeded($discountAmount,$coupon->limit ) ? $coupon->limit:$discountAmount;
          
    }
    
    public function discountedPrice($coupons,$amount)
    {
    
    return  $this->discountAmount($coupons,$amount);
    }

    public function isExceeded($discountAmount, int $limit)
    {

        return $discountAmount > $limit;
    }
}
