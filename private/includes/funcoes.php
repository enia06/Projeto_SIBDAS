<?php

require_once __DIR__ . '/../../config/config.php';

// Inicia a sessão se ainda não estiver iniciada
function start_session() {
    if (session_status() == PHP_SESSION_NONE) {
    session_start();
    }
}

// Verifica se a sessão do utilizador está ativa
function check_session() {
    return isset($_SESSION['utilizador']);
}

// Redireciona automaticamente se não houver sessão iniciada
function redirect_if_not_logged($redirect_to = '/private/login/login.php') {
    start_session();
    if (!check_session()) {
        header("Location: ". BASE_URL . $redirect_to);
        exit;
    }
}

function logout_and_redirect($redirect_to = '/private/login/login.php') {
    start_session();
    session_unset();
    session_destroy();
    header("Location: ". BASE_URL . $redirect_to);
    exit;
}

function aes_encrypt($value) {
    return bin2hex(openssl_encrypt(
        $value,
        OPENSSL_METHOD,
        OPENSSL_KEY,
        OPENSSL_RAW_DATA,
        OPENSSL_IV
    ));
}

function aes_decrypt($value) {
    if (!is_string($value) || strlen($value) % 2 !== 0) {
        return false;
    }

    return openssl_decrypt(
        hex2bin($value),
        OPENSSL_METHOD,
        OPENSSL_KEY,
        OPENSSL_RAW_DATA,
        OPENSSL_IV
    );
}

function redirect_if_not_allowed($perfis_permitidos)
{
    start_session();

    if (!isset($_SESSION['perfil'])) {
        header('Location: /sibdas/1241327/stay-this-positive/private/login/login.php');
        exit;
    }

    if (!in_array($_SESSION['perfil'], $perfis_permitidos)) {
        header('Location: /sibdas/1241327/stay-this-positive/private/indexpriv.php');
        exit;
    }
}

function registar_log($tipo_evento, $descricao, $utilizador = null) {
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
            INSERT INTO logs (utilizador, tipo_evento, descricao)
            VALUES (:utilizador, :tipo_evento, :descricao)
        ");

        $comando->execute([
            ':utilizador' => $utilizador ?? ($_SESSION['nome_utilizador'] ?? $_SESSION['utilizador'] ?? 'Desconhecido'),
            ':tipo_evento' => $tipo_evento,
            ':descricao' => $descricao
        ]);

    } catch (PDOException $err) {
        // Não mostramos erro ao utilizador para não interromper a aplicação
    }
}