<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Editar Post</title>
</head>
<body>

    <?php include '../Controller/EditarPostController.php'; ?>
    <?php include '../View/header.php'; ?>

    <div class="container my-5" style="max-width:600px;">
        <h2>Editar Post</h2>

        <?php if ($erro): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <?php if ($sucesso): ?>
            <div class="alert alert-success" style="color: black;" ><?= htmlspecialchars($sucesso) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="texto" class="form-label">Texto do Post</label>
                <textarea name="texto" id="texto" rows="5" class="form-control" required><?= htmlspecialchars($post['texto']) ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="feed.php" class="btn btn-secondary ms-2">Cancelar</a>
        </form>
    </div>
    
    

    <?php include '../View/footer.php'; ?>

</body>
</html>
