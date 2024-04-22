<?php

namespace App\Http\Controllers\Auth;

use Core\Auth;
use Core\Response;
use Core\Validator;

class AuthenticatedSessionController
{
    public function create(): void
    {
        view('auth.create');
    }

    #[NoReturn] public function store(): void
    {

        $data = Validator::check([
            'email' => 'required|email|exists:user,email',
            'password' => 'required|min:8|digits|specials',
        ]);
        Auth::attempt($data);
    }

    #[NoReturn] public function destroy(): void
    {
        $_SESSION = [];
        session_destroy();
        Response::redirect('/login');
    }
}