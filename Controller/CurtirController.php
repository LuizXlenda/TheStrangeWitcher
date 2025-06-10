<?php
    session_start();
    header('Content-Type: application/json'); // CORREÇÃO 1: Essencial para o JavaScript entender a resposta
    require '../Model/Conexao.php';

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

    // CORREÇÃO 2: Envolver a lógica em um bloco try...catch para robustez
    try {
        $pdo->beginTransaction();

        // Verificar se já curtiu o post
        $stmt = $pdo->prepare("SELECT id FROM curtidas WHERE id_usuario = ? AND id_publicacao = ?");
        $stmt->execute([$usuario_id, $id_publicacao]);
        $existe = $stmt->fetch();

        if ($existe) {
            // Se já curtiu, remove a curtida
            $stmt = $pdo->prepare("DELETE FROM curtidas WHERE id = ?");
            $stmt->execute([$existe['id']]);
            $curtiu = false;
        } else {
            // Se não curtiou, adiciona
            $stmt = $pdo->prepare("INSERT INTO curtidas (id_usuario, id_publicacao) VALUES (?, ?)");
            $stmt->execute([$usuario_id, $id_publicacao]);
            $curtiu = true;
        }

        // Contar total de curtidas no post agora
        $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM curtidas WHERE id_publicacao = ?");
        $stmt->execute([$id_publicacao]);
        $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $pdo->commit();

        echo json_encode(['success' => true, 'curtiu' => $curtiu, 'total' => $total]);

    } catch (PDOException $e) {
        $pdo->rollBack();
        responderErro("Erro de banco de dados: " . $e->getMessage());
    }
?>