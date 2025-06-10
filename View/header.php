
<?php include '../Controller/LembrarSenhaController.php'; ?>


<header>
  <nav class="navbar navbar-expand-lg bg-dark fixed-top" data-bs-theme="dark">
    <div class="container-fluid">
      
      <a class="navbar-brand" href="index.php"><img src="../Img/logo.jpeg" style="border-radius: 360px;" alt="Logo do site" width="50"> The Strange Witcher
</a>
      
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <div class="collapse navbar-collapse" id="navbarNav">
        
        <?php if (isset($_SESSION['usuario_id'])): // Se o usuário ESTÁ LOGADO ?>

          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="feed.php"><i class="fa-solid fa-house"></i> Feed</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="listar_usuarios.php"><i class="fa-solid fa-magnifying-glass"></i> Pesquisar</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="postar.php"><i class="fa-solid fa-pen-to-square"></i> Postar</a>
            </li>
          </ul>
          
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
              <li class="nav-item">
                  <a class="nav-link" href="perfil.php"><i class="fa-solid fa-user"></i> Meu Perfil</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="../Controller/LogoutController.php"><i class="fa-solid fa-door-open"></i> Sair</a>
              </li>
          </ul>
        
        <?php else: // Se o usuário NÃO ESTÁ LOGADO (visitante) ?>

          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
              <li class="nav-item">
                  <a class="nav-link" href="sobre.php"> Sobre nós</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="feedback.php"> Deixe seu feedback</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="login.php"><i class="fa-solid fa-right-to-bracket"></i> Entrar</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="cadastrar.php"><i class="fa-solid fa-user-plus"></i> Cadastre-se</a>
              </li>
          </ul>

        <?php endif; ?>

      </div>
    </div>
  </nav>
</header>
<br>
<br>
<br>