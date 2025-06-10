<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css" />
    <title>Detalhes do Post</title>
</head>
<body>
    
    <?php include '../Controller/PostController.php'; ?>

    <?php include '../View/header.php'; ?>

    

    <main class="container my-4 my-lg-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                <div class="card post-card mb-4">
                    <div class="card-header d-flex align-items-center">
                        <img src="<?= $post['foto_perfil'] ? '../uploads/' . htmlspecialchars($post['foto_perfil']) : '../uploads/padrao.png' ?>" alt="Foto de perfil" class="post-author-img rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover; border: 1px solid #ccc;">
                        <a href="perfil.php?id=<?= $post['id_usuario'] ?>" class="fw-bold text-decoration-none">
                            @<?= htmlspecialchars($post['nickname']) ?>
                        </a>
                    </div>
                    <div class="card-body">
                        <p class="card-text fs-5"><?= nl2br(htmlspecialchars($post['texto'])) ?></p>
                        <small class="d-block mt-3">
                            Publicado em <?= date('d/m/Y H:i', strtotime($post['data_publicacao'])) ?>
                        </small>
                        <hr>
                        <h4 class="mb-4">Comentários: </h4>
                        <?php
                            $comentarios = buscarComentarios($pdo, $post['id']);
                            if (empty($comentarios)) {
                                echo "<div class='card card-body text-center text-muted'>Nenhum comentário ainda. Seja o primeiro!</div>";
                            } else {
                                exibirComentarios($pdo, $comentarios);
                            }
                        ?>
                    </div>
                </div>

                <div class="card mb-5">
                    <div class="card-body">
                        <h5 class="card-title">Deixe seu comentário</h5>
                        <form method="post" action="">
                            <input type="hidden" name="id_publicacao" value="<?= $id_post ?>">
                            <input type="hidden" name="id_comentario_pai" value="">
                            <div class="mb-3">
                                <textarea name="texto" class="form-control" placeholder="O que você achou?" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Comentar</button>
                        </form>
                        
                    </div>
                </div>

                
            </div>
        </div>
    </main>

    <?php include '../View/footer.php';?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>