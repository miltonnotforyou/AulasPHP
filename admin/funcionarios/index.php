<?php 
  // ============================================================
  // ARQUIVO: index.php — Listagem de Funcionários
  // FUNÇÃO: Exibe a tabela de funcionários com filtros dinâmicos.
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="../../assets/css/dashboard.min.css">
  <link rel="stylesheet" href="../../assets/css/styles.min.css">
  <link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon">
</head>
<body>

  <?php include('../Topo.php'); /* Barra superior do sistema */ ?>

  <div class="container-fluid">
    <div class="row">

      <?php include('../Navegacao.php'); /* Menu lateral esquerdo */ ?>

      <!-- Área de conteúdo principal — 10 colunas Bootstrap -->
      <main class="ms-auto col-lg-10 px-md-4">

        <?php
          include('../Log.php');      // Registra acesso do usuário
          include('../Mensagem.php'); // Exibe alertas de ações anteriores (sucesso/erro)
        ?>

        <div class="card mt-3 mb-4">

          <!-- Cabeçalho do card com título e botão de cadastro -->
          <div class="card-header d-flex justify-content-between align-items-center" 
               style="background-color: #2b3d4f; color: white;">
            <h4 class="m-0">Funcionários</h4>

            <!-- Botão que leva para a página de cadastro de novo funcionário -->
            <a href="Inserir.php" class="btn btn-light btn-sm">
              <i class="bi bi-plus"></i> Adicionar Novo
            </a>
          </div>

          <div class="card-body">

            <!-- ====================================================
                 1. BARRA DE FILTROS
                 Cada campo chama buscar() ao ser alterado/digitado.
                 Os valores são enviados via AJAX para Tabela.php,
                 que devolve as <tr> filtradas.
            ==================================================== -->
            <div class="row mb-3">

              <!-- Filtro por STATUS: Ativo (1) ou Inativo (0) -->
              <div class="col-md-2">
                <select name="status" id="status" class="form-control" onchange="buscar()">
                  <option value="">Status</option>
                  <option value="1">Ativo</option>
                  <option value="0">Inativo</option>
                </select>
              </div>

              <!-- Filtro por SEXO: M, F ou O -->
              <div class="col-md-2">
                <select name="sexo" id="sexo" class="form-control" onchange="buscar()">
                  <option value="">Sexo</option>
                  <option value="M">Masculino</option>
                  <option value="F">Feminino</option>
                  <option value="O">Outro</option>
                </select>
              </div>

              <!-- Filtro por CIDADE — populado dinamicamente do banco.
                   DISTINCT = evita cidades duplicadas na lista.
                   WHERE cidade IS NOT NULL AND cidade != '' = ignora
                   funcionários sem cidade cadastrada.
                   ORDER BY cidade = lista em ordem alfabética. -->
              <div class="col-md-3">
                <select name="cidade" id="cidade" class="form-control" onchange="buscar()">
                  <option value="">Cidade</option>
                  <?php 
                    $sql_cidade = "SELECT DISTINCT cidade 
                                   FROM funcionario 
                                   WHERE cidade IS NOT NULL AND cidade != '' 
                                   ORDER BY cidade";
                    $query_cidade = mysqli_query($conexao, $sql_cidade);

                    if ($query_cidade) {
                      foreach($query_cidade as $cidade) {
                        // htmlspecialchars() no value E no texto evita XSS
                        // caso alguma cidade tenha caracteres especiais
                        echo '<option value="' . htmlspecialchars($cidade['cidade']) . '">' 
                             . htmlspecialchars($cidade['cidade']) . '</option>';
                      }
                    }
                  ?>
                </select>
              </div>

              <!-- Filtro por CARGO — só exibe cargos ativos (status = 1),
                   ordenados alfabeticamente por nome. -->
              <div class="col-md-2">
                <select name="cargo" id="cargo" class="form-control" onchange="buscar()">
                  <option value="">Cargo</option>
                  <?php 
                    $sql_cargo = "SELECT codigo_cargo, nome 
                                  FROM cargo 
                                  WHERE status = 1 
                                  ORDER BY nome";
                    $query_cargo = mysqli_query($conexao, $sql_cargo);

                    if($query_cargo){
                      foreach($query_cargo as $cargo) {
                        // value = código numérico (enviado para Tabela.php)
                        // texto = nome legível (exibido ao usuário)
                        echo '<option value="' . $cargo['codigo_cargo'] . '">' 
                             . htmlspecialchars($cargo['nome']) . '</option>';
                      }
                    }
                  ?>
                </select>
              </div>

              <!-- Campo de busca por NOME — tipo "search" exibe o X para limpar.
                   onkeyup="buscar()" filtra a cada tecla digitada (busca em tempo real). -->
              <div class="col-md-3">
                <input type="search" name="nome" id="nome" 
                       class="form-control" 
                       placeholder="Pesquisar por nome..." 
                       onkeyup="buscar()">
              </div>

            </div><!-- Fim row de filtros -->

            <!-- ====================================================
                 2. TABELA DE RESULTADOS
                 O <thead> é fixo (definido aqui em HTML).
                 O <tbody id="listar"> começa com "Carregando dados..."
                 e é substituído pelo conteúdo retornado pelo AJAX.
            ==================================================== -->
            <div class="table-responsive"> <!-- Adiciona scroll horizontal em telas pequenas -->
              <table class="table table-striped table-hover align-middle border">

                <!-- Cabeçalho fixo da tabela — 11 colunas -->
                <thead style="background-color: #2b3d4f; color: white;">
                  <tr>
                    <th class="text-white bg-dark">Código</th>
                    <th class="text-white bg-dark">Cargo</th>
                    <th class="text-white bg-dark">Foto</th>
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

                <!-- Corpo da tabela: começa com mensagem de espera.
                     O JavaScript substituirá este conteúdo pelo retorno do AJAX. -->
                <tbody id="listar">
                  <tr>
                    <td colspan="11" class="text-center py-4">Carregando dados...</td>
                  </tr>
                </tbody>

              </table>
            </div>

          </div><!-- Fim card-body -->
        </div><!-- Fim card -->

      </main>
    </div>
  </div>

  <!-- Fecha a conexão com o banco — não é mais necessária após os selects -->
  <?php mysqli_close($conexao); ?>

  <!-- jQuery (necessário para o $.ajax abaixo) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

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
      let cargo  = $('#cargo').val();   // código do cargo ou '' (todos)
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
          cargo:  cargo,
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
    // funcionários e preenche a tabela automaticamente.
    // ============================================================
    $(document).ready(function() {
      buscar();

      //FUNÇÃO PARA PESQUISAR APENAS PELO NOME
      $('#pesquisar').keyup(function() {
        var pesquisa = $(this).val();

        buscar('', '', '', '', pesquisa); // Chama a função buscar() para atualizar a tabela com o filtro de nome
      })
    });
  </script>

</body>
</html>