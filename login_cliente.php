<?php 
// Iniciando a sessão para gerenciar o estado de autenticação do usuário
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IOT STORE — LOGIN CLIENTE</title>

  <!-- BOOTSTRAP CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <!-- BOOTSTRAP ICONS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  
  <!-- CUSTOMIZAÇÃO DO TEMPLATE (Mantendo o seu padrão) -->
  <link rel="stylesheet" href="./assets/css/signin.min.css">
  <link rel="stylesheet" href="./assets/css/styles.min.css">
  
  <!-- FAVICON -->
  <link rel="shortcut icon" href="./logo/logotipo_light.png" type="image/x-icon">
</head>
<body>

  <main class="form-signin text-center">
    <form action="valida_login_cliente.php" method="POST">      
      <img class="mb-4" src="./logo/logotipo_light.png" alt="Logo da IOT Store" width="72" height="72">
      <h2 class="h3 mb-3 text-light">Área do Cliente</h2>
      
      <!-- Campos de entrada para e-mail e senha -->
      <input type="email" class="form-control mb-2" name="email" placeholder="E-mail" required autofocus>
      <input type="password" class="form-control" name="senha" placeholder="Senha" required>

      <button class="w-100 btn btn-lg btn-light mt-2" type="submit">Entrar e Comprar</button>
      
      <!-- Link para a página de cadastro que criamos -->
      <div class="mt-4">
         <a href="cadastro.php" class="text-light text-decoration-none">Ainda não tem conta? <strong>Cadastre-se aqui</strong></a>
      </div>
    </form>
             
    <div class="pt-3 text-light">
      <?php 
      // Tratamento de mensagens de erro específicas do cliente
      if (isset($_SESSION['loginClienteVazio'])) {
          echo '<div class="alert alert-dark alert-dismissible fade show" role="alert">';
          echo $_SESSION['loginClienteVazio']; 
          echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
          unset($_SESSION['loginClienteVazio']); 
      }

      if (isset($_SESSION['loginClienteErro'])) {
          echo '<div class="alert alert-dark alert-dismissible fade show" role="alert">';
          echo $_SESSION['loginClienteErro']; 
          echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
          unset($_SESSION['loginClienteErro']); 
      }
      ?>
    </div>
  </main>
  
  <!-- JQUERY & BOOTSTRAP JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>