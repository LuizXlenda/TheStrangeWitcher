<?php include '../Controller/PagUsuarioController.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de @<?= htmlspecialchars($usuario['nickname']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include '../View/header.php'; ?>

    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                <header class="profile-header card mb-5">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3 justify-content-between">
                            <div class="d-flex align-items-center">
                                <img 
                                    src="<?= htmlspecialchars($usuario['foto_perfil'] ? '../uploads/' . $usuario['foto_perfil'] : '../uploads/padrao.png') ?>" 
                                    alt="Foto de perfil" 
                                    class="profile-picture" 
                                >
                                <div class="ms-3">
                                    <h2 class="mb-0">@<?= htmlspecialchars($usuario['nickname']) ?></h2>
                                </div>
                            </div>
                            <form method="post" class="ms-3">
                                <?php if ($jaSegue): ?>
                                    <button type="submit" name="deixar_de_seguir" class="btn btn-secondary">Deixar de seguir</button>
                                <?php else: ?>
                                    <button type="submit" name="seguir" class="btn btn-primary"><i class="fa-solid fa-user-plus me-2"></i>Seguir</button>
                                <?php endif; ?>
                            </form>
                        </div>

                        <div class="profile-stats d-flex gap-4 mb-3">
                            <div><strong><?= count($posts) ?></strong> publicações</div>
                            <div><a href="listar_seguidores.php?id=<?= $id_perfil ?>"><strong><?= $totalSeguidores ?></strong> seguidores</a></div>
                            <div><a href="listar_seguidores.php?id=<?= $id_perfil ?>"><strong><?= $totalSeguindo ?></strong> seguindo</a></div>
                        </div>

                        <p class="profile-bio mb-0">
                            <?= nl2br(htmlspecialchars($usuario['bio'])) ?: '<span>Nenhuma biografia definida.</span>' ?>
                        </p>
                    </div>
                </header>

                <h3 class="posts-heading mb-4">Publicações</h3>

                <?php if (empty($posts)): ?>
                    <div class="card post-card">
                        <div class="card-body text-center">
                            <p class="mb-0">Este usuário ainda não fez nenhuma publicação.</p>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($posts as $post): ?>
                        <div class="card post-card mb-3">
                            <div class="card-body">
                                <p class="card-text mb-0"><?= nl2br(htmlspecialchars($post['texto'])) ?></p>
                            </div>
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <small>
                                    Publicado em: <?= date('d/m/Y H:i', strtotime($post['data_publicacao'])) ?>
                                     <?php if (!empty($post['editado'])): ?>
                                        <span class="badge bg-secondary ms-2">Editado</span>
                                    <?php endif; ?>
                                </small>
                                <a href="post_detalhe.php?id=<?= $post['id'] ?>" class="btn-comment">
                                    <i class="fa-solid fa-comment-dots"></i> Ver Comentários
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include '../View/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>