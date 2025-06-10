<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bem-vindo à TSW!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include '../Controller/IndexController.php';?>

    <?php include '../View/header.php';?>

    <main>
        <section class="hero-section text-center py-5">
            <div class="container">
                <h1 class="display-4 fw-bold">Bem-vindo à The Strange Witcher</h1>
                <p class="lead col-lg-8 mx-auto">Onde suas ideias se conectam e suas paixões ganham vida. Compartilhe momentos, descubra novidades e faça parte de uma comunidade incrível.</p>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mt-4">
                    <a href="cadastrar.php" class="btn btn-primary btn-lg px-4 gap-3">Cadastre-se Gratuitamente</a>
                    <a href="login.php" class="btn btn-outline-secondary btn-lg px-4">Já tenho uma conta</a>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <h2 class="text-center mb-5">Explore um Mundo de Possibilidades</h2>
                <div class="row text-center g-4">
                    <div class="col-md-4">
                        <div class="feature-item">
                            <i class="fas fa-share-alt fa-3x mb-3"></i>
                            <h3 class="h5">Compartilhe com Facilidade</h3>
                            <p>Publique textos, fotos e atualizações de forma simples e intuitiva.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-item">
                            <i class="fas fa-users fa-3x mb-3"></i>
                            <h3 class="h5">Conecte-se com Pessoas</h3>
                            <p>Siga amigos, interaja com comentários e construa sua rede de contatos.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-item">
                            <i class="fas fa-compass fa-3x mb-3"></i>
                            <h3 class="h5">Descubra Novidades</h3>
                            <p>Navegue por um feed dinâmico e encontre conteúdos que te interessam.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="recent-posts-section py-5">
            <div class="container">
                <h2 class="text-center mb-5">O que estão falando por aqui...</h2>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <?php if (empty($posts)): ?>
                            <p class="text-center">Ainda não há publicações. Seja o primeiro!</p>
                        <?php else: ?>
                            <?php foreach ($posts as $post):
                                $fotoPerfil = $post['foto_perfil'] ? '../uploads/' . htmlspecialchars($post['foto_perfil']) : '../uploads/padrao.png';
                            ?>
                                <div class="card post-card mb-4">
                                    <div class="card-header d-flex align-items-center">
                                        <img src="<?= $fotoPerfil ?>" alt="Foto de perfil" class="post-author-img rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover; border: 1px solid #ccc;">
                                        <span class="fw-bold">@<?= htmlspecialchars($post['nickname']) ?></span>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text"><?= nl2br(htmlspecialchars($post['texto'])) ?></p>
                                    </div>
                                    <div class="card-footer text-center">
                                        <a href="post_detalhe.php?id=<?= $post['id'] ?>" class="btn btn-sm btn-outline-primary">
                                            Ver post e comentários
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <?php include '../View/footer.php';?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>