<?php
// Inclui o arquivo de conexão com o banco de dados
include_once './conexao/conecta.php'; 

// Query usando os nomes EXATOS das colunas da sua tabela
$sql = "SELECT * FROM produto WHERE status = 1 ORDER BY preco_venda LIMIT 8";

// Executa a query. Se der erro, mostra o motivo na tela.
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

    <!-- Slick Carousel -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

    <!-- Arquivo de Estilos CSS -->
    <link rel="stylesheet" href="./src/style.css" />
  </head>
  <body>
    <!-- Container principal que envolve todo o site -->
    <div class="site-container">

      <!-- Cabeçalho do site -->
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

      <main>
        <!-- Seção de Destaque Principal -->
        <section class="destaque-principal">
          <div class="caixa-conteudo">
            <div class="cartao-destaque">
              <!-- Imagem de fundo do destaque -->
              <div class="fundo-destaque" style="background-image: url(./Produtos/Banner.jpg)"></div>
              <!-- Camada de gradiente para melhorar a leitura do texto -->
              <div class="camada-destaque"></div>

              <div class="conteudo-destaque">
                <span class="etiqueta-destaque">Tecnologia do Futuro</span>
                <h2 class="titulo-destaque">Automatize o que importa. Viva o que é essencial!</h2>
                <p class="descricao-destaque">Descubra o futuro da automação residencial com nossa curadoria exclusiva de dispositivos inteligentes.</p>
                <div class="botoes-destaque">
                  <a href="produtos.php"><button class="botao-primario">
                    Ver Coleção <i class="fa-solid fa-arrow-right"></i>
                  </button></a>
                  <a href="produtos.php?promocao=1"><button class="botao-contorno" >Ofertas do Dia</button></a>
                  
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Seção de Produtos em Destaque -->
        <section class="produtos-destaque">
          <div class="caixa-conteudo">
            <div class="cabecalho-secao">
              <div class="titulo-secao">
                <h3>Destaques</h3>
                <p>Os dispositivos mais desejados da temporada</p>
              </div>
              <a href="produtos.php" class="ver-todos">
                Ver todos <i class="fa-solid fa-arrow-up-right-from-square"></i>
              </a>
            </div>

            <!-- Grade de exibição dos produtos -->
            <div class="carrossel-produtos">
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
          </div>
        </section>

        <!-- Banner Promocional com Cupom -->
        <section class="promocao">
          <div class="caixa-conteudo">
            <div class="banner-promocional">
              <div class="texto-promocional">
                <h2>PROMOÇÃO: 10% OFF</h2>
                <p>Em sua primeira compra de dispositivos IoT. Use o cupom abaixo:</p>
                <div class="caixa-cupom">
                  <span class="codigo-cupom">IOT10</span>
                  <button class="botao-cupom">COPIAR</button>
                </div>
              </div>
              <div class="acao-promocional">
              <a href="produtos.php"><button class="botao-grande">Aproveitar Agora</button></a>  
              </div>
            </div>
          </div>
        </section>

        <!-- Seção Institucional: Nossa Missão -->
        <section class="nossa-missao">
          <div class="caixa-conteudo conteudo-missao">
            <div class="moldura-imagem-missao">
              <div class="fundo-imagem-missao"></div>
              <img src="./Produtos/missão.png" alt="Nossa Missão" class="imagem-missao" />
            </div>
            <div class="texto-missao">
              <div class="etiqueta-missao"><span></span> Nossa Missão</div>
              <h2>Liderando a Inovação no seu Dia a Dia</h2>
              <p>Na IoT STORE, não apenas vendemos gadgets; nós projetamos experiências. Nossa curadoria é focada em trazer a inteligência das coisas para a palma da sua mão, tornando sua rotina mais eficiente, segura e conectada.</p>
              <div class="estatisticas-missao">
                <div class="item-estatistica">
                  <span>10k+</span>
                  <p>Produtos Vendidos</p>
                </div>
                <div class="item-estatistica">
                  <span>24h</span>
                  <p>Suporte Técnico</p>
                </div>
              </div>
              <a href="contato.php" class="saiba-mais" >Entre em contato conosco! <i class="fa-solid fa-arrow-right"></i></a>
                          
            </div>
          </div>
        </section>
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
    </div>
    
    <!-- Scripts JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="src/script2.js"></script>
       
  </body>
</html>
