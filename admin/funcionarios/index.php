<?php 
  // conexão com o banco de dados
  require_once('../../conexao/conecta.php');

  
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
            <h4 class="m-0">Funcionários</h4>
            <a href="Inserir.php" class="btn btn-light btn-sm">
              <i class="bi bi-plus"></i>

              Adicionar
            </a>

        <!-- Conexão com o banco de dados -->
            <?php 
            $sql = "SELECT funcionario.*, cargo.nome AS cargo 
            FROM funcionario 
            LEFT JOIN cargo ON funcionario.codigo_cargo = cargo.codigo_cargo";

            $query = mysqli_query($conexao, $sql);// Executa a conexão com o banco de dados e relaiza a consulta SQL
            
              if (mysqli_num_rows($query) > 0) {

            ?>

          </div>
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

              <div class="col-2">
                <form action="">
                  <select name="sexo" id="sexo" class="form-control">
                    <option value="">Sexo</option>
                    <option value="m">Masculino</option>
                    <option value="f">Feminino</option>
                    <option value="n">Não Informado</option>

                  </select>
                </form>
              </div>

              <div class="col-2">
                <form action="">
                  <select name="cargo" id="cargo" class="form-control">
                    <option value="">Cargo</option>
                    
                    <?php 
                      $sql_cargo = "SELECT funcionario.codigo_funcionario, funcionario.foto, funcionario.codigo_cargo, funcionario.nome, funcionario.cpf, funcionario.sexo, funcionario.observacao, funcionario.status, funcionario.data_cadastro, cargo.nome 'cargo'
                      FROM funcionario JOIN cargo 
                      ON funcionario.codigo_cargo = cargo.codigo_cargo 
                      WHERE funcionario.status = 1";


                       $query_cargo = mysqli_query($conexao, $sql_cargo);
                      
                       foreach($query_cargo as $cargo) {
                            echo '<option value="' . $cargo['codigo_cargo'] . '">' . $cargo['nome'] . '</option>';
                        }
                    
                    ?>
                    
                    
                    </select>
                </form>
              </div>
              <!-- CAMPO BUSCA  -->

            <div class="col-3">
              <form action="">
                <input type="search" name="pesquisa" id="pesquisa" class="form-control" placeholder="Pesquisar por nome...">

            </form>
            </div>

                                            
          </div>

          <div class="card-body">
            <table class="table" style="background-color: #2b3d4f; color: white;">
              <thead> <!-- Tabela -->
                <tr style="background-color: #2b3d4f; color: white;">
                  <th class="text-white" style="background-color: #2b3d4f; color: white;">código</th>
                  <th class="text-white" style="background-color: #2b3d4f; color: white;">foto</th>
                  <th class="text-white" style="background-color: #2b3d4f; color: white;">cargo</th>
                  <th class="text-white" style="background-color: #2b3d4f; color: white;">Nome</th>
                  <th class="text-white" style="background-color: #2b3d4f; color: white;">CPF</th>
                  <th class="text-white" style="background-color: #2b3d4f; color: white;">Sexo</th>
                  <th class="text-white" style="background-color: #2b3d4f; color: white;">Observação</th>
                  <th class="text-white" style="background-color: #2b3d4f; color: white;">Status</th>
                  <th class="text-white" style="background-color: #2b3d4f; color: white;">Data Cadastro</th>
                  <th class="text-white" style="background-color: #2b3d4f; color: white;">Ações</th>
                </tr>
              </thead>
              <tbody>
                <!-- foreach para pegar dados da tabela -->
              <?php 
                  foreach ($query as $funcionario) {  
                ?><tr>
                  <td class="table-light"><?php echo $funcionario['codigo_funcionario'] ?></td>
                  <td class="table-light"><?php echo $funcionario['foto'] ?></td>
                  <td class="table-light"><?php echo $funcionario['cargo'] ?></td>
                  <td class="table-light"><?php echo $funcionario['nome'] ?></td>
                  <td class="table-light"><?php echo $funcionario['cpf'] ?></td>
                  <td class="table-light"><?php 
                    if ($funcionario['sexo'] == 'M') {
                      echo '<span>Masculino</span>';
                    } else {
                      echo '<span>Feminino</span>';
                    }
                  ?></td>
                  <td class="table-light"><?php echo $funcionario['observacao'] ?></td>
                  <td class="table-light"><?php 
                    if ($funcionario['status'] == 1) {
                      echo '<span class="badge rounded-pill bg-success">Ativo</span>';
                    } else {
                      echo '<span class="badge rounded-pill bg-danger">Inativo</span>';
                    }
                  ?></td>

                  <td class="table-light"><?php echo date('d/m/Y', strtotime($funcionario['data_cadastro'])) ?></td>


                  <td class="table-light"> <!-- Botões  -->
                    <a href="Editar.php?codigo_cargo=<?php echo $funcionario['codigo_cargo'] ?>" class="btn btn-outline-success btn-sm" title="Editar">
                      <i class="bi bi-pencil"> </i>
                    </a>

                    <a href="" class="btn btn-outline-danger btn-sm" title="Excluir">
                      <i class="bi bi-trash"> </i>
                    </a>
                  </td>
                         

                <?php } 
                ?>
                <!-- fechamento do foreach para pegar dados da tabela -->
                
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