<?php
class Curtida {
    public static function jaCurtiu($pdo, $usuario_id, $id_publicacao) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id FROM curtidas WHERE id_usuario = ? AND id_publicacao = ?");
        $stmt->execute([$usuario_id, $id_publicacao]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function removerCurtida($pdo, $idCurtida) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM curtidas WHERE id = ?");
        return $stmt->execute([$idCurtida]);
    }

    public static function adicionarCurtida($pdo, $usuario_id, $id_publicacao) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO curtidas (id_usuario, id_publicacao) VALUES (?, ?)");
        return $stmt->execute([$usuario_id, $id_publicacao]);
    }

    public static function contarCurtidas($pdo, $id_publicacao) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM curtidas WHERE id_publicacao = ?");
        $stmt->execute([$id_publicacao]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}
?>