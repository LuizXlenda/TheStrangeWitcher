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
        global $pdo;
        $stmt = $pdo->prepare("SELECT nickname, bio, foto_perfil FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function emailExiste($pdo, $email) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() ? true : false;
    }

    public static function nicknameExiste($pdo, $nickname) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE nickname = ?");
        $stmt->execute([$nickname]);
        return $stmt->fetch() ? true : false;
    }

    public static function cadastrarUsuario($pdo, $email, $nickname, $senha_hash, $bio, $foto_perfil) {
        global $pdo;
        try {
            $stmt = $pdo->prepare("INSERT INTO usuarios (email, nickname, senha, bio, foto_perfil) VALUES (?, ?, ?, ?, ?)");
            return $stmt->execute([$email, $nickname, $senha_hash, $bio, $foto_perfil]);
        } catch (PDOException $e) {
            // error_log($e->getMessage());
            return false;
        }
    }

    public static function buscarUsuarioPorId($pdo, $id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT nickname, bio, foto_perfil FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function nicknameExisteParaOutro($pdo, $nickname, $id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE nickname = ? AND id != ?");
        $stmt->execute([$nickname, $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public static function atualizarUsuario($pdo, $id, $nickname, $bio, $foto_perfil) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE usuarios SET nickname = ?, bio = ?, foto_perfil = ? WHERE id = ?");
        return $stmt->execute([$nickname, $bio, $foto_perfil, $id]);
    }

}
?>