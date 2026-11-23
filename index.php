<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\config\DataBase;
use Dotenv\Dotenv;
use App\Model\User;
use App\Controller\AuthController;


$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    $connection = DataBase::connect();
    $userModel = new User($connection);
    // $userConnect->create("Pedro","pedro@gmail.com","pedropinto");
    
    $userLogin = new AuthController($userModel);
    $respostaToken = $userLogin->login('pedro@gmail.com','pedropinto');
print_r($respostaToken);
    
} catch (PDOException $e) {
    http_response_code(500);
    error_log($e->getMessage());
}
