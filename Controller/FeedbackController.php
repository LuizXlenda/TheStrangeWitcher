<?php
// Lógica de validação e processamento do formulário
session_start();
require_once '../Model/Conexao.php';

// Inicializa variáveis
$erros = [];
$sucesso = '';
$nome = '';
$email = '';
$telefone = '';
$mensagem = '';

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Pega os dados do formulário e limpa espaços em branco
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);
    $mensagem = trim($_POST['mensagem']);

    // --- VALIDAÇÕES EM PHP ---

    // Validação do Nome
    if (empty($nome)) {
        $erros['nome'] = "O campo nome é obrigatório.";
    }

    // Validação do Email
    if (empty($email)) {
        $erros['email'] = "O campo email é obrigatório.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros['email'] = "Por favor, insira um endereço de email válido.";
    }

    // Validação do Telefone (opcional, mas se preenchido, valida o formato)
    if (!empty($telefone) && !preg_match('/^\(\d{2}\) \d{4,5}-\d{4}$/', $telefone)) {
        $erros['telefone'] = "O formato do telefone deve ser (99) 99999-9999.";
    }

    // Validação da Mensagem
    if (empty($mensagem)) {
        $erros['mensagem'] = "Por favor, deixe sua mensagem de feedback.";
    }

    // --- PROCESSAMENTO ---
    // Se não houver erros, insere no banco de dados
    if (empty($erros)) {
        try {
            $sql = "INSERT INTO feedbacks (nome, email, telefone, mensagem) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $email, $telefone, $mensagem]);

            $sucesso = "Feedback enviado com sucesso! Agradecemos sua contribuição.";
            
            // Limpa os campos após o envio bem-sucedido
            $nome = $email = $telefone = $mensagem = '';

        } catch (PDOException $e) {
            $erros['geral'] = "Ocorreu um erro ao enviar seu feedback. Tente novamente mais tarde.";
        }
    }
}
?>