<?php 
  // Abrindo a Conexão com o banco de dados
  require_once __DIR__ .'/../../conexao/conecta.php';

// Verificando se o usuário está autenticado para permitir o acesso à página de administração
  include_once '../Usuario_Comum.php'; // Verifica se o usuário está logado (qualquer tipo de usuário)
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
                  <select name="status" id="status" class="form-control" onchange="buscar()">
                    <option value="">Status</option>
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>

                  </select>
                </form>
              </div>
              <!-- CAMPO BUSCA POR NOME  -->

            <div class="col-4">
              <form action="">
                <input type="search" name="cargo" id="cargo" class="form-control" placeholder="Pesquisar por cargo..." onkeyup="buscar()">

          </form>
            </div>

              <!-- CAMPO BUSCA POR CÓDIGO  -->
  
                <div class="col-3">
                  <form action="">
                    <input type="search" name="codigo" id="codigo" class="form-control" placeholder="Pesquisar por código..." onkeyup="buscar()">
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
             <!-- Corpo da tabela: começa com mensagem de espera.
                     O JavaScript substituirá este conteúdo pelo retorno do AJAX. -->
              <tbody id="listar">
                 <tr>
                    <td colspan="10" class="text-center py-4">Carregando dados...</td>
                 </tr>
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


    <!-- Fecha a conexão com o banco — não é mais necessária após os selects -->
  <?php mysqli_close($conexao); ?>
  
  <!-- jQuery (necessário para o $.ajax abaixo) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

   <script>
    // ============================================================
    // 3. FUNÇÃO buscar() — CORAÇÃO DA PÁGINA
    // Coleta os filtros, faz uma requisição AJAX para Tabela.php
    // e injeta o HTML retornado dentro do <tbody id="listar">.
    // ============================================================
    function buscar() {

      // Captura o valor atual de cada filtro com jQuery ($('#id').val())
      let cargo   = $('#cargo').val();    // 'M', 'F', 'O' ou '' (todos)
      let status  = $('#status').val();   // '1', '0' ou '' (todos)
      let codigo  = $('#codigo').val();   // '1', '0' ou '' (todos)

      

      // Feedback visual imediato: troca o conteúdo da tabela por
      // uma mensagem de "carregando" enquanto a requisição acontece.
      $('#listar').html(
        '<tr><td colspan="11" class="text-center text-muted py-4">Filtrando informações...</td></tr>'
      );

      // --------------------------------------------------------
      // Requisição AJAX com jQuery
      // --------------------------------------------------------
      $.ajax({
        url: 'Tabela.php',  // Arquivo PHP que processa os filtros e retorna as <tr>
        method: 'POST',     // Envia os dados no corpo da requisição (não na URL)
        data: {             // Objeto com todos os filtros que serão recebidos via $_POST
          cargo:   cargo,
          status:  status,
          codigo:  codigo
        },
        dataType: 'html',          // Espera HTML puro de volta (as linhas <tr>)

        // Sucesso: substitui o conteúdo do <tbody> pelo HTML retornado
        success: function(resposta) {
          $('#listar').html(resposta);
        },

        // Erro de rede ou servidor: exibe mensagem de falha na tabela
        error: function() {
          $('#listar').html(
            '<tr><td colspan="11" class="text-center text-danger py-4">Erro de conexão ao carregar a tabela.</td></tr>'
          );
        }
      });
    }

    // ============================================================
    // 4. CARREGAMENTO INICIAL
    // Assim que a página terminar de carregar no navegador,
    // chama buscar() sem nenhum filtro — isso traz TODOS os
    // Clientes e preenche a tabela automaticamente.
    // ============================================================
    $(document).ready(function() {
      buscar();

      //FUNÇÃO PARA PESQUISAR APENAS PELO NOME
      $('#pesquisar').keyup(function() {
        var pesquisa = $(this).val();

        buscar('', '', '',  pesquisa); // Chama a função buscar() para atualizar a tabela com o filtro de nome
      })
    });

  </script>


</body>
</html>