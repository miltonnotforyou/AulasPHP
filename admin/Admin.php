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
  <link rel="shortcut icon" href="../assets/img/favicon.ico" type="image/x-icon">


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

              <!-- Conteúdo Principal -->
        <main class="conteudo-principal">
            <header class="cabecalho-superior">
                <div class="barra-pesquisa">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Pesquisar sistemas, dispositivos...">
                </div>

                <div class="perfil-usuario">
                    <div style="text-align: right;">
                      
                        <p style="font-size: 12px; color: #64748b; text-transform: uppercase; font-weight: 900;">Administrador</p>
                    </div>
                    <img src="https://i.pravatar.cc/100" class="foto-perfil" alt="Avatar">
                </div>
            </header>

            <div class="corpo-dashboard">
                <div class="cabecalho-corpo">
                    <div class="titulo">
                        <h2>Visão Geral</h2>
                        <p style="color: #64748b; font-size: 14px; margin-top: 4px;">Bem-vindo ao centro de comando da IOT Store.</p>
                    </div>
                    <div class="seletor-data">
                        <i class="bi bi-calendar3"></i>
                        <span>01 Abril, 2025 - 30 Abril, 2025</span>
                        <i class="bi bi-chevron-down"></i>
                    </div>
                </div>

                <!-- Cartões de Metas -->
                <div class="grade-metas">
                    <article class="cartao-metas">
                        <div class="cabecalho-metas">
                            <div class="caixa-icone" style="background: #eff6ff; color: #1d4ed8;">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                            <span class="etiqueta-tendencia">+12%</span>
                        </div>
                        <h3>Total de Vendas</h3>
                        <p class="valor">R$ 45.280,00</p>
                    </article>

                    <article class="cartao-metas">
                        <div class="cabecalho-metas">
                            <div class="caixa-icone" style="background: #f1f5f9; color: #475569;">
                                <i class="bi bi-cpu"></i>
                            </div>
                            <span class="etiqueta-tendencia">+5%</span>
                        </div>
                        <h3>Dispositivos Ativos</h3>
                        <p class="valor">1.240</p>
                    </article>

                    <article class="cartao-metas">
                        <div class="cabecalho-metas">
                            <div class="caixa-icone" style="background: #fffbeb; color: #b45309;">
                                <i class="bi bi-person-plus"></i>
                            </div>
                            <span class="etiqueta-tendencia">+8%</span>
                        </div>
                        <h3>Novos Clientes</h3>
                        <p class="valor">156</p>
                    </article>

                    <article class="cartao-metas">
                        <div class="cabecalho-metas">
                            <div class="caixa-icone" style="background: #fef2f2; color: #b91c1c;">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <span class="etiqueta-tendencia" style="color: #b91c1c; background: #fee2e2;">Atenção</span>
                        </div>
                        <h3>Pedidos Pendentes</h3>
                        <p class="valor">24</p>
                    </article>
                </div>

                 <!-- Grade de Gráficos -->
                <div class="grade-graficos">
                    <!-- Desempenho de Vendas -->
                    <div class="cartao-grafico">
                        <div class="cabecalho-grafico">
                            <h3>Desempenho de Vendas</h3>
                            <a href="#" class="link-exportar"><button class="btn btn-dark btn-sm">Exportar Relatório</button></a>
                        </div>
                        <div class="container-barras">
                            <div class="coluna-barra">
                                <div class="barra barra-jun" style="height: 35%;"></div>
                                <span class="rotulo-mes">Jun</span>
                            </div>
                            <div class="coluna-barra">
                                <div class="barra barra-jul" style="height: 55%;"></div>
                                <span class="rotulo-mes">Jul</span>
                            </div>
                            <div class="coluna-barra">
                                <div class="barra barra-ago" style="height: 45%;"></div>
                                <span class="rotulo-mes">Ago</span>
                            </div>
                            <div class="coluna-barra">
                                <div class="barra barra-set" style="height: 85%;"></div>
                                <span class="rotulo-mes">Set</span>
                            </div>
                            <div class="coluna-barra">
                                <div class="barra barra-out" style="height: 100%;"></div>
                                <span class="rotulo-mes">Out</span>
                            </div>
                        </div>
                    </div>

                    <!-- Distribuição por Categoria -->
                    <div class="cartao-grafico">
                        <div class="cabecalho-grafico">
                            <h3>Distribuição por Categoria</h3>
                        </div>
                        <div class="container-rosca">
                            <div class="rosca-grafico">
                                <div class="rosca-texto">
                                    <span class="numero">1.2k</span>
                                    <span class="unidade">Unidades</span>
                                </div>
                            </div>
                            <div class="legenda-rosca">
                                <div class="item-legenda">
                                    <div class="categoria">
                                        <div class="ponto-cor" style="background: #152738;"></div>
                                        Segurança
                                    </div>
                                    <span class="porcentagem">42%</span>
                                </div>
                                <div class="item-legenda">
                                    <div class="categoria">
                                        <div class="ponto-cor" style="background: #64748b;"></div>
                                        Iluminação
                                    </div>
                                    <span class="porcentagem">28%</span>
                                </div>
                                <div class="item-legenda">
                                    <div class="categoria">
                                        <div class="ponto-cor" style="background: #443621;"></div>
                                        Centrais (Hubs)
                                    </div>
                                    <span class="porcentagem">18%</span>
                                </div>
                                <div class="item-legenda">
                                    <div class="categoria">
                                        <div class="ponto-cor" style="background: #cbd5e1;"></div>
                                        Sensores
                                    </div>
                                    <span class="porcentagem">12%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabela de Pedidos -->
                <div class="cartao-pedidos-recentes">
                    <div class="cabecalho-tabela">
                        <h3 style="font-size: 18px; font-weight: 900;">Pedidos Recentes</h3>
                        <button class="btn btn-dark btn-sm">Ver Todos</button>
                    </div>
                    <div style="overflow-x: auto;">
                        <table class="tabela-dados">
                            <thead>
                                <tr>
                                    <th>Código Venda</th>
                                    <th>Cliente</th>
                                    <th>Produto</th>
                                    <th>Status</th>
                                    <th style="text-align: right;">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="font-weight: 700; color: #152738;">#NX-8234</td>
                                    <td>Chilindrina de las Nieves</td>
                                    <td>Smart Hub Pro v2</td>
                                    <td><span class="badge-status status-entregue">Entregue</span></td>
                                    <td style="text-align: right; font-weight: 900;">R$ 849,00</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 700; color: #152738;">#NX-8235</td>
                                    <td>Florinda Meza</td>
                                    <td>Kit Iluminação WiFi</td>
                                    <td><span class="badge-status status-processando">Processando</span></td>
                                    <td style="text-align: right; font-weight: 900;">R$ 1.250,00</td>
                                </tr>
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
</body>
</html>