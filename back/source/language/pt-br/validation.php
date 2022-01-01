<?php

return [


    'required' => 'O campo :attribute é obrigatório.',
    'email' => 'O campo :attribute deve conter um email válido.',
    'unique' => 'O :attribute já foi usado.',
    'exists' => 'O :attribute não está cadastrado.',

    'max' => [
        'string' => 'O campo :attribute deve conter no máximo :max caracteres.'
    ],
    'min' => [
        'string' => 'O campo :attribute deve conter no mínimo :min caracteres'
    ],
    'size' => [
        'string' => 'O campo :attribute deve conter :size caracteres.'
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        'name' => 'nome',
        'email' => 'e-mail',
        'password' => 'senha'
    ],

];