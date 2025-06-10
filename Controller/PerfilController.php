<?php
session_start();
require_once '../Model/Usuario.php';
require_once '../Model/Publicacao.php';
require_once '../Model/Comentario.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['usuario_id'];

// Excluir conta
if (isset($_GET['excluir_conta'])) {
    Usuario::excluirConta($id);
    session_destroy();
    header("Location: index.php");
    exit;
}

// Excluir post
if (isset($_GET['excluir_post'])) {
    $idPost = (int)$_GET['excluir_post'];
    Publicacao::excluir($idPost, $id);
    header("Location: perfil.php");
    exit;
}

// Excluir comentário
if (isset($_GET['excluir_comentario'])) {
    $idComentario = (int)$_GET['excluir_comentario'];
    Comentario::excluir($idComentario, $id);
    header("Location: post_detalhe.php");
    exit;
}

// Dados do perfil
$usuario = Usuario::buscarDados($id);
$posts = Publicacao::listarPorUsuario($id);
$totalSeguidores = Usuario::contarSeguidores($id);
$totalSeguindo = Usuario::contarSeguindo($id);
?>
