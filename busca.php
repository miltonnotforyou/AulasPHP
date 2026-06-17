<?php
// Inclui o arquivo de conexão com o banco de dados
require_once __DIR__ . '/conexao/conecta.php';

if(isset($_GET['busca']) && $_GET['busca'] != '') 
{
  $busca = $_GET['busca']; // Pega o termo de busca enviado pela barra de pesquisa
}  


$sql_count = "SELECT COUNT(*) AS quantidade FROM produto WHERE nome LIKE '%$busca%'"; // Cria uma query SQL para contar o número total de produtos cadastrados na tabela "produto". O resultado da contagem será retornado em uma coluna chamada "quantidade".
$query_count = mysqli_query($conexao, $sql_count); // Executa a query de contagem no banco de dados. O resultado será um conjunto de dados com uma única linha e uma coluna chamada 'quantidade', que contém o número total de produtos cadastrados.
$linha = mysqli_fetch_assoc($query_count); // Pega a primeira linha do resultado da query, que contém a contagem total de produtos.
$quantidade = $linha['quantidade']; // A variável $quantidade agora contém o número total de produtos cadastrados no banco de dados. Você pode usar essa variável para exibir a quantidade de produtos ou para configurar a paginação, por exemplo.

$buscapag = "&busca=" . $busca; //


if(isset($_GET['pagina']) && !empty($_GET['pagina'])) 
  {
    $paginaAtual = $_GET['pagina']; // Verifica se a variável 'pagina' foi passada pela URL e se não está vazia. Se for verdade, atribui o valor da página atual à variável $paginaAtual. Isso é útil para implementar a funcionalidade de paginação, permitindo que o usuário navegue entre diferentes páginas de produtos.
  } 
else 
  {
    $paginaAtual = 1; // Página padrão
  }

  $url = "?pagina="; // Base da URL para a paginação. O número da página será adicionado a essa string para criar os links de navegação entre as páginas de produtos.

  //Quantidade de produtos por página
  $paginaQuantidade = 16; // Define a quantidade de produtos que serão exibidos por página. Isso é importante para controlar a quantidade de produtos mostrados ao usuário e para calcular o número total de páginas necessárias para exibir todos os produtos cadastrados.

  //Valor inicial para o LIMIT da query SQL
  $valorInicial = ($paginaAtual * $paginaQuantidade) - $paginaQuantidade; // Calcula o valor inicial para a cláusula LIMIT da query SQL. Isso determina a partir de qual registro os produtos serão exibidos na página atual. Por exemplo, se a página atual for 2 e a quantidade por página for 8, o valor inicial será 8, o que significa que os produtos exibidos começarão a partir do nono registro (índice 8) da tabela de produtos.

  $paginaFinal = ceil($quantidade / $paginaQuantidade); // Calcula o número total de páginas necessárias para exibir todos os produtos cadastrados. A função ceil() é usada para arredondar para cima, garantindo que mesmo que haja um número de produtos que não seja exatamente divisível pela quantidade por página, uma página adicional será criada para exibir os produtos restantes.

  $paginaInicial = 1; // Define a página inicial para a navegação. Normalmente, a página inicial é 1, mas isso pode ser ajustado conforme necessário.
  $paginaProxima = $paginaAtual + 1; // Calcula o número da próxima página. Isso é útil para criar um link de navegação para a próxima página de produtos.
  $paginaAnterior = $paginaAtual - 1; // Calcula o número da página anterior. Isso é útil para criar um link de navegação para a página anterior de produtos.


// Buscando todas as categorias ordenadas por nome
$query_categorias = mysqli_query($conexao, "SELECT * FROM categoria ORDER BY nome ASC");

// Buscando todas as marcas ordenadas por nome
$query_marcas = mysqli_query($conexao, "SELECT * FROM marca ORDER BY nome ASC");

// Buscando o maior preço cadastrado para configurar o limite do Slider
$query_preco = mysqli_query($conexao, "SELECT MAX(preco_venda) as max_preco FROM produto"); // Pega o maior preço de venda registrado na tabela de produtos
$dados_preco = mysqli_fetch_assoc($query_preco); // Se o banco retornar um valor, usamos ele. Caso contrário, definimos um valor padrão (ex: R$ 5000)
$preco_maximo_banco = $dados_preco['max_preco'] ? ceil($dados_preco['max_preco']) : 5000; // O ceil() arredonda para cima, garantindo que o slider tenha um limite inteiro e confortável para o usuário.

// Buscando produtos em promoção (status_promoção = 1)
$query_promocoes = mysqli_query($conexao, "SELECT * FROM produto WHERE status_promocao = 1 ORDER BY nome ASC");

/// 1. Inicia a query SEMPRE com WHERE 1=1 para permitir a adição segura do AND
$sql = "SELECT * FROM produto WHERE status = 1 AND nome LIKE '%$busca%' LIMIT $valorInicial, $paginaQuantidade"; // A cláusula "WHERE 1=1" é uma técnica comum para facilitar a construção dinâmica de consultas SQL. Ela permite que você adicione condições adicionais usando "AND" sem se preocupar com a sintaxe, pois "1=1" é sempre verdadeiro e não afeta o resultado da consulta. O "AND status = 1" é um exemplo para filtrar apenas produtos ativos, mas você pode ajustar essa condição conforme a estrutura do seu banco de dados e os critérios que deseja aplicar.


// 2. Verifica se veio o aviso de promoção pela URL do botão da página inicial
if (isset($_GET['promocao']) && $_GET['promocao'] == '1') {
    $sql .= " AND status_promocao = 1";
}


// 3. Executa a query final
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
</head>
<body>
    
    <div class="site-container">
         <!-- Cabeçalho-->
      <header>
        <div class="caixa-conteudo cabecalho-conteudo">
          <!-- Logotipo com imagem -->
          <a href="/" class="logotipo">
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
        <!-- catalogo container -->
  <div class="catalogo-container caixa-conteudo">

    <!-- SIDEBAR -->
  <aside class="sidebar">
      <div class="sidebar-conteudo">
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
        <!--Exibe a quantidade de produtos mostrados na página atual e o total de produtos cadastrados no banco de dados. A variável $paginaQuantidade representa o número de produtos exibidos por página, enquanto $quantidade representa o total de produtos disponíveis. -->
        <p>Exibindo <span><?php echo mysqli_num_rows($resultado); ?></span> de <?php echo $quantidade; ?> produtos</p> 
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
          <h1 style="color: #0f172a; font-weight: 600;">
              Sua busca: <span style="color: var(--texto-suave);"><?php echo isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : ''; ?></span>
          </h1>
       
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
                    <img src="./Produtos/<?php echo $produto['foto']; ?>" alt="<?php echo $produto['nome']; ?>"/>  
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
                  <p style="color: red;">Nenhum produto encontrado no momento.</p>
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
              <a class="page-link" href="<?php echo $url . $paginaInicial . $buscapag ?>">Início</a>
            </li>
          <?php }?>

          <?php if($paginaAtual >= 2){ ?>  
          <li class="page-item">
              <a class="page-link" href="<?php echo $url . $paginaAnterior . $buscapag ?> " aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
             <?php }?>
             
            <?php if($paginaAtual != $paginaFinal){ ?> 
             <li class="page-item">
                <a class="page-link" href="<?php echo $url . $paginaProxima . $buscapag ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                </a>
              </li>

              <li class="page-item">
                <a class="page-link" href="<?php echo $url . $paginaFinal . $buscapag ?>">Final</a>
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
  <script>
    // Pega o slider e o texto onde o valor vai aparecer
    const precoSlider = document.querySelector('.preco-slider');
    const precoLabel = document.querySelectorAll('.preco-labels span')[1]; 

    // Atualiza o texto visualmente quando arrastar o slider
    if(precoSlider) {
      precoSlider.addEventListener('input', function() {
        let valorFormatado = parseInt(this.value).toLocaleString('pt-BR');
        precoLabel.textContent = 'R$ ' + valorFormatado;
      });
    }

    // --- FUNÇÃO Buscar ---
    function buscar() {
        // 1. Pega todas as categorias marcadas (cria um Array)
        var categoriasSelecionadas = [];
        $('.filtro-categoria:checked').each(function() {
            categoriasSelecionadas.push($(this).val());
        });

        // 2. Pega a marca selecionada (Radio button)
        var marcaSelecionada = $('.filtro-marca:checked').val() || '';

        // 3. Pega o valor do slider de preço
        var precoMax = $('.preco-slider').val();

        // ---> NOVIDADE: Verifica se a caixa de promoção está marcada <---
      // Se estiver marcada, envia '1', se não, envia vazio ('')
      var promocaoAtiva = $('#filtro-promocao').is(':checked') ? '1' : '';

        // 4. Envia para o Tabela.php
        $.ajax({
          url: 'Tabela.php',
          type: 'POST',
          data: {
            categoria: categoriasSelecionadas,
            marca: marcaSelecionada,
            preco_max: precoMax,
            promocao: promocaoAtiva
          },
          success: function(data) {
            // Atualiza a grade de produtos com os novos cartões
            $('.grade-produtos').html(data);
            
            // Opcional: Atualiza o contador de "Exibindo X produtos" (se você criar um ID para ele)
            // $('#contador-produtos').text($('.grade-produtos .cartao-produto').length);
          }
        });
    }

    // Aciona a busca automaticamente sempre que o usuário clicar em uma categoria, marca ou soltar o slider
    $(document).ready(function() {
        $('.filtro-categoria, .filtro-marca, #filtro-promocao').on('change', buscar);
        $('.preco-slider').on('change', buscar); // 'change' no slider dispara quando solta o mouse
    });
  </script>

</body>
</html>