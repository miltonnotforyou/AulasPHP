<?php 
  require_once __DIR__ .'/../../conexao/conecta.php';

 // ============================================================
  // 1. RECEBIMENTO DOS FILTROS ENVIADOS PELO AJAX (método POST)
  // ============================================================
  $busca_produto = $_POST['produto'] ?? ''; 
  $status        = $_POST['status'] ?? ''; 
  $promocao      = $_POST['promocao'] ?? ''; 
  $estoque       = $_POST['estoque'] ?? ''; 
  $marca         = $_POST['marca'] ?? ''; 

  // ============================================================
  // 2. MONTAGEM DA QUERY SQL DE FORMA DINÂMICA
  // ============================================================
  $sql = "SELECT * FROM produto WHERE 1=1";

  // ============================================================
  // 3. ADIÇÃO CONDICIONAL DOS FILTROS NA QUERY
  // ============================================================

  // Filtro por marca - "LIKE" para buscar enquanto digita
  if (!empty($busca_produto)) {
      $sql .= " AND nome LIKE '%" . mysqli_real_escape_string($conexao, $busca_produto) . "%'";
  }

  // Filtro por STATUS
  if ($status !== '') {
      $sql .= " AND status = '" . mysqli_real_escape_string($conexao, $status) . "'";
  }

  // Filtro por PROMOÇÃO
  if ($promocao !== '') {
      $sql .= " AND status_promocao = '" . mysqli_real_escape_string($conexao, $promocao) . "'";
  }

  // Filtro por ESTOQUE
  if ($estoque !== '') {
      if ($estoque == '1') {
          // Em Estoque (Acima de 10)
          $sql .= " AND qtde_estoque > 10";
      } elseif ($estoque == '2') {
          // Estoque Baixo (De 1 até 10)
          $sql .= " AND qtde_estoque > 0 AND qtde_estoque <= 10";
      } elseif ($estoque == '3') {
          // Fora de Estoque (0 ou negativo)
          $sql .= " AND qtde_estoque <= 0";
      }
  }

  // Filtro por MARCA
  if ($marca !== '') {
      $sql .= " AND codigo_marca = '" . mysqli_real_escape_string($conexao, $marca) . "'";
  }

  // Ordenação
  $sql .= " ORDER BY nome ASC";

   // ============================================================
  // 4. EXECUÇÃO DA QUERY
  // ============================================================
  $query = mysqli_query($conexao, $sql);

  // ============================================================
  // 5. VERIFICAÇÃO E EXIBIÇÃO DOS RESULTADOS
  // ============================================================
  
  if ($query && mysqli_num_rows($query) > 0) {
      while ($produto = mysqli_fetch_assoc($query)) {
?>
        <tr>
          <td class="table-light"><?php echo htmlspecialchars($produto['codigo_produto']); ?></td>
          <td class="table-light"><?php echo htmlspecialchars($produto['nome']); ?></td>
          <td class="table-light"><?php echo htmlspecialchars($produto['descricao']); ?></td>
          <td class="table-light"><?php echo htmlspecialchars($produto['qtde_estoque']); ?></td>
          <td class="table-light">
            <?php 
              if ($produto['status_promocao'] == 1) {
                echo '<span class="badge rounded-pill bg-success">Sim</span>';
              } else {
                echo '<span class="badge rounded-pill bg-danger">Não</span>';
              }
            ?>
          </td>
          <td class="table-light">
            <?php 
              if ($produto['status'] == 1) {
                echo '<span class="badge rounded-pill bg-success">Ativo</span>';
              } else {
                echo '<span class="badge rounded-pill bg-danger">Inativo</span>';
              }
            ?>
          </td>
          <td class="table-light"><?php echo date('d/m/Y', strtotime($produto['data_cadastro'])); ?></td>
          <td class="table-light"> 
            <a href="Editar.php?codigo_produto=<?php echo $produto['codigo_produto']; ?>" class="btn btn-outline-success btn-sm" title="Editar">
              <i class="bi bi-pencil"></i>
            </a>
            <a href="Excluir.php?codigo_produto=<?php echo $produto['codigo_produto']; ?>" class="btn btn-outline-danger btn-sm" title="Excluir">
              <i class="bi bi-trash"></i>
            </a>
          </td>
        </tr>
<?php 
      }
  } else {
      // colspan 8 (total exato de colunas de produtos)
      echo '<tr>
              <td colspan="8" class="text-center table-light text-danger py-3">
                Nenhum produto encontrado com estes filtros!
              </td>
            </tr>';
  }
?>