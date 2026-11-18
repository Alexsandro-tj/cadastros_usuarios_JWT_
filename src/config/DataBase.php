<?php

class DataBase
{
    private static ?PDO $connection = null;//mantém uma única conexão durante a execução da aplicação.

    public static function connect(): PDO
    {
        if (self::$connection === null) {
            $host = $_ENV['DB_HOST'];
            $dbname = $_ENV['DB_NAME'];
            $username = $_ENV['DB_USER'];
            $password = $_ENV['DB_PASS'];

            $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";

            self::$connection = new PDO(
                $dsn,
                $username,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        }
        return self::$connection;
    }
}
