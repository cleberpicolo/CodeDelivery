<?php
/**
 * Created by PhpStorm.
 * User: clebe
 * Date: 26/07/2016
 * Time: 11:46
 */

namespace CodeDelivery\OAuth2;


use Illuminate\Support\Facades\Auth;

class PasswordGrantVerifier
{
    public function verify($username, $password)
    {
        $credentials = [
            'email'    => $username,
            'password' => $password,
        ];

        if (Auth::once($credentials)) {
            return Auth::user()->id;
        }

        return false;
    }
}