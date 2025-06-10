<?php

// /Controller/FeedController.php
session_start();
require_once '../Model/Publicacao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$ordem = $_GET['ordem'] ?? 'recente';
$posts = Publicacao::buscarTodas($ordem);

// adiciona informação se o usuário curtiu
foreach ($posts as &$post) {
    $post['jaCurtiu'] = Publicacao::usuarioCurtiu($usuario_id, $post['id']);
}
unset($post); 


?>