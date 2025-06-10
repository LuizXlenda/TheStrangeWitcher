<?php
        session_start();
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: login.php");
            exit();
        }

        require_once '../Model/Conexao.php';

        $usuario_id = $_SESSION['usuario_id'];
        

        // Lógica para adicionar um novo comentário/resposta
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id_publicacao = $_POST['id_publicacao'] ?? null;
            $texto = trim($_POST['texto'] ?? '');
            $id_comentario_pai = $_POST['id_comentario_pai'] ?? null;
            if ($id_comentario_pai === '') $id_comentario_pai = null;

            if ($id_publicacao && $texto !== '') {
                $sqlInsert = "INSERT INTO comentarios (id_usuario, id_publicacao, texto, id_comentario_pai) VALUES (?, ?, ?, ?)";
                $stmtInsert = $pdo->prepare($sqlInsert);
                $stmtInsert->execute([$usuario_id, $id_publicacao, $texto, $id_comentario_pai]);
                // Redireciona para a mesma página para evitar reenvio do formulário
                header("Location: " . $_SERVER['REQUEST_URI']);
                exit();
            }
        }

        if (isset($_GET['excluir_comentario'])) {
            $idComentario = (int)$_GET['excluir_comentario'];
            // Verifica se o comentário pertence ao usuário
            $verificaComentario = $pdo->prepare("SELECT id, id_publicacao FROM comentarios WHERE id = ? AND id_usuario = ?");
            $verificaComentario->execute([$idComentario, $usuario_id]);

            if ($verificaComentario->rowCount() > 0) {
                $comentario = $verificaComentario->fetch();
                $delComentario = $pdo->prepare("DELETE FROM comentarios WHERE id = ?");
                $delComentario->execute([$idComentario]);
                // Redireciona para o post correto
                header("Location: post_detalhe.php?id=" . $comentario['id_publicacao']);
                exit;
            } else {
                echo "Comentário não encontrado ou você não tem permissão.";
            }
        }


        if (!isset($_GET['id'])) {
            echo "Post não especificado.";
            exit();
        }

        $id_post = $_GET['id'];

        // Busca o post principal
        $sql = "SELECT p.*, u.nickname, u.foto_perfil FROM publicacoes p JOIN usuarios u ON p.id_usuario = u.id WHERE p.id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_post]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$post) {
            echo "Publicação não encontrada.";
            exit();
        }

        
        function buscarComentarios($pdo, $id_publicacao, $id_comentario_pai = null) {
            $sql = "
                SELECT c.*, u.nickname, u.foto_perfil
                FROM comentarios c
                JOIN usuarios u ON c.id_usuario = u.id
                WHERE c.id_publicacao = ? AND " . ($id_comentario_pai === null ? "c.id_comentario_pai IS NULL" : "c.id_comentario_pai = ?") . "
                ORDER BY c.data_comentario ASC
            ";
            $stmt = $pdo->prepare($sql);
            $params = $id_comentario_pai === null ? [$id_publicacao] : [$id_publicacao, $id_comentario_pai];
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        function exibirComentarios($pdo, $comentarios) {
            foreach ($comentarios as $comentario) {
                $id = $comentario['id'];
                $respostas = buscarComentarios($pdo, $comentario['id_publicacao'], $id);
                $fotoPerfil = $comentario['foto_perfil'] ? '../uploads/' . htmlspecialchars($comentario['foto_perfil']) : '../uploads/padrao.png';
        ?>
                <div class="comment-thread">
                    <div class="comment-container">
                        <div class="d-flex">
                            <img src="<?= $fotoPerfil ?>" alt="Foto de perfil" class="comment-author-img rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover; border: 1px solid #ccc;">
                            <div class="w-100">
                                <a href="perfil.php?id=<?= $comentario['id_usuario'] ?>" class="fw-bold text-decoration-none">@<?= htmlspecialchars($comentario['nickname']) ?></a>
                                <p class="comment-text mb-1"><?= nl2br(htmlspecialchars($comentario['texto'])) ?></p>
                                <small><?= date('d/m/Y H:i', strtotime($comentario['data_comentario'])) ?></small>

                                <div class="comment-actions mt-2">
                                    <a class="btn-responder" data-bs-toggle="collapse" href="#reply-form-<?= $id ?>" role="button">
                                        Responder
                                    </a>
                                    <?php if (!empty($respostas)): ?>
                                        <a class="btn-responder ms-3" data-bs-toggle="collapse" href="#respostas-<?= $id ?>" role="button">
                                            Ver respostas (<?= count($respostas) ?>)
                                        </a>
                                    <?php endif; ?>
                                </div>
                                
                                <hr>

                                <?php if ($comentario['id_usuario'] == $_SESSION['usuario_id']) : ?>
                                    <div class="post-actions d-flex justify-content-end gap-2">
                                        <a href="editar_comentario.php?id=<?= $comentario['id'] ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fa-solid fa-pen-to-square"></i> Editar
                                        </a>
                                        <a href="post_detalhe.php?id=<?= $comentario['id_publicacao'] ?>&excluir_comentario=<?= $comentario['id'] ?>" 
                                            class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('Tem certeza que deseja excluir este comentário?')">
                                            <i class="fa-solid fa-trash"></i> Excluir
                                        </a>

                                    </div>
                                <?php endif; ?>


                                <div class="collapse mt-3" id="reply-form-<?= $id ?>">
                                    <form method="post" action="">
                                        <input type="hidden" name="id_publicacao" value="<?= $comentario['id_publicacao'] ?>">
                                        <input type="hidden" name="id_comentario_pai" value="<?= $id ?>">
                                        <textarea name="texto" class="form-control form-control-sm" placeholder="Escreva sua resposta..." required></textarea>
                                        <button type="submit" class="btn btn-sm btn-primary mt-2">Enviar Resposta</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($respostas)): ?>
                        <div class="collapse" id="respostas-<?= $id ?>">
                            <?php exibirComentarios($pdo, $respostas); // Chamada recursiva para exibir as respostas ?>
                        </div>
                    <?php endif; ?>
                </div>
        <?php
            } 
        } 
?>