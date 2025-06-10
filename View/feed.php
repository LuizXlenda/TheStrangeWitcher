<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Feed</title>
</head>
<body>
    
    
    <?php include '../Controller/FeedController.php'; ?>

    <?php include '../View/header.php'; ?>
    
    <main class="container my-4 my-lg-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                <!-- filtro para ordenar posts -->
                <div class="btn-group mb-4" role="group" aria-label="Filtro de posts">
                    <button type="button" class="btn btn-outline-primary <?= ($ordem === 'recente') ? 'active' : '' ?>" id="btn-recentes">Recentes</button>
                    <button type="button" class="btn btn-outline-primary <?= ($ordem === 'popular') ? 'active' : '' ?>" id="btn-populares">Populares</button>
                </div>

                <?php if (count($posts) === 0): ?>
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="lead mb-0">Nenhuma publicação encontrada. Siga pessoas para ver as novidades!</p>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($posts as $post): ?>
                        <?php
                            $stmtCurtiu = $pdo->prepare("SELECT id FROM curtidas WHERE id_usuario = ? AND id_publicacao = ?");
                            $stmtCurtiu->execute([$usuario_id, $post['id']]);
                            $jaCurtiu = $stmtCurtiu->fetch() ? true : false;
                            $curtiuClass = $jaCurtiu ? 'curtido' : '';
                            $fotoPerfil = $post['foto_perfil'] ? '../uploads/' . htmlspecialchars($post['foto_perfil']) : '../uploads/padrao.png';
                        ?>

                        <div class="card post-card mb-4">
                            <div class="card-header d-flex align-items-center">
                                <img src="<?= $fotoPerfil ?>" alt="Foto de perfil de <?= htmlspecialchars($post['nickname']) ?>" class="post-author-img rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover; border: 1px solid #ccc;">
                                <a href="ver_usuario.php?id=<?= $post['id_usuario'] ?>" class="fw-bold text-decoration-none">
                                    @<?= htmlspecialchars($post['nickname']) ?>
                                </a>
                            </div>

                            <div class="card-body">
                                <p class="card-text"><?= nl2br(htmlspecialchars($post['texto'])) ?></p>
                                <small class="d-block mt-3">
                                    Publicado em <?= date('d/m/Y H:i', strtotime($post['data_publicacao'])) ?>
                                    <?php if ($post['editado']): ?>
                                        <span class=""> (Editado)</span>
                                    <?php endif; ?>
                                </small>

                            </div>

                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <div class="post-actions d-flex align-items-center gap-3">
                                    <button class="btn-curtir-post <?= $curtiuClass ?>" data-id="<?= $post['id'] ?>">
                                        <i class="fa-solid fa-heart"></i> Curtir
                                    </button>
                                    <span>
                                        <span id="curtidas-post-<?= $post['id'] ?>"><?= $post['total_curtidas'] ?></span> curtidas
                                    </span>
                                </div>
                                <a href="post_detalhe.php?id=<?= $post['id'] ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fa-solid fa-comment-dots"></i> Ver (<?= $post['total_comentarios'] ?>)
                                </a>
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php endif; ?>

            </div>
        </div>
    </main>

    <script>
    document.querySelectorAll('.btn-curtir-post').forEach(button => {
        button.addEventListener('click', () => {
            const idPost = button.getAttribute('data-id');

            fetch('../Controller/CurtirController.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'id_publicacao=' + encodeURIComponent(idPost)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const contador = document.getElementById('curtidas-post-' + idPost);
                    contador.textContent = data.total;

                    if (data.curtiu) {
                        button.classList.add('curtido');
                    } else {
                        button.classList.remove('curtido');
                    }
                } else {
                    alert('Erro: ' + data.message);
                }
            })
            .catch(() => alert('Erro de comunicação ao tentar curtir o post.'));
        });
    });

    // Filtro de ordenação
    document.getElementById('btn-recentes').addEventListener('click', () => {
        window.location.href = '?ordem=recente';
    });

    document.getElementById('btn-populares').addEventListener('click', () => {
        window.location.href = '?ordem=popular';
    });
    </script>

    <?php include '../View/footer.php';?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
