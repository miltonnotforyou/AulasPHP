<?php 
// Iniciando a sessão para gerenciar o estado de autenticação do usuário
//conexão com o banco de dados
require_once __DIR__ . '/../conexao/conecta.php';

//Iniciando a sessão para gerenciar o estado de autenticação do usuário
if (!isset($_SESSION)) 
    {
    session_start();
    }

    // Verificando se o usuário está autenticado para permitir o acesso à página de administração
    if (!isset($_SESSION['USER']))
        {
            $_SESSION['naoAutorizado'] = "Apenas usuários autenticados podem acessar o painel administrativo."; // Armazenando a mensagem de erro na sessão para exibir na página de login
            header("Location: Index.php"); // Redireciona para a página de login se o usuário não estiver autenticado
            
        }
    // Configuração da data de hoje em Português
    $meses = [
        '01' => 'Janeiro', '02' => 'Fevereiro', '03' => 'Março', '04' => 'Abril',
        '05' => 'Maio', '06' => 'Junho', '07' => 'Julho', '08' => 'Agosto',
        '09' => 'Setembro', '10' => 'Outubro', '11' => 'Novembro', '12' => 'Dezembro'
    ];
    $data_hoje = date('d') . ' de ' . $meses[date('m')] . ' de ' . date('Y');

   

    // 2. CONSULTAS PARA OS CARTÕES DE METAS
    // Total de Vendas (Soma da coluna 'valor_total' da tabela 'venda')
    $sql_vendas = "SELECT SUM(valor_total) as total FROM venda"; 
    $res_vendas = $conexao->query($sql_vendas);
    $total_vendas = $res_vendas->fetch_assoc()['total'] ?? 0;

    // Dispositivos Ativos (Soma do estoque da tabela 'produto' onde status = 1)
    $sql_produtos = "SELECT SUM(qtde_estoque) as total FROM produto WHERE status = 1";
    $res_produtos = $conexao->query($sql_produtos);
    $total_produtos = $res_produtos->fetch_assoc()['total'] ?? 0;

    // Novos Clientes (Total de clientes ativos)
    $sql_clientes = "SELECT COUNT(*) as total FROM cliente WHERE status = 1";
    $res_clientes = $conexao->query($sql_clientes);
    $total_clientes = $res_clientes->fetch_assoc()['total'] ?? 0;

    // Total de Pedidos (Como não há coluna status na tabela venda, pegamos o total de pedidos gerados)
    $sql_pedidos = "SELECT COUNT(*) as total FROM venda";
    $res_pedidos = $conexao->query($sql_pedidos);
    $total_pedidos = $res_pedidos->fetch_assoc()['total'] ?? 0;


    // 3. CONSULTA PARA A TABELA DE PEDIDOS RECENTES
    $sql_recentes = "SELECT v.codigo_venda, c.nome as cliente_nome, v.forma_pagamento, v.valor_total 
                    FROM venda v
                    INNER JOIN cliente c ON v.codigo_cliente = c.codigo_cliente
                    ORDER BY v.codigo_venda DESC LIMIT 5";
    $res_recentes = $conexao->query($sql_recentes);


    // 4. CONSULTA PARA O GRÁFICO DE BARRAS (Vendas por Mês)
    $sql_grafico_vendas = "SELECT MONTHNAME(data_venda) as mes, SUM(valor_total) as total 
                        FROM venda 
                        GROUP BY MONTH(data_venda) 
                        ORDER BY MONTH(data_venda) ASC LIMIT 6";
    $res_graf_vendas = $conexao->query($sql_grafico_vendas);

    $meses_venda = [];
    $valores_venda = [];
    if ($res_graf_vendas && $res_graf_vendas->num_rows > 0) {
        while($linha = $res_graf_vendas->fetch_assoc()) {
            $meses_venda[] = $linha['mes'];
            $valores_venda[] = $linha['total'];
        }
    }

    // 5. CONSULTA PARA O GRÁFICO DE ROSCA (Estoque por Categoria)
    // Pega o nome da categoria e soma a quantidade em estoque dos produtos vinculados a ela
    $sql_grafico_cat = "SELECT c.nome as categoria, SUM(p.qtde_estoque) as qtd_estoque 
                        FROM produto p 
                        INNER JOIN categoria c ON p.codigo_categoria = c.codigo_categoria 
                        WHERE p.status = 1
                        GROUP BY c.codigo_categoria 
                        ORDER BY qtd_estoque DESC LIMIT 5";
    $res_graf_cat = $conexao->query($sql_grafico_cat);

    $nomes_categorias = [];
    $qtd_categorias = [];
    if ($res_graf_cat && $res_graf_cat->num_rows > 0) {
        while($linha = $res_graf_cat->fetch_assoc()) {
            $nomes_categorias[] = $linha['categoria'];
            $qtd_categorias[] = $linha['qtd_estoque'];
        }
    }
    
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
  <link rel="stylesheet" href="../assets/css/dashboard.min.css">
  <link rel="stylesheet" href="../assets/css/styles.min.css">
  <link rel="stylesheet" href="../custom/css/style.css">


   <!-- FAVICON -->
    <link rel="shortcut icon" href="../logo/logotipo_light.png" type="image/x-icon">


</head>
<body>

  <?php
    #Início TOPO
    include('Topo.php');
    #Final TOPO
  ?>

  <div class="container-fluid">
    <div class="row">
      <?php
        #Início MENU
        include('Navegacao.php');
        #Final MENU
      ?>

      <div class="ms-auto col-lg-10 px-md-4">
        <?php
          include('Log.php');
        ?>

        <div>
            <?php 
            if (isset($_SESSION['naoAdm']))
                {
                    echo $_SESSION['naoAdm']; // Exibe a mensagem de erro armazenada na sessão
                    unset($_SESSION['naoAdm']); // Limpa a mensagem da sessão para evitar exibições futuras
                }
                            
            ?>
        </div>

              <!-- Conteúdo Principal -->
        <main class="conteudo-principal">
            <header class="cabecalho-superior">
                <div class="barra-pesquisa">
                    <i class="bi bi-search"></i>
                    <input type="text" id="termo-pesquisa" placeholder="Pesquisar clientes, produtos, vendas...">
                </div>

                <div class="perfil-usuario" style="display: flex; align-items: center; gap: 10px;">
                    <div style="text-align: right;">
                        
                        <p style="font-size: 14px; margin: 0; font-weight: 700; color: #1e293b;">
                            <?php 
                                // Verifica se o nome social não está vazio. Se tiver conteúdo, usa ele. Se não, usa o nome real.
                                $nome_exibicao = !empty($_SESSION['NOME_SOCIAL']) ? $_SESSION['NOME_SOCIAL'] : ($_SESSION['NAME'] ?? 'Usuário');
                                
                                echo htmlspecialchars($nome_exibicao);
                            ?>
                        </p>
                        
                        <p style="font-size: 11px; margin: 0; color: #64748b; text-transform: uppercase; font-weight: 900;">
                            <?php 
                                if (isset($_SESSION['TYPE'])) {
                                    // Se for 1 exibe Administrador, senão exibe Comum
                                    echo $_SESSION['TYPE'] == 1 ? 'Administrador' : 'Comum';
                                } else {
                                    echo 'Acesso Indefinido';
                                }
                            ?>
                        </p>
                        
                    </div>
                    
                    <?php 
                        // Se a sessão da foto tiver conteúdo, usa ela. Se estiver vazia, usa o avatar padrão.
                        $foto_perfil = !empty($_SESSION['PHOTO']) ? '../images/' . $_SESSION['PHOTO'] : 'https://i.pravatar.cc/100';
                    ?>
                    <img src="<?php echo htmlspecialchars($foto_perfil); ?>" class="foto-perfil" alt="Avatar" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                </div>
            
            </header>

            <!-- Pesquisa oculta por padrão -->

            <div id="area-resultados-pesquisa" style="display: none;"></div>

            <div class="corpo-dashboard">

            <!-- Conteúdo Principal Graficos -->

            <div class="corpo-dashboard">
                <div class="cabecalho-corpo">
                    <div class="titulo">
                        <h2>Visão Geral</h2>
                        <p style="color: #64748b; font-size: 14px; margin-top: 4px;">Bem-vindo ao centro de comando da IOT Store.</p>
                    </div>
                    <div class="seletor-data">
                        <i class="bi bi-calendar3"></i>
                        <span><?php echo $data_hoje; ?></span>
                    </div>
                </div>

                <div class="grade-metas">
                    <article class="cartao-metas">
                        <div class="cabecalho-metas">
                            <div class="caixa-icone" style="background: #eff6ff; color: #1d4ed8;">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                        </div>
                        <h3>Faturamento</h3>
                        <p class="valor">R$ <?php echo number_format($total_vendas, 2, ',', '.'); ?></p>
                    </article>

                    <article class="cartao-metas">
                        <div class="cabecalho-metas">
                            <div class="caixa-icone" style="background: #f1f5f9; color: #475569;">
                                <i class="bi bi-cpu"></i>
                            </div>
                        </div>
                        <h3>Itens em Estoque</h3>
                        <p class="valor"><?php echo number_format($total_produtos, 0, ',', '.'); ?></p>
                    </article>

                    <article class="cartao-metas">
                        <div class="cabecalho-metas">
                            <div class="caixa-icone" style="background: #fffbeb; color: #b45309;">
                                <i class="bi bi-person-plus"></i>
                            </div>
                        </div>
                        <h3>Clientes Ativos</h3>
                        <p class="valor"><?php echo number_format($total_clientes, 0, ',', '.'); ?></p>
                    </article>

                    <article class="cartao-metas">
                        <div class="cabecalho-metas">
                            <div class="caixa-icone" style="background: #fef2f2; color: #b91c1c;">
                                <i class="bi bi-cart-check"></i>
                            </div>
                        </div>
                        <h3>Total de Pedidos</h3>
                        <p class="valor"><?php echo $total_pedidos; ?></p>
                    </article>
                </div>

                <div class="grade-graficos" style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 30px;">
    
                <div class="cartao-grafico" style="flex: 2; min-width: 300px; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="cabecalho-grafico" style="margin-bottom: 20px;">
                        <h3 style="margin: 0; font-size: 16px;">Desempenho de Vendas</h3>
                    </div>
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="graficoVendas" 
                                data-rotulos='<?php echo json_encode($meses_venda); ?>' 
                                data-valores='<?php echo json_encode($valores_venda); ?>'>
                        </canvas>
                    </div>
                </div>

                <div class="cartao-grafico" style="flex: 1; min-width: 300px; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="cabecalho-grafico" style="margin-bottom: 20px;">
                        <h3 style="margin: 0; font-size: 16px;">Estoque por Categoria</h3>
                    </div>
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="graficoCategorias" 
                                data-rotulos='<?php echo json_encode($nomes_categorias); ?>' 
                                data-valores='<?php echo json_encode($qtd_categorias); ?>'>
                        </canvas>
                    </div>
                </div>

            </div>

                <div class="cartao-pedidos-recentes">
                    <div class="cabecalho-tabela">
                        <h3 style="font-size: 18px; font-weight: 900;">Pedidos Recentes</h3>
                    </div>
                    <div style="overflow-x: auto;">
                        <table class="tabela-dados" style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 1px solid #e2e8f0; text-align: left;">
                                    <th style="padding: 12px;">Código Venda</th>
                                    <th style="padding: 12px;">Cliente</th>
                                    <th style="padding: 12px;">Pagamento</th>
                                    <th style="padding: 12px; text-align: right;">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if ($res_recentes && $res_recentes->num_rows > 0): 
                                    while($pedido = $res_recentes->fetch_assoc()): 
                                ?>
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td style="padding: 12px; font-weight: 700; color: #152738;">VD-<?php echo str_pad($pedido['codigo_venda'], 4, '0', STR_PAD_LEFT); ?></td>
                                        <td style="padding: 12px;"><?php echo htmlspecialchars($pedido['cliente_nome']); ?></td>
                                        <td style="padding: 12px;"><span style="background:#e2e8f0; padding:4px 8px; border-radius:4px; font-size:12px;"><?php echo $pedido['forma_pagamento'] ?: 'N/A'; ?></span></td>
                                        <td style="padding: 12px; text-align: right; font-weight: 900;">R$ <?php echo number_format($pedido['valor_total'], 2, ',', '.'); ?></td>
                                    </tr>
                                <?php 
                                    endwhile; 
                                else: 
                                ?>
                                    <tr>
                                        <td colspan="4" style="padding: 20px; text-align: center; color: #64748b;">Nenhuma venda registrada ainda.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
                       
      </main>
              <footer class="cabecalho-superior p-5 mt-1">
                <div class="titulo">
                    <h5>Gerenciamento Rápido</h5>
                    <p style="color: #64748b; font-size: 14px; margin-top: 4px;">Acesse as principais seções do painel.</p>
                </div>
              <a href="../admin/produtos/Inserir.php" class="btn btn-dark btn-sm">Adicionar Produto</a>
              <a href="../admin/funcionarios/Inserir.php" class="btn btn-dark btn-sm">Adicionar Funcionario</a>
              <a href="../admin/clientes/Inserir.php" class="btn btn-dark btn-sm">Adicionar Cliente</a>
              <a href="../admin/cargos/Inserir.php" class="btn btn-dark btn-sm">Adicionar Cargo</a>
              <a href="../admin/categorias/Inserir.php" class="btn btn-dark btn-sm">Adicionar Categoria</a>
              <a href="../admin/marcas/Inserir.php" class="btn btn-dark btn-sm">Adicionar Marca</a>


              </div>
    </div>
  </div>
  
  <!-- JQUERY CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!-- BOOTSTRAP JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <!-- CHART.JS -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- SCRIPTS PERSONALIZADOS -->
  <script src="../src/script2.js"></script>
    
</body>
</html>