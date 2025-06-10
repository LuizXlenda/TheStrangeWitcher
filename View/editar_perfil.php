<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Feed</title>
</head>
<body>
    
    <?php include '../Controller/EditarPerfilController.php'; ?>

    <?php include '../View/header.php'; ?>


    <div class="container my-5" style="max-width:600px;">
        <h2>Editar Perfil</h2>

        <?php if ($erro): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <?php if ($sucesso): ?>
            <div class="alert alert-success"><?= htmlspecialchars($sucesso) ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nickname" class="form-label">Nickname</label>
                <input type="text" name="nickname" id="nickname" class="form-control" required
                    value="<?= htmlspecialchars($usuario['nickname']) ?>" />
            </div>

            <div class="mb-3">
                <label for="bio" class="form-label">Biografia</label>
                <textarea name="bio" id="bio" rows="4" class="form-control"><?= htmlspecialchars($usuario['bio']) ?></textarea>
            </div>

            <div class="mb-3">
                <label for="foto_perfil" class="form-label">Foto de Perfil (jpg, png)</label>
                <input type="file" name="foto_perfil" id="foto_perfil" class="form-control" accept=".jpg,.jpeg,.png,.gif" />
                <?php if ($usuario['foto_perfil']): ?>
                    <img src="../uploads/<?= htmlspecialchars($usuario['foto_perfil']) ?>" alt="Foto de Perfil" style="max-width: 120px; margin-top:10px; border-radius:50%;" />
                <?php else: ?>
                    <p class="text-muted">Nenhuma foto de perfil definida.</p>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="perfil.php" class="btn btn-secondary ms-2">Cancelar</a>
        </form>
    </div>

    <?php include '../View/footer.php';?>
    
</body>
</html>
