<?php

namespace Source\Http\Controllers\Api;

use Source\Model\User as ModelUser;
use Source\Http\Controllers\Controller;

class User extends Controller
{
    public function users()
    {
        $users = ModelUser::find()->object();

        echo json_encode($users);
    }
}