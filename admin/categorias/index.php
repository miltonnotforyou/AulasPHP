<?php 
  // Conexão com o banco de dados
  require_once('../../conexao/conecta.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PAINEL ADMINISTRATIVO</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

  <link rel="stylesheet" href="../../assets/css/dashboard.min.css">
  <link rel="stylesheet" href="../../assets/css/styles.min.css">
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
            <h4 class="m-0">Categorias</h4>
            <a href="Inserir.php" class="btn btn-light btn-sm">
              <i class="bi bi-plus"></i> Adicionar
            </a>
          </div>

          <?php 
            $sql = "SELECT categoria.* 
                    FROM categoria";

            $query = mysqli_query($conexao, $sql);
            
            // Verifica se a query funcionou e se tem pelo menos 1 registro
            if ($query && mysqli_num_rows($query) > 0) {
          ?>

          <div class="card-body">
            <div class="row mb-3">
              <div class="col-2">
                <form action="">
                  <select name="status" id="status" class="form-control">
                    <option value="">Status</option>
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
                  </select>
                </form>
              </div>

              

              <div class="col-3">
                <form action="">
                  <input type="search" name="pesquisa" id="pesquisa" class="form-control" placeholder="Pesquisar por nome...">
                </form>
              </div>
              <div class="col-3">
                <form action="">
                  <input type="search" name="pesquisa" id="pesquisa" class="form-control" placeholder="Pesquisar por data de cadastro...">
                </form>
              </div>

              
            </div> <table class="table table-striped table-hover" style="background-color: #2b3d4f; color: white;">
              <thead> 
                <tr style="background-color: #2b3d4f; color: white;">
                  <th class="text-white" style="background-color: #2b3d4f;">Código</th>
                  <th class="text-white" style="background-color: #2b3d4f;">Nome</th>
                  <th class="text-white" style="background-color: #2b3d4f;">Descrição</th>
                  <th class="text-white" style="background-color: #2b3d4f;">Status</th>
                  <th class="text-white" style="background-color: #2b3d4f;">Data Cadastro</th>
                  <th class="text-white" style="background-color: #2b3d4f;">Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($query as $categoria) { ?>
                <tr>
                  <td class="table-light"><?php echo $categoria['codigo_categoria'] ?></td>
                  <td class="table-light"><?php echo $categoria['nome'] ?></td>
                  <td class="table-light"><?php echo $categoria['observacao'] ?></td>
                   <td class="table-light">
                    <?php 
                      if ($categoria['status'] == 1) {
                        echo '<span class="badge rounded-pill bg-success">Ativo</span>';
                      } else {
                        echo '<span class="badge rounded-pill bg-danger">Inativo</span>';
                      }
                    ?>
                  </td>
                  <td class="table-light"><?php echo date('d/m/Y', strtotime($categoria['data_cadastro'])) ?></td>
                  <td class="table-light"> 
                    <a href="Editar.php?codigo_categoria=<?php echo $categoria['codigo_categoria'] ?>" class="btn btn-outline-success btn-sm" title="Editar">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <a href="" class="btn btn-outline-danger btn-sm" title="Excluir">
                      <i class="bi bi-trash"></i>
                    </a>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div> <?php 
            } else {
              // Exibe mensagem caso não haja categorias cadastrados
              echo '<div class="alert alert-danger mx-3 mt-3" role="alert">
                      Nenhuma categoria encontrada!
                    </div>';
            }
          ?>
        </div> </main>
    </div>
  </div>

  <?php mysqli_close($conexao); ?>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>