<?php include '../Controller/EditarComentarioController.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Comentário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include '../View/header.php'; ?>

    <div class="container mt-5">
        <h2>Editar Comentário</h2>
        <form method="post">
            <div class="mb-3">
                <textarea name="texto" class="form-control" required><?= htmlspecialchars($comentario['texto']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="post_detalhe.php?id=<?= $comentario['id_publicacao'] ?>" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <?php include '../View/footer.php';?>
</body>
</html>
