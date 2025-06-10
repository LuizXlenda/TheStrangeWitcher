<?php
    // Inicia a sessão se ainda não foi iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['usuario_id']) && isset($_COOKIE['remember_me'])) {
        list($selector, $validator) = explode(':', $_COOKIE['remember_me'], 2);

        if ($selector && $validator) {
            require_once __DIR__ . '/../Model/Conexao.php';
            require_once __DIR__ . '/../Model/AuthToken.php';

            $token = AuthToken::buscarTokenValido($pdo, $selector);

            if ($token && hash_equals($token['hashed_validator'], hash('sha256', $validator))) {
                $usuario = AuthToken::buscarUsuarioPorId($pdo, $token['userid']);

                if ($usuario) {
                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['nickname'] = $usuario['nickname'];
                }
            }
        }
    }
?>