<?php

require_once 'Conexao.php';

class Seguidor {
    
    public static function listarSeguidores($idUsuario) {
        global $pdo;
        $sql = "
            SELECT u.id, u.nickname, u.foto_perfil 
            FROM seguidores s
            JOIN usuarios u ON s.id_seguidor = u.id
            WHERE s.id_seguido = ?
            ORDER BY u.nickname ASC
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idUsuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public static function listarSeguindo($idUsuario) {
        global $pdo;
        $sql = "
            SELECT u.id, u.nickname, u.foto_perfil 
            FROM seguidores s
            JOIN usuarios u ON s.id_seguido = u.id
            WHERE s.id_seguidor = ?
            ORDER BY u.nickname ASC
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idUsuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function jaSegue($pdo, $seguidorId, $seguidoId) {
        $stmt = $pdo->prepare("SELECT 1 FROM seguidores WHERE id_seguidor = ? AND id_seguido = ?");
        $stmt->execute([$seguidorId, $seguidoId]);
        return $stmt->rowCount() > 0;
    }

    public static function seguir($pdo, $seguidorId, $seguidoId) {
        $stmt = $pdo->prepare("INSERT INTO seguidores (id_seguidor, id_seguido) VALUES (?, ?)");
        $stmt->execute([$seguidorId, $seguidoId]);
    }

    public static function deixarDeSeguir($pdo, $seguidorId, $seguidoId) {
        $stmt = $pdo->prepare("DELETE FROM seguidores WHERE id_seguidor = ? AND id_seguido = ?");
        $stmt->execute([$seguidorId, $seguidoId]);
    }

    public static function contarSeguidores($pdo, $id) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM seguidores WHERE id_seguido = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }

    public static function contarSeguindo($pdo, $id) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM seguidores WHERE id_seguidor = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }
}
