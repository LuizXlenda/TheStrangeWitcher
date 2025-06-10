<?php
    // Inicia a sessão se ainda não foi iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // LÓGICA PARA LOGAR AUTOMATICAMENTE COM O COOKIE "LEMBRAR-ME"
    // Isso só roda se o usuário NÃO tiver uma sessão ativa, mas TIVER o cookie.
    if (!isset($_SESSION['usuario_id']) && isset($_COOKIE['remember_me'])) {
        
        list($selector, $validator) = explode(':', $_COOKIE['remember_me'], 2);

        if ($selector && $validator) {
            require_once __DIR__ . '/../Model/Conexao.php'; // Garante a conexão

            $stmt = $pdo->prepare("SELECT * FROM auth_tokens WHERE selector = ? AND expires >= NOW()");
            $stmt->execute([$selector]);
            $token = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($token) {
                // Se o token foi encontrado e não expirou, verificamos o validator
                if (hash_equals($token['hashed_validator'], hash('sha256', $validator))) {
                    // Sucesso! O usuário é autêntico. Criamos a sessão para ele.
                    $stmtUser = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
                    $stmtUser->execute([$token['userid']]);
                    $usuario = $stmtUser->fetch();
                    
                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['nickname'] = $usuario['nickname'];
                }
            }
        }
    }
  ?>