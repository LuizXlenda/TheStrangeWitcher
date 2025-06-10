<?php
        session_start();

        // Se o usuário já estiver logado, redireciona para o feed para não mostrar a página inicial novamente.
        if (isset($_SESSION['usuario_id'])) {
            header("Location: feed.php");
            exit();
        }

        // Inclui a conexão para buscar os posts mais recentes
        require_once '../Model/Conexao.php';

        // Busca os 3 posts mais recentes para exibir como prévia
        $sql = "
            SELECT p.*, u.nickname, u.foto_perfil
            FROM publicacoes p
            JOIN usuarios u ON p.id_usuario = u.id
            ORDER BY p.data_publicacao DESC
            LIMIT 3
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    ?>