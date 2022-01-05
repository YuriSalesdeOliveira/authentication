<?php

namespace Source\Model;

use Exception;

class Login extends Model
{
    private int $user;

    public function __construct()
    {
        $this->user = $_SESSION['user'] ?? 0;
    }

    public static function check(): bool
    {
        return (new self())->user ? true : false;
    }

    public static function attempt(array $credentials): bool
    {
        $user = User::find(['email' => $credentials['email']])->first();

        if ($user) {

            if (password_verify($credentials['password'], $user->password)) {

                $_SESSION['user'] = $user->id;

                return true;
            }

        }

        return false;
    }

    public static function user(): User|bool
    {
        if (self::check()) {

            $user =  User::find(['id' => (new self())->user])->first();

            if ($user) return $user;

            static::logout();

            if (DEVELOPMENT)
                throw new Exception('Usuário na sessão não foi encontrado na base de dados');

        }
        
        return false;
    }

    public static function logout()
    {
        $_SESSION['user'] = 0;

        return true;
    }
}
