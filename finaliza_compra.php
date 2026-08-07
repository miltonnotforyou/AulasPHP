<?php
// Inclui o arquivo de conexão com o banco de dados
require_once './conexao/conecta.php';

// Inicia a sessão
if (!isset($_SESSION)) {
    session_start();
}

// 2. CAPTURANDO E PROTEGENDO AS VARIÁVEIS
$codigo_cliente = intval($_SESSION['CLIENTE_ID']); 
$forma_pagamento = mysqli_real_escape_string($conexao, $_POST['forma_pagamento']);
$codigo_funcionario = 19; 
$observacao = 'Venda web via ' . $forma_pagamento;

// Recebendo o desconto do formulário
$desconto = isset($_POST['valor_desconto']) ? floatval($_POST['valor_desconto']) : 0;

// 3. CALCULANDO O TOTAL (Antes de inserir na Venda)
$valor_total_bruto = 0;
foreach ($_SESSION['carrinho'] as $codigo_produto => $quantidade) {
    $cod = intval($codigo_produto);
    $sql_preco = "SELECT preco_venda FROM produto WHERE codigo_produto = $cod";
    $query_preco = mysqli_query($conexao, $sql_preco);
    
    if ($produto = mysqli_fetch_assoc($query_preco)) {
        $valor_total_bruto += ($produto['preco_venda'] * intval($quantidade));
    }
}

// Aplica a subtração final
$valor_total_liquido = $valor_total_bruto - $desconto;

// Formata os valores para o padrão do Banco de Dados (com ponto)
$valor_total_bd = number_format($valor_total_liquido, 2, '.', '');
$desconto_bd = number_format($desconto, 2, '.', '');

// 4. INSERINDO NA TABELA VENDA (A query usa a variável $desconto_bd agora)
$sql_venda = "INSERT INTO venda (data_venda, desconto, valor_total, forma_pagamento, observacao, codigo_funcionario, codigo_cliente) 
              VALUES (NOW(), $desconto_bd, $valor_total_bd, '$forma_pagamento', '$observacao', $codigo_funcionario, $codigo_cliente)";

if (mysqli_query($conexao, $sql_venda)) {
    
    // Pega o código gerado da venda
    $codigo_venda_gerada = mysqli_insert_id($conexao);

    // 5. INSERINDO OS ITENS DO CARRINHO NA TABELA ITEM_VENDA
    foreach ($_SESSION['carrinho'] as $codigo_produto => $quantidade) {
        
        $cod_prod = intval($codigo_produto);
        $qtd = intval($quantidade);

        $sql_prod = "SELECT preco_venda FROM produto WHERE codigo_produto = $cod_prod";
        $query_prod = mysqli_query($conexao, $sql_prod);
        $prod_info = mysqli_fetch_assoc($query_prod);

        // Formata os valores monetários com ponto
        $valor_item = number_format($prod_info['preco_venda'], 2, '.', '');
        $valor_total_item = number_format($prod_info['preco_venda'] * $qtd, 2, '.', '');

        // Salva o item da venda
        $sql_item = "INSERT INTO item_venda (qtde_item, valor_item, valor_total_item, codigo_produto, codigo_venda) 
                     VALUES ($qtd, $valor_item, $valor_total_item, $cod_prod, $codigo_venda_gerada)";
        
        mysqli_query($conexao, $sql_item);

        // Baixa o estoque
        $sql_estoque = "UPDATE produto SET qtde_estoque = qtde_estoque - $qtd WHERE codigo_produto = $cod_prod";
        mysqli_query($conexao, $sql_estoque);
    }

    
    // 6. LIMPANDO O CARRINHO E CUPONS APÓS SUCESSO
    unset($_SESSION['carrinho']);
    unset($_SESSION['cupom_desconto']);
    unset($_SESSION['cupom_nome']);

    echo "<script>
            alert('Compra finalizada com sucesso! O código do seu pedido é: " . $codigo_venda_gerada . "');
            window.location.href = 'index.php';
          </script>";
          
} else {
    // Se der erro, mostramos o erro e a query exata para facilitar encontrar o defeito
    echo "Erro ao finalizar a compra: " . mysqli_error($conexao) . "<br><br>Query executada:<br>" . $sql_venda;
}
?>