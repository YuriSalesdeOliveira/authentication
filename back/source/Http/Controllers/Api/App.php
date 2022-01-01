<?php

namespace Source\Http\Controllers\Api;

use Source\Http\Controllers\Controller;

class App extends Controller
{
    public function error($data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $error_code = $data['error_code'];

        $status_http = [
            400 => 'BAD_REQUEST',
            404 => 'NOT_FOUND',
            405 => 'METHOD_NOT_ALLOWED',
            501 => 'NOT_IMPLEMENTED'
        ];

        echo "Oops ! {$status_http[$error_code]}";
    }
}