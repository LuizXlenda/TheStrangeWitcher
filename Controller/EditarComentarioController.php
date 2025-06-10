<?php
    session_start();
    require_once '../Model/Comentario.php';

    if (!isset($_SESSION['usuario_id'])) {
        header("Location: login.php");
        exit();
    }

    $usuario_id = $_SESSION['usuario_id'];
    $id_comentario = $_GET['id'] ?? null;

    if (!$id_comentario) {
        echo "Comentário não especificado.";
        exit();
    }

    $comentario = Comentario::buscarPorIdDoUsuario($id_comentario, $usuario_id);

    if (!$comentario) {
        echo "Comentário não encontrado ou você não tem permissão.";
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $novoTexto = trim($_POST['texto']);
        if ($novoTexto !== '') {
            Comentario::editar($id_comentario, $novoTexto);
            header("Location: post_detalhe.php?id=" . $comentario['id_publicacao']);
            exit();
        }
    }
?>
