<?php
    session_start();

    // Redireciona se já estiver logado
    if (isset($_SESSION['usuario_id'])) {
        header("Location: feed.php");
        exit();
    }

    require_once '../Model/Conexao.php';
    require_once '../Model/Publicacao.php';

    // Busca os posts mais recentes
    $posts = Publicacao::buscarPostsRecentes($pdo);
?>