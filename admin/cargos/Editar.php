<?php 
 // Conexão com o banco de dados
  require_once __DIR__ .'/../../conexao/conecta.php';
  ######## Inicia a sessão#######

// Verificando se o usuário está autenticado para permitir o acesso à página de administração
  include_once '../Usuario_Comum.php'; // Verifica se o usuário está logado (qualquer tipo de usuário)
?>

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>PAINEL ADMINISTRATIVO</title>

  <!-- BOOTSTRAP CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

  <!-- BOOTSTRAP ICONS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

  <!-- CUSTOMIZAÇÃO DO TEMPLATE -->
  <link rel="stylesheet" href="../../assets/css/dashboard.min.css">
  <link rel="stylesheet" href="../../assets/css/styles.min.css">

  <!-- FAVICON -->
    <link rel="shortcut icon" href="../../logo/logotipo_light.png" type="image/x-icon">


</head>
<body>

  <?php
    #Início TOPO
    include('../Topo.php');
    #Final TOPO
  ?>

  <div class="container-fluid">
    <div class="row">
      <?php
        #Início MENU
        include('../Navegacao.php');
        #Final MENU
      ?>

      <main class="ms-auto col-lg-10 px-md-4">
        <?php
          include('../Log.php');
          include('../Mensagem.php');
          
          if(isset($_GET['codigo_cargo']) && $_GET['codigo_cargo'] != '')          
        {
          // CORREÇÃO 1: Proteção contra SQL Injection forçando para número Inteiro
          $codigo = intval($_GET['codigo_cargo']); // Recebe o código do funcionário via GET para buscar os dados e preencher o formulário de edição
          $sql = "SELECT * FROM cargo WHERE codigo_cargo = $codigo"; // Query para buscar o funcionário específico pelo código recebido via GET

          $query = mysqli_query($conexao, $sql); // Executa a query para buscar o funcionário específico
          $cargo = mysqli_fetch_assoc($query); // mysqli_fetch_assoc() retorna os dados do funcionário como um array associativo, onde as chaves são os nomes das colunas do banco de dados
       
        ?>
        
        <div class="card">
          <div class="card-header d-flex justify-content-between" style="background-color: #2b3d4f; color: white;">
            <h4 class="m-0">Editar Cargo</h4>
            <a href="index.php" class="btn btn-light btn-sm" >
              <i class="bi bi-arrow-left-short"></i>

              Voltar
            </a>

            </div>

          <div class="card-body">
            <form action="acoes.php" method="post">
                <div class="row">
                    <div class="col-6">
                    <label for="cargo"><strong class="text-danger">*</strong> Cargo</label>
                    <input type="text" name="cargo" id="cargo" class="form-control" maxlength="40" value="<?php echo $cargo['nome']; ?>"required>
                    
                </div>

                <div class="col-6">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1"<?php if($cargo['status'] == 1) echo ' selected'; ?> >Ativo</option>
                        <option value="0"<?php if($cargo['status'] == 0) echo ' selected'; ?> >Inativo</option>
                    </select>
                </div>

                <div class="col-12 mt-2">
                    <label for="observacao">Observação:</label>
                    <textarea name="observacao" id="observacao" class="form-control" maxlength="100"><?php echo $cargo['observacao']; ?></textarea>

                    <!-- Campo oculto para identificar a ação de cadastro de cargo -->
                    <input type="hidden" name="editar" value="editar_cargo"> 
                    <!-- Campo oculto para enviar o código do cargo a ser editado -->
                     <input type="hidden" name="codigo_cargo" value="<?php echo $codigo; ?>">

                    <input type="submit" value="Editar" class="btn btn-dark mt-3">
                </div>
               



                </div>


            </form> 


        </div>
         <?php 
        } 
        else {
      // Nenhum cargo encontrado: exibe mensagem centralizada
      // colspan="11" faz a célula ocupar todas as 11 colunas da tabela
        echo '<tr>
                <td colspan="11" class="text-center table-light text-danger py-3">
                    Nenhum cargo encontrado com estes filtros!
                </td>
                </tr>';
            }
      
      ?>   

      </main>
    </div>
  </div>

  <?php 
    // Fechando a conexão que abrimos no topo
    if(isset($conexao)) mysqli_close($conexao); 
  ?>
  
  <!-- JQUERY CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!-- BOOTSTRAP JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>