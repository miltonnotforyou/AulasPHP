<?php
// Inclui o arquivo de conexão com o banco de dados
include_once './conexao/conecta.php'; 

// Query usando os nomes EXATOS das colunas da tabela
$sql = "SELECT codigo_produto, nome, descricao, preco_venda, foto FROM produto LIMIT 8";

// Executa a query. Se der erro, mostra o motivo na tela.
$resultado = mysqli_query($conexao, $sql) or die("Erro no Banco de Dados: " . mysqli_error($conexao));

// 1. Inicia a query base com WHERE 1=1 para facilitar a concatenação
$sql = "SELECT codigo_produto, nome, descricao, preco_venda, foto FROM produto WHERE 1=1";

// 2. Verifica se o filtro de MARCA foi acionado
if (!empty($_GET['marca'])) {
    $marca_id = mysqli_real_escape_string($conexao, $_GET['marca']);
    $sql .= " AND codigo_marca = '$marca_id'";
}

// 3. Verifica se o filtro de PREÇO MÁXIMO foi acionado
if (!empty($_GET['preco_max'])) {
    $preco_max = (float)$_GET['preco_max'];
    $sql .= " AND preco_venda <= $preco_max";
}

// 4. Verifica se o filtro de CATEGORIA (checkboxes) foi acionado
if (!empty($_GET['categoria'])) {
    // Como é um array (vários checkboxes podem estar marcados), transformamos em uma string separada por vírgulas
    $categorias = array_map('intval', $_GET['categoria']);
    $lista_categorias = implode(',', $categorias);
    $sql .= " AND codigo_categoria IN ($lista_categorias)";
}

// Executa a query final com os filtros aplicados
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
            <i class="fa-solid fa-magnifying-glass icone-pesquisa"></i>
            <input type="text" placeholder="Pesquisar dispositivos inteligentes..." />
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
        <form action="" method="GET">

        <div class="filtro-section">
          <h3>Categorias</h3>
          <div class="filtro-grid">
            <label class="filtro-item">
              <input type="checkbox" checked>
              <span>Segurança</span>
            </label>
            <label class="filtro-item">
              <input type="checkbox">
              <span>Iluminação</span>
            </label>
            <label class="filtro-item">
              <input type="checkbox">
              <span>Conectividade</span>
            </label>
            <label class="filtro-item">
              <input type="checkbox">
              <span>Energia</span>
            </label>
          </div>
        </div>

        <div class="filtro-section"> 
          <h3>Faixa de Preço</h3>
          <input class="preco-slider" type="range" min="0" max="5000"> <!-- filtro de faixa de preço do sidebar -->          
          <div class="preco-labels">
            <span>R$ 0</span>
            <span>R$ 5.000</span>
          </div>
        </div>

        <div class="filtro-section">
          <h3>Marcas</h3>
          <div class="filtro-grid">
            <label class="filtro-item">
              <input type="radio" name="marca">
              <span>SmartLife</span>
            </label>
            <label class="filtro-item">
              <input type="radio" name="marca">
              <span>Tuya</span>
            </label>
            <label class="filtro-item">
              <input type="radio" name="marca">
              <span>Sonoff</span>
            </label>
          </div>
        </div>
        </form>
      </div>
    </aside>
    <!-- Fim do SIDEBAR -->

    <!-- ÁREA DE PRODUTOS -->
    <div class="area-produtos">

      <!-- Barra de ferramentas -->
      <div class="barra-ferramentas">
        <p>Exibindo <span>8</span> de 48 produtos</p>
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
                  <p>Nenhum produto em destaque no momento.</p>
              <?php endif; ?>
            </div>
      <!-- fim .grade-produtos -->

    </div>
    <!-- fim area produtos -->

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
    
    <script>
  // Pega o slider e o texto onde o valor vai aparecer
  const precoSlider = document.querySelector('.preco-slider');
  const precoLabel = document.querySelectorAll('.preco-labels span')[1]; // Pega o segundo span (o do valor máximo)

  // Atualiza o texto sempre que o usuário arrastar o slider
  if(precoSlider) {
    precoSlider.addEventListener('input', function() {
      // Formata o número para o padrão de moeda (ex: 5000 -> 5.000)
      let valorFormatado = parseInt(this.value).toLocaleString('pt-BR');
      precoLabel.textContent = 'R$ ' + valorFormatado;
    });
  }
</script>
</body>
</html>