<?php
// Inclui o arquivo de conexão com o banco de dados
require_once __DIR__ . '/conexao/conecta.php';

// 1. INICIALIZA AS CONDIÇÕES DOS FILTROS
// Começamos com uma string vazia e vamos adicionando os filtros conforme o que vier na URL
$condicoes = "";

// Verifica se veio o aviso de promoção pela URL
if (isset($_GET['promocao']) && $_GET['promocao'] == '1') {
    $condicoes .= " AND status_promocao = 1";
}

// Verifica se existe uma busca (implementado no passo anterior)
if (isset($_GET['busca']) && !empty(trim($_GET['busca']))) {
    $busca = mysqli_real_escape_string($conexao, $_GET['busca']);
    $condicoes .= " AND nome LIKE '%$busca%'";
}

// (Você pode adicionar outros filtros aqui usando a mesma lógica do $condicoes .= " AND ...")


// 2. CONTA O TOTAL DE PRODUTOS (Respeitando os filtros criados acima)
// Cria uma query SQL para contar o número de produtos ativos E que atendam aos filtros
$sql_count = "SELECT COUNT(*) AS quantidade FROM produto WHERE status = 1" . $condicoes; 
$query_count = mysqli_query($conexao, $sql_count); 
$linha = mysqli_fetch_assoc($query_count); 
// A variável $quantidade agora contém o número Y (total de produtos filtrados)
$quantidade = $linha['quantidade']; 


// 3. CONFIGURAÇÕES DA PAGINAÇÃO
if(isset($_GET['pagina']) && !empty($_GET['pagina'])) {
    $paginaAtual = (int)$_GET['pagina']; 
} else {
    $paginaAtual = 1; // Página padrão
}

// Lógica para manter os filtros na URL ao trocar de página
$parametros_get = $_GET;
unset($parametros_get['pagina']); // Remove a página atual para montar a base
$query_string = http_build_query($parametros_get); // Monta os filtros (ex: busca=lampada&promocao=1)
// Base da URL para a paginação inteligente
$url = "?" . ($query_string ? $query_string . "&" : "") . "pagina="; 

$paginaQuantidade = 16; // Quantidade de produtos por página

// Valor inicial para o LIMIT da query SQL
$valorInicial = ($paginaAtual * $paginaQuantidade) - $paginaQuantidade; 

$paginaFinal = ceil($quantidade / $paginaQuantidade); 
if ($paginaFinal == 0) $paginaFinal = 1; // Evita que a página final seja 0 caso a busca não retorne nada

$paginaInicial = 1; 
$paginaProxima = $paginaAtual + 1; 
$paginaAnterior = $paginaAtual - 1; 


// 4. QUERIES SECUNDÁRIAS (Sidebar)
// Buscando todas as categorias ordenadas por nome
$query_categorias = mysqli_query($conexao, "SELECT * FROM categoria ORDER BY nome ASC");

// Buscando todas as marcas ordenadas por nome
$query_marcas = mysqli_query($conexao, "SELECT * FROM marca ORDER BY nome ASC");

// Buscando o maior preço cadastrado para configurar o limite do Slider
$query_preco = mysqli_query($conexao, "SELECT MAX(preco_venda) as max_preco FROM produto"); 
$dados_preco = mysqli_fetch_assoc($query_preco); 
$preco_maximo_banco = $dados_preco['max_preco'] ? ceil($dados_preco['max_preco']) : 5000; 


// 5. QUERY PRINCIPAL (Buscando os produtos da página atual)
// Junta o WHERE base (status = 1), os filtros dinâmicos e, por fim, o LIMIT da paginação
$sql = "SELECT * FROM produto WHERE status = 1 " . $condicoes . " LIMIT $valorInicial, $paginaQuantidade"; 

// Executa a query final
$resultado = mysqli_query($conexao, $sql) or die("Erro no Banco de Dados: " . mysqli_error($conexao));
?>

<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>IOT STORE - Tecnologia de Ponta</title>

    <meta name="author" content="Milton Silva">

    <!-- FontAwesome (ícones) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Script do jQuery Ajax -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Arquivo de Estilos CSS -->
    <link rel="stylesheet" href="./src/style.css" />
    <!-- FAVICON -->
    <link rel="shortcut icon" href="../IOT_Store/logo/logotipo_light.png" type="image/x-icon">
</head>
<body>
    
    <div class="site-container">
         <!-- Cabeçalho-->
      <header>
        <div class="caixa-conteudo cabecalho-conteudo">
          <!-- Logotipo com imagem -->
          <a href="index.php" class="logotipo">
            <img src="./logo/logotipo_light.png" alt="IOT STORE Logo" class="logotipo-img">
          </a>

          <!-- Barra de pesquisa de produtos -->
        <div class="barra-pesquisa">
          <form action="busca.php" method="GET">
            <button type="submit"><i class="fa-solid fa-magnifying-glass icone-pesquisa"></i></button>
            <input type="text" name="busca" placeholder="Pesquisar dispositivos inteligentes..." />            
          </form>
        </div>

       
          <!-- Ações do usuário (perfil, favoritos, carrinho) -->
          <div class="cabecalho-acoes">

          <button class="botao-icone" id="btn-tema" title="Alternar Tema">
              <i class="fa-solid fa-moon"></i>
            </button>
  
          <button class="botao-icone botao-pesquisa-mobile mobile-only">
            <i class="fa-solid fa-magnifying-glass"></i>
          </button>

          <button class="botao-icone">
            <i class="fa-regular fa-user"></i>
          </button>
          <button class="botao-icone">
            <i class="fa-regular fa-heart"></i>
          </button>
          <button class="botao-carrinho">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="contador-carrinho">10</span>
          </button>
        </div>
        </div>
      </header>
        <!-- Fim do Cabeçalho -->
      
<main>
    <button class="botao-abrir-filtros mobile-only">
  <i class="fa-solid fa-filter"></i> Filtrar Produtos
    </button>
    
        <!-- catalogo container -->
  <div class="catalogo-container caixa-conteudo">

    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="sidebar-conteudo">
        <button class="botao-fechar-filtros mobile-only">
          <i class="fa-solid fa-xmark"></i> Fechar
        </button>
        <form id="form-filtros">

    <!-- Promoções -->
        <div class="filtro-section">
          <h3>Promoções</h3>
          <div class="filtro-grid">
            <label class="filtro-item">
              <input type="checkbox" id="filtro-promocao" value="1" <?php echo (isset($_GET['promocao']) && $_GET['promocao'] == '1') ? 'checked' : ''; ?>>
              <span style="color: #ef4444; font-weight: 600;">
                <i class="fa-solid fa-tag"></i> Ofertas Especiais
              </span> 
            </label>
          </div>
        </div>

    <!-- CATEGORIAS -->
        <div class="filtro-section" style = "padding:30px 0 30px 0;">
          <h3>Categorias</h3>
          <div class="filtro-grid">
            <?php 
            // Verifica se a query funcionou e se existe pelo menos 1 categoria no banco
            if ($query_categorias && mysqli_num_rows($query_categorias) > 0) 
              // Inicia o loop: roda uma vez para cada categoria encontrada no banco
              {
                while($cat = mysqli_fetch_assoc($query_categorias)): 
            ?>
                <label class="filtro-item">
                  <input type="checkbox" class="filtro-categoria" value="<?php echo $cat['codigo_categoria']; ?>">
                  
                  <span><?php echo $cat['nome']; ?></span> 
                </label>
            <?php 
                endwhile; // Fim do loop das categorias
              } else
            // Mensagem de segurança caso a tabela de categorias esteja vazia
            {                
                echo "<p style='font-size: 12px; color: #666;'>Nenhuma categoria cadastrada.</p>";
            }
            ?>
          </div>
        </div>

    <!-- PREÇO -->
        <div class="filtro-section" style = "padding:30px 0 30px 0;"> 
          <h3>Faixa de Preço</h3>
          <input class="preco-slider" type="range" min="0" max="<?php echo $preco_maximo_banco; ?>" value="<?php echo $preco_maximo_banco; ?>">       
          
          <div class="preco-labels">
            <span>R$ 0</span>
            <span>R$ <?php echo number_format($preco_maximo_banco, 2, ',', '.'); ?></span>
          </div>
        </div>

    <!-- MARCAS -->
        <div class="filtro-section" style = "padding:30px 0 30px 0;">
          <h3>Marcas</h3>
          <div class="filtro-grid">
            <?php 
            // Verifica se a query funcionou e se existem marcas cadastradas
            if ($query_marcas && mysqli_num_rows($query_marcas) > 0) 
              // Inicia o loop das marcas
              {
                while($marca = mysqli_fetch_assoc($query_marcas)): 
            ?>
                <label class="filtro-item">
                  <input type="radio" class="filtro-marca" name="marca" value="<?php echo $marca['codigo_marca']; ?>">
                  
                  <span><?php echo $marca['nome']; ?></span>
                </label>
            <?php 
                endwhile; // Fim do loop das marcas
              } else 
              // Mensagem de segurança caso a tabela de marcas esteja vazia
              {
                echo "<p style='font-size: 12px; color: #666;'>Nenhuma marca cadastrada.</p>";
              }
            ?>
          </div>
        </div>
    
    <!-- BOTÃO LIMPAR FILTROS -->
        <button type="reset" class="botao-grande" onclick="setTimeout(buscar, 100)">Limpar Filtros</button>

        </form>
      </div>
    </aside>
    
    <!-- Fim do SIDEBAR -->

    <!-- ÁREA DE PRODUTOS -->
    <div class="area-produtos">

      <!-- Barra de ferramentas -->
      <div class="barra-ferramentas">
      <?php if ($quantidade > 0): ?>
        <p>Exibindo <span><?php echo mysqli_num_rows($resultado); ?></span> de <?php echo $quantidade; ?> produtos</p>
      <?php else: ?>
        <p>Nenhum produto encontrado para estes filtros.</p>
      <?php endif; ?>
    
        
        <div class="organizar-container">
          <label class="organizar-label">Ordenar por:</label>
          <select class="organizar-select">
            <option>Mais relevantes</option>
            <option>Menor preço</option>
            <option>Maior preço</option>
            <option>Novidades</option>
          </select>
        </div>
      </div>

      <!-- Cabeçalho da seção -->
      <div class="cabecalho-secao">
        <div class="titulo-secao">
          <h1>Dispositivos Inteligentes</h1>
          <p>Transforme seu ambiente com o que há de mais avançado em conectividade e automação residencial</p>
        </div>
        <nav class="breadcrumbs">
          <a href="index.php">Home</a>
          <span class="separador">/</span>
          <span class="atual">Produtos</span>
          <i class="fa-solid fa-arrow-up-right-from-square"></i>
        </nav>
      </div>

      <!-- Grade de produtos -->
      <div class="grade-produtos">
              <?php 
              if (mysqli_num_rows($resultado) > 0): // Verifica se há produtos retornados pela query
                  while($produto = mysqli_fetch_assoc($resultado)): 
                      // Puxando da coluna 'preco_venda'
                      $precoFormatado = number_format($produto['preco_venda'], 2, ',', '.'); // Formata o preço para o formato brasileiro (R$ 1.234,56)
              ?>
              
              <div class="cartao-produto">
                <div class="imagem-produto">
                  <!-- Link para a página de detalhes do produto, passando o código do produto como parâmetro -->
                  <a href="detalhes.php?id=<?php echo $produto['codigo_produto']; ?>">  
                    <!-- // Exibe a imagem do produto, usando o caminho armazenado na coluna 'foto' da tabela. -->
                    <img src="./images/<?php echo $produto['foto']; ?>" alt="<?php echo $produto['nome']; ?>"/>  
                  </a>
                </div>
                <h4 class="nome-produto"><?php echo $produto['nome']; ?></h4>
                <p class="descricao-produto"><?php echo $produto['descricao']; ?></p>
                <div class="rodape-produto">
                  <span class="preco-produto">R$ <?php echo $precoFormatado; ?></span>
                  <button class="botao-adicionar-carrinho">
                    <i class="fa-solid fa-cart-shopping"></i>
                  </button>
                </div>
              </div>

              <?php 
                  endwhile; 
              else: 
              ?>
                  <p>Nenhum produto em destaque no momento.</p>
              <?php endif; ?>
            </div>
      <!-- fim .grade-produtos -->

    </div>

    </div>
    <!-- fim area produtos -->

    <!--------------------------- paginação-------------------------------------------------------------------------------->
    <div class="paginacao-container">
      <nav aria-label="paginacao">
          <ul class="pagination justify-content-center">
             
          <?php if($paginaAtual != $paginaInicial){ ?>
            <li class="page-item">
              <a class="page-link" href="<?php echo $url . $paginaInicial?>">Início</a>
            </li>
          <?php }?>

          <?php if($paginaAtual >= 2){ ?>  
          <li class="page-item">
              <a class="page-link" href="<?php echo $url . $paginaAnterior ?> " aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
             <?php }?>
             
            <?php if($paginaAtual != $paginaFinal){ ?> 
             <li class="page-item">
                <a class="page-link" href="<?php echo $url . $paginaProxima ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                </a>
              </li>

              <li class="page-item">
                <a class="page-link" href="<?php echo $url . $paginaFinal ?>">Final</a>
              </li>
           <?php }?> 

          </ul>
        </nav>
      </div>
    </div>
  <!-- fim catalogo container -->

</main>
     
    <!-- Rodapé do site -->
      <footer>
        <div class="caixa-conteudo">
          <div class="grade-rodape">

            <!-- Informações da marca e redes sociais -->
            <div class="informacao-rodape">
              <a href="/" class="logotipo-rodape">
                <div class="logotipo-rodape-icone">
                 <img src="./logo/logotipo_light.png" alt="IOT STORE Logo" class="logotipo-img"> 
                </div>
                <h2 class="logotipo-texto">IOT STORE</h2>
              </a>
              <p class="descricao-rodape">Sua parceira premium em automação e tecnologia inteligente para casa e negócios.</p>
              <div class="links-sociais">
                <a href="https://www.linkedin.com/in/milton-nascimento-alves-da-silva/" target="_blank" class="botao-social"><i class="fa-brands fa-linkedin"></i></a>
                <a href="https://www.facebook.com/profile.html?id=100013903541113" target="_blank" class="botao-social"><i class="fa-brands fa-facebook"></i></a>
                <a href="https://www.instagram.com/mnsilvanavegantes/" target="_blank" class="botao-social"><i class="fa-brands fa-instagram"></i></a>
                <a href="https://web.whatsapp.com/" target="_blank" class="botao-social"><i class="fa-brands fa-whatsapp"></i></a>
              </div>
            </div>

            <!-- Colunas de links institucionais -->
            <div class="coluna-rodape">
              <h4>Institucional</h4>
              <ul>
                <li><a href="#">Sobre Nós</a></li>
                <li><a href="#">Minha Conta</a></li>
                <li><a href="#">Trabalhe Conosco</a></li>
                <li><a href="#">Blog Tech</a></li>
              </ul>
            </div>

            <div class="coluna-rodape">
              <h4>Informações</h4>
              <ul>
                <li><a href="#">Política de Entrega</a></li>
                <li><a href="#">Privacidade e Segurança</a></li>
                <li><a href="#">Trocas e Devoluções</a></li>
                <li><a href="#">FAQ</a></li>
              </ul>
            </div>

            <!-- Informações de contato -->
            <div class="coluna-rodape">
              <h4>Contato</h4>
              <ul class="lista-contato">
                <li><i class="fa-solid fa-phone"></i> (19) 4002-8922</li>
                <li><i class="fa-solid fa-envelope"></i> contato@iotstore.com.br</li>
                <li><i class="fa-regular fa-clock"></i> Seg - Sex: 09h às 18h</li>
              </ul>
            </div>
          </div>

          <!-- Parte inferior do rodapé com selos e direitos autorais -->
          <div class="rodape-inferior">
            <div class="item-rodape-inferior">
              <span>Pagamento</span>
              <div class="icones-pagamento">
                <a href="https://www.visa.com.br" target="_blank" class="botao-social"><i class="fa-brands fa-cc-visa"></i></a>
                <a href="https://www.mastercard.com" target="_blank" class="botao-social"><i class="fa-brands fa-cc-mastercard"></i></a>
                <a href="https://www.bcb.gov.br/estabilidadefinanceira/pix" target="_blank" class="botao-social"><i class="fa-brands fa-pix"></i></a>
                
              </div>
            </div>
            <div class="item-rodape-inferior">
              <span>Segurança</span>
              <div class="icones-seguranca">
                <i class="fa-solid fa-shield-halved" style="color: #10b981;"></i>
                <i class="fa-solid fa-circle-check" style="color: #3b82f6;"></i>
              </div>
            </div>
            <p class="direitos-autorais">&copy; 2026 IOT STORE. Todos os direitos reservados.</p>
            <p class="direitos-autorais">Desenvolvido por <a href="https://github.com/miltonnotforyou" target="_blank">Milton Silva
            <i class="fa-brands fa-github"></i></a></p>
          </div>
        </div>
      </footer>
    <!-- Fim Rodapé do site -->

    </div>
    
    <!-- Script para funcionalidades do site -->
  <script src="src/script2.js"></script>

</body>
</html>