<?php
// Inclui o arquivo de conexão com o banco de dados
include_once './conexao/conecta.php';

// Iniciando a sessão para gerenciar o estado de autenticação e os itens do carrinho
if (!isset($_SESSION)) {
    session_start();
}

$produto = null;

// ==========================================
// 1. LÓGICA DE ADICIONAR ITEM AO CARRINHO
// ==========================================
// Verifica se um ID foi passado na URL e NÃO é uma ação de remover
if(isset($_GET['id']) && !empty($_GET['id']) && !isset($_GET['acao'])) {
    
    $codigo = intval($_GET['id']); 
    
    $sql = "SELECT p.* FROM produto p WHERE p.codigo_produto = $codigo"; 
    $query = mysqli_query($conexao, $sql) or die("Erro na Query: " . mysqli_error($conexao)); 
    $produto = mysqli_fetch_assoc($query);

    if($produto) {
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = array();
        }
        if (isset($_SESSION['carrinho'][$codigo])) {
            $_SESSION['carrinho'][$codigo] += 1;
        } else {
            $_SESSION['carrinho'][$codigo] = 1;
        }
    }
    
    // REDIRECIONAMENTO VITAL: Limpa a URL para evitar duplicidade ao dar F5
    header("Location: carrinho.php");
    exit;
}

// ==========================================
// 2. LÓGICA DE REMOÇÃO DE ITEM
// ==========================================
if (isset($_GET['acao']) && $_GET['acao'] == 'remover' && isset($_GET['id'])) {
    $codigo_remover = intval($_GET['id']);
    
    // Remove o item específico do carrinho
    if (isset($_SESSION['carrinho'][$codigo_remover])) {
        unset($_SESSION['carrinho'][$codigo_remover]);
    }
    
    // Se o carrinho ficar vazio, também removemos os cupons para evitar lixo na sessão
    if (empty($_SESSION['carrinho'])) {
        unset($_SESSION['cupom_desconto']);
        unset($_SESSION['cupom_nome']);
    }
    
    // Redireciona para limpar a URL
    header("Location: carrinho.php");
    exit;
}

// ==========================================
// 3. LÓGICA DE APLICAÇÃO DE CUPOM
// ==========================================
if (isset($_POST['aplicar_cupom']) && !empty($_POST['codigo_cupom'])) {
    $codigo_digitado = strtoupper(trim($_POST['codigo_cupom']));
    
    if ($codigo_digitado === 'IOT10') {
        $_SESSION['cupom_desconto'] = 0.10; // 10% de desconto
        $_SESSION['cupom_nome'] = 'IOT10';
        $mensagem_cupom = "<span style='color: #10b981; font-weight: bold;'>Cupom IOT10 aplicado com sucesso (10% OFF)!</span>";
    } else {
        $mensagem_cupom = "<span style='color: #ef4444; font-weight: bold;'>Cupom inválido ou expirado.</span>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IOT STORE - Seu Carrinho</title>
    <meta name="author" content="Milton Silva">
    <!-- FontAwesome (ícones) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />
    <!-- Arquivo de Estilos CSS -->
    <link rel="stylesheet" href="./src/style.css" />
    <link rel="shortcut icon" href="../IOT_Store/logo/logotipo_light.png" type="image/x-icon">
</head>
<body>
    
    <div class="site-container">
        <!-- Cabeçalho-->
        <?php include('cabecalho.php'); ?>
        <!-- Fim do Cabeçalho -->
    <!-- Conteudo principal -->
      <main class="conteudo-principal">
      <!-- Breadcrumb -->
      <nav class="breadcrumbs">
        <a href="index.php">Inicio</a>
        <span class="separador">/</span>
        <span class="atual">Carrinho</span>
      </nav>

      <section class="secao-titulo-pagina" style="margin-bottom: 2rem;">
        <h1 class="titulo-produto" style="font-size: 2rem;">Seu Carrinho</h1>
        <p style="color: #64748b; font-size: 1.1rem;">Revise seus itens e finalize sua compra com segurança.</p>
      </section>

      <section class="secao-produto" style="display: block; background: transparent; padding: 0;"> 

        <!-- ÁREA 1: LISTA DE PRODUTOS -->
        <div style="background-color: white; border-radius: 12px; padding: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 30px;">
          
          <?php
          $valor_total = 0; 
          if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0): 
          ?>
            
            <div class="cabecalho-lista-produtos" style="display: flex; justify-content: space-between; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px; margin-bottom: 20px; font-weight: bold; color: #475569;">
              <div style="flex: 2;">Produto</div>
              <div style="flex: 1; text-align: center;">Quantidade</div>
              <div style="flex: 1; text-align: right;">Subtotal</div>
            </div>

            <?php foreach ($_SESSION['carrinho'] as $codigo_produto => $quantidade):
              $sql = "SELECT * FROM produto WHERE codigo_produto = $codigo_produto";
              $query = mysqli_query($conexao, $sql);
              $produto = mysqli_fetch_assoc($query);

              $subtotal_item = $produto['preco_venda'] * $quantidade;
              $valor_total += $subtotal_item; 
            ?>
              
              <article class="item-carrinho" style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #e2e8f0; padding-bottom: 20px; margin-bottom: 20px;">
                
                <div class="detalhes-produto" style="display: flex; align-items: center; gap: 20px; flex: 2;">
                  <div style="width: 80px; height: 80px; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0; flex-shrink: 0;">
                    <img src="./images/<?php echo $produto['foto']; ?>" alt="<?php echo $produto['nome']; ?>" style="width: 100%; height: 100%; object-fit: cover;">
                  </div>
                  <div>
                    <h3 style="font-size: 1.1rem; margin: 0 0 5px 0; color: #1e293b;"><?php echo $produto['nome']; ?></h3>
                    <a href="carrinho.php?acao=remover&id=<?php echo $codigo_produto; ?>" style="color: #ef4444; font-size: 0.85rem; text-decoration: none;">
                      <i class="fa-solid fa-trash-can"></i> Remover
                    </a>
                  </div>
                </div>

                <div class="valores-produto" style="display: flex; flex: 2; justify-content: space-between;">
                  <div style="flex: 1; text-align: center; font-weight: bold; color: #475569;">
                    <?php echo $quantidade; ?> un.
                  </div>

                  <div style="flex: 1; text-align: right;">
                    <span style="font-size: 1.2rem; font-weight: bold; color: var(--primaria);">
                      R$ <?php echo number_format($subtotal_item, 2, ',', '.'); ?>
                    </span>
                  </div>
                </div>

              </article>
            
            <?php endforeach; else: ?>
              
              <div style="text-align: center; padding: 40px 20px;">
                <i class="fa-solid fa-cart-shopping" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 15px;"></i>
                <h3 style="color: #475569; margin-bottom: 10px;">Seu carrinho está vazio no momento.</h3>
                <a href="produtos.php" class="botao-comprar-agora" style="display: inline-block; width: auto; padding: 10px 25px; text-decoration: none; margin-top: 15px;">
                  Continuar Comprando
                </a>
              </div>

          <?php endif; ?>
        </div>
        <!-- FIM DA ÁREA 1 -->

        <?php if ($valor_total > 0): ?>
          
          <!-- ÁREA 2: FORMULÁRIOS E RESUMO -->
          <!-- A troca do grid-template-columns para auto-fit torna isso responsivo automaticamente -->
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px; align-items: start;">
            
            <!-- Coluna da Esquerda: Ferramentas (Frete/Cupom) -->
            <div style="background-color: white; border-radius: 12px; padding: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
              
              <div class="calculo-frete" style="margin-bottom: 25px;">
                <p class="frete-titulo" style="font-weight: bold; margin-bottom: 8px;"><i class="fas fa-truck"></i> Calcular Frete</p>
                <div class="frete-input-grupo" style="display: flex; gap: 5px;">
                  <input type="text" placeholder="00000-000" style="flex: 1; min-width: 0; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                  <button class="botao-frete" style="padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; background: #e2e8f0;">OK</button>
                </div>
              </div>

              <form action="carrinho.php" method="POST">
                <div class="calculo-frete">
                  <p class="frete-titulo" style="font-weight: bold; margin-bottom: 8px;"><i class="fas fa-ticket"></i> Cupom de Desconto</p>
                  <div class="frete-input-grupo" style="display: flex; gap: 5px;">
                    <input type="text" name="codigo_cupom" placeholder="Insira o código" value="<?php echo isset($_SESSION['cupom_nome']) ? $_SESSION['cupom_nome'] : ''; ?>" style="flex: 1; min-width: 0; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                    <button type="submit" name="aplicar_cupom" class="botao-frete" style="background-color: #64748b; color: white; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer;">Aplicar</button>
                  </div>
                </div>
                <?php if(isset($mensagem_cupom)) echo "<p style='margin-top: 10px; font-size: 0.9rem;'>$mensagem_cupom</p>"; ?>
              </form>

            </div>

            <!-- Coluna da Direita: Finalização e Resumo -->
            <div style="background-color: white; border-radius: 12px; padding: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
              
              <h3 style="margin-bottom: 20px; color: #1e293b; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">Resumo</h3>
              
              <div style="display: flex; justify-content: space-between; margin-bottom: 10px; color: #475569;">
                <span>Subtotal</span>
                <strong>R$ <?php echo number_format($valor_total, 2, ',', '.'); ?></strong>
              </div>

              <?php 
              $valor_desconto = 0;
              $valor_final = $valor_total;

              if(isset($_SESSION['cupom_desconto'])) {
                  $valor_desconto = $valor_total * $_SESSION['cupom_desconto'];
                  $valor_final = $valor_total - $valor_desconto;
              ?>
                  <div style="display: flex; justify-content: space-between; margin-bottom: 10px; color: #10b981; font-weight: bold;">
                    <span>Desconto (<?php echo $_SESSION['cupom_nome']; ?>)</span>
                    <span>- R$ <?php echo number_format($valor_desconto, 2, ',', '.'); ?></span>
                  </div>
              <?php } ?>
              
              <div style="display: flex; justify-content: space-between; font-size: 1.3rem; margin-bottom: 25px; margin-top: 15px; border-top: 1px solid #e2e8f0; padding-top: 15px;">
                <span style="color: #1e293b; font-weight: bold;">Total</span>
                <span style="color: var(--primaria); font-weight: 900;">R$ <?php echo number_format($valor_final, 2, ',', '.'); ?></span>
              </div>

              <?php if(isset($_SESSION['CLIENTE_ID'])): ?>
                <form action="finaliza_compra.php" method="POST">
                  
                  <input type="hidden" name="valor_desconto" value="<?php echo $valor_desconto; ?>">

                  <div style="margin-bottom: 20px;">
                    <label for="forma_pagamento" style="display:block; margin-bottom: 8px; font-weight: bold; color: #475569; font-size: 0.9rem;">Forma de Pagamento:</label>
                    
                    <div class="linha-pagamento" style="display: flex; gap: 10px; align-items: stretch;">
                        <select name="forma_pagamento" id="forma_pagamento" required style="flex: 1; min-width: 0; padding: 12px; border: 1px solid #cbd5e1; border-radius: 6px; background-color: #f8fafc; font-size: 1rem; color: #334155;">
                            <option value="" selected disabled>Selecione...</option>
                            <option value="Pix">Pix</option>
                            <option value="Cartão de Crédito">Cartão de Crédito</option>
                            <option value="Cartão de Débito">Cartão de Débito</option>
                            <option value="Dinheiro">Boleto Bancário</option>
                        </select>

                        <button type="submit" class="botao-comprar-agora" style="white-space: nowrap; padding: 12px 20px; margin: 0; display: flex; align-items: center; justify-content: center; height: auto; flex-shrink: 0;">
                            Finalizar Compra <i class="fa-solid fa-arrow-right" style="margin-left: 8px;"></i>
                        </button>
                    </div>
                  </div> 
                </form>
              <?php else: ?>
                <a href="login_cliente.php" style="text-decoration: none;">
                  <button class="botao-no-carrinho" style="width: 100%;">
                    Faça login para finalizar <i class="fa-solid fa-user" style="margin-left: 8px;"></i>
                  </button>
                </a>
              <?php endif; ?>

            </div>
          </div>
        <?php endif; ?>
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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> 
    <script src="src/script2.js"></script>
</body>
</html>