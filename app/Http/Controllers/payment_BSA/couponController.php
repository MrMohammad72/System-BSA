<?php

namespace App\Http\Controllers\payment_BSA;

use App\coupon;
use App\Http\Controllers\Controller;
use App\Services\Storage\Contracts\SessionStorage;
use App\Services\Storage\Cost\TotalCost;
use App\Services\Storage\coupon\couponValidator;
use App\Session_coupon;
use Illuminate\Http\Request;

class couponController extends Controller 
{
    private $validator;
    private $basketCost;
    private $coupon;
    public function __construct(couponValidator $validator,TotalCost $basketCost,coupon $coupon)
    {
        //$this->middleware('auth');
       $this->validator=$validator;
       $this->basketCost=$basketCost;
       $this->coupon=$coupon;
    }
   

    public function index()
    {
     
      
      if (  $this->basketCost-> getsummary()) {
    
          return response()->json(['message'=>'sucess','status'=>200, $this->basketCost->getsummary(),resolve(SessionStorage::class)->all()]);
   
        }return response()->json(['message'=>'error','status'=>500]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'=>['required'],
            'percent'=>['required'],
            'limit'=>['required']  
        ]);
        if ( $this->coupon->store($request)) {
            return response()->json(['message'=>'sucess','status'=>200,'result'=> $this->coupon->store]);
        }return response()->json(['message'=>'error','status'=>500]);


    }
    public function show()
    {
      if ( $this->coupon->index) {
        return response()->json(['message'=>'sucess','status'=>200,'result'=>$this->coupon->index]);
    }return response()->json(['message'=>'error','status'=>500]); 
    }

    public function add(Request $request)
    {

       $session=resolve( Session_coupon::class);
            $request->validate([
               'coupon'=>['required','exists:coupons,code']
            ]);
            $coupon= $this->coupon->search($request);
            if ( $this->validator->isValid($coupon)) {
                $session->store($request);
                return response()->json(['message'=>'sucess','status'=>200,'result'=>'coupon applied successfully.']);
            }return response()->json(['message'=>'error','status'=>500 ,'result'=>'coupon Code is invalid.']);  
    }

    public function clear()
    {
        $session=resolve(session_coupon::class);

      if ( $session->clear()) {
        return response()->json(['message'=>'sucess','status'=>200]);
      }return response()->json(['message'=>'error','status'=>500]);
    }
}
