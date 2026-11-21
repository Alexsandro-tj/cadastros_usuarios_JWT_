<?php

namespace App\config;

use PDO;

class DataBase
{
    //mantém uma única conexão durante a execução da aplicação.
    private static ?PDO $connection = null;
    // Centraliza a resposabilidade de conexão
    public static function connect(): PDO
    {
        if (self::$connection === null) {
            $host = $_ENV['DB_HOST'];
            $port = $_ENV['DB_PORT'];
            $dbname = $_ENV['DB_NAME'];
            $username = $_ENV['DB_USER'];
            $password = $_ENV['DB_PASS'];

            $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";

            self::$connection = new PDO(
                $dsn,
                $username,
                
                $password,
                [
                    //permite tratar erros por exeções
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    //retorna os resultados como arrays associativos
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    //desativa prepared statements emuldados
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        }
        return self::$connection;
    }
}
