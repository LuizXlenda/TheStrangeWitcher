<?php
    require_once '../Model/Conexao.php';
    require_once '../Model/Usuario.php';
    session_start();

    if (!isset($_SESSION['usuario_id'])) {
        header("Location: login.php");
        exit;
    }

    $id = $_SESSION['usuario_id'];
    $usuario = Usuario::buscarUsuarioPorId($pdo, $id);

    $erro = '';
    $sucesso = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nickname = trim($_POST['nickname']);
        $bio = trim($_POST['bio']);

        // Validação
        if (empty($nickname)) {
            $erro = "O nickname não pode ficar vazio.";
        } elseif (Usuario::nicknameExisteParaOutro($pdo, $nickname, $id)) {
            $erro = "Esse nickname já está em uso por outro usuário.";
        }

        $foto_perfil = $usuario['foto_perfil']; // mantém foto atual por padrão

        // Upload de nova foto (se houver)
        if (!$erro && isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
            $ext_permitidas = ['jpg', 'jpeg', 'png', 'gif'];
            $nomeArquivo = $_FILES['foto_perfil']['name'];
            $ext = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));

            if (in_array($ext, $ext_permitidas)) {
                $novoNome = 'perfil_' . $id . '_' . time() . '.' . $ext;
                $caminhoUpload = __DIR__ . '/../uploads/' . $novoNome;

                if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $caminhoUpload)) {
                    // Remove foto antiga (exceto a padrão)
                    if (
                        $usuario['foto_perfil'] &&
                        $usuario['foto_perfil'] !== 'imagem.jpeg' &&
                        file_exists(__DIR__ . '/../uploads/' . $usuario['foto_perfil'])
                    ) {
                        unlink(__DIR__ . '/../uploads/' . $usuario['foto_perfil']);
                    }
                    $foto_perfil = $novoNome;
                } else {
                    $erro = "Falha ao enviar a foto.";
                }
            } else {
                $erro = "Formato da foto não é permitido. Use jpg, jpeg, png ou gif.";
            }
        }

        // Atualiza se não houver erro
        if (!$erro) {
            if (Usuario::atualizarUsuario($pdo, $id, $nickname, $bio, $foto_perfil)) {
                $sucesso = "Perfil atualizado com sucesso!";
                $usuario['nickname'] = $nickname;
                $usuario['bio'] = $bio;
                $usuario['foto_perfil'] = $foto_perfil;
            } else {
                $erro = "Erro ao atualizar perfil.";
            }
        }
    }
?>