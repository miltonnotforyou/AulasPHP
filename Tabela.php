<?php 
require_once __DIR__ . '/conexao/conecta.php';

// Recebe os dados do AJAX
$categorias = $_POST['categoria'] ?? []; 
$marca      = $_POST['marca'] ?? ''; 
$preco_max  = $_POST['preco_max'] ?? '';
$promocao = $_POST['promocao'] ?? '';  

$sql = "SELECT * FROM produto WHERE 1=1";

// Filtro de Categorias (Transforma o array em string separada por vírgula)
if (!empty($categorias)) {
    $lista_categorias = implode(',', array_map('intval', $categorias)); // Garante que os valores sejam inteiros para evitar SQL Injection
    $sql .= " AND codigo_categoria IN ($lista_categorias)";
}

// Filtro de Marca
if ($marca !== '') {
    $sql .= " AND codigo_marca = '" . mysqli_real_escape_string($conexao, $marca) . "'";
}


// Filtro de Promoção  
  if ($promocao !== '') {
      $sql .= " AND status_promocao = '" . mysqli_real_escape_string($conexao, $promocao) . "'";
  }

// Filtro de Preço Máximo
if ($preco_max !== '') {
    $preco = (float)$preco_max;
    $sql .= " AND preco_venda <= $preco";
}

$sql .= " ORDER BY nome ASC";
$query = mysqli_query($conexao, $sql);

// Desenha o HTML de retorno
if ($query && mysqli_num_rows($query) > 0) {
    while ($produto = mysqli_fetch_assoc($query)) {
        $precoFormatado = number_format($produto['preco_venda'], 2, ',', '.');
        
        // Estrutura exata do cartão produtos.php
        echo '
        <div class="cartao-produto">
            <div class="imagem-produto">
                <a href="detalhes.php?id=' . $produto['codigo_produto'] . '">  
                    <img src="./Produtos/' . $produto['foto'] . '" alt="' . $produto['nome'] . '"/>  
                </a>
            </div>
            <h4 class="nome-produto">' . $produto['nome'] . '</h4>
            <p class="descricao-produto">' . $produto['descricao'] . '</p>
            <div class="rodape-produto">
                <span class="preco-produto">R$ ' . $precoFormatado . '</span>
                <button class="botao-adicionar-carrinho">
                    <i class="fa-solid fa-cart-shopping"></i>
                </button>
            </div>
        </div>';
    }
} else {
    // Retorno adaptado para não quebrar a grade CSS
    echo '<p style="color: #ef4444; font-weight: bold; grid-column: 1 / -1;">
            Nenhum produto encontrado com estes filtros!
          </p>';
}
?>