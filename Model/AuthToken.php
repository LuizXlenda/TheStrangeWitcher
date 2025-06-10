<?php
    class AuthToken {
        public static function buscarTokenValido($pdo, $selector) {
            global $pdo;
            $stmt = $pdo->prepare("SELECT * FROM auth_tokens WHERE selector = ? AND expires >= NOW()");
            $stmt->execute([$selector]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public static function buscarUsuarioPorId($pdo, $user_id) {
            global $pdo;
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
            $stmt->execute([$user_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
?>