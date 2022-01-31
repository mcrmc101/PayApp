<?php

namespace Mcrmc\Payapp\Controllers;

use Backend\Classes\Controller;
use RainLab\User\Models\User;
use Illuminate\Http\Request;
use JWTAuth;
use Mcrmc\Payapp\Models\Account;

class UserControl extends Controller
{
    /**
     * getAuthenticatedUser
     * 
     * get the user
     *
     * @return void
     */
    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }
}
