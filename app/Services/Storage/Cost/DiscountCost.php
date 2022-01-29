<?php

namespace App\Services\Storage\Cost;

use App\Services\Storage\Contracts\costInterface;
use App\Services\Storage\Discount\DiscountManager;

class  DiscountCost implements costInterface{

    private $cost;
   
    public function __construct(costInterface $cost)
    {
        $this->cost=$cost;
    }
    public function getCost()
    {
        $discountManager=resolve(DiscountManager::class);
       return $discountManager->calculateUserDiscount();

    }
    public function getTotalCosts()
    {
        return $this->getCost();
             
    }

    public function persianDescription()
    {
      return 'Discount rate';
    }



    public function getsummary()
    {
        return array_merge( $this->cost->getsummary(),[$this->persianDescription()=>$this->getCost()]);
    }
}
