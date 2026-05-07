<?php 
  // ============================================================
  // ARQUIVO: index.php — Listagem de clientes
  // FUNÇÃO: Exibe a tabela de clientes com filtros dinâmicos.
  //         Os dados da tabela são carregados via AJAX (Tabela.php),
  //         não diretamente aqui — esta página só monta a estrutura.
  // ============================================================

  // Conexão com o banco necessária para popular os selects de
  // cidade e cargo ainda no carregamento inicial da página.
  require_once __DIR__ .'/../../conexao/conecta.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PAINEL ADMINISTRATIVO</title>

  <!-- Bootstrap 5 CSS, Bootstrap Icons, estilos customizados e favicon -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="../../assets/css/dashboard.min.css">
  <link rel="stylesheet" href="../../assets/css/styles.min.css">
  <link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon">
</head>
<body>

  <?php /* Barra superior do sistema */
    #Início TOPO
    include('../Topo.php');
    #Final TOPO
  ?>

  <div class="container-fluid">
    <div class="row">
      <?php
        #Início MENU
        include('../Navegacao.php'); /* Menu lateral esquerdo */
        #Final MENU
      ?>

    <!-- Área de conteúdo principal — 10 colunas Bootstrap -->
      <main class="ms-auto col-lg-10 px-md-4">
        <?php
          include('../Log.php'); // Registra acesso do usuário
        ?>
        
         <!-- Cabeçalho do card com título e botão de cadastro -->
        <div class="card">
          <div class="card-header d-flex justify-content-between" style="background-color: #2b3d4f; color: white;">
            <h4 class="m-0">Clientes</h4>

            <!-- Botão que leva para a página de cadastro de novo funcionário -->
            <a href="Inserir.php" class="btn btn-light btn-sm">
              <i class="bi bi-plus"></i> Adicionar
            </a>
          </div>

          <?php 
            $sql = "SELECT * 
                    FROM cliente
                    WHERE status = 1;";

            $query = mysqli_query($conexao, $sql);
            
            // Verifica se a query funcionou e se tem pelo menos 1 registro
            if ($query && mysqli_num_rows($query) > 0) {
          ?>

          <!-- ====================================================
                 1. BARRA DE FILTROS
                 Cada campo chama buscar() ao ser alterado/digitado.
                 Os valores são enviados via AJAX para Tabela.php,
                 que devolve as <tr> filtradas.
            ==================================================== -->

          <div class="card-body">
            <div class="row mb-3">
              <!-- Filtro por STATUS: Ativo (1) ou Inativo (0) -->
              <div class="col-2">
                  <select name="status" id="status" class="form-control" onchange="buscar()">
                    <option value="">Status</option>
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
                  </select>
              </div>

              <!-- Filtro por SEXO: M, F ou O -->
              <div class="col-2">
                  <select name="sexo" id="sexo" class="form-control" onchange="buscar()">
                    <option value="">Sexo</option>
                    <option value="m">Masculino</option>
                    <option value="f">Feminino</option>
                    <option value="n">Não Informado</option>
                  </select>
              </div>

<!-- Campo de busca por NOME — tipo "search" exibe o X para limpar.
                   onkeyup="buscar()" filtra a cada tecla digitada (busca em tempo real). -->
              <div class="col-3">
                  <input type="search" name="nome" id="nome" class="form-control" placeholder="Pesquisar por nome..." onkeyup="buscar()">
              </div>

              <!-- Filtro por CIDADE — populado dinamicamente do banco.
                   DISTINCT = evita cidades duplicadas na lista.
                   WHERE cidade IS NOT NULL AND cidade != '' = ignora
                   funcionários sem cidade cadastrada.
                   ORDER BY cidade = lista em ordem alfabética. -->
               <div class="col-3"> <select name="cidade" id="cidade" class="form-control" onchange="buscar()">
                    <option value="">Todas as Cidades</option>
                    <?php 
                      // Busca apenas as cidades únicas (DISTINCT) na tabela de clientes
                      $sql_cidade = "SELECT DISTINCT cidade 
                                     FROM cliente 
                                     WHERE cidade IS NOT NULL AND cidade != '' 
                                     ORDER BY cidade";
                      $query_cidade = mysqli_query($conexao, $sql_cidade);

                      if ($query_cidade) {
                        foreach($query_cidade as $c) {
                          echo '<option value="' . htmlspecialchars($c['cidade']) . '">' 
                               . htmlspecialchars($c['cidade']) . '</option>';
                        }
                      }
                    ?>
                  </select>
              </div>

            </div> <!-- Fim row de filtros -->
              <!-- ====================================================
                  2. TABELA DE RESULTADOS
                  O corpo da tabela (<tbody>) é preenchido dinamicamente
                  pela resposta do AJAX (Tabela.php), que retorna as <tr>
                  filtradas de acordo com os critérios selecionados.
                  ==================================================== -->

            <table class="table table-striped table-hover" style="background-color: #2b3d4f; color: white;">
             <!-- Cabeçalho fixo da tabela -->  
            <thead> 
                <tr style="background-color: #2b3d4f; color: white;">
                  <th class="text-white" style="background-color: #2b3d4f;">Código</th>
                  <th class="text-white" style="background-color: #2b3d4f;">Nome</th>
                  <th class="text-white" style="background-color: #2b3d4f;">CPF</th>
                  <th class="text-white" style="background-color: #2b3d4f;">E-mail</th>
                  <th class="text-white" style="background-color: #2b3d4f;">Telefone Celular</th>
                  <th class="text-white" style="background-color: #2b3d4f;">Cidade / UF</th>
                  <th class="text-white" style="background-color: #2b3d4f;">Sexo</th>
                  <th class="text-white" style="background-color: #2b3d4f;">Status</th>
                  <th class="text-white" style="background-color: #2b3d4f;">Data Cadastro</th>
                  <th class="text-white" style="background-color: #2b3d4f;">Ações</th>
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
              // Exibe mensagem caso não haja funcionários
              echo '<div class="alert alert-danger mx-3 mt-3" role="alert">
                      Nenhum cliente encontrado!
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
      let sexo   = $('#sexo').val();    // 'M', 'F', 'O' ou '' (todos)
      let status = $('#status').val();  // '1', '0' ou '' (todos)
      let cidade = $('#cidade').val();  // nome da cidade ou '' (todas)
      let nome   = $('#nome').val();    // texto digitado ou '' (todos)

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
          sexo:   sexo,
          status: status,
          cidade: cidade,
          nome:   nome
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