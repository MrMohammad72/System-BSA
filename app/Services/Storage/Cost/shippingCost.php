<?php
namespace App\Services\Storage\Cost;

use App\Services\Storage\Contracts\costInterface;

class shippingCost implements costInterface
{
    const  SHIPPING_COST=10000;
    private $basketCost;
    public function __construct(BasketCost $basketCost)
    {
      $this->basketCost=$basketCost;
    }

    public function getCost()
    {
        return self::SHIPPING_COST;
    }

    public function persianDescription()
    {
        return 'Transportation costs';
    }

    public function getTotalCosts()
    {
       return $this->getCost()+$this->basketCost->getTotalCosts();
    }

    public function getsummary()
    {
        return array_merge($this->basketCost->getsummary(),[$this->persianDescription()=>$this->getCost()]);
     }
}
