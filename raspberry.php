<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
  <div class="conteudo-principal">

    <!-- Breadcrumb(Mapa do Site) -->
    <nav class="breadcrumbs">
      <a href="index.php">Inicio</a>
      <span class="separador">/</span>
      <a href="produtos.php">Produtos</a>
      <span class="separador">/</span>
      <span class="atual">Raspberry Pi 4</span>
    </nav>

    <!-- Seção principal: galeria + info lado a lado -->
    <section class="secao-produto">

      <!-- Galeria -->
      <div class="galeria">
        <div class="imagem-principal">
          <img src="./Produtos/raspberry1.png" alt="raspberry" referrerpolicy="no-referrer">
        </div>
        <div class="miniaturas">
          <div class="miniatura ativa">
            <img src="./Produtos/raspberry1.png" alt="Miniatura 1" referrerpolicy="no-referrer">
          </div>
          <div class="miniatura">
            <img src="./Produtos/Raspberry_Pi_4_Model_B_-_Side.jpg" alt="Miniatura 2" referrerpolicy="no-referrer">
          </div>
          <div class="miniatura">
            <img src="./Produtos/raspberrypi5_anatomy.jpg" alt="Miniatura 3" referrerpolicy="no-referrer">
          </div>
          <div class="miniatura">
            <img src="./Produtos/capturar-2dogundep4.png" alt="Miniatura 4" referrerpolicy="no-referrer">
          </div>
        </div>
      </div>
      <!-- fim .galeria -->

      <!-- Info do produto -->
      <div class="info-produto">
        <div>
          
          <h1 class="titulo-produto">Raspberry Pi 4</h1>
          <div class="avaliacao">
            <div class="estrelas">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <span>(900 avaliações)</span>
          </div>
        </div>

        <div class="preco-container">
          <p class="preco-atual">R$ 649,00</p>
          <p class="parcelamento">em até 10x de R$ 60,90 sem juros</p>
        </div>

        <div class="botoes-acao">
          <button class="botao-comprar-agora">
            <i class="fas fa-shopping-bag"></i> Comprar Agora
          </button>
          <button class="botao-no-carrinho">
            <i class="fas fa-cart-plus"></i> No Carrinho
          </button>
        </div>

        <div class="calculo-frete">
          <p class="frete-titulo"><i class="fas fa-truck"></i> Calcular Frete</p>
          <div class="frete-input-grupo">
            <input type="text" placeholder="00000-000">
            <button class="botao-frete">OK</button>
          </div>
        </div>

        <div class="grade-recursos">
          <div class="recurso-item">
            <i class="fas fa-tv"></i>
            <div>
              <p class="recurso-label">Resolução</p>
              <p class="recurso-valor">Ultra HD 4K</p>
            </div>
          </div>
          <div class="recurso-item">
            <i class="fa-solid fa-microchip"></i>
            <div>
              <p class="recurso-label">Processador</p>
              <p class="recurso-valor">Broadcom BCM2711</p>
            </div>
          </div>
          <div class="recurso-item">
            <i class="fa-solid fa-memory"></i>
            <div>
              <p class="recurso-label">Memória</p>
              <p class="recurso-valor">8GB</p>
            </div>
          </div>
          <div class="recurso-item">
            <i class="fas fa-microphone"></i>
            <div>
              <p class="recurso-label">Áudio</p>
              <p class="recurso-valor">4-pole stereo audio</p>
            </div>
          </div>
        </div>
      </div>
      <!-- fim .info-produto -->

    </section>
    <!-- fim .secao-produto -->

    <!-- Especificações Técnicas -->
    <section class="especificacoes">
      <h2>Especificações Técnicas</h2>
      <table class="tabela-especificacoes">
        <tr>
          <td class="tabela-col-label">Modelo</td>
          <td class="tabela-col-valor">4 - Versão Oficial</td>
        </tr>
        <tr>
          <td class="tabela-col-label">Mémoria RAM</td>
          <td class="tabela-col-valor">8GB</td>
        </tr>
        <tr>
          <td class="tabela-col-label">Processador</td>
          <td class="tabela-col-valor">Processador quad-core de alto desempenho 64-bit</td>
        </tr>
        <tr>
          <td class="tabela-col-label">Armazenamento</td>
          <td class="tabela-col-valor">MicroSD (até 512GB) e Nuvem</td>
        </tr>
        <tr>
          <td class="tabela-col-label">Conectividade</td>
          <td class="tabela-col-valor">Wi-Fi 2.4GHz / 5GHz & Ethernet RJ45</td>
        </tr>
        <tr>
          <td class="tabela-col-label">Portas USB</td>
          <td class="tabela-col-valor">2 portas USB 3.0 ; 2 portas USB 2.0.</td>
        </tr>
      </table>
    </section>

    <!-- Produtos Relacionados -->
    <section class="produtos-relacionados">
      <div class="relacionados-topo">
        <h2>Produtos Relacionados</h2>
        <a href="produtos.php" class="ver-todos">Ver todos</a>
      </div>
      <div class="grade-produtos">
        <div class="cartao-produto">
          <div class="cartao-imagem">
            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuAZwy7MFIpS-WM7q4oEbci3chaT8cI7ghhRiT1blIE-n4fSd-VHxRGWn_En-9RsikwZTTxzBszQhpib0rt-09NQnpRlwmEXPxfbDoBzyymK4yJu5iMJ94oG9DzCPPcuc8bej5rkbqyQQCxqHFdi16DvHXByl1_PmLkUfQ9EfK-qateAVBvbM58rzLWRVgmo2FgcxXX5UoJEDV-qsXRwVQ4uMuC9bycaQOgPnJpSSRQkYG5Vu2s8ou72bejOcr5jKx5YmwkNf-iFG4-E" alt="Smart Hub" referrerpolicy="no-referrer">
          </div>
          <div class="cartao-info">
            <p class="cartao-categoria">Hubs</p>
            <p class="cartao-nome">Smart Hub Gateway Pro</p>
            <p class="cartao-preco">R$ 189,00</p>
          </div>
        </div>
        <div class="cartao-produto">
          <div class="cartao-imagem">
            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDtstdPqXsFw7j4vlPpPgD1kR3GctDQRdkZg8pb_X-lSZEHZjNNN-zLJXEBq98OASK60bZbQ6yflBLL9mxjNojL9IkbBQ9XSZjym6YrqVuxbtSYkQbyrnYLGChSjMkkkaij3Kc0bTpzxM0G33hXU2uNsbRzBVgQngdYBLv_uFbiXXlg3Dyy0LizdOcP9xl5ZekRTJ7EwIOF_P56ctB4xzb8niOX84-qnnHFKMc0iumv0kbxZev40YvOoeQtzuRqYrK4_Y_1HloO5Hf0" alt="Campainha" referrerpolicy="no-referrer">
          </div>
          <div class="cartao-info">
            <p class="cartao-categoria">Campainhas</p>
            <p class="cartao-nome">Campainha de Vídeo Smart</p>
            <p class="cartao-preco">R$ 245,00</p>
          </div>
        </div>
        <div class="cartao-produto">
          <div class="cartao-imagem">
            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuAmoZqqPv_8IiATZJHQ_I9jjL1Cc5qlRvb9JyZUE3IfZTR2I6n9-uEpgCVw18_fvIRB4DpsiPik7zygPW8JdTKOE1OilpJosHmj_sVfPtSnlh0bamHTyGM2KwFZv6FiPFGSp23uD0NB-jcun-V17Ep-iVkLZPUgIrq5mzQ4Stacmqt48QSMcD-XcM6H9XcRyHsUodOF7F3e84tji2OHkSLdxSXx9ZjhoiUz_oVBWyCZgyFueE3RmTpkO_JtUUHjSLDVgbHNS14b2ACz" alt="Tomada" referrerpolicy="no-referrer">
          </div>
          <div class="cartao-info">
            <p class="cartao-categoria">Energia</p>
            <p class="cartao-nome">Tomada Inteligente Wi-Fi</p>
            <p class="cartao-preco">R$ 89,00</p>
          </div>
        </div>
        <div class="cartao-produto">
          <div class="cartao-imagem">
            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuAMIDPgrK_SU8Dxixs4uupRbbPAHFK7YSLkwi7MVgsOuK51O27QU_OAX9bHVQPNzq_8EC96SVZhoaG2FnGt8N3yC-VkjxP_Q1Wp7aySmSIByxFj3YOMAfKLnCAfP5OwkuPGoNUFQo55WTY0I47k-Q3QfYTmKXvtD3-_yWrhgOijF-ScbTWhPK25Tb3u7veuY1ufeFPayVrcNYqzXwjmoOM5074HwfGXdz95lFZCYuYNAYXCmiDXa3GKvwBETEdPeNk6KufG9TNdN-93" alt="Lâmpada" referrerpolicy="no-referrer">
          </div>
          <div class="cartao-info">
            <p class="cartao-categoria">Iluminação</p>
            <p class="cartao-nome">Lâmpada Inteligente RGB+W</p>
            <p class="cartao-preco">R$ 59,90</p>
          </div>
        </div>
      </div>
    </section>

  </div>
  <!-- fim .conteudo-principal -->
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

</body>
</html>