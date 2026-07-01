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
    <!-- FAVICON -->
    <link rel="shortcut icon" href="../IOT_Store/logo/logotipo_light.png" type="image/x-icon">
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

        <!-- Seção de Sobre Nós -->

        <section class="secao-sobre-loja caixa-conteudo">
          
          <div class="grade-sobre-topo">
            
            <div class="cartao-sobre-missao">
              <span class="etiqueta-sobre">Quem Somos</span>
              <h2 class="titulo-sobre-grande">Nossa Missão</h2>
              <p class="texto-sobre-descricao">
                Somos apaixonados por trazer inovação e soluções inteligentes para o seu dia a dia. Nosso objetivo é transformar sua experiência em casa com tecnologia de ponta, oferecendo produtos de automação residencial que garantem conforto, segurança e praticidade absoluta em cada detalhe.
              </p>
              
              <div class="estatisticas-sobre">
                <div class="dado-sobre">
                  <div class="numero-sobre">10k+</div>
                  <div class="legenda-sobre">Produtos Vendidos</div>
                </div>
                <div class="dado-sobre">
                  <div class="numero-sobre">24h</div>
                  <div class="legenda-sobre">Suporte Especializado</div>
                </div>
              </div>
            </div>

            <div class="cartao-imagem-sobre">
              <img src="./images/termostato.png" alt="Tecnologia residencial" class="img-fundo-sobre">
              <div class="camada-escura-sobre"></div>
              
              <div class="caixa-flutuante-glass">
                <div class="icone-destaque-sobre">
                  <i class="fa-solid fa-wand-magic-sparkles"></i>
                </div>
                <h4 class="titulo-glass">Tecnologia que Sente</h4>
                <p class="texto-glass">Dispositivos inteligentes que antecipam suas necessidades térmicas e luminosas de forma invisível.</p>
              </div>
            </div>
            
          </div>

          <div class="pilares-sobre">
            <div class="cabecalho-pilares">
              <h2>Inovação, Qualidade e Compromisso</h2>
              <p>Nossos pilares garantem que cada interação com a tecnologia seja excepcional, duradoura e focada em melhorar sua rotina.</p>
            </div>

            <div class="grade-pilares">
              <div class="cartao-pilar">
                <div class="icone-pilar"><i class="fa-solid fa-lightbulb"></i></div>
                <h3>Inovação</h3>
                <p>Buscamos constantemente as últimas tendências em automação residencial e conectividade para manter sua casa na vanguarda.</p>
              </div>

              <div class="cartao-pilar">
                <div class="icone-pilar"><i class="fa-solid fa-certificate"></i></div>
                <h3>Qualidade</h3>
                <p>Selecionamos produtos testados sob rigorosos padrões para garantir durabilidade, longevidade e performance impecável.</p>
              </div>

              <div class="cartao-pilar">
                <div class="icone-pilar"><i class="fa-solid fa-handshake"></i></div>
                <h3>Compromisso</h3>
                <p>Estamos ao seu lado desde a escolha dos dispositivos até o suporte diário, garantindo uma jornada suave e satisfatória.</p>
              </div>
            </div>
          </div>

          <div class="linha-tempo-sobre">
            <div class="cabecalho-tempo">
              <i class="fa-regular fa-calendar-days"></i>
              <h3>Nossa Trajetória</h3>
            </div>
            
            <div class="grade-trajetoria">
              <div class="item-trajetoria">
                <span class="ano-trajetoria">O Início</span>
                <h4>A Fundação</h4>
                <p>Nascimento da IOT STORE com o desejo de democratizar o acesso à automação residencial de qualidade.</p>
              </div>
              <div class="item-trajetoria">
                <span class="ano-trajetoria">Expansão</span>
                <h4>Catálogo Completo</h4>
                <p>Lançamento oficial da nossa plataforma com uma curadoria exclusiva de dispositivos inteligentes.</p>
              </div>
              <div class="item-trajetoria">
                <span class="ano-trajetoria">Conquista</span>
                <h4>Referência Local</h4>
                <p>Estabelecimento como uma marca de confiança, entregando soluções integradas e suporte técnico avançado.</p>
              </div>
              <div class="item-trajetoria">
                <span class="ano-trajetoria">O Futuro</span>
                <h4>Evolução Contínua</h4>
                <p>Busca constante por novas tendências para tornar os ambientes cada vez mais conectados e eficientes.</p>
              </div>
            </div>
          </div>

        </section>

        <!-- fim da seção Sobre Nós -->
      </main>

      <!-- Rodapé do site -->
      <footer>
        <div class="caixa-conteudo">
          <div class="grade-rodape">
            <!-- Informações da marca e redes sociais -->
            <div class="informacao-rodape">
              <a href="index.php" class="logotipo-rodape">
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
