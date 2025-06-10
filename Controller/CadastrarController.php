<?php
// --- PASSO 1: TODA A LÓGICA PHP VEM PRIMEIRO ---
require_once '../Model/Conexao.php';
session_start();

// Se o usuário já estiver logado, redireciona para o feed
if (isset($_SESSION['usuario_id'])) {
    header("Location: feed.php");
    exit();
}

// Inicializa variáveis para armazenar erros e valores dos campos
$erros = [];
$email = '';
$nickname = '';
$bio = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Pega os dados do formulário e limpa
    $email = trim($_POST['email']);
    $nickname = trim($_POST['nickname']);
    $senha = $_POST['senha']; // A senha não é "limpa" com trim
    $bio = trim($_POST['bio']);

    // --- VALIDAÇÕES ---

    // Valida o email
    if (empty($email)) {
        $erros['email'] = "O e-mail é obrigatório.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros['email'] = "Formato de e-mail inválido.";
    } else {
        // Verifica se o email já existe
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $erros['email'] = "Este e-mail já está em uso.";
        }
    }

    // Valida o nickname
    if (empty($nickname)) {
        $erros['nickname'] = "O nickname é obrigatório.";
    } else {
        // Verifica se o nickname já existe
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE nickname = ?");
        $stmt->execute([$nickname]);
        if ($stmt->fetch()) {
            $erros['nickname'] = "Este nickname já está em uso.";
        }
    }
    
    // Valida a senha
    if (empty($senha)) {
        $erros['senha'] = "A senha é obrigatória.";
    } elseif (strlen($senha) < 6) { // Exemplo: exigir no mínimo 6 caracteres
        $erros['senha'] = "A senha deve ter no mínimo 6 caracteres.";
    }

    // Se não houver erros, prossiga com a inserção
    if (empty($erros)) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        
        // Define uma foto de perfil padrão. 'imagem.jpeg' foi mantido.
        $foto_perfil_padrao = 'imagem.jpeg';

        try {
            $stmt = $pdo->prepare("INSERT INTO usuarios (email, nickname, senha, bio, foto_perfil) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$email, $nickname, $senha_hash, $bio, $foto_perfil_padrao]);

            // Redireciona para o login após o sucesso do cadastro
            header("Location: login.php?cadastro=sucesso"); // CORREÇÃO no caminho
            exit;
        } catch (PDOException $e) {
            $erros['geral'] = "Ocorreu um erro ao criar a conta. Tente novamente.";
            // Para depuração: error_log($e->getMessage());
        }
    }
}
?>