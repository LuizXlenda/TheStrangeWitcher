<?php


require_once 'Conexao.php';

class Publicacao {
    public static function buscarTodas($ordem) {
        global $pdo;

        if ($ordem === 'popular') {
            $sql = "SELECT p.*, u.nickname, u.foto_perfil,
                        (SELECT COUNT(*) FROM curtidas WHERE id_publicacao = p.id) AS total_curtidas,
                        (SELECT COUNT(*) FROM comentarios WHERE id_publicacao = p.id) AS total_comentarios,
                        ((SELECT COUNT(*) FROM curtidas WHERE id_publicacao = p.id) +
                         (SELECT COUNT(*) FROM comentarios WHERE id_publicacao = p.id)) AS popularidade
                    FROM publicacoes p
                    JOIN usuarios u ON p.id_usuario = u.id
                    ORDER BY popularidade DESC, p.data_publicacao DESC";
        } else {
            $sql = "SELECT p.*, u.nickname, u.foto_perfil,
                        (SELECT COUNT(*) FROM curtidas WHERE id_publicacao = p.id) AS total_curtidas,
                        (SELECT COUNT(*) FROM comentarios WHERE id_publicacao = p.id) AS total_comentarios
                    FROM publicacoes p
                    JOIN usuarios u ON p.id_usuario = u.id
                    ORDER BY p.data_publicacao DESC";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function usuarioCurtiu($idUsuario, $idPublicacao) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id FROM curtidas WHERE id_usuario = ? AND id_publicacao = ?");
        $stmt->execute([$idUsuario, $idPublicacao]);
        return $stmt->fetch() ? true : false;
    }

    public static function listarPorUsuario($idUsuario) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id, texto, data_publicacao, editado FROM publicacoes WHERE id_usuario = ? ORDER BY data_publicacao DESC");
        $stmt->execute([$idUsuario]);
        return $stmt->fetchAll();
    }

    public static function excluir($idPost, $idUsuario) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id FROM publicacoes WHERE id = ? AND id_usuario = ?");
        $stmt->execute([$idPost, $idUsuario]);
        if ($stmt->rowCount() > 0) {
            $del = $pdo->prepare("DELETE FROM publicacoes WHERE id = ?");
            return $del->execute([$idPost]);
        }
        return false;
    }

    public static function inserir($pdo, $id_usuario, $texto) {
        global $pdo;
        $sql = "INSERT INTO publicacoes (id_usuario, texto, data_publicacao) VALUES (?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$id_usuario, $texto]);
    }

    public static function buscarPorUsuario($pdo, $id_usuario) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id, texto, data_publicacao, editado FROM publicacoes WHERE id_usuario = ? ORDER BY data_publicacao DESC");
        $stmt->execute([$id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function buscarPorIdEUsuario($pdo, $post_id, $usuario_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM publicacoes WHERE id = ? AND id_usuario = ?");
        $stmt->execute([$post_id, $usuario_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function atualizarTexto($pdo, $post_id, $usuario_id, $novo_texto) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE publicacoes SET texto = ?, editado = 1, data_publicacao = NOW() WHERE id = ? AND id_usuario = ?");
        return $stmt->execute([$novo_texto, $post_id, $usuario_id]);
    }

    public static function buscarPostsRecentes($pdo, $limite = 3) {
        global $pdo;
        $sql = "
            SELECT p.*, u.nickname, u.foto_perfil
            FROM publicacoes p
            JOIN usuarios u ON p.id_usuario = u.id
            ORDER BY p.data_publicacao DESC
            LIMIT ?
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}



?>