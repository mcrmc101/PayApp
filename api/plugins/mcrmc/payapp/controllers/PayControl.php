<?php

namespace Mcrmc\Payapp\Controllers;

use Backend\Classes\Controller;
use RainLab\User\Models\User;
use Illuminate\Http\Request;
use JWTAuth;
use Mail;
use Mcrmc\Payapp\Models\Account;
use Mcrmc\Payapp\Models\Payment;

class PayControl extends Controller
{
    /**
     * newPayment
     * 
     * New Payment form generator
     * Check Token, get account from token, fill model, create stripe token and email the customer a link 
     *
     * @param  mixed $req
     * @return void
     */
    public function newPayment(Request $req)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if (!$user) {
            return response()->json(['token_expired'], 401);
        }
        $acc = Account::where('userid', '=', $user->id)->first();
        if ($acc->islive == 0) {
            $pk = $acc->pkey_test;
            $sk = $acc->skey_test;
        } else {
            $pk = $acc->pkey;
            $sk = $acc->skey;
        }
        \Stripe\Stripe::setApiKey($sk);
        try {
            $pay = new Payment();
            $pay->cname = e($req['cname']);
            $pay->cemail = e($req['cemail']);
            $pay->amount = e($req['amount']);
            $uid = uniqid();
            $pay->paycode = md5($uid);
            $pay->userid = $user->id;
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $pay->amount * 100,
                'currency' => 'gbp',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);
            $pay->client_secret = strval($paymentIntent->client_secret);
            $pay->save();
            $user = User::find($pay->userid);
            $payurl = 'https://payapp.mcrmc.co.uk/payment?paycode=' . $pay->paycode . '&pk=' . $pk .  '&name=' . $user->name . '&amount=' . $pay->amount;
            $cemail = $pay->cemail;
            $vars = [
                'payurl' => $payurl,
                'name' => $user->name,
                'amount' => $pay->amount,
                'cname' => $pay->cname
            ];
            Mail::send('mcrmc.payapp::mail.newPayment', $vars, function ($message) use ($cemail) {
                $message->to($cemail);
                $message->subject('PayApp Request');
            });
            return response()->json(['success' => 'Email Sent'], 200);
        } catch (Error $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * getPaymentInfo
     * 
     * Get client_secret for payment
     *
     * @param  mixed $req
     * @return void
     */
    public function getPaymentInfo(Request $req)
    {
        $pay = Payment::where('paycode', '=', e($req['paycode']))->first();
        if ($pay->ispaid == 1) {
            return response()->json(['error' => 'Payment Completed'], 418);
        }
        return response()->json(['success' => $pay->client_secret], 200);
    }

    /**
     * paymentSuccess
     * 
     * mark payment as paid and send confirmation and reciept emails to user and customer
     * 
     *
     * @param  mixed $req
     * @return void
     */
    public function paymentSuccess(Request $req)
    {
        $pay = Payment::where('client_secret', '=', e($req['cs']))->first();
        if ($pay->ispaid == 0) {
            $pay->ispaid = 1;
            $pay->save();
            $user = User::find($pay->userid);
            $cemail = $pay->cemail;
            $uemail = $user->email;
            $vars = [
                'name' => $user->name,
                'amount' => $pay->amount,
                'cname' => $pay->cname
            ];
            Mail::send('mcrmc.payapp::mail.paymentSuccess', $vars, function ($message) use ($cemail) {
                $message->to($cemail);
                $message->subject('PayApp Payment Success');
            });
            Mail::send('mcrmc.payapp::mail.paymentReceived', $vars, function ($message) use ($uemail) {
                $message->to($uemail);
                $message->subject('PayApp Payment Received');
            });
            $data = [
                'name' => $user->name,
                'amount' => $pay->amount,
                'email' => $user->email
            ];
            return response()->json(['success' => $data], 200);
        } else {
            return response()->json(['error' => 'Payment Completed'], 418);
        }
    }
}
