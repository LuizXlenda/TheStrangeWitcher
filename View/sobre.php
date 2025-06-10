<?php
// É uma boa prática iniciar a sessão mesmo em páginas públicas,
// para que o header possa exibir os links corretos se o usuário já estiver logado.
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nós - TSW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include '../View/header.php'; ?>

    <main class="container my-4 my-lg-5">
        
        <section class="text-center pt-5 pb-4">
            <h1 class="display-4 fw-bold">Nossa Missão</h1>
            <p class="lead col-lg-8 mx-auto">Conectar entusiastas, criadores e fãs do universo de The Witcher em um espaço único, onde a paixão pela saga se transforma em amizade e novas aventuras.</p>
        </section>

        <section class="py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="text-center mb-4">Nossa História</h2>
                    <p>O "The Strange Witcher" nasceu da ideia de um desenvolvedor apaixonado por desenvolvimento web e pelo vasto mundo criado por Andrzej Sapkowski. Percebendo a necessidade de um lugar dedicado onde os fãs pudessem não apenas discutir, mas também compartilhar suas criações, teorias e momentos favoritos, este projeto foi forjado.</p>
                    <p>Desde a primeira linha de código, nosso objetivo tem sido criar uma plataforma intuitiva, bonita e, acima de tudo, acolhedora. Cada funcionalidade foi pensada para enriquecer a experiência da comunidade, transformando uma simples rede social em um verdadeiro ponto de encontro para todos os que trilham o Caminho.</p>
                </div>
            </div>
        </section>
        
        <section class="py-5 bg-darker rounded-3">
            <div class="container">
                <h2 class="text-center mb-5">Nossa Equipe</h2>
                <div class="row justify-content-center text-center">
                    <div class="col-md-6 col-lg-4">
                        <h4 class="mt-3">Amanda Edling & Luiz Storrer</h4>
                        <br>
                        <p>Responsáveis por dar vida ao The Strange Witcher, combinando paixão por código e pela jornada de Geralt de Rívia.</p>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="py-5">
            <div class="container">
                <h2 class="text-center mb-5">Nossos Valores</h2>
                <div class="row text-center g-4">
                    <div class="col-md-4">
                        <div class="feature-item">
                            <i class="fas fa-users fa-3x mb-3"></i>
                            <h3 class="h5">Comunidade</h3>
                            <p>Acreditamos que a força da nossa plataforma está nas pessoas que a compõem. Respeito e colaboração são a base de tudo.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-item">
                            <i class="fas fa-lightbulb fa-3x mb-3"></i>
                            <h3 class="h5">Criatividade</h3>
                            <p>Incentivamos a criação e o compartilhamento de conteúdo original, desde fanarts e cosplays até discussões aprofundadas.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-item">
                            <i class="fas fa-shield-alt fa-3x mb-3"></i>
                            <h3 class="h5">Confiança</h3>
                            <p>Nos comprometemos a oferecer um ambiente seguro e proteger a privacidade e os dados de todos os nossos usuários.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="text-center py-5">
            <h2 class="fw-bold">Junte-se a Nós no Caminho</h2>
            <p class="lead">Sua jornada no continente começa aqui.</p>
            <a href="cadastrar.php" class="btn btn-primary btn-lg mt-3">Criar Minha Conta</a>
        </section>

    </main>

    <?php include '../View/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>