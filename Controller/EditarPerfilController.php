<?php
        include '../Model/Conexao.php';
        session_start();

        if (!isset($_SESSION['usuario_id'])) {
            header("Location: login.php");
            exit;
        }

        $id = $_SESSION['usuario_id'];

        // Pega dados atuais do usuário
        $stmt = $pdo->prepare("SELECT nickname, bio, foto_perfil FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        $usuario = $stmt->fetch();

        $erro = '';
        $sucesso = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nickname = trim($_POST['nickname']);
            $bio = trim($_POST['bio']);

            // Verifica se nickname está vazio
            if (empty($nickname)) {
                $erro = "O nickname não pode ficar vazio.";
            } else {
                // Verifica se nickname já existe para outro usuário
                $stmtCheck = $pdo->prepare("SELECT id FROM usuarios WHERE nickname = ? AND id != ?");
                $stmtCheck->execute([$nickname, $id]);
                if ($stmtCheck->fetch()) {
                    $erro = "Esse nickname já está em uso por outro usuário.";
                }
            }

            // Se não houve erro, processa atualização
            if (!$erro) {
                // Upload da foto (se enviou)
                $foto_perfil = $usuario['foto_perfil']; // mantém foto atual se não alterar

                if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
                    $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif'];
                    $nomeArquivo = $_FILES['foto_perfil']['name'];
                    $ext = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));

                    if (in_array($ext, $extensoes_permitidas)) {
                        $novoNome = 'perfil_' . $id . '_' . time() . '.' . $ext;
                        $caminhoUpload = __DIR__ . '/../uploads/' . $novoNome;

                        // Move o arquivo para uploads
                        if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $caminhoUpload)) {
                            // Apaga a foto antiga (se existir)
                        if (
                            $usuario['foto_perfil'] &&
                            $usuario['foto_perfil'] !== 'imagem.jpeg' && // não apagar a imagem padrão
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

                // Se não houve erro no upload, atualiza banco
                if (!$erro) {
                    $stmtUpdate = $pdo->prepare("UPDATE usuarios SET nickname = ?, bio = ?, foto_perfil = ? WHERE id = ?");
                    if ($stmtUpdate->execute([$nickname, $bio, $foto_perfil, $id])) {
                        $sucesso = "Perfil atualizado com sucesso!";
                        // Atualiza dados atuais para mostrar no formulário
                        $usuario['nickname'] = $nickname;
                        $usuario['bio'] = $bio;
                        $usuario['foto_perfil'] = $foto_perfil;
                    } else {
                        $erro = "Erro ao atualizar perfil.";
                    }
                }
            }
        }
    ?>