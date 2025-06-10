<?php
    require_once '../Model/Conexao.php';
    require_once '../Model/Usuario.php';
    session_start();

    // Se já estiver logado, redireciona
    if (isset($_SESSION['usuario_id'])) {
        header("Location: feed.php");
        exit();
    }

    // Inicializa variáveis
    $erros = [];
    $email = '';
    $nickname = '';
    $bio = '';

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        $email = trim($_POST['email']);
        $nickname = trim($_POST['nickname']);
        $senha = $_POST['senha'];
        $bio = trim($_POST['bio']);

        // Validações
        if (empty($email)) {
            $erros['email'] = "O e-mail é obrigatório.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erros['email'] = "Formato de e-mail inválido.";
        } elseif (Usuario::emailExiste($pdo, $email)) {
            $erros['email'] = "Este e-mail já está em uso.";
        }

        if (empty($nickname)) {
            $erros['nickname'] = "O nickname é obrigatório.";
        } elseif (Usuario::nicknameExiste($pdo, $nickname)) {
            $erros['nickname'] = "Este nickname já está em uso.";
        }

        if (empty($senha)) {
            $erros['senha'] = "A senha é obrigatória.";
        } elseif (strlen($senha) < 6) {
            $erros['senha'] = "A senha deve ter no mínimo 6 caracteres.";
        }

        if (empty($erros)) {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $foto_perfil_padrao = 'imagem.jpeg';

            $resultado = Usuario::cadastrarUsuario($pdo, $email, $nickname, $senha_hash, $bio, $foto_perfil_padrao);
            
            if ($resultado) {
                header("Location: login.php?cadastro=sucesso");
                exit;
            } else {
                $erros['geral'] = "Ocorreu um erro ao criar a conta. Tente novamente.";
            }
        }
    }
?>
