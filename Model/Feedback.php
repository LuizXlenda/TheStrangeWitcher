<?php
class Feedback {
    public static function inserirFeedback($pdo, $nome, $email, $telefone, $mensagem) {
        global $pdo;
        try {
            $sql = "INSERT INTO feedbacks (nome, email, telefone, mensagem) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([$nome, $email, $telefone, $mensagem]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
