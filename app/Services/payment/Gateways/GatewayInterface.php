<?php
namespace App\Services\Payment\Gateways;

use App\order;
use Illuminate\Http\Request;

interface GatewayInterface{
    const TRANSACTION_FAILED='transaction.failed';
    const TRANSACTION_SUCESS='transaction.sucess';

    public function pay(order $order);

    public function verify(Request $request);
    
    public function gatename():string;
}