<?php

namespace Mcrmc\Payapp\Controllers;

use Backend\Classes\Controller;
use RainLab\User\Models\User;
use Illuminate\Http\Request;
use JWTAuth;
use Mcrmc\Payapp\Models\Account;
use Mcrmc\Payapp\Models\Payment;

class ArchiveControl extends Controller
{
    /**
     * getNotPaid
     * 
     * Get incomplete payments
     *
     * @return void
     */
    public function getNotPaid()
    {
        $user = JWTAuth::parseToken()->authenticate();
        if (!$user) {
            return response()->json(['token_expired'], 401);
        }
        return Payment::where('userid', '=', $user->id)->where('ispaid', '=', 0)->get();
    }

    /**
     * getPaid
     * 
     * get completed payments
     *
     * @return void
     */
    public function getPaid()
    {
        $user = JWTAuth::parseToken()->authenticate();
        if (!$user) {
            return response()->json(['token_expired'], 401);
        }
        return Payment::where('userid', '=', $user->id)->where('ispaid', '=', 1)->get();
    }
}
