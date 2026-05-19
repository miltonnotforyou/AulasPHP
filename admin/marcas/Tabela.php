<?php 
 
  require_once __DIR__ .'/../../conexao/conecta.php';

  // ============================================================
  // 1. RECEBIMENTO DOS FILTROS ENVIADOS PELO AJAX (método POST)
  // ============================================================

  // Recebe o nome do marca e o status 
  $busca_marca = $_POST['marca'] ?? ''; 
  $status      = $_POST['status'] ?? ''; 

  // ============================================================
  // 2. MONTAGEM DA QUERY SQL DE FORMA DINÂMICA
  // ============================================================
  $sql = "SELECT * FROM marca WHERE 1=1";

  // ============================================================
  // 3. ADIÇÃO CONDICIONAL DOS FILTROS NA QUERY
  // ============================================================

  // Filtro por marca - "LIKE" para buscar enquanto digita
  if (!empty($busca_marca)) {
      $sql .= " AND nome LIKE '%" . mysqli_real_escape_string($conexao, $busca_marca) . "%'";
  }

  // Filtro por STATUS 
  if ($status !== '') {
      $sql .= " AND status = '" . mysqli_real_escape_string($conexao, $status) . "'";
  }

  // Ordena o resultado por nome em ordem crescente (A → Z)
  $sql .= " ORDER BY nome ASC";

  // ============================================================
  // 4. EXECUÇÃO DA QUERY
  // ============================================================
  $query = mysqli_query($conexao, $sql);

  // ============================================================
  // 5. VERIFICAÇÃO E EXIBIÇÃO DOS RESULTADOS
  // ============================================================
  if ($query && mysqli_num_rows($query) > 0) {

      while ($marca = mysqli_fetch_assoc($query)) {
?>
        <tr>
          <td class="table-light"><?php echo htmlspecialchars($marca['codigo_marca']); ?></td>

          <td class="table-light"><?php echo htmlspecialchars($marca['nome']); ?></td>

          <td class="table-light"><?php echo htmlspecialchars($marca['observacao']); ?></td>

          <td class="table-light">
            <?php 
              if ($marca['status'] == 1) {
                echo '<span class="badge rounded-pill bg-success">Ativo</span>';
              } else {
                echo '<span class="badge rounded-pill bg-danger">Inativo</span>';
              }
            ?>
          </td>

          <td class="table-light"><?php echo date('d/m/Y', strtotime($marca['data_cadastro'])); ?></td>

          <td class="table-light"> 
            <a href="Editar.php?codigo_marca=<?php echo $marca['codigo_marca']; ?>" class="btn btn-outline-success btn-sm" title="Editar">
              <i class="bi bi-pencil"></i>
            </a>
            <a href="Excluir.php?codigo_marca=<?php echo $marca['codigo_marca']; ?>" class="btn btn-outline-danger btn-sm" title="Excluir">
              <i class="bi bi-trash"></i>
            </a>
          </td>
        </tr>
<?php 
      } // Fim do while

  } else {
      // Colspan 6, para bater com o número de colunas da tabela marcas
      echo '<tr>
              <td colspan="6" class="text-center table-light text-danger py-3">
                Nenhuma marca encontrado com estes filtros!
              </td>
            </tr>';
  }
?>