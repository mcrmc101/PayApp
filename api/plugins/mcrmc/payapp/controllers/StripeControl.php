<?php

namespace Mcrmc\Payapp\Controllers;

use Backend\Classes\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Mcrmc\Payapp\Models\Account;

class StripeControl extends Controller
{
    /**
     * getStripeInfo
     * 
     * get stripe info for the user
     *
     * @return void
     */
    public function getStripeInfo()
    {
        $user = JWTAuth::parseToken()->authenticate();
        if (!$user) {
            return response()->json(['token_expired'], 401);
        }
        $acc = Account::where('userid', '=', $user->id)->first();
        $data = [
            'skey' => $acc->skey,
            'pkey' => $acc->pkey,
            'skey_test' => $acc->skey_test,
            'pkey_test' => $acc->pkey_test,
            'islive' => $acc->islive
        ];
        return response()->json(['success' => $data], 200);
    }

    /**
     * updateStripe
     * 
     * update users stripe info
     *
     * @param  mixed $req
     * @return void
     */
    public function updateStripe(Request $req)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if (!$user) {
            return response()->json(['token_expired'], 401);
        }
        $acc = Account::where('userid', '=', $user->id)->first();
        $acc->skey = e($req['skey']);
        $acc->pkey = e($req['pkey']);
        $acc->pkey_test = e($req['pkeytest']);
        $acc->skey_test = e($req['skeytest']);
        $acc->islive = e($req['islive']);
        $acc->save();
        return response()->json(['success' => 'Saved!'], 200);
    }
}
