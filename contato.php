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

            <!-- Início do Conteúdo -->
            <section id="conteudo" class="secao-contato caixa-conteudo">
                <div class="cabecalho-secao-contato">
                    <h2>Entre em Contato Conosco</h2>
                    <p>Tem alguma dúvida? Podemos te ajudar com consultores especializados!</p>
                </div>

                <div class="grid-contato">
                    <!-- Formulário -->
                    <div class="cartao-contato">
                        <form action="">
                            <div class="grupo-form">
                                <label for="nome">Nome</label>
                                <input type="text" name="nome" id="nome" placeholder="Insira seu nome" class="txtform" required>
                            </div>

                            <div class="grupo-form">
                                <label for="email">E-mail</label>
                                <input type="email" name="email" id="email" placeholder="Insira seu e-mail" class="txtform" required>
                            </div>

                            <div class="grupo-form">
                                <label for="mensagem">Mensagem</label>
                                <textarea name="mensagem" id="mensagem" placeholder="Digite sua mensagem" class="txtMensagem" required></textarea>
                            </div>

                            <button type="submit" class="btn-form">
                                Enviar Mensagem <i class="fa-solid fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Mapa -->
                    <div class="cartao-mapa">
                       
                        <iframe src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d14719.714655301615!2d-47.655361!3d-22.7308927!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x94c631a09ac7b2e1%3A0x197834b105f878e3!2sSenac%20Piracicaba%20-%20R.%20Santa%20Cruz%2C%201148%20-%20Alto%2C%20Piracicaba%20-%20SP%2C%2013419-030%2C%20Brasil!3m2!1d-22.7285295!2d-47.6455872!5e0!3m2!1spt-BR!2sbr!4v1782924489659!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin" class="mapa"></iframe>
                    </div>
                </div>
            </section>
            <!-- Final do Conteúdo -->

   

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
              <a href="sobreNos.php" class="saiba-mais">
                Saiba mais sobre nós <i class="fa-solid fa-arrow-right"></i>
              </a>
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
                <li><a href="sobreNos.php">Sobre Nós</a></li>
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
