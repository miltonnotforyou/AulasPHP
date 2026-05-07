<?php 
  // ============================================================
  // ARQUIVO: Novo.php (ou Cadastrar.php) — Página de cadastro de produto
  // FUNÇÃO: Exibe o formulário HTML para cadastrar um novo produto
  //         no sistema, incluindo foto, preço, estoque, marca, etc.
  // ============================================================

  // Inclui o arquivo de conexão com o banco de dados.
  // Necessário aqui pois mais abaixo fazemos queries de marca e categoria.
  require_once __DIR__ .'/../../conexao/conecta.php';

  // ============================================================
  // 1. CONTROLE DE SESSÃO
  // ============================================================

  // Verifica se a sessão JÁ está ativa antes de iniciar.
  // Evita o erro "session already started" caso outro arquivo
  // incluído já tenha chamado session_start() antes.
  if (!isset($_SESSION)) {
      session_start();
  }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PAINEL ADMINISTRATIVO</title>

  <!-- Bootstrap 5.3 — framework CSS para layout responsivo e componentes visuais -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
        rel="stylesheet" 
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" 
        crossorigin="anonymous">

  <!-- Bootstrap Icons — biblioteca de ícones SVG usada nos botões -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

  <!-- CSS customizado do projeto (dashboard e estilos gerais) -->
  <link rel="stylesheet" href="../../assets/css/dashboard.min.css">
  <link rel="stylesheet" href="../../assets/css/styles.min.css">

  <!-- Ícone que aparece na aba do navegador -->
  <link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon">

</head>

<body>

  <?php
    // ============================================================
    // 2. INCLUSÃO DOS COMPONENTES DE LAYOUT REUTILIZÁVEIS
    // ============================================================

    // Topo.php = barra superior (logo, nome do usuário logado, etc.)
    include('../Topo.php');
  ?>

  <div class="container-fluid">
    <div class="row">

      <?php
        // Navegacao.php = menu lateral esquerdo com os links do sistema
        include('../Navegacao.php');
      ?>

      <!-- Coluna principal do conteúdo — ocupa 10 das 12 colunas Bootstrap -->
      <main class="ms-auto col-lg-10 px-md-4">

        <?php
          // Log.php    = registra o acesso/ação do usuário no sistema
          // Mensagem.php = exibe alertas de sucesso ou erro de ações anteriores
          //               (ex: "Produto cadastrado com sucesso!")
          include('../Log.php');
          include('../Mensagem.php');
        ?>

        <!-- ======================================================
             3. CARD PRINCIPAL DO FORMULÁRIO
        ====================================================== -->
        <div class="card">

          <!-- Cabeçalho do card com título e botão de voltar -->
          <div class="card-header d-flex justify-content-between" 
               style="background-color: #2b3d4f; color: white;">
            <h4 class="m-0">Novo Produto</h4>

            <!-- Botão que leva de volta para a listagem de produtos -->
            <a href="index.php" class="btn btn-light btn-sm">
              <i class="bi bi-arrow-left-short"></i>
              Voltar
            </a>
          </div>

          <div class="card-body">

            <!-- ====================================================
                 4. FORMULÁRIO DE CADASTRO
                 - action="Acoes.php" → quem vai processar o envio
                 - method="post"      → dados enviados no corpo da requisição (não na URL)
                 - enctype="multipart/form-data" → OBRIGATÓRIO para envio de arquivos (foto)
            ==================================================== -->
            <form action="Acoes.php" method="post" enctype="multipart/form-data">
              <div class="row">

                <!-- ================================================
                     5. COLUNA DA ESQUERDA — Preview da foto do produto
                ================================================ -->
                <div class="col-md-3 mt-4 d-flex justify-content-center">
                  <!-- Imagem placeholder exibida antes do usuário escolher uma foto.
                       O id="preview-foto" é usado pelo JavaScript (preview_foto.js)
                       para trocar a imagem em tempo real assim que o arquivo é selecionado. -->
                  <img src="../../assets/img/placeholder-produto.jpg"
                       id="preview-foto" 
                       alt="Foto do Produto" 
                       class="rounded" 
                       style="width: 350px; height: 350px; object-fit: cover;">
                </div>

                <!-- ================================================
                     6. COLUNA DA DIREITA — Campos do formulário
                ================================================ -->
                <div class="col-md-9">
                  <div class="row">

                    <!-- Input de arquivo para upload da foto.
                         accept="image/*" restringe a seleção apenas para imagens. -->
                    <div class="col-md-4 mt-2">
                      <label for="foto">Foto do Produto</label>
                      <input type="file" name="foto" id="foto" 
                             class="form-control" accept="image/*">
                    </div>

                    <!-- Nome do produto — obrigatório (required), máximo 60 caracteres -->
                    <div class="col-md-5 mt-2">
                      <label for="nome"><strong class="text-danger">*</strong> Nome</label>
                      <input type="text" name="nome" id="nome" 
                             class="form-control" maxlength="60" required>
                    </div>

                    <!-- Status do produto: desabilitado (disabled) no cadastro
                         porque todo produto novo começa como "Ativo" por padrão. -->
                    <div class="col-md-3 mt-2">
                      <label for="status">Status</label>
                      <select name="status" id="status" class="form-control" disabled>
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                      </select>
                    </div>

                    <!-- Data de cadastro preenchida automaticamente com a data de hoje.
                         readonly = o usuário vê mas não pode alterar.
                         date('Y-m-d') gera o formato exigido pelo input type="date" -->
                    <div class="col-md-2 mt-2">
                      <label for="data_cadastro">
                        <strong class="text-danger">*</strong> Data Cadastro
                      </label>
                      <input type="date" name="data_cadastro" id="data_cadastro" 
                             class="form-control" 
                             value="<?php echo date('Y-m-d'); ?>" 
                             readonly>
                    </div>

                    <!-- ============================================
                         7. CAMPOS DE PRECIFICAÇÃO
                         A lógica é: preço de venda = custo + lucro%
                         O cálculo é feito pela função lucro() em script.js,
                         chamada pelo evento oninput nos dois campos abaixo.
                    ============================================ -->

                    <!-- Preço de custo: quanto o produto custa para a empresa -->
                    <div class="col-md-2 mt-2">
                      <label for="preco_custo">
                        <strong class="text-danger">*</strong> Preço de Custo
                      </label>
                      <input type="number" name="preco_custo" id="preco_custo" 
                             class="form-control" step="0.01" min="0" 
                             required oninput="lucro()"> <!-- Dispara cálculo ao digitar -->
                    </div>

                    <!-- Percentual de lucro desejado (ex: 30 = 30%) -->
                    <div class="col-md-2 mt-2">
                      <label for="valor_lucro">
                        <strong class="text-danger">*</strong> Lucro %
                      </label>
                      <input type="number" name="valor_lucro" id="valor_lucro" 
                             class="form-control" step="0.01" min="0" 
                             required oninput="lucro()"> <!-- Dispara cálculo ao digitar -->
                    </div>

                    <!-- Preço de venda: calculado automaticamente pelo JS, readonly.
                         O usuário não digita aqui — o valor é preenchido pela função lucro(). -->
                    <div class="col-md-2 mt-2">
                      <label for="preco_venda">
                        <strong class="text-danger">*</strong> Preço de Venda
                      </label>
                      <input type="number" name="preco_venda" id="preco_venda" 
                             class="form-control" step="0.01" min="0" readonly>
                    </div>

                    <!-- Quantidade disponível no estoque no momento do cadastro -->
                    <div class="col-md-2 mt-2">
                      <label for="qtde_estoque">
                        <strong class="text-danger">*</strong> Quantidade em Estoque
                      </label>
                      <input type="number" name="qtde_estoque" id="qtde_estoque" 
                             class="form-control" min="0" required>
                    </div>

                    <!-- ============================================
                         8. CAMPOS DE PROMOÇÃO
                         Funcionam de forma similar à precificação:
                         preço promoção = preço venda - desconto%
                         onchange="desabilitar()" ativa/desativa o campo
                         de desconto conforme o status da promoção.
                    ============================================ -->
                    <div class="col-md-12 mt-2">
                      <div class="row">

                        <!-- Se promoção estiver "Ativa", desabilitar() habilita o campo de desconto.
                             Se "Inativa" ou vazio, o campo de desconto fica bloqueado. -->
                        <div class="col-md-2 mt-2">