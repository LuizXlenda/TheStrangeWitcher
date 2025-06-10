<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisar Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include '../Controller/UsuariosController.php'; ?>

    <?php include '../View/header.php'; ?>

    <main class="container my-4 my-lg-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                <div class="card mb-5">
                    <div class="card-body">
                        <h2 class="card-title mb-3">Encontre Usuários</h2>
                        <form method="GET" action="">
                            <div class="input-group">
                                <input type="text" name="busca" class="form-control form-control-lg" placeholder="Digite um nickname..." value="<?= htmlspecialchars($termo) ?>">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fa-solid fa-magnifying-glass"></i> <span class="d-none d-sm-inline">Buscar</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <h3 class="mb-4">Resultados da Pesquisa</h3>
                
                <?php if (count($usuarios) === 0): ?>
                    <div class="card card-body text-center text-muted">
                        Nenhum usuário encontrado com o termo "<?= htmlspecialchars($termo) ?>".
                    </div>
                <?php else: ?>
                    <div class="list-group">
                        <?php foreach ($usuarios as $usuario): 
                            // Ignorar a exibição do próprio usuário na lista
                            if ($usuario['id'] === $_SESSION['usuario_id']) {
                                continue;
                            }
                            $fotoPerfil = $usuario['foto_perfil'] ? '../uploads/' . htmlspecialchars($usuario['foto_perfil']) : '../uploads/padrao.png';
                        ?>
                            <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <img src="<?= $fotoPerfil ?>" alt="Foto de <?= htmlspecialchars($usuario['nickname']) ?>" class="user-list-img rounded-circle me-3">
                                    <strong class="h5 mb-0">@<?= htmlspecialchars($usuario['nickname']) ?></strong>
                                </div>
                                <a href="ver_usuario.php?id=<?= $usuario['id'] ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fa-solid fa-user"></i> Ver Perfil
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include '../View/footer.php';?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>