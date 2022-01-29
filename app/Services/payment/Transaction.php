<?php

namespace App\Services\Payment;

use App\Events\OrderRegistered;
use App\Invoice;
use App\Order;
use App\Payment;
use App\product;
use App\Services\Storage\Basket\Basket;
use App\Services\Storage\Contracts\costInterface;
use Illuminate\Http\Request;
use App\Services\payment\Gateways\GatewayInterface;
use App\Services\payment\Gateways\Pasargad;
use App\Services\payment\Gateways\Saman;
use Dotenv\Result\Result;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Transaction
{
    private $request;

    private $basket;

    /**
     * @var CostInterface
     */
    private $cost;


    public function __construct(Request $request, Basket $basket , CostInterface $cost)
    {
        $this->request = $request;
        $this->basket = $basket;
        $this->cost = $cost;
    }


    public function checkout($request)
    {
        
            $order = $this->makeOrder($request);
            $order->generateInvoice();
            dd('hi');

            $payment = $this->makePayment($order);
            
            if ($payment->isOnline()) {

                return $this->gatewayFactory()->pay($order);
            //pay($order, $this->cost->getTotalCosts())
        }

        $this->completeOrder($order);

        return $order;
    }

    public function pay(Order $order)
    {

        return $this->gatewayFactory()->pay($order, $order->payment->amount);

    }



    public function verify()
    {
        
        $result = $this->gatewayFactory()->verify($this->request);
       

        if ($result['status'] === GatewayInterface::TRANSACTION_FAILED) return false;
        
        
        
        $this->confirmPayment($result);
        
        
        $this->completeOrder($result['order']);
       

        return true;
    }



    private function completeOrder($order)
    {
        
       $this->normalizeQuantity($order);
       
      // event(new OrderRegistered($order));
       
     
       $this->basket->clear();

     
    }
    private function normalizeQuantity($order)
    {
        $product=resolve(product::class);
        foreach ($order->products() as $key=>$value) {
        
            $product->decrementProduct($key,$value);
        }
    }



    private function confirmPayment($result)
    {
       
        return $result['order']->payment->confirm($result['refNum'], $result['gateway']);
    }




    private function gatewayFactory()
    {

        if (!$this->request->has('gateway')) return resolve(Saman::class);
       

        $gateway = [
            'saman' => Saman::class,
            'pasargad' => Pasargad::class
        ][$this->request->gateway];
        return resolve($gateway);


    }

    private function makeOrder()
    {
        $order = Order::create([
            'user_id' => auth('api')->user()->id,
            'code' => bin2hex(Str::random(16)),
            'amount' => $this->basket->subTotal()
        ]);


        $products=$order->products();
        $this->insertToTableOrderProduct($products, $order);
      
        return $order;
    }

    public function insertToTableOrderProduct($products, $order)
    {
        foreach (array_keys($products) as $key => $value) {
            DB::table('order_product')->insert([
                'order_id'=>$order->id,
                'product_id'=>$value
            ]);
        }
    }


    private function makePayment($order)
    {
       
        
        return Payment::create([
            'order_id' => $order->id,
            'method' => $this->request->method,
            'gateway'=>$this->request->gateway,
            'amount' => $this->cost->getTotalCosts(),
            'status'=>0
        ]);
    }
}
