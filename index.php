<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\config\DataBase;
use Dotenv\Dotenv;
use App\Model\User;
use App\Controller\AuthController;
use App\services\JwtService;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
header('Content-Type: application/json; charset=utf-8');
try {
    $connection = DataBase::connect();
    $userModel = new User($connection);
    $jwtService = new JwtService;

    $userLogin = new AuthController($userModel, $jwtService);
    $dados = json_decode(file_get_contents('php://input'), true);
    if (!is_array($dados) || empty($dados['email']) || empty($dados['password'])) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Dados autenticados invalidos!'
        ]);
        exit;
    } else {

        $token = $userLogin->login($dados['email'], $dados['password']);
    }

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'token' => $token
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    error_log($e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Erro interno banco da dados'
    ]);
} catch (RuntimeException $e) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    error_log($e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Erro interno no servidor'
    ]);
}
