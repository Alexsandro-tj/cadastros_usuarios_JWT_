<?php

namespace App\Controller;

use App\Model\User;
use Firebase\JWT\JWT;
use RuntimeException;

class AuthController
{

    private User $user;

    public function __construct(User $userModel)
    {
        $this->user = $userModel;
    }

    public function login(string $inputEmail, string $inputSenha): string
    {
        $user = $this->user->findByEmail($inputEmail);
        if ($user === null || !password_verify($inputSenha, $user['password'])) {
            throw new RuntimeException('E-mail ou senha invalidos.', 401);
        } else {

            $secretKey = $_ENV['JWT_SECRET'] ?? throw new RuntimeException('JWT_SECRTE não configurada');

            $payLoad = [
                'iss' =>  'minha-api.com',
                'iat' => time(),
                'exp' => time() + 3600,
                'email' => $user['id']
            ];
            $token = JWT::encode(
                $payLoad,
                $secretKey,
                'HS256'
            );
            return $token;
        }
    }
}
