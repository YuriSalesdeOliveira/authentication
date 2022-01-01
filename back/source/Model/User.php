<?php

namespace Source\Model;

class User extends Model
{
    protected static string $entity = 'users';
    protected static array $columns = [
        'name' => 'require',
        'email' => 'require',
        'password' => 'require',
        'is_admin' => 'require'
    ];
}