<?php

namespace App;

use App\Services\Storage\Basket\Basket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class order extends Model
{
    protected $fillable=['user_id','code','amount'];

    
    public function products()
    {
        $basket=resolve(Basket::class);
        foreach ($basket->all() as $product) {
           
             $products[$product->id] = ['quantity' => $product->quantity];
        }

        return $products;    
    }
    public function payment()
    {
        return $this->hasOne(payment::class);
    }
    

    public function generateInvoice()
    {

      $pdf= Pdf::loadView('order.invoice',['order'=>$this]);
      return $pdf->save($this->invoicePath());
   }
    public function invoicePath()
    {
        return storage_path('app/public/invoices/') . $this->id . '.pdf';
    }

    public function paid()
    {
        return $this->payment->status;
    }
   
    public function downloadInvoice()
    {

        return Storage::disk('public')->download('invoices/' . $this->id . '.pdf');

    }
  


}
