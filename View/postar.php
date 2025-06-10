<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../View/style.css">
    <title>Postar</title>
</head>
<body>
    <?php include '../Controller/PostarController.php'; ?>

    <?php include '../View/header.php'; ?>

    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-9">

                <div class="card post-card">
                    <div class="card-header">
                        <h2 class="h4 mb-0">O que está pensando?</h2>
                    </div>
                    <div class="card-body">

                        <?php if ($mensagem_erro): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= htmlspecialchars($mensagem_erro) ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="postar.php">
                            <div class="mb-2">
                                <textarea 
                                    name="texto" 
                                    id="post-texto"
                                    class="form-control" 
                                    rows="6" 
                                    placeholder="Escreva algo incrível aqui..." 
                                    required
                                    maxlength="280"
                                ></textarea>
                            </div>

                            <div class="d-flex justify-content-end text-muted small" id="char-counter">
                                0 / 280
                            </div>
                            
                            <div class="mt-3 text-end">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fa-solid fa-paper-plane me-2"></i>Postar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const postTexto = document.getElementById('post-texto');
        const charCounter = document.getElementById('char-counter');
        const maxLength = postTexto.getAttribute('maxlength');

        // Atualiza o contador ao carregar a página (caso o navegador preencha o campo)
        charCounter.textContent = `${postTexto.value.length} / ${maxLength}`;

        // Adiciona o listener para o evento de digitação
        postTexto.addEventListener('input', () => {
            const currentLength = postTexto.value.length;
            charCounter.textContent = `${currentLength} / ${maxLength}`;

            // Muda a cor para vermelho se o limite for atingido
            if (currentLength >= maxLength) {
                charCounter.classList.add('text-danger', 'fw-bold');
            } else {
                charCounter.classList.remove('text-danger', 'fw-bold');
            }
        });
    </script>

    <?php include '../View/footer.php';?>
</body>
</html>
