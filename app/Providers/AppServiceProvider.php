<?php

namespace App\Providers;

use App\Observers\responseObserver;
use App\Observers\UserObserver;
use App\Observers\userStateObserver;
use App\Response;
use App\Services\Storage\Basket\Basket;
use App\Services\Storage\Contracts\costInterface;
use App\Services\Storage\Contracts\SessionStorage;
use App\Services\Storage\Contracts\storageInterface;
use App\Services\Storage\Cost\BasketCost;
use App\Services\Storage\Cost\DiscountCost;
use App\Services\Storage\Cost\shippingCost;
use App\Services\Storage\Cost\TotalCost;
use App\Services\Storage\Discount\DiscountManager;
use App\User;
use App\Userstate;
use Illuminate\Support\ServiceProvider;
use SoapServer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(storageInterface::class,function ($app){
            return new SessionStorage('cart');
        });
        $this->app->bind(costInterface::class,function ($app){
            $basketCost = new BasketCost($app->make(Basket::class));
             $shippingCost = new shippingCost($basketCost);
             $discountCost = new DiscountCost($shippingCost);
             $totalCost=new TotalCost($discountCost, $app->make(shippingCost::class));
            return $totalCost;
           
        });

    }
}
