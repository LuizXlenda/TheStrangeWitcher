<?php include '../Controller/LoginController.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Entrar no TSW</title>
</head>
<body>
    
    <?php include '../View/header.php'; ?>
    
    <main class="container login-container">
        <div class="row justify-content-center w-100">
            <div class="col-lg-5 col-md-8">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header text-center">
                        <h2 class="fw-light my-4">Bem-vindo de volta!</h2>
                        <p class="lead">Acesse sua conta para continuar.</p>
                    </div>
                    <div class="card-body">
                        
                        <?php if (isset($sucesso)): ?>
                            <div class='alert alert-success text-center'><?= htmlspecialchars($sucesso) ?></div>
                        <?php endif; ?>

                        <?php if (isset($erros['geral'])): ?>
                            <div class='alert alert-danger text-center'><?= htmlspecialchars($erros['geral']) ?></div>
                        <?php endif; ?>

                        <form method="POST" action="login.php" novalidate>
                            <div class="mb-3">
                                <label for="nicknameInput" class="form-label">Nickname</label>
                                <input type="text" name="nickname" placeholder="Seu nickname" required class="form-control <?= isset($erros['nickname']) ? 'is-invalid' : '' ?>" id="nicknameInput" value="<?= htmlspecialchars($nickname) ?>">
                                <?php if (isset($erros['nickname'])): ?>
                                    <div class="invalid-feedback"><?= $erros['nickname'] ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mb-3">
                                <label for="senhaInput" class="form-label">Senha</label>
                                <input type="password" name="senha" placeholder="Sua senha" required class="form-control <?= isset($erros['senha']) ? 'is-invalid' : '' ?>" id="senhaInput">
                                <?php if (isset($erros['senha'])): ?>
                                    <div class="invalid-feedback"><?= $erros['senha'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="lembrar" id="lembrarCheck">
                                    <label class="form-check-label" for="lembrarCheck">Lembrar-me</label>
                                </div>
                            </div>
                            
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">Entrar</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3">
                        <div class="small">
                            <p class="mb-0">Ainda não tem conta? <a href="cadastrar.php">Cadastre-se aqui</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include '../View/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>