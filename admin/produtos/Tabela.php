<?php 
  // ============================================================
  // ARQUIVO: busca_categorias.php (chamado via AJAX)
  // ============================================================

  require_once __DIR__ .'/../../conexao/conecta.php';

  // ============================================================
  // 1. RECEBIMENTO DOS FILTROS ENVIADOS PELO AJAX (método POST)
  // ============================================================

  // Recebe o nome do produto e o status 
  $busca_produto = $_POST['produto'] ?? ''; 
  $status      = $_POST['status'] ?? ''; 

  // ============================================================
  // 2. MONTAGEM DA QUERY SQL DE FORMA DINÂMICA
  // ============================================================
 

  $sql = "SELECT produto.*, marca.nome AS marca_nome 
          FROM produto 
          JOIN marca ON produto.codigo_marca = marca.codigo_marca 
          WHERE 1=1";

  // ============================================================
  // 3. ADIÇÃO CONDICIONAL DOS FILTROS NA QUERY
  // ============================================================

  // Filtro por produto - "LIKE" para buscar enquanto digita
  if (!empty($busca_produto)) {
      $sql .= " AND produto.nome LIKE '%" . mysqli_real_escape_string($conexao, $busca_produto) . "%'";
  }

  // Filtro por STATUS 
  if ($status !== '') {
      $sql .= " AND produto.status = '" . mysqli_real_escape_string($conexao, $status) . "'";
  }

  // Ordena o resultado por nome em ordem crescente (A → Z)
  $sql .= " ORDER BY produto.nome ASC";

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

          <td class="table-light"><?php echo htmlspecialchars($produto['marca_nome']); ?></td>

          <td class="table-light"><?php echo htmlspecialchars($produto['descricao']); ?></td>

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
      } // Fim do while

  } else {
      // Alterado o colspan de 11 para 6, para bater certinho com o número de colunas da sua tabela de categorias
      echo '<tr>
              <td colspan="6" class="text-center table-light text-danger py-3">
                Nenhuma marca encontrado com estes filtros!
              </td>
            </tr>';
  }
?>