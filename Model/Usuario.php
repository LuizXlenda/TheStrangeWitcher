<?php

require_once 'Conexao.php';

class Usuario {
    public static function buscarUsuarios($termo = '') {
        global $pdo;

        if ($termo !== '') {
            $stmt = $pdo->prepare("SELECT id, nickname, foto_perfil FROM usuarios WHERE nickname LIKE ? ORDER BY nickname ASC");
            $stmt->execute(['%' . $termo . '%']);
        } else {
            $stmt = $pdo->query("SELECT id, nickname, foto_perfil FROM usuarios ORDER BY nickname ASC");
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function buscarPorNickname($nickname) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE nickname = ?");
        $stmt->execute([$nickname]);
        return $stmt->fetch();
    }

    public static function removerTokensAntigos($usuarioId) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM auth_tokens WHERE userid = ?");
        $stmt->execute([$usuarioId]);
    }

    public static function salvarNovoToken($selector, $hashedValidator, $usuarioId, $dataExpiracao) {
        global $pdo;
        $stmt = $pdo->prepare("
            INSERT INTO auth_tokens (selector, hashed_validator, userid, expires)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$selector, $hashedValidator, $usuarioId, $dataExpiracao]);
    }

    public static function apagarToken($selector) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM auth_tokens WHERE selector = ?");
    $stmt->execute([$selector]);
    }

    public static function excluirConta($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function buscarDados($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT nickname, bio, foto_perfil FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function contarSeguidores($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM seguidores WHERE id_seguido = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }

    public static function contarSeguindo($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM seguidores WHERE id_seguidor = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }

    public static function buscarPorId($pdo, $id) {
        $stmt = $pdo->prepare("SELECT nickname, bio, foto_perfil FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
?>