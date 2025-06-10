<?php
        include '../Model/Conexao.php';
        session_start();

        if (!isset($_SESSION['usuario_id'])) {
            header("Location: login.php");
            exit;
        }

        $usuario_id = $_SESSION['usuario_id'];
        $erro = '';
        $sucesso = '';

        if (!isset($_GET['id']) || empty($_GET['id'])) {
            die("ID do post não fornecido.");
        }

        $post_id = $_GET['id'];

        $stmt = $pdo->prepare("SELECT * FROM publicacoes WHERE id = ? AND id_usuario = ?");
        $stmt->execute([$post_id, $usuario_id]);
        $post = $stmt->fetch();

        if (!$post) {
            die("Publicação não encontrada ou você não tem permissão para editá-la.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $texto = trim($_POST['texto']);

            if (empty($texto)) {
                $erro = "O texto do post não pode ficar vazio.";
            } else {
                $stmtUpdate = $pdo->prepare("UPDATE publicacoes SET texto = ?, editado = 1, data_publicacao = NOW() WHERE id = ? AND id_usuario = ?");
                if ($stmtUpdate->execute([$texto, $post_id, $usuario_id])) {
                    $sucesso = "Post atualizado com sucesso!";
                    $post['texto'] = $texto; 
                } else {
                    $erro = "Erro ao atualizar o post.";
                }
            }
        }
    ?>