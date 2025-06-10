<?php
require_once '../Model/Usuario.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$termo = $_GET['busca'] ?? '';

$usuarios = Usuario::buscarUsuarios($termo);
?>