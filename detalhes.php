<?php
// Inclui o arquivo de conexão com o banco de dados
include_once './conexao/conecta.php';

// Iniciando a sessão para gerenciar o estado de autenticação do usuário
if (!isset($_SESSION)) {
    session_start();
}

// Verifica se o ID do produto foi passado na URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    
    // Converte o ID para número inteiro (segurança extra)
    $codigo = intval($_GET['id']); 
    
    // A QUERY COM JOIN: Busca o produto e cruza com categoria e marca
    // IMPORTANTE: Confirme se as tabelas se chamam "categoria" e "marca" e a coluna é "nome"
    $sql = "SELECT p.*, c.nome AS nome_categoria, m.nome AS nome_marca 
            FROM produto p
            LEFT JOIN categoria c ON p.codigo_categoria = c.codigo_categoria
            LEFT JOIN marca m ON p.codigo_marca = m.codigo_marca
            WHERE p.codigo_produto = $codigo"; 

    $query = mysqli_query($conexao, $sql) or die("Erro na Query: " . mysqli_error($conexao)); 
    $produto = mysqli_fetch_assoc($query);

    // Se o ID passado não existir no banco
    if(!$produto) {
        die("<div style='text-align:center; padding:50px;'><h3>Produto não encontrado.</h3><a href='produtos.php'>Voltar para a loja</a></div>");
    }

} else {
    // Se acessar direto sem ID, redireciona
    header("Location: produtos.php");
    exit;
}
?>


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
    <!-- FAVICON -->
    <link rel="shortcut icon" href="../IOT_Store/logo/logotipo_light.png" type="image/x-icon">
</head>
<body>
    
    <div class="site-container">
      <?php 
      // Verifica se o ID do produto foi passado na URL
          if(isset($_GET['codigo_produto']) && $_GET['codigo_produto'] != '')          
          {
              $codigo = intval($_GET['codigo_produto']); // Recebe o código via GET
              $sql = "SELECT p.*, c.nome AS nome_categoria, m.nome AS nome_marca 
                      FROM produto p
                      LEFT JOIN categoria c ON p.codigo_categoria = c.codigo_categoria
                      LEFT JOIN marca m ON p.codigo_marca = m.codigo_marca
                      WHERE p.codigo_produto = '$codigo'";
              

              $query = mysqli_query($conexao, $sql); 
              $produto = mysqli_fetch_assoc($query);
              if(!$produto) {
                  echo "<p>Produto não encontrado.</p>";
                  exit;
              }
          }      
      ?>

          
      <!-- Cabeçalho-->
        <?php
          #Início cabecalho
        include('cabecalho.php');
          #Final cabecalho
        ?>
      
        <!-- Fim do Cabeçalho -->

      <main>
  <div class="conteudo-principal">
  
    <!-- Breadcrumb(Mapa do Site) -->
    <nav class="breadcrumbs">
      <a href="index.php">Inicio</a>
      <span class="separador">/</span>
      <a href="produtos.php">Produtos</a>
      <span class="separador">/</span>
      <span class="atual"><?php echo $produto['nome']; ?></span>
    </nav>

    <!-- Seção principal: galeria + info lado a lado -->

  
    <section class="secao-produto">

      <!-- Galeria -->
      <div class="galeria">
        <div class="imagem-principal">
          <img id="img-destaque" src="./images/<?php echo $produto['foto']; ?>" alt="<?php echo $produto['nome']; ?>"/> 
        </div>
        
        <div class="miniaturas">
          <?php if (!empty($produto['foto'])): ?>
          <div class="miniatura ativa" onclick="trocarImagem(this, '<?php echo $produto['foto']; ?>')">
            <img src="./images/<?php echo $produto['foto']; ?>" alt="Foto 1 de <?php echo $produto['nome']; ?>"/> 
          </div>
          <?php endif; ?>

          <?php 
          for ($i = 2; $i <= 6; $i++) {
              $colunaFoto = 'foto' . $i;
              if (!empty($produto[$colunaFoto])) {
          ?>
              <div class="miniatura" onclick="trocarImagem(this, '<?php echo $produto[$colunaFoto]; ?>')">
                <img src="./images/<?php echo $produto[$colunaFoto]; ?>" alt="Foto <?php echo $i; ?> de <?php echo $produto['nome']; ?>"/>
              </div>
          <?php 
              }
          } 
          ?>
        </div>
      </div>
      <!-- fim .galeria -->

      <!-- Info do produto -->
      <div class="info-produto">
        <div>
          <span class="etiqueta-destaque">Destaque da Semana</span>
          <h1 class="titulo-produto"><?php echo $produto['nome']; ?></h1>
          <div class="avaliacao">
            <div class="estrelas">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star-half-alt"></i>
            </div>
            <span>(128 avaliações)</span>
          </div>
        </div>

        <div class="preco-container">
          <?php 
            // Verifica se o status de promoção está ativo (igual a 1)
            if ($produto['status_promocao'] == 1): 
              // Se estiver em promoção, o valor da parcela usa o preço promocional
              $valorParcela = $produto['preco_promocao'] / 10;
          ?>
              <span style="background-color: var(--primaria); color: white; padding: 3px 8px; border-radius: 5px; font-size: 0.75rem; font-weight: bold; margin-bottom: 5px; display: inline-block;">
              <!-- Calcula o desconto percentual e exibe, ceil arredonda para cima para evitar mostrar 0% quando o desconto for pequeno -->
              <?php echo ceil($produto['desconto_promocao']); ?>% OFF
              </span>

              <p style="text-decoration: line-through; color: #94a3b8; font-size: 1rem; margin-bottom: -5px;">
                <!-- Exibe o preço de venda normal, number_format para formatar o valor em R$ -->
                De: R$ <?php echo number_format($produto['preco_venda'], 2, ',', '.'); ?>
              </p>
              
              <p class="preco-atual" style="color: var(--primaria);"> Por: R$ <?php echo number_format($produto['preco_promocao'], 2, ',', '.'); ?>
              </p>

          <?php 
            else: 
              // Se não estiver em promoção, o valor da parcela usa o preço normal de venda
              $valorParcela = $produto['preco_venda'] / 10;
          ?>
              
              <p class="preco-atual">R$ <?php echo number_format($produto['preco_venda'], 2, ',', '.'); ?></p>
          
          <?php endif; ?>

          <p class="parcelamento">em até 10x de R$ <?php echo number_format($valorParcela, 2, ',', '.'); ?> sem juros</p>
        </div>

        <div class="botoes-acao">
          <!-- Botão Comprar Agora -->
          <a href="carrinho.php?id=<?php echo $produto['codigo_produto']; ?>" style="text-decoration: none; flex: 1;">
              <button class="botao-comprar-agora" style="width: 100%;">
                <i class="fas fa-shopping-bag"></i> Comprar Agora
              </button>
          </a>

          <!-- Botão No Carrinho -->
          <a href="carrinho.php?id=<?php echo $produto['codigo_produto']; ?>" style="text-decoration: none; flex: 1;">
              <button class="botao-no-carrinho" style="width: 100%;">
                <i class="fas fa-cart-plus"></i> No Carrinho
              </button>
          </a>
        </div>

        <div class="calculo-frete" style="margin-bottom: 20px;">
          <p class="frete-titulo" style="font-weight: bold; margin-bottom: 8px;"><i class="fas fa-truck"></i> Calcular Frete</p>
          
          <div class="frete-input-grupo" style="display: flex; gap: 5px;">
            <!-- Adicionado ID cep-destino -->
            <input type="text" id="cep-destino" placeholder="00000-000" style="flex: 1; min-width: 0; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
            
            <!-- Adicionado ID btn-frete e mudado type para button -->
            <button type="button" id="btn-frete" class="botao-frete" style="padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; background: #e2e8f0; color: #334155; font-weight: bold;">OK</button>
          </div>
          
          <!-- Div onde os resultados da API vão aparecer -->
          <div id="resultado-frete" style="margin-top: 15px;"></div>
        </div>

        <div class="grade-recursos">
          <div class="recurso-item">
            <i class="fa-solid fa-tags"></i>
            <div>
              <p class="recurso-label">Marca</p>
              <p class="recurso-valor"><?php echo $produto['nome_marca']; ?></p>
            </div>
          </div>
          <div class="recurso-item">
            <i class="fas fa-layer-group"></i>
            <div>
              <p class="recurso-label">Categoria</p>
              <p class="recurso-valor"><?php echo $produto['nome_categoria']; ?></p>
            </div>
          </div>
          
        </div>
      </div>
      <!-- fim .info-produto -->

    </section>
    <!-- fim .secao-produto -->

    <!-- Especificações Técnicas -->
    <section class="especificacoes">
      <h2>Especificações</h2>
      <table class="tabela-especificacoes">
        <tr>
          <td class="tabela-col-label">Descrição</td>
          <td class="tabela-col-valor"><?php echo $produto['descricao']; ?></td>
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
        <?php 
        // 1. Categoria e o ID do produto atual (que já foram carregados no topo da página)
        $categoria_atual = $produto['codigo_categoria'];
        $codigo_atual = $produto['codigo_produto'];

        // 2. Query: Mesma categoria AND ID diferente do atual. Limitado a 4 itens.
        $sql_relacionados = "SELECT codigo_produto, nome, preco_venda, foto, descricao 
                             FROM produto 
                             WHERE codigo_categoria = '$categoria_atual' 
                             AND codigo_produto != '$codigo_atual' 
                             LIMIT 4";
                             
        $query_relacionados = mysqli_query($conexao, $sql_relacionados);

        // 3. Verifica se o banco retornou algum produto relacionado
        if ($query_relacionados && mysqli_num_rows($query_relacionados) > 0): 
            while($relacionado = mysqli_fetch_assoc($query_relacionados)): 
                // Formata o preço
                $precoRelacionado = number_format($relacionado['preco_venda'], 2, ',', '.');
        ?>
        
        <div class="cartao-produto">
          <div class="cartao-imagem">
            <a href="detalhes.php?id=<?php echo $relacionado['codigo_produto']; ?>">
              <img src="./Produtos/<?php echo $relacionado['foto']; ?>" alt="<?php echo $relacionado['nome']; ?>">
            </a>
          </div>
          <div class="cartao-info">
            <p class="cartao-nome"><?php echo $relacionado['nome']; ?></p>
            <p class="cartao-descricao"><?php echo $relacionado['descricao']; ?></p>
            <p class="cartao-preco">R$ <?php echo $precoRelacionado; ?></p>
          </div>
        </div>

        <?php 
            endwhile; 
        else: 
        ?>
            <p style="color: #64748b; font-size: 0.875rem; grid-column: 1 / -1;">
                Nenhum outro produto encontrado nesta categoria.
            </p>
        <?php endif; ?>
        
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

  <!-- Script para funcionalidades do site -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> 
  <script src="src/script2.js"></script>

  <!-- Script de Cálculo de Frete para a Página de Detalhes -->
    <script>
      $(document).ready(function() {
          
          $('#btn-frete').click(function(e) {
              e.preventDefault();
              
              var cep = $('#cep-destino').val().replace(/\D/g, ''); 
              if(cep.length !== 8) {
                  alert('Por favor, digite um CEP válido com 8 números.');
                  return;
              }

              // Mensagem de carregamento
              $('#resultado-frete').html('<div style="text-align: center; color: #64748b; padding: 10px;"><i class="fas fa-spinner fa-spin"></i> Consultando transportadoras...</div>');

              $.ajax({
                  url: 'calcula_frete.php',
                  method: 'POST',
                  data: { cep_destino: cep },
                  dataType: 'json',
                  success: function(response) {
                      var htmlResultado = '';
                      
                      if(response.erro) {
                          $('#resultado-frete').html('<span style="color: #ef4444; font-size: 0.9rem;">' + response.erro + '</span>');
                          return;
                      }

                      if(response.length > 0) {
                          htmlResultado += '<ul style="list-style: none; padding: 0; margin: 0; border: 1px solid #e2e8f0; border-radius: 6px; overflow: hidden;">';
                          
                          $.each(response, function(index, transportadora) {
                              if(!transportadora.error && transportadora.price) {
                                  // Na página de detalhes, apenas listamos as opções (sem radio buttons)
                                  htmlResultado += `
                                      <li style="display: flex; justify-content: space-between; align-items: center; padding: 12px 15px; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
                                          <div style="display: flex; flex-direction: column;">
                                              <strong style="color: #1e293b; font-size: 0.95rem;">${transportadora.company.name}</strong>
                                              <span style="color: #64748b; font-size: 0.8rem;">${transportadora.name} - Até ${transportadora.delivery_time} dias úteis</span>
                                          </div>
                                          <span style="color: var(--primaria); font-weight: 900; font-size: 1.1rem;">R$ ${transportadora.price.replace('.', ',')}</span>
                                      </li>
                                  `;
                              }
                          });
                          
                          htmlResultado += '</ul>';
                          
                          if(htmlResultado.indexOf('<li') === -1) {
                              $('#resultado-frete').html('<span style="color: #ef4444; font-size: 0.9rem;">Nenhuma opção disponível.</span>');
                          } else {
                              $('#resultado-frete').html(htmlResultado);
                          }
                          
                      } else {
                          $('#resultado-frete').html('<span style="color: #ef4444; font-size: 0.9rem;">CEP não encontrado ou área sem cobertura.</span>');
                      }
                  },
                  error: function() {
                      $('#resultado-frete').html('<span style="color: #ef4444; font-size: 0.9rem;">Erro de conexão com o servidor.</span>');
                  }
              });
          });
      });
    </script>

</body>
       
        
</html>