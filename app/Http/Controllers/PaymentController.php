<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;

class PaymentController extends Controller
{
    public function pay(Request $request){
        // Stripe::setApiKey(env('STRIPE_SECRET'));//シークレットキー
    
        //   $charge = Charge::create(array(
        //        'amount' => 100,
        //        'currency' => 'jpy',
        //        'source'=> request()->stripeToken,
        //    ));
        //  return back();

        // Stripe::setApiKey(env('STRIPE_SECRET'));

        // $customer = Customer::create(array(
        //     'email' => $request->stripeEmail,
        //     'source' => $request->stripeToken
        // ));

        // $charge = Charge::create(array(
        //     'customer' => $customer->id,
        //     'amount' => 1000,
        //     'currency' => 'jpy'
        // ));
        //  return back();
    }


   
}
