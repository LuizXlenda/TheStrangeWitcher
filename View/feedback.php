<?php include '../Controller/FeedbackController.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - TSW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include '../View/header.php'; ?>

    <main class="container my-4 my-lg-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header text-center">
                        <h2 class="fw-light my-4">Deixe seu Feedback</h2>
                        <p class="lead">Sua opinião é muito importante para nós!</p>
                    </div>
                    <div class="card-body">
                        
                        <?php if (!empty($sucesso)): ?>
                            <div class="alert alert-success"><?= htmlspecialchars($sucesso) ?></div>
                        <?php endif; ?>

                        <?php if (!empty($erros['geral'])): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($erros['geral']) ?></div>
                        <?php endif; ?>

                        <form action="feedback.php" method="POST" novalidate>
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome Completo</label>
                                <input type="text" name="nome" id="nome" class="form-control <?= isset($erros['nome']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($nome) ?>" required>
                                <?php if (isset($erros['nome'])): ?>
                                    <div class="invalid-feedback"><?= $erros['nome'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control <?= isset($erros['email']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($email) ?>" required>
                                <?php if (isset($erros['email'])): ?>
                                    <div class="invalid-feedback"><?= $erros['email'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="telefone" class="form-label">Telefone (Opcional)</label>
                                <input type="tel" name="telefone" id="telefone" class="form-control <?= isset($erros['telefone']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($telefone) ?>" placeholder="(99) 99999-9999">
                                <?php if (isset($erros['telefone'])): ?>
                                    <div class="invalid-feedback"><?= $erros['telefone'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="mensagem" class="form-label">Sua Mensagem</label>
                                <textarea name="mensagem" id="mensagem" class="form-control <?= isset($erros['mensagem']) ? 'is-invalid' : '' ?>" rows="5" required><?= htmlspecialchars($mensagem) ?></textarea>
                                <?php if (isset($erros['mensagem'])): ?>
                                    <div class="invalid-feedback"><?= $erros['mensagem'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Enviar Feedback</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include '../View/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>