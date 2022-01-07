<?php

namespace Source\Http\Controllers\Api;

use Source\Model\Login;
use CoffeeCode\Router\Router;
use Source\Support\Upload\Image;
use Source\Model\User as ModelUser;
use YuriOliveira\Validation\Validate;
use Source\Http\Controllers\Controller;

class User extends Controller
{
    public function __construct(Router $router)
    {
        parent::__construct($router);

        if (!Login::check()) {

            echo json_encode([
                'status' => false,
                'error' => [
                    'type' => 'validation',
                    'data' => [
                        'update' => 'Usuário não foi encontrado'
                    ]
                ]
            ]);

            die();
        }
    }

    public function index()
    {
        $users = ModelUser::find()->object();

        echo json_encode($users);
    }

    public function store($data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
    }

    public function show($data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
    }

    public function update($data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $user = ModelUser::find(['id' => $data['id']])->first();

        if (!$user) {
    
            echo json_encode([
                'status' => false,
                'error' => [
                    'type' => 'validation',
                    'data' => [
                        'update' => 'Usuário não foi encontrado'
                    ]
                ]
            ]);

            return;
        }

        if ($user->id != Login::user()->id) {

            echo json_encode([
                'status' => false,
                'error' => [
                    'type' => 'validation',
                    'data' => [
                        'update' => 'Sem permissão para alterar esse usuário'
                    ]
                ]
            ]);

            return;
        }

        // Fazer a validação de telefone quando existir

        $validate = new Validate($_FILES + $data);

        $validate->validate([
            'bio' => ['c_filled', 'max:500'],
            'email' => ['c_filled', 'email'],
            'password' => ['c_filled', 'min:8']
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
        
        if (isset($_FILES['photo']) && $_FILES['photo']['size']) {

            $upload = new Image(PATH['storage'] . '/images');
    
            $uploaded = $upload->upload($_FILES['photo']);

            if (!$uploaded) {

                echo json_encode([
                    'status' => false,
                    'error' => [
                        'type' => 'upload',
                        'data' => $upload->errors()
                    ]
                ]);

                return;
            }
        }

        if (!empty($uploaded)) $user->photo = $uploaded;
        if (!empty($data['name'])) $user->name = $data['name'];
        if (!empty($data['bio'])) $user->bio = $data['bio'];
        if (!empty($data['phone'])) $user->phone = $data['phone'];
        if (!empty($data['email'])) $user->email = $data['email'];
        if (!empty($data['password'])) $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
        
        if (!$user->save()) {

            echo json_encode([
                'status' => false,
                'error' => [
                    'type' => 'update',
                    'data' => $user->error()
                ]
            ]);

            return;
        }

        echo json_encode([
            'status' => true,
            'data' => [
                'teste' => $user->getAttributes(),
                'update' => 'Usuário atualizado com sucesso'
            ]
        ]);

    }

    public function destroy($data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $user = ModelUser::find(['id' => $data['id']])->first();

        if (!$user) {

            echo json_encode([
                'status' => false,
                'error' => [
                    'type' => 'validation',
                    'data' => [
                        'delete' => 'Usuário não pode ser removido'
                    ]
                ]
            ]);

            return;
        }

        $user->autoRemove();

        echo json_encode([
            'status' => true
        ]);
    }
}