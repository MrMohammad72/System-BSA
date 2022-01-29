<?php

namespace App;

use App\Services\Storage\Cost\DiscountCalculator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class product extends Model
{
    protected $fillable=['title','description','image','price','stock'];

    public function index()
    {
      return product::all();
    }

    public function hasProduct(int $quantity)
    {
        return $this->stock >= $quantity;
    }

    public function decrementProduct($product,$value)
    {
      $stock=$this::where('id',$product)->value('stock');
      $this->stock=$stock-$value['quantity'];
      $this->where('id',$product)->update(['stock'=>$this->stock]);
     
    }
    
    public function category()
    {
    
        return $this->belongsTo(category::class);
    }
}
