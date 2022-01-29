<?php
namespace App\Services\Storage\coupon;

use App\coupon;
use App\Services\Storage\Contracts\canUseIt;
use App\Services\Storage\Contracts\IsExpired;

class couponValidator {

    public function isValid(coupon $coupon)
    {
      $isExpired= resolve(IsExpired::class);
      $canUseIt=resolve(canUseIt::class);
       $isExpired->setNextValidator($canUseIt);
      return $isExpired->validate($coupon);
    }
}
