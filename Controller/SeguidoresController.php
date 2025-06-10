<?php
    require_once '../Model/Seguidor.php';
    session_start();

    if (!isset($_SESSION['usuario_id'])) {
        header("Location: login.php");
        exit;
    }

    $id_perfil = $_GET['id'] ?? $_SESSION['usuario_id'];
    $meu_id = $_SESSION['usuario_id'];

    // Agora usamos o Model
    $seguidores = Seguidor::listarSeguidores($id_perfil);
    $seguindo = Seguidor::listarSeguindo($id_perfil);
?>
