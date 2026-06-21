<?php

require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: index.php');
    exit;
}

$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$mensagem = trim($_POST['mensagem'] ?? '');

$erros = [];

// Validações
if (empty($nome)) {
    $erros[] = 'O nome é obrigatório.';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros[] = 'O email é inválido.';
}

if (strlen($mensagem) < 5) {
    $erros[] = 'A mensagem é demasiado curta.';
}

if (!empty($erros)) {
    header('Location: index.php#contacto');
    exit;
}

try {

    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST .
        ";port=" . MYSQL_PORT .
        ";dbname=" . MYSQL_DATABASE .
        ";charset=utf8mb4",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );

    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $comando = $ligacao->prepare("
        INSERT INTO mensagens_contacto
        (
            nome,
            email,
            mensagem
        )
        VALUES
        (
            :nome,
            :email,
            :mensagem
        )
    ");

    $comando->execute([
        ':nome' => $nome,
        ':email' => $email,
        ':mensagem' => $mensagem
    ]);

    header('Location: index.php#contacto');
    exit;

} catch (PDOException $err) {

    header('Location: index.php#contacto');
    exit;
}