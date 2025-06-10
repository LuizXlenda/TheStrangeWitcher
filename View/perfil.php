<?php include '../Controller/PerfilController.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css" />
    <title>Perfil</title>
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
                            <div class="d-flex gap-2">
                                <a href="editar_perfil.php" class="btn btn-sm btn-secondary">Editar Perfil</a>
                                <a href="perfil.php?excluir_conta=1" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir sua conta? Esta ação é irreversível.')">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </div>

                        <div class="profile-stats d-flex gap-4 mb-3">
                            <div><strong><?= count($posts) ?></strong> publicações</div>
                            <div><a href="listar_seguidores.php?id=<?= $id ?>"><strong><?= $totalSeguidores ?></strong> seguidores</a></div>
                            <div><a href="listar_seguidores.php?id=<?= $id ?>"><strong><?= $totalSeguindo ?></strong> seguindo</a></div>
                        </div>

                        <p class="profile-bio mb-0">
                            <?= nl2br(htmlspecialchars($usuario['bio'])) ?: '<span>Nenhuma biografia definida.</span>' ?>
                        </p>
                    </div>
                </header>

                <h3 class="posts-heading mb-4">Minhas Publicações</h3>

                <?php if (empty($posts)): ?>
                    <div class="card post-card">
                        <div class="card-body text-center">
                            <p class="mb-0">O silêncio ecoa por aqui... Nenhuma publicação foi feita ainda.</p>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($posts as $post): ?>
                        <div class="card post-card mb-3">
                            <div class="card-body">
                                <p class="card-text mb-0"><?= nl2br(htmlspecialchars($post['texto'])) ?></p>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small>
                                        Publicado em: <?= date('d/m/Y H:i', strtotime($post['data_publicacao'])) ?>
                                        <?php if ($post['editado']): ?>
                                            <span class="badge bg-secondary ms-2">Editado</span>
                                        <?php endif; ?>
                                    </small>
                                    <a href="post_detalhe.php?id=<?= $post['id'] ?>" class="btn-comment">
                                        <i class="fa-solid fa-comment-dots"></i> Ver Comentários
                                    </a>
                                </div>
                                <hr>
                                <div class="post-actions d-flex justify-content-end gap-2">
                                    <a href="editar_post.php?id=<?= $post['id'] ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fa-solid fa-pen-to-square"></i> Editar
                                    </a>
                                    <a href="perfil.php?excluir_post=<?= $post['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Excluir esta publicação?')">
                                        <i class="fa-solid fa-trash"></i> Excluir
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include '../View/footer.php';?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>