<?php 
  // Abrindo a Conexão com o banco de dados
  require_once __DIR__ .'/../../conexao/conecta.php';

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
  <link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon">


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
        
        ?>
        
        <div class="card">
          <div class="card-header d-flex justify-content-between" style="background-color: #2b3d4f; color: white;">
            <h4 class="m-0">Cargos</h4>
            <a href="Inserir.php" class="btn btn-light btn-sm">
              <i class="bi bi-plus"></i>

              Adicionar
            </a>
          </div>


            <!-- Conexão com o banco de dados -->
            <?php 
            $sql = "SELECT * FROM cargo";

            $query = mysqli_query($conexao, $sql);// Executa a conexão com o banco de dados e relaiza a consulta SQL
            
              if (mysqli_num_rows($query) > 0) {

            ?>

          
          <div class="card-body">
            <div class="row">
              <!-- FILTRO POR STATUS -->

              <div class="col-2">
                <form action="">
                  <select name="status" id="status" class="form-control">
                    <option value="">Status</option>
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>

                  </select>
                </form>
              </div>
              <!-- CAMPO BUSCA  -->

            <div class="col-4">
              <form action="">
                <input type="search" name="pesquisa" id="pesquisa" class="form-control" placeholder="Pesquisar por cargo...">

          </form>
            </div>
                                  
          </div>

        <div class="card-body">
          <table class="table table-striped table-hover">
              <thead>
                  <tr style="background-color: #2b3d4f; color: white;"> 
                      <th class="text-white" style="background-color: #2b3d4f; color: white;">Código</th>
                      <th class="text-white" style="background-color: #2b3d4f; color: white;">Cargo</th>
                      <th class="text-white" style="background-color: #2b3d4f; color: white;">Observação</th>
                      <th class="text-white" style="background-color: #2b3d4f; color: white;">Status</th>
                      <th class="text-white" style="background-color: #2b3d4f; color: white;">Data Cadastro</th>
                      <th class="text-white" style="background-color: #2b3d4f; color: white;">Ações</th>
                  </tr>
              </thead>
              <tbody>

                <?php 
                  foreach ($query as $cargo) {  
                ?>
                <tr>
                  <td class="table-light"><?php echo $cargo['codigo_cargo'] ?></td>
                  <td class="table-light"><?php echo $cargo['nome'] ?></td>
                  <td class="table-light"><?php echo $cargo['observacao'] ?></td>
                  <td class="table-light"><?php 
                    if ($cargo['status'] == 1) {
                      echo '<span class="badge rounded-pill bg-success">Ativo</span>';
                    } else {
                      echo '<span class="badge rounded-pill bg-danger">Inativo</span>';
                    }
                  ?></td>

                  <td class="table-light"><?php echo date('d/m/Y', strtotime($cargo['data_cadastro'])) ?></td>


                  <td class="table-light"> <!-- Botões  -->
                    <a href="Editar.php?codigo_cargo=<?php echo $cargo['codigo_cargo'] ?>" class="btn btn-outline-success btn-sm" title="Editar">
                      <i class="bi bi-pencil"> </i>
                    </a>

                    <a href="" class="btn btn-outline-danger btn-sm" title="Excluir">
                      <i class="bi bi-trash"> </i>
                    </a>
                  </td>

                </tr>
                <?php } 
                ?>
                
              </tbody>
            </table>
        </div>

          <?php 
            } else {
              echo '<div class="alert alert-danger mx-3 mt-3" role="alert">
                    Nenhum cargo encontrado!
                    </div>';
            }

          ?>

        </div>
        

      </main>
    </div>
  </div>


    <!-- FECHANDO A CONEXÃO COM O BANCO DE DADOS -->
  <?php 
    mysqli_close($conexao);
  ?>
  
  <!-- JQUERY CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!-- BOOTSTRAP JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>