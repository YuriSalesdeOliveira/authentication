<?php

namespace Source\Http\Controllers\Api;

use Source\Model\Login as ModelLogin;
use Source\Support\Validate;
use Source\Http\Controllers\Controller;

class Login extends Controller
{
    public function login($data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        
        $validate = new Validate($data);

        $validate->validate([
            'email' => ['email', 'required'],
            'password' => ['required']
        ]);

        if ($errors = $validate->errors()) {

            echo json_encode([
                'status' => false,
                'error' => [
                    'type' => 'validation',
                    'data' => $errors
                ]
            ]);

            return;
        }

        $credentials = [
            'email' => $data['email'],
            'password' => $data['password']
        ];

        if (!ModelLogin::attempt($credentials)) {

            echo json_encode([
                'status' => false,
                'error' => [
                    'type' => 'validation',
                    'data' => [
                        'login' => 'Email e Senha não conferem'
                    ]
                ]
            ]);

            return;
        }

        echo json_encode([
            'status' => true,
            'data' => [
                'logged_user_id' => ModelLogin::user()->id
            ]
        ]);
    }

    public function logged()
    {
        if ($logged_user = ModelLogin::user()) {

            echo json_encode([
                'status' => true,
                'data' => [
                    'logged_user_id' => ModelLogin::user()->id
                ]
            ]);

            return;
        }

        echo json_encode(['status' => false]);
    }

    public function logout()
    {
        if (ModelLogin::check()) {

            ModelLogin::logout();

            echo json_encode(['status' => true]);

            return;
        }

        echo json_encode([
            'status' => false,
            'error' => [
                'type' => 'validation',
                'data' => [
                    'logout' => 'Usuário não está logado'
                ]
            ]
        ]);
    } 
}
