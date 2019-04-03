<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use MercadoPago;

class PaymentController extends Controller
{
    public function index(Request $request){
        return view('payment');
    }

    public function pay(Request $request){
        //dd($request->all());

        try{
            MercadoPago\SDK::setAccessToken("TEST-388296888267745-031616-36905f60e051f7b5266300fc1b65a353-190369495"); // On Sandbox
            $payment = new MercadoPago\Payment();

            MercadoPago\SDK::setAccessToken("TEST-388296888267745-031616-36905f60e051f7b5266300fc1b65a353-190369495");

            $payment = new MercadoPago\Payment();

            /*$payment->transaction_amount = 141;
            $payment->token = $request->token;
            $payment->description = "Ergonomic Silk Shirt";
            $payment->installments = 1;
            $payment->payment_method_id = "visa";
            $payment->payer = array(
                "email" => "larue.nienow@hotmail.com"
            );

            $payment->save();*/

            $payment->transaction_amount = 5;
            $payment->token = $request->token;
            $payment->description = "Mediocre Plastic Table";
            $payment->installments = 1;
            $payment->payment_method_id = $request->paymentMethodId;
            $payment->payer = array(
                "email" => $request->email,
            );

            //$m = $payment->getAttributes();

            // Save and posting the payment
            $payment->save();

            if(isset($payment->error) && !empty($payment->error)){
                dd($payment->error);
            }else{
                dd($payment->status);
            }

        }catch (\Exception $e){
            dd($e);
        }

    }
}
