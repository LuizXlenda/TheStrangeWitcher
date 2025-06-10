<?php include '../Controller/CadastrarController.php';?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Cadastrar</title>
</head>
<body>
    
    <?php include '../View/header.php';?>

    <main class="container form-container my-4 my-lg-5">
        <div class="row justify-content-center w-100">
            <div class="col-lg-5 col-md-8">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header text-center">
                        <h2 class="fw-light my-4">Crie sua Conta</h2>
                    </div>
                    <div class="card-body">
                        
                        <?php if(!empty($erros['geral'])): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($erros['geral']) ?></div>
                        <?php endif; ?>

                        <form method="POST" action="cadastrar.php" novalidate>
                            <div class="mb-3">
                                <label for="emailInput" class="form-label">Endereço de e-mail</label>
                                <input type="email" name="email" placeholder="Seu e-mail" required class="form-control <?= isset($erros['email']) ? 'is-invalid' : '' ?>" id="emailInput" value="<?= htmlspecialchars($email) ?>">
                                <?php if(isset($erros['email'])): ?>
                                    <div class="invalid-feedback"><?= $erros['email'] ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mb-3">
                                <label for="nicknameInput" class="form-label">Nome de usuário (nickname)</label>
                                <input type="text" name="nickname" placeholder="Seu nickname" required class="form-control <?= isset($erros['nickname']) ? 'is-invalid' : '' ?>" id="nicknameInput" value="<?= htmlspecialchars($nickname) ?>">
                                <div class="form-text">Este será seu nome público no site.</div>
                                <?php if(isset($erros['nickname'])): ?>
                                    <div class="invalid-feedback"><?= $erros['nickname'] ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mb-3">
                                <label for="senhaInput" class="form-label">Senha</label>
                                <input type="password" name="senha" placeholder="Mínimo de 6 caracteres" required class="form-control <?= isset($erros['senha']) ? 'is-invalid' : '' ?>" id="senhaInput">
                                <?php if(isset($erros['senha'])): ?>
                                    <div class="invalid-feedback"><?= $erros['senha'] ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mb-3">
                                <label for="bioInput" class="form-label">Biografia (opcional)</label>
                                <textarea name="bio" placeholder="Fale um pouco sobre você..." class="form-control" id="bioInput" rows="3"><?= htmlspecialchars($bio) ?></textarea>
                            </div>
                            
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">Cadastrar</button>
                            </div>
                        </form>

                    </div>
                    <div class="card-footer text-center py-3">
                        <div class="small">
                            <p class="mb-0">Já tem uma conta? <a href="login.php">Faça login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <?php include '../View/footer.php';?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>