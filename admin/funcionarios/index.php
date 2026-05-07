<?php 
  // Conexão com o banco de dados
  require_once __DIR__ .'/../../conexao/conecta.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PAINEL ADMINISTRATIVO</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="../../assets/css/dashboard.min.css">
  <link rel="stylesheet" href="../../assets/css/styles.min.css">
  <link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon">
</head>
<body>

  <?php include('../Topo.php'); ?>

  <div class="container-fluid">
    <div class="row">
      <?php include('../Navegacao.php'); ?>

      <main class="ms-auto col-lg-10 px-md-4">
        <?php
          include('../Log.php');
          include('../Mensagem.php');
        ?>
        
        <div class="card mt-3 mb-4">
          <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #2b3d4f; color: white;">
            <h4 class="m-0">Funcionários</h4>
            <a href="Inserir.php" class="btn btn-light btn-sm">
              <i class="bi bi-plus"></i> Adicionar Novo
            </a>
          </div>

          <div class="card-body">
            
            <div class="row mb-3">
              <div class="col-md-2">
                <select name="status" id="status" class="form-control" onchange="buscar()">
                  <option value="">Status</option>
                  <option value="1">Ativo</option>
                  <option value="0">Inativo</option>
                </select>
              </div>

              <div class="col-md-2">
                <select name="sexo" id="sexo" class="form-control" onchange="buscar()">
                  <option value="">Sexo</option>
                  <option value="M">Masculino</option>
                  <option value="F">Feminino</option>
                  <option value="O">Outro</option>
                </select>
              </div>

              <div class="col-md-3">
                <select name="cidade" id="cidade" class="form-control" onchange="buscar()">
                  <option value="">Cidade</option>
                   <?php 
                      $sql_cidade = "SELECT DISTINCT cidade FROM funcionario WHERE cidade IS NOT NULL AND cidade != '' ORDER BY cidade";
                      $query_cidade = mysqli_query($conexao, $sql_cidade);

                      if ($query_cidade) {
                        foreach($query_cidade as $cidade) {
                           echo '<option value="' . htmlspecialchars($cidade['cidade']) . '">' . htmlspecialchars($cidade['cidade']) . '</option>';
                        }
                      }
                  ?>
                </select>
              </div>

              <div class="col-md-2">
                <select name="cargo" id="cargo" class="form-control" onchange="buscar()">
                  <option value="">Cargo</option>
                  <?php 
                    $sql_cargo = "SELECT codigo_cargo, nome FROM cargo WHERE status = 1 ORDER BY nome";
                    $query_cargo = mysqli_query($conexao, $sql_cargo);
                    
                    if($query_cargo){
                        foreach($query_cargo as $cargo) {
                            echo '<option value="' . $cargo['codigo_cargo'] . '">' . htmlspecialchars($cargo['nome']) . '</option>';
                        }
                    }
                  ?>
                </select>
              </div>

              <div class="col-md-3">
                <input type="search" name="nome" id="nome" class="form-control" placeholder="Pesquisar por nome..." onkeyup="buscar()">
              </div>
            </div> 
            
            <div class="table-responsive">
              <table class="table table-striped table-hover align-middle border">
                <thead style="background-color: #2b3d4f; color: white;"> 
                  <tr>
                    <th class="text-white bg-dark">Código</th>
                    <th class="text-white bg-dark">Foto</th>
                    <th class="text-white bg-dark">Cargo</th>
                    <th class="text-white bg-dark">Nome</th>
                    <th class="text-white bg-dark">Nascimento</th>
                    <th class="text-white bg-dark">CPF</th>
                    <th class="text-white bg-dark">Sexo</th>
                    <th class="text-white bg-dark">Acesso</th>
                    <th class="text-white bg-dark">Status</th>
                    <th class="text-white bg-dark">Cadastro</th>
                    <th class="text-white bg-dark text-center">Ações</th>
                  </tr>
                </thead>
                <tbody id="listar">
                   <tr>
                     <td colspan="11" class="text-center py-4">Carregando dados...</td>
                   </tr>
                </tbody>
              </table>
            </div>
            
          </div> 
        </div> 
      </main>
    </div>
  </div>

  <?php mysqli_close($conexao); ?>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // FUNÇÃO UNIFICADA PARA BUSCA
    function buscar() {
      // Captura os valores de todos os campos
      let sexo = $('#sexo').val();
      let status = $('#status').val();
      let cidade = $('#cidade').val(); // Ajustado para 'cidade' em minúsculo
      let cargo = $('#cargo').val();
      let nome = $('#nome').val(); // Adicionado campo de pesquisa

      // Mensagem visual enquanto carrega
      $('#listar').html('<tr><td colspan="11" class="text-center text-muted py-4">Filtrando informações...</td></tr>');

      // Executa o AJAX
      $.ajax({
        url: 'Tabela.php', // Atenção à letra maiúscula se estiver em ambiente Linux
        method: 'POST',
        data: {
            sexo: sexo, 
            status: status, 
            cidade: cidade, 
            cargo: cargo,
            nome: nome
        },
        dataType: 'html',
        success: function(resposta){
          $('#listar').html(resposta);
        },
        error: function() {
          $('#listar').html('<tr><td colspan="11" class="text-center text-danger py-4">Erro de conexão ao carregar a tabela.</td></tr>');
        }
      });
    }

    // Carrega a tabela completa assim que a página estiver pronta
    $(document).ready(function() {
      buscar(); 
    });
  </script>

</body>
</html>