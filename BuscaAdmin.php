<?php 
// Caminho da conexão com o banco de dados
require_once __DIR__ . '/conexao/conecta.php';

$termo = isset($_POST['pesquisa']) ? trim($_POST['pesquisa']) : '';

// Se o usuário apagou a pesquisa, não fazemos nada
if (empty($termo)) {
    exit;
}

$termo_seguro = $conexao->real_escape_string($termo); // Escapa caracteres especiais para evitar SQL Injection
$encontrou_algo = false; // Flag para exibir a mensagem de "Nenhum resultado"

// =========================================================================
// 1. BUSCA DE PRODUTOS
// =========================================================================
$sql_prod = "SELECT codigo_produto, nome, qtde_estoque, preco_venda, status 
             FROM produto 
             WHERE nome LIKE '%$termo_seguro%' OR descricao LIKE '%$termo_seguro%'
             ORDER BY nome ASC LIMIT 10";
$res_prod = $conexao->query($sql_prod);

// =========================================================================
// 2. BUSCA DE CLIENTES
// =========================================================================
$sql_cli = "SELECT codigo_cliente, nome, cpf, email, status 
            FROM cliente 
            WHERE nome LIKE '%$termo_seguro%' OR cpf LIKE '%$termo_seguro%' OR email LIKE '%$termo_seguro%'
            ORDER BY nome ASC LIMIT 10";
$res_cli = $conexao->query($sql_cli);

// =========================================================================
// 3. BUSCA DE VENDAS
// Busca por nome do cliente ou pelo código exato da venda
// =========================================================================
$sql_ven = "SELECT v.codigo_venda, c.nome as cliente_nome, v.data_venda, v.valor_total, v.forma_pagamento 
            FROM venda v
            INNER JOIN cliente c ON v.codigo_cliente = c.codigo_cliente
            WHERE c.nome LIKE '%$termo_seguro%' OR v.codigo_venda = '$termo_seguro'
            ORDER BY v.codigo_venda DESC LIMIT 10";
$res_ven = $conexao->query($sql_ven);


// =========================================================================
// RENDERIZAÇÃO DO HTML
// =========================================================================

echo '<div style="display: flex; flex-direction: column; gap: 20px; padding-top: 20px;">';

// --- RENDERIZA TABELA DE PRODUTOS ---
if ($res_prod && $res_prod->num_rows > 0) {
    $encontrou_algo = true;
    echo '<div class="cartao-resultados" style="box-shadow: 0 1px 3px rgba(0,0,0,0.1); background: #fff; border-radius: 8px; padding: 20px;">';
    echo '<h3 style="font-size: 16px; font-weight: 900; margin-bottom: 15px; color: #0f172a;"><i class="bi bi-box-seam me-2"></i>Produtos Encontrados</h3>';
    echo '<div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 1px solid #e2e8f0; text-align: left;">
                        <th style="padding: 10px; color: #64748b;">Código</th>
                        <th style="padding: 10px; color: #64748b;">Produto</th>
                        <th style="padding: 10px; color: #64748b;">Estoque</th>
                        <th style="padding: 10px; text-align: right; color: #64748b;">Preço</th>
                        <th style="padding: 10px; text-align: center; color: #64748b;">Status</th>
                    </tr>
                </thead><tbody>';
    
    while ($row = $res_prod->fetch_assoc()) {
        $badge = $row['status'] == 1 
            ? '<span style="background:#dcfce7; color:#166534; padding:4px 8px; border-radius:4px; font-size:11px; font-weight: 700;">Ativo</span>' 
            : '<span style="background:#fee2e2; color:#991b1b; padding:4px 8px; border-radius:4px; font-size:11px; font-weight: 700;">Inativo</span>';
            
        echo '<tr style="border-bottom: 1px solid #f1f5f9;">';
        echo '<td style="padding: 10px; font-weight: 700; color: #152738;">PRD-' . str_pad($row['codigo_produto'], 4, '0', STR_PAD_LEFT) . '</td>';
        echo '<td style="padding: 10px; color: #334155;">' . htmlspecialchars($row['nome']) . '</td>';
        echo '<td style="padding: 10px; color: #334155;">' . $row['qtde_estoque'] . ' un</td>';
        echo '<td style="padding: 10px; text-align: right; font-weight: 900;">R$ ' . number_format($row['preco_venda'], 2, ',', '.') . '</td>';
        echo '<td style="padding: 10px; text-align: center;">' . $badge . '</td>';
        echo '</tr>';
    }
    echo '</tbody></table></div></div>';
}


// --- RENDERIZA TABELA DE CLIENTES ---
if ($res_cli && $res_cli->num_rows > 0) {
    $encontrou_algo = true;
    echo '<div class="cartao-resultados" style="box-shadow: 0 1px 3px rgba(0,0,0,0.1); background: #fff; border-radius: 8px; padding: 20px;">';
    echo '<h3 style="font-size: 16px; font-weight: 900; margin-bottom: 15px; color: #0f172a;"><i class="bi bi-people me-2"></i>Clientes Encontrados</h3>';
    echo '<div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 1px solid #e2e8f0; text-align: left;">
                        <th style="padding: 10px; color: #64748b;">Código</th>
                        <th style="padding: 10px; color: #64748b;">Nome</th>
                        <th style="padding: 10px; color: #64748b;">CPF</th>
                        <th style="padding: 10px; color: #64748b;">E-mail</th>
                        <th style="padding: 10px; text-align: center; color: #64748b;">Status</th>
                    </tr>
                </thead><tbody>';
    
    while ($row = $res_cli->fetch_assoc()) {
        $badge = $row['status'] == 1 
            ? '<span style="background:#dcfce7; color:#166534; padding:4px 8px; border-radius:4px; font-size:11px; font-weight: 700;">Ativo</span>' 
            : '<span style="background:#fee2e2; color:#991b1b; padding:4px 8px; border-radius:4px; font-size:11px; font-weight: 700;">Inativo</span>';
            
        echo '<tr style="border-bottom: 1px solid #f1f5f9;">';
        echo '<td style="padding: 10px; font-weight: 700; color: #152738;">CLI-' . str_pad($row['codigo_cliente'], 4, '0', STR_PAD_LEFT) . '</td>';
        echo '<td style="padding: 10px; color: #334155;">' . htmlspecialchars($row['nome']) . '</td>';
        echo '<td style="padding: 10px; color: #334155;">' . htmlspecialchars($row['cpf']) . '</td>';
        echo '<td style="padding: 10px; color: #334155;">' . htmlspecialchars($row['email']) . '</td>';
        echo '<td style="padding: 10px; text-align: center;">' . $badge . '</td>';
        echo '</tr>';
    }
    echo '</tbody></table></div></div>';
}


// --- RENDERIZA TABELA DE VENDAS ---
if ($res_ven && $res_ven->num_rows > 0) {
    $encontrou_algo = true;
    echo '<div class="cartao-resultados" style="box-shadow: 0 1px 3px rgba(0,0,0,0.1); background: #fff; border-radius: 8px; padding: 20px;">';
    echo '<h3 style="font-size: 16px; font-weight: 900; margin-bottom: 15px; color: #0f172a;"><i class="bi bi-cart-check me-2"></i>Vendas Encontradas</h3>';
    echo '<div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 1px solid #e2e8f0; text-align: left;">
                        <th style="padding: 10px; color: #64748b;">Código</th>
                        <th style="padding: 10px; color: #64748b;">Cliente</th>
                        <th style="padding: 10px; color: #64748b;">Data</th>
                        <th style="padding: 10px; color: #64748b;">Pagamento</th>
                        <th style="padding: 10px; text-align: right; color: #64748b;">Valor Total</th>
                    </tr>
                </thead><tbody>';
    
    while ($row = $res_ven->fetch_assoc()) {
        $data_formatada = date('d/m/Y H:i', strtotime($row['data_venda']));
            
        echo '<tr style="border-bottom: 1px solid #f1f5f9;">';
        echo '<td style="padding: 10px; font-weight: 700; color: #152738;">VD-' . str_pad($row['codigo_venda'], 4, '0', STR_PAD_LEFT) . '</td>';
        echo '<td style="padding: 10px; color: #334155;">' . htmlspecialchars($row['cliente_nome']) . '</td>';
        echo '<td style="padding: 10px; color: #334155;">' . $data_formatada . '</td>';
        echo '<td style="padding: 10px;"><span style="background:#f1f5f9; padding:4px 8px; border-radius:4px; font-size:11px; font-weight: 600;">' . ($row['forma_pagamento'] ?: 'N/A') . '</span></td>';
        echo '<td style="padding: 10px; text-align: right; font-weight: 900;">R$ ' . number_format($row['valor_total'], 2, ',', '.') . '</td>';
        echo '</tr>';
    }
    echo '</tbody></table></div></div>';
}

echo '</div>'; // Fechamento do container principal


// --- MENSAGEM SE NÃO ENCONTRAR NADA ---
if (!$encontrou_algo) {
    echo '<div style="padding: 40px; background: #fff; border-radius: 8px; margin-top: 20px; text-align: center; color: #64748b; font-weight: 500; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <i class="bi bi-search" style="font-size: 32px; display: block; margin-bottom: 15px; color: #cbd5e1;"></i>
            Nenhum resultado encontrado para "<strong>' . htmlspecialchars($termo) . '</strong>".<br>
            <span style="font-size: 13px; font-weight: normal; margin-top: 5px; display: block;">Tente pesquisar por código, nome, CPF ou e-mail.</span>
          </div>';
}
?>