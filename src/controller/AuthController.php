<?php

namespace App\Controller;

use App\Model\User;
use App\services\JwtService;
use RuntimeException;

class AuthController
{

    private User $user;
    private JwtService $jwtServices;

    public function __construct(User $userModel, JwtService $jwtServices)
    {
        $this->user = $userModel;
        $this->jwtServices = $jwtServices;
    }

    public function login(string $inputEmail, string $inputSenha): string
    {
        $user = $this->user->findByEmail($inputEmail);
        if ($user === null || !password_verify($inputSenha, $user['password'])) {
            throw new RuntimeException('E-mail ou senha invalidos.', 401);
        }
        $userToken = $this->jwtServices->generateToken($user);
        return $userToken;
    }
}
