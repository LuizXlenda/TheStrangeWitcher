<?php
        session_start();
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: login.php");
            exit();
        }

        require '../Model/conexao.php'; 
        require_once '../Model/Publicacao.php';

        $mensagem_erro = '';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $texto = trim($_POST['texto']);
            $id_usuario = $_SESSION['usuario_id'];

            if (!empty($texto)) {
                
                if (strlen($texto) > 280) {
                    $mensagem_erro = "Sua publicação não pode exceder 280 caracteres.";
                } else {
                    Publicacao::inserir($pdo, $id_usuario, $texto);
                    header("Location: feed.php");
                    exit();
                }
            } else {
                $mensagem_erro = "A publicação não pode estar vazia.";
            }
        }
 ?>