<?php

namespace Source\Http\Controllers\Api;

use Source\Model\User as ModelUser;
use Source\Http\Controllers\Controller;

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
    }

    public function destroy($data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $user_id = $data['id'];

        if (ModelUser::removeByFilters(['id' => $user_id])) {

            echo json_encode([
                'status' => true
            ]);

            return;
        }

        echo json_encode([
            'status' => false,
            'errors' => [
                'type' => 'delete',
                'data' => [
                    'delete' => 'Usuário não pode ser removido'
                ]
            ]
        ]);
    }
}