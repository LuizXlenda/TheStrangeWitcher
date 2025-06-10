<?php
    session_start();
    require_once '../Model/Conexao.php';
    require_once '../Model/Feedback.php';

    $erros = [];
    $sucesso = '';
    $nome = '';
    $email = '';
    $telefone = '';
    $mensagem = '';

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $nome = trim($_POST['nome']);
        $email = trim($_POST['email']);
        $telefone = trim($_POST['telefone']);
        $mensagem = trim($_POST['mensagem']);

        // Validações
        if (empty($nome)) {
            $erros['nome'] = "O campo nome é obrigatório.";
        } elseif (preg_match('/[0-9]/', $nome)) {
            $erros['nome'] = "O nome não pode conter números.";
        }

        if (empty($email)) {
            $erros['email'] = "O campo email é obrigatório.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erros['email'] = "Por favor, insira um endereço de email válido.";
        }

        if (!empty($telefone) && !preg_match('/^\(\d{2}\) \d{4,5}-\d{4}$/', $telefone)) {
            $erros['telefone'] = "O formato do telefone deve ser (99) 99999-9999.";
        }

        if (empty($mensagem)) {
            $erros['mensagem'] = "Por favor, deixe sua mensagem de feedback.";
        }

        // Se estiver tudo certo, salva o feedback
        if (empty($erros)) {
            $resultado = Feedback::inserirFeedback($pdo, $nome, $email, $telefone, $mensagem);
            
            if ($resultado) {
                $sucesso = "Feedback enviado com sucesso! Agradecemos sua contribuição.";
                $nome = $email = $telefone = $mensagem = ''; // Limpa os campos
            } else {
                $erros['geral'] = "Ocorreu um erro ao enviar seu feedback. Tente novamente mais tarde.";
            }
        }
    }
?>
