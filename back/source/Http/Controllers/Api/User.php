<?php

namespace Source\Http\Controllers\Api;

use Source\Model\User as ModelUser;
use Source\Http\Controllers\Controller;
use Source\Support\Upload\Image;

class User extends Controller
{
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
        }

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

        $user->photo = $uploaded;
        $user->name = $data['name'];
        $user->bio = $data['bio'];
        $user->phone = $data['phone'];
        $user->email = $data['email'];
        $user->password = password_hash($data['password'], PASSWORD_DEFAULT);

        // $user->save();

        echo json_encode([
            'status' => true,
            'data' => [
                'teste' => $user->getAttributes()
                // 'update' => 'Usuário atualizado com sucesso'
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