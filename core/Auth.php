<?php

namespace Core;

use App\Models\User;

class Auth
{
    public static function check(): bool
    {
        return isset($_SESSION['user']);
    }

    public static function attempt(array $credentials)
    {
        $email = $credentials['email'];
        $password = $credentials['password'];
        $user_model = new User(base_path('.env.local.ini'));
        $user = $user_model->findByEmail($email);
        if (password_verify($password, $user->password)) {
            $_SESSION['user'] = $user;
            Response::redirect('/jiris');
        }
        $_SESSION['errors']['password'] = 'Le mot de passe ne correspond pas';
        $_SESSION['old']['email'] = $email;
        Response::redirect('/login');
    }

    public static function id(): int
    {
     return $_SESSION['user']->id;
    }
}