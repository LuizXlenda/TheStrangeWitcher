<?php
    require_once '../Model/Conexao.php';
    require_once '../Model/Publicacao.php';
    session_start();

    if (!isset($_SESSION['usuario_id'])) {
        header("Location: login.php");
        exit;
    }

    $usuario_id = $_SESSION['usuario_id'];
    $erro = '';
    $sucesso = '';

    // Verifica se o ID foi passado
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        die("ID do post não fornecido.");
    }

    $post_id = intval($_GET['id']);

    // Busca o post
    $post = Publicacao::buscarPorIdEUsuario($pdo, $post_id, $usuario_id);

    if (!$post) {
        die("Publicação não encontrada ou você não tem permissão para editá-la.");
    }

    // Se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $texto = trim($_POST['texto']);

        if (empty($texto)) {
            $erro = "O texto do post não pode ficar vazio.";
        } else {
            if (Publicacao::atualizarTexto($pdo, $post_id, $usuario_id, $texto)) {
                $sucesso = "Post atualizado com sucesso!";
                $post['texto'] = $texto;
            } else {
                $erro = "Erro ao atualizar o post.";
            }
        }
}
