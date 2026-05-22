<?php 
  // ============================================================
  // ARQUIVO: busca_clientes.php (chamado via AJAX)
  // FUNÇÃO: Recebe filtros, consulta o banco e devolve as linhas
  //         da tabela HTML com os clientes encontrados.
  // ============================================================

  // Inclui o arquivo de conexão com o banco de dados MySQL.
  // __DIR__ garante que o caminho seja relativo a este arquivo,
  // independente de onde o script for chamado.
  require_once __DIR__ .'/../../conexao/conecta.php';

  // ============================================================
  // 1. RECEBIMENTO DOS FILTROS ENVIADOS PELO AJAX (método POST)
  // ============================================================

  // O operador ?? (null coalescing) evita erro "Undefined index":
  // se o campo não vier no POST, assume string vazia '' como padrão.
  $sexo   = $_POST['sexo']   ?? ''; // Ex: 'M', 'F', 'O'
  $status = $_POST['status'] ?? ''; // Ex: '1' (ativo) ou '0' (inativo)
  $cidade = $_POST['cidade'] ?? ''; // Ex: 'Piracicaba'
 
  //Busca por nome: o usuário pode digitar parte do nome, então usamos LIKE na query.
  $nome   = mysqli_real_escape_string($conexao, $_POST['nome'] ?? ''); // Ex: 'Milton'

  // ============================================================
  // 2. MONTAGEM DA QUERY SQL DE FORMA DINÂMICA
  // ============================================================

  // Query base: busca todos os clientes com seu cargo.
  // LEFT JOIN = traz o cliente MESMO que ele não tenha cargo cadastrado.
  // O alias "cargo_nome" renomeia cargo.nome para evitar conflito com
  // cliente.nome na hora de ler os resultados.
  // WHERE 1=1 é um truque: sempre verdadeiro, permite adicionar
  // AND's opcionais sem precisar checar se é o primeiro filtro.
  $sql = "SELECT cliente.*
          FROM cliente 
          WHERE 1=1";

  // ============================================================
  // 3. ADIÇÃO CONDICIONAL DOS FILTROS NA QUERY
  // ============================================================

  // Só adiciona o filtro se o valor NÃO for vazio.
  // mysqli_real_escape_string() escapa caracteres perigosos (ex: aspas)
  // protegendo contra SQL Injection básico.

  // Filtro por SEXO (M / F / O)
  if (!empty($sexo)) {
      $sql .= " AND cliente.sexo = '" . mysqli_real_escape_string($conexao, $sexo) . "'";
  }

  // Filtro por STATUS — usa !== '' em vez de !empty()
  // porque o valor '0' (inativo) seria considerado "vazio" pelo empty(),
  // o que causaria um bug: o filtro "inativo" nunca funcionaria.
  if ($status !== '') {
      $sql .= " AND cliente.status = '" . mysqli_real_escape_string($conexao, $status) . "'";
  }

  // Filtro por CIDADE
  if (!empty($cidade)) {
      $sql .= " AND cliente.cidade = '" . mysqli_real_escape_string($conexao, $cidade) . "'";
  }

   // Filtro por NOME — usa LIKE com % nas duas pontas para busca parcial.
  // Ex: buscar "il" encontra "Milton", "Milena", "Gilberto", etc.
  if (!empty($nome)) {
      $sql .= " AND (cliente.nome LIKE '%" . mysqli_real_escape_string($conexao, $nome) . "%' OR cliente.nome_social LIKE '%" . mysqli_real_escape_string($conexao, $nome) . "%')";
      
  }

  // Ordena o resultado por nome em ordem crescente (A → Z)
  $sql .= " ORDER BY cliente.nome ASC";

  // ============================================================
  // 4. EXECUÇÃO DA QUERY
  // ============================================================

  // mysqli_query() executa o SQL e retorna um objeto de resultado,
  // ou FALSE em caso de erro.
  $query = mysqli_query($conexao, $sql);

  // ============================================================
  // 5. VERIFICAÇÃO E EXIBIÇÃO DOS RESULTADOS
  // ============================================================

  // Verifica duas condições antes de tentar exibir:
  // - $query é válido (a query não teve erro)
  // - há pelo menos 1 linha retornada
  if ($query && mysqli_num_rows($query) > 0) {

      // mysqli_fetch_assoc() lê uma linha por vez como array associativo
      // (chave = nome da coluna). O while percorre até não ter mais linhas.
      while ($cliente = mysqli_fetch_assoc($query)) {
?>
        <!-- Cada iteração do while gera uma linha <tr> da tabela HTML -->
        <tr>
          <td class="table-light"><?php echo htmlspecialchars($cliente['codigo_cliente']); ?></td>

          <td class="table-light">
            <?php 
              $nome_exibicao = !empty($cliente['nome_social']) ? $cliente['nome_social'] : $cliente['nome'];
              echo htmlspecialchars($nome_exibicao); 
            ?>
          </td>

          <td class="table-light"><?php echo htmlspecialchars($cliente['cpf']); ?></td>

          <td class="table-light"><?php echo htmlspecialchars($cliente['email']); ?></td>

          <td class="table-light"><?php echo htmlspecialchars($cliente['telefone_celular']); ?></td>

          <td class="table-light"><?php echo htmlspecialchars($cliente['cidade'] . ' / ' . $cliente['estado']); ?></td>

          <td class="table-light">
            <?php 
              $sexoFormatado = strtoupper($cliente['sexo']);
              if      ($sexoFormatado == 'M') { echo 'Masculino'; } 
              elseif  ($sexoFormatado == 'F') { echo 'Feminino'; } 
              else                            { echo 'Não Informado'; }
            ?>
          </td>

          <td class="table-light">
            <?php 
              if ($cliente['status'] == 1) {
                echo '<span class="badge rounded-pill bg-success">Ativo</span>';
              } else {
                echo '<span class="badge rounded-pill bg-danger">Inativo</span>';
              }
            ?>
          </td>

          <td class="table-light"><?php echo date('d/m/Y', strtotime($cliente['data_cadastro'])); ?></td>

          <td class="table-light"> 
            <a href="Editar.php?codigo_cliente=<?php echo $cliente['codigo_cliente']; ?>" class="btn btn-outline-success btn-sm" title="Editar">
              <i class="bi bi-pencil"></i>
            </a>
            <!-- Botões de ação: Excluir. -->
            <form action="Acoes.php" method="POST" class="d-inline">
              <button type="submit" class="btn btn-outline-danger btn-sm" title="Excluir" 
                      name="deletar_cliente" 
                      value="<?php echo $cliente['codigo_cliente']; ?>" 
                      onclick="return confirm('Tem certeza que deseja excluir o cliente <?php echo htmlspecialchars($cliente['nome']); ?>?');">
                <i class="bi bi-trash"></i>
              </button>
            </form>  <!-- ← TAG QUE FALTAVA -->

            </td>
        </tr>
<?php 
      } // Fim do while — próxima linha do resultado

  } else {
      // Nenhum cliente encontrado: exibe mensagem centralizada
      // colspan="11" faz a célula ocupar todas as 11 colunas da tabela
      echo '<tr>
              <td colspan="11" class="text-center table-light text-danger py-3">
                Nenhum cliente encontrado com estes filtros!
              </td>
            </tr>';
  }
?>