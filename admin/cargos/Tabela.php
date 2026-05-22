<?php 
  // ============================================================
  // ARQUIVO: busca_cargos.php (chamado via AJAX)
  // ============================================================

  require_once __DIR__ .'/../../conexao/conecta.php';

  // ============================================================
  // 1. RECEBIMENTO DOS FILTROS ENVIADOS PELO AJAX (método POST)
  // ============================================================

  // Recebe o nome do cargo e o status (que estava faltando)
  $busca_cargo = $_POST['cargo'] ?? ''; 
  $status      = $_POST['status'] ?? ''; 

  // ============================================================
  // 2. MONTAGEM DA QUERY SQL DE FORMA DINÂMICA
  // ============================================================
  $sql = "SELECT * FROM cargo WHERE 1=1";

  // ============================================================
  // 3. ADIÇÃO CONDICIONAL DOS FILTROS NA QUERY
  // ============================================================

  // Filtro por CARGO - Alterado de "=" para "LIKE" para buscar enquanto digita
  if (!empty($busca_cargo)) {
      $sql .= " AND nome LIKE '%" . mysqli_real_escape_string($conexao, $busca_cargo) . "%'";
  }

  // Filtro por STATUS - Adicionado, pois estava faltando!
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

      while ($cargo = mysqli_fetch_assoc($query)) {
?>
        <tr>
          <td class="table-light"><?php echo htmlspecialchars($cargo['codigo_cargo']); ?></td>

          <td class="table-light"><?php echo htmlspecialchars($cargo['nome']); ?></td>

          <td class="table-light"><?php echo htmlspecialchars($cargo['observacao']); ?></td>

          <td class="table-light">
            <?php 
              if ($cargo['status'] == 1) {
                echo '<span class="badge rounded-pill bg-success">Ativo</span>';
              } else {
                echo '<span class="badge rounded-pill bg-danger">Inativo</span>';
              }
            ?>
          </td>

          <td class="table-light"><?php echo date('d/m/Y', strtotime($cargo['data_cadastro'])); ?></td>

          <td class="table-light"> 
            <a href="Editar.php?codigo_cargo=<?php echo $cargo['codigo_cargo']; ?>" class="btn btn-outline-success btn-sm" title="Editar">
              <i class="bi bi-pencil"></i>
            </a>
            
            <!-- Botões de ação: Excluir. -->
            <form action="acoes.php" method="POST" class="d-inline">
              <button type="submit" class="btn btn-outline-danger btn-sm" title="Excluir" name="deletar_cargo" value="<?php echo $cargo['codigo_cargo']?> " onclick="return confirm('Tem certeza que deseja excluir o cargo <?php echo $cargo['nome']; ?>?');">
              <i class="bi bi-trash"></i>

              </button>
            </form>
          </td>
        </tr>
<?php 
      } // Fim do while

  } else {
      // Alterado o colspan de 11 para 6, para bater certinho com o número de colunas da sua tabela de cargos
      echo '<tr>
              <td colspan="6" class="text-center table-light text-danger py-3">
                Nenhum cargo encontrado com estes filtros!
              </td>
            </tr>';
  }
?>