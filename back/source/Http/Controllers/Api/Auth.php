<?php

namespace Source\Http\Controllers\Api;

use Attribute;
use Source\Model\User;
use Source\Http\Controllers\Controller;
use Source\Model\Login;

class Auth extends Controller
{
    public function login($data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $credentials = [
            'email' => $data['email'],
            'password' => $data['password']
        ];

        if (!Login::attempt($credentials)) {

            echo json_encode([
                'status' => false
            ]);

            return;
        }

        echo json_encode([
            'status' => true,
            'data' => [
                'user' => Login::user()->getAttributes()
            ]
        ]);
    }
}