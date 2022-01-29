<?php

namespace App\Services\Storage\Cost;

use App\Services\Storage\Contracts\costInterface;
use App\Services\Storage\Cost\shippingCost;
class  TotalCost implements costInterface{

    private $discountCost;
    private $total;
    public function __construct(DiscountCost $discountCost,shippingCost $total)
    {

        $this->discountCost=$discountCost;
        $this->total=$total;
    }
    public function getCost()
    {
      

       return $this->total->getTotalCosts();

    }
    public function getTotalCosts()
    {
    
             
         return  $this->getCost() -  $this->discountCost->getTotalCosts() ;
    }

    public function persianDescription()
    {
      return 'The amount payable';
    }



    public function getsummary()
    {
        return array_merge(  $this->discountCost->getsummary(),[$this->persianDescription()=>$this->getTotalCosts()]);
    }
}
