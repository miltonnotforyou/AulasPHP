<?php 
//Iniciando a sessão para gerenciar o estado de autenticação do usuário
if (!isset($_SESSION)) 
    {
    session_start();
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>PAINEL ADMINISTRATIVO — LOGIN</title>

  <!-- BOOTSTRAP CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

  <!-- BOOTSTRAP ICONS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

  <!-- CUSTOMIZAÇÃO DO TEMPLATE -->
  <link rel="stylesheet" href="../assets/css/signin.min.css">
  <link rel="stylesheet" href="../assets/css/styles.min.css">

  <!-- FAVICON -->
  <link rel="shortcut icon" href="../assets/img/favicon.ico" type="image/x-icon">


</head>
<body>

  <main class="form-signin text-center">
    <!-- Formulário de login -->
    <form action="login.php" method="POST"> 
      <h2 class="h3 mb-3 text-light">Faça seu Login</h2>
     <!-- Campos de entrada para usuário e senha, ambos com validação de preenchimento obrigatório -->
      <input type="text" class="form-control mb-2" name="usuario" placeholder="Usuário" required autofocus>

      <input type="password" class="form-control" name="senha" placeholder="Senha" required>

      <button class="w-100 btn btn-lg btn-dark" type="submit">Login</button>

    </form>

    <div class="pt-2 text-light">
      <?php 
      // Verificando se há mensagens de erro armazenadas na sessão e exibindo-as para o usuário
      
      //loginVazio é a mensagem de erro para campos vazios 
      if (isset($_SESSION['loginVazio']))
          {
             echo '<div class="alert alert-dark alert-dismissible fade show" role="alert">';
            echo $_SESSION['loginVazio']; // Exibe a mensagem de erro armazenada na sessão
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            unset($_SESSION['loginVazio']); // Limpa a mensagem da sessão para evitar exibições futuras
          }

      //loginErro é a mensagem de erro para usuário ou senha inválidos
      if (isset($_SESSION['loginErro']))
          {
            echo '<div class="alert alert-dark alert-dismissible fade show" role="alert">';
            echo $_SESSION['loginErro']; // Exibe a mensagem de erro armazenada na sessão
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            unset($_SESSION['loginErro']); // Limpa a mensagem da sessão para evitar exibições futuras
          }

      //naoAutorizado é a mensagem de erro para usuário não autorizado
      if (isset($_SESSION['naoAutorizado']))
          {
            echo '<div class="alert alert-dark alert-dismissible fade show" role="alert">';
            echo $_SESSION['naoAutorizado']; // Exibe a mensagem de erro armazenada na sessão
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';            
            unset($_SESSION['naoAutorizado']); // Limpa a mensagem da sessão para evitar exibições futuras
          }

      
      //logoff é a mensagem de sucesso para usuário que saiu da conta
      if (isset($_SESSION['logoff']))
          {
            echo '<div class="alert alert-dark alert-dismissible fade show" role="alert">';
            echo $_SESSION['logoff']; // Exibe a mensagem de sucesso armazenada na sessão
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';            
            unset($_SESSION['logoff']); // Limpa a mensagem da sessão para evitar exibições futuras
          }
        
        
        
        ?>
    </div>

    <p class="mt-5 text-light">&copy; <?= date('Y') ?></p>
  </main>
  
  <!-- JQUERY CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!-- BOOTSTRAP JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>