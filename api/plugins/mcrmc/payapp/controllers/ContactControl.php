<?php

namespace Mcrmc\Payapp\Controllers;

use Backend\Classes\Controller;
use RainLab\User\Models\User;
use Illuminate\Http\Request;
use JWTAuth;
use Mail;
use Mcrmc\Payapp\Models\Contact;

class ContactControl extends Controller
{
    /**
     * newContact
     * 
     * Simple Contact form
     *
     * @param  mixed $req
     * @return void
     */
    public function newContact(Request $req)
    {
        $con = new Contact();
        $con->cename = e($req['cname']);
        $con->cemail = e($req['cemail']);
        $con->message = e($req['message']);
        $con->save();
        $vars = [
            'cname' => $con->cename,
            'cemail' => $con->cemail,
            'mess' => e($req['message']),
        ];
        Mail::send('mcrmc.payapp::mail.newContact', $vars, function ($message) {
            $message->to('mark@mcrmc.co.uk');
            $message->subject('PayApp Contact');
        });
        return response()->json(['success' => 'Message Sent!'], 200);
    }
}
