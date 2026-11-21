<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\config\DataBase;
use Dotenv\Dotenv;
use App\Model\User;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    $connection = DataBase::connect();
    $userModel = new User($connection);
    // $userConnect->create("Pedro","pedro@gmail.com","pedropinto");
    $user = $userModel->findByEmail("pedro@gmail.com");

    if ($user === null) {
        echo "usuario não encontrado!";
        exit;
    }
    $senhaVerificada = password_verify("pedropinto", $user['password']) ? "senha correta!" : "senha incorreta";
    echo $senhaVerificada;
} catch (PDOException $e) {
    http_response_code(500);
    error_log($e->getMessage());
}
