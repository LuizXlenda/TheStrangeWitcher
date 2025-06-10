<?php
    session_start();
    require_once '../Model/Usuario.php';
    require_once '../Model/Seguidor.php';
    require_once '../Model/Publicacao.php';
    require_once '../Model/Conexao.php';

    if (!isset($_SESSION['usuario_id']) || !isset($_GET['id'])) {
        header("Location: login.php");
        exit;
    }

    $meuId = $_SESSION['usuario_id'];
    $id_perfil = $_GET['id'];

    if ($meuId == $id_perfil) {
        header("Location: perfil.php");
        exit;
    }

    // Processar ação de seguir ou deixar de seguir
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (Seguidor::jaSegue($pdo, $meuId, $id_perfil)) {
            if (isset($_POST['deixar_de_seguir'])) {
                Seguidor::deixarDeSeguir($pdo, $meuId, $id_perfil);
            }
        } else {
            if (isset($_POST['seguir'])) {
                Seguidor::seguir($pdo, $meuId, $id_perfil);
            }
        }
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit;
    }

    // Buscar dados
    $jaSegue = Seguidor::jaSegue($pdo, $meuId, $id_perfil);
    $usuario = Usuario::buscarPorId($pdo, $id_perfil);

    if (!$usuario) {
        header("Location: listar_usuarios.php?erro=nao_encontrado");
        exit;
    }

    $posts = Publicacao::buscarPorUsuario($pdo, $id_perfil);
    $totalSeguidores = Seguidor::contarSeguidores($pdo, $id_perfil);
    $totalSeguindo = Seguidor::contarSeguindo($pdo, $id_perfil);
?>