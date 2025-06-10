<?php
require_once '../Model/Usuario.php';
session_start();

if (isset($_SESSION['usuario_id'])) {
    header("Location: feed.php");
    exit();
}

$erros = [];
$nickname = '';

if (isset($_GET['cadastro']) && $_GET['cadastro'] === 'sucesso') {
    $sucesso = "Conta criada com sucesso! Agora você pode fazer o login.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nickname = trim($_POST['nickname']);
    $senha = $_POST['senha'];

    if (empty($nickname)) $erros['nickname'] = "O campo nickname é obrigatório.";
    if (empty($senha)) $erros['senha'] = "O campo senha é obrigatório.";

    if (empty($erros)) {
        $usuario = Usuario::buscarPorNickname($nickname);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nickname'] = $usuario['nickname'];

            if (isset($_POST['lembrar'])) {
                Usuario::removerTokensAntigos($usuario['id']);

                $selector = bin2hex(random_bytes(16));
                $validator = bin2hex(random_bytes(32));
                $expires = new DateTime('+30 days');

                Usuario::salvarNovoToken(
                    $selector,
                    hash('sha256', $validator),
                    $usuario['id'],
                    $expires->format('Y-m-d H:i:s')
                );

                setcookie(
                    'remember_me',
                    $selector . ':' . $validator,
                    $expires->getTimestamp(),
                    '/',
                    '',
                    false,
                    true
                );
            }

            header("Location: feed.php");
            exit;
        } else {
            $erros['geral'] = "Nickname ou senha incorretos.";
        }
    }
}
?>
