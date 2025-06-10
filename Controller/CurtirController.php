<?php
    session_start();
    header('Content-Type: application/json');

    require '../Model/Conexao.php';
    require '../Model/Curtida.php';

    function responderErro($mensagem) {
        echo json_encode(['success' => false, 'message' => $mensagem]);
        exit();
    }

    if (!isset($_SESSION['usuario_id'])) {
        responderErro('Não logado');
    }

    if (!isset($_POST['id_publicacao'])) {
        responderErro('Publicação inválida');
    }

    $usuario_id = $_SESSION['usuario_id'];
    $id_publicacao = intval($_POST['id_publicacao']);

    try {
        $pdo->beginTransaction();

        $existeCurtida = Curtida::jaCurtiu($pdo, $usuario_id, $id_publicacao);

        if ($existeCurtida) {
            Curtida::removerCurtida($pdo, $existeCurtida['id']);
            $curtiu = false;
        } else {
            Curtida::adicionarCurtida($pdo, $usuario_id, $id_publicacao);
            $curtiu = true;
        }

        $total = Curtida::contarCurtidas($pdo, $id_publicacao);

        $pdo->commit();

        echo json_encode(['success' => true, 'curtiu' => $curtiu, 'total' => $total]);

    } catch (PDOException $e) {
        $pdo->rollBack();
        responderErro("Erro de banco de dados: " . $e->getMessage());
    }
?>