<?php


namespace App\Services\payment\Gateways;

use App\order;
use App\Services\Payment\Gateways\GatewayInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use SoapClient;

class Saman implements GatewayInterface {

    private $merchentId;
    private $callback;
    public function __construct()
    {
        $this->merchentId='425585658';
        $this->callback=route('payment.verify', $this->gatename());
    }
    public function gatename():string
    {
        return 'saman';
    }
    public function pay($order)
    {
        return $this->redirectToBank($order);
    }
    public function redirectToBank($order)
    {
      
        $amount=$order->amount +  1000;
        echo "<form id='samanpayment' method='post' action='http://sep.shaparak.ir/payment.aspx' >
        <input type='hidden' name='Amount' value='{$amount}'/>
        <input type='hidden' name='ResNum' value='{$order->code}'>
        <input type='hidden' name='RedirectURL' value='{$this->callback}' />
        <input type='hidden' name='MID' value='{$this->merchentId}' />
        </form><script>document.forms['samanpeyment'].submit()<script>";
    }
    public function verify(Request $request)
    {
     //dd($request->all());
        // if (!$request->has('state')|| $request->input('status') =='ok') {
        //     return $this->transactionFailed();
        // }
        
       
        $soapClient=new \SoapClient('https://acquirer.samanepay.com/payments/referencepayment.asmx?WSDL');
        $response=$soapClient->verifyTransaction($request->input('RefNum'),$this->merchentId);
        $order=$this->getOrder($request->input('ResNum'));
        
        

        //شبیه سازی زمانی که درخواست okاست چه اتفاق هایی می افتد 
        $response=$order->amount+1000;
        $request->merge(['RefNum'=>789456123]);
        
        return $response==($order->amount+1000)
        ?$this->transasctionSuccess($order,$request->input('RefNum'))
        :$this->transactionFailed();

    }
    public function transactionFailed()
    {
        return ['status'=>self::TRANSACTION_FAILED];
    }
    public function transasctionSuccess($order,$refNum)
    {
        return ['status'=>self::TRANSACTION_SUCESS,
                'order'=>$order,
                'refNum'=>$refNum,
                'gateway'=>$this->gatename()];
    }
    public function getOrder($resNum)
    {
        
        return order::where('code',$resNum)->firstOrFail();
    }

  
}