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

      <!-- Botão Mobile devolvido aqui -->
      <button class="botao-icone botao-pesquisa-mobile mobile-only">
        <i class="fa-solid fa-magnifying-glass"></i>
      </button>

      <button class="botao-icone">
        <a href="./admin/Index.php"><i class="fa-regular fa-user"></i></a>
      </button>
      <button class="botao-icone">
        <i class="fa-regular fa-heart"></i>
      </button>
      <button class="botao-carrinho">
        <a href="carrinho.php"><i class="fa-solid fa-cart-shopping"></i></a>
        <span class="contador-carrinho"></span>
      </button>
    </div>
  </div>
</header>