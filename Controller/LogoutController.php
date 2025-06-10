<?php
    session_start();
    require_once '../Model/Conexao.php';
    require_once '../Model/Usuario.php';

    if (isset($_COOKIE['remember_me'])) {
        list($selector, $validator) = explode(':', $_COOKIE['remember_me'], 2);
        setcookie('remember_me', '', time() - 3600, '/');
        
        if ($selector) {
            Usuario::apagarToken($selector);
        }
    }

    $_SESSION = [];
    session_destroy();

    header("Location: ../View/login.php");
    exit;
?>
