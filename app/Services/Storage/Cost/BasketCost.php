<?php
namespace App\Services\Storage\Cost;

use App\Services\Storage\Basket\Basket;
use App\Services\Storage\Contracts\costInterface;

class BasketCost implements costInterface {
    private $basket;
    public function __construct(Basket $basket)
    {
        $this->basket=$basket;

     }
    public function getCost()
    {
    
      return  $this->basket->subTotal();
    }

    public function persianDescription()
    {
       return 'Total cost';
    }

    public function getTotalCosts()
    {
       return $this->getCost();
    }

    public function getsummary()
    {
        return [$this->persianDescription()=>$this->getTotalCosts()];
    }
}
