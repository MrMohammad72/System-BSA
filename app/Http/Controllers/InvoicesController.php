<?php

namespace App\Http\Controllers;

use App\order;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    

    public function __construct()
    {
     $this->middleware('auth');   
    }

    public function show(order $order)
    {
        $order->downloadInvoices();
    }
}
