<?php
require_once 'Conexao.php';

class Comentario {
    public static function excluir($idComentario, $idUsuario) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id FROM comentarios WHERE id = ? AND id_usuario = ?");
        $stmt->execute([$idComentario, $idUsuario]);
        if ($stmt->rowCount() > 0) {
            $del = $pdo->prepare("DELETE FROM comentarios WHERE id = ?");
            return $del->execute([$idComentario]);
        }
        return false;
    }

    public static function buscarPorIdDoUsuario($idComentario, $idUsuario) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM comentarios WHERE id = ? AND id_usuario = ?");
        $stmt->execute([$idComentario, $idUsuario]);
        return $stmt->fetch();
    }

    public static function editar($idComentario, $novoTexto) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE comentarios SET texto = ?, editado = TRUE WHERE id = ?");
        return $stmt->execute([$novoTexto, $idComentario]);
    }

}
