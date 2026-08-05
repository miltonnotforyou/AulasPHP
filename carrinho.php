<?php
// Inclui o arquivo de conexão com o banco de dados
include_once './conexao/conecta.php';

// Iniciando a sessão para gerenciar o estado de autenticação do usuário e os itens do carrinho
if (!isset($_SESSION)) {
    session_start();
}

$produto = null;

// Verifica se um ID foi passado na URL (ex: quando o usuário clica em "Adicionar ao Carrinho")
if(isset($_GET['id']) && !empty($_GET['id'])) {
    
    $codigo = intval($_GET['id']); 
    
    $sql = "SELECT p.*, c.nome AS nome_categoria, m.nome AS nome_marca 
            FROM produto p
            LEFT JOIN categoria c ON p.codigo_categoria = c.codigo_categoria
            LEFT JOIN marca m ON p.codigo_marca = m.codigo_marca
            WHERE p.codigo_produto = $codigo"; 

    $query = mysqli_query($conexao, $sql) or die("Erro na Query: " . mysqli_error($conexao)); 
    $produto = mysqli_fetch_assoc($query);

    // Se um ID foi passado, mas não existe no banco, você pode avisar o usuário
    if(!$produto) {
        $erro_produto = "Produto não encontrado.";
    } else {
        // 1 Se o carrinho ainda não existir na sessão, criamos um array vazio
            if (!isset($_SESSION['carrinho'])) {
                $_SESSION['carrinho'] = array();
            }

            // 2️ Verifica se o produto já está no carrinho
            if (isset($_SESSION['carrinho'][$codigo])) {
                // Se já estiver, apenas aumentamos a quantidade em 1
                $_SESSION['carrinho'][$codigo] += 1;
            } else {
                // Se não estiver, adicionamos ao carrinho com a quantidade inicial de 1
                $_SESSION['carrinho'][$codigo] = 1;
            }
                }
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
      <a href="carrinho.php">Carrinho</a>
      <span class="separador">/</span>
      <span class="atual"><?php echo $produto['nome']; ?></span>
    </nav>

      <!-- ==================== CONTEÚDO PRINCIPAL (CARRINHO) ==================== -->
  <main class="container-principal">
    
    <!-- Seção do Título da Página -->
    <section class="secao-titulo-pagina">
      <h1 class="titulo-pagina">Seu Carrinho</h1>
      <p class="subtitulo-pagina">Revise seus itens e finalize sua compra com segurança.</p>
    </section>

    <!-- Estrutura do Carrinho em Grade (Layout Principal) -->
    <div class="grade-carrinho">
      
      <!-- LADO ESQUERDO: Lista de Produtos Adicionados -->
     <section class="lista-itens-carrinho">
    <?php
    
    // Verifica se o carrinho existe e se tem itens
    if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0): 
        $valor_total = 0;
        // Percorre cada item do carrinho
        // $codigo_produto é a chave (ID) e $quantidade é o valor salvo
        foreach ($_SESSION['carrinho'] as $codigo_produto => $quantidade):
            
            // 1. Fazemos um SELECT no banco buscando o produto por este $codigo_produto
            $sql = "SELECT * FROM produto WHERE codigo_produto = $codigo_produto";
            $query = mysqli_query($conexao, $sql);
            $produto = mysqli_fetch_assoc($query);

            // 2. Formatamos o preço
            $precoFormatado = number_format($produto['preco_venda'], 2, ',', '.');
            $valor_total += $produto['preco_venda'] * $quantidade;

            // 3. Calculamos o subtotal do item (preço * quantidade)
            $subtotal_item = $produto['preco_venda'] * $quantidade;
            $subtotalFormatado = number_format($subtotal_item, 2, ',', '.');
    ?>
            
            <!-- Aqui entra o seu HTML do cartão do produto (usando os dados de $produto e $quantidade) -->
            <article class="cartao-produto">
                <!-- Imagem, Titulo, etc... -->
                <span class="numero-quantidade"><?php echo $quantidade; ?></span>
            </article>
          
    <?php 
        endforeach; 
    else: 
    ?>
        <p>Seu carrinho está vazio.</p>
    <?php endif; ?>
</section>

      <!-- LADO DIREITO: Coluna Lateral (Resumo, Frete e Cupom) -->
      <aside class="coluna-lateral">
        
        <!-- CAIXA 1: Resumo do Pedido -->
        <div class="caixa-resumo">
          <h2 class="titulo-resumo">Resumo do Pedido</h2>
          
          <div class="linha-resumo">
            <span>Subtotal (3 itens)</span>
            <strong><?php echo number_format($valor_total, 2, ',', '.'); ?></strong>
          </div>
          
          <div class="linha-resumo">
            <span>Desconto</span>
            <strong style="color: var(--cor-principal);">- R$ 0,00</strong>
          </div>
          
          <div class="linha-resumo">
            <span>Frete</span>
            <strong>A calcular</strong>
          </div>
          
          <div class="linha-resumo linha-total">
            <span>Total</span>
            <span class="preco-total"><?php echo number_format($valor_total, 2, ',', '.'); ?></span>
          </div>

          <a href="finaliza_compra.php" class="link-botao">
            <button class="botao-finalizar-compra">
              Finalizar Compra
              <i class="fa-solid fa-arrow-right"></i>
            </button>
          </a>

        <!-- CAIXA 2: Cálculo de Frete e Cupom -->
        <div class="caixa-resumo">
          <!-- Cálculo de Frete -->
          <div class="grupo-ferramenta">
            <label for="campo-cep" class="etiqueta-ferramenta">CÁLCULO DE FRETE</label>
            <div class="campo-com-botao">
              <input type="text" id="campo-cep" class="campo-texto" placeholder="00000-000">
              <button class="botao-secundario">OK</button>
            </div>
          </div>

          <hr class="divisor">

          <!-- Cupom de Desconto -->
          <div class="grupo-ferramenta">
            <label for="campo-cupom" class="etiqueta-ferramenta">CUPOM DE DESCONTO</label>
            <div class="campo-com-botao">
              <input type="text" id="campo-cupom" class="campo-texto" placeholder="Insira o código">
              <button class="botao-secundario">Aplicar</button>
            </div>
          </div>
        </div>

      </aside>

    </div>

  </main>  
  <!-- fim .conteudo-principal -->


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

</body>
       
        
</html>