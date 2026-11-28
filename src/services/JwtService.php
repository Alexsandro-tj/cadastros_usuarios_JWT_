<?php

namespace App\services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use RuntimeException;
use stdClass;

class JwtService
{
    private string $secretKey;

    public function __construct()
    {
        $this->secretKey = $_ENV['JWT_SECRET'] ?? throw new RuntimeException("Chave não configurada");
    }

    public function generateToken(array $authData): string
    {

        $payLoad = [
            'iss' => 'minha-api.com',
            'iat' => time(),
            'exp' => time() + 3600,
            'email' => $authData['email'],
            'sub' => $authData['id']
        ];
        $token = JWT::encode($payLoad, $this->secretKey, 'HS256');
        return $token;
    }
    public function validateToken(string $tokenJwt): stdClass
    {

        $decodePayload = JWT::decode($tokenJwt,  new Key($this->secretKey, 'HS256'));
        return $decodePayload;
    }
}
