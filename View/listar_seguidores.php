<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Conexões</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <?php include '../Controller/SeguidoresController.php'; ?>

    <?php include '../View/header.php'; ?>

    <main class="container my-4 my-lg-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                <div class="text-center mb-4">
                    <h2 class="mb-3">Conexões</h2>
                    <a href="ver_usuario.php?id=<?= $id_perfil ?>" class="btn btn-outline-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Voltar ao perfil
                    </a>
                </div>

                <ul class="nav nav-tabs nav-fill mb-0" id="conexoesTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab-seguidores" data-bs-toggle="tab" data-bs-target="#conteudo-seguidores" type="button" role="tab">
                            Seguidores (<?= count($seguidores) ?>)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-seguindo" data-bs-toggle="tab" data-bs-target="#conteudo-seguindo" type="button" role="tab">
                            Seguindo (<?= count($seguindo) ?>)
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="conexoesTabsContent">
                    <div class="tab-pane fade show active" id="conteudo-seguidores" role="tabpanel">
                        <?php if (empty($seguidores)): ?>
                            <p class="text-center m-0">Nenhum seguidor encontrado.</p>
                        <?php else: ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($seguidores as $usuario):
                                    $fotoPerfil = $usuario['foto_perfil'] ? '../uploads/' . htmlspecialchars($usuario['foto_perfil']) : '../uploads/padrao.png';
                                    $linkPerfil = 'ver_usuario.php?id=' . $usuario['id'];
                                ?>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <img src="<?= $fotoPerfil ?>" alt="Foto de <?= htmlspecialchars($usuario['nickname']) ?>" class="user-list-img rounded-circle me-3">
                                            <strong class="h5 mb-0">@<?= htmlspecialchars($usuario['nickname']) ?></strong>
                                        </div>
                                        <a href="<?= $linkPerfil ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fa-solid fa-user"></i> Ver Perfil
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="tab-pane fade" id="conteudo-seguindo" role="tabpanel">
                        <?php if (empty($seguindo)): ?>
                            <p class="text-center m-0">Não segue ninguém ainda.</p>
                        <?php else: ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($seguindo as $usuario):
                                    $fotoPerfil = $usuario['foto_perfil'] ? '../uploads/' . htmlspecialchars($usuario['foto_perfil']) : '../uploads/padrao.png';
                                    $linkPerfil = 'ver_usuario.php?id=' . $usuario['id'];
                                ?>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <img src="<?= $fotoPerfil ?>" alt="Foto de <?= htmlspecialchars($usuario['nickname']) ?>" class="user-list-img rounded-circle me-3">
                                            <strong class="h5 mb-0">@<?= htmlspecialchars($usuario['nickname']) ?></strong>
                                        </div>
                                        <a href="<?= $linkPerfil ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fa-solid fa-user"></i> Ver Perfil
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include '../View/footer.php';?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
