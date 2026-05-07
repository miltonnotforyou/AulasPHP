<?php 
  // ============================================================
  // ARQUIVO: busca_funcionarios.php (chamado via AJAX)
  // FUNÇÃO: Recebe filtros, consulta o banco e devolve as linhas
  //         da tabela HTML com os funcionários encontrados.
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
  $cargo  = $_POST['cargo']  ?? ''; // Ex: '3' (código do cargo)
  $nome   = $_POST['nome']   ?? ''; // Ex: 'Milton' (busca por texto)

  // ============================================================
  // 2. MONTAGEM DA QUERY SQL DE FORMA DINÂMICA
  // ============================================================

  // Query base: busca todos os funcionários com seu cargo.
  // LEFT JOIN = traz o funcionário MESMO que ele não tenha cargo cadastrado.
  // O alias "cargo_nome" renomeia cargo.nome para evitar conflito com
  // funcionario.nome na hora de ler os resultados.
  // WHERE 1=1 é um truque: sempre verdadeiro, permite adicionar
  // AND's opcionais sem precisar checar se é o primeiro filtro.
  $sql = "SELECT funcionario.*, cargo.nome AS cargo_nome 
          FROM funcionario 
          LEFT JOIN cargo ON funcionario.codigo_cargo = cargo.codigo_cargo 
          WHERE 1=1";

  // ============================================================
  // 3. ADIÇÃO CONDICIONAL DOS FILTROS NA QUERY
  // ============================================================

  // Só adiciona o filtro se o valor NÃO for vazio.
  // mysqli_real_escape_string() escapa caracteres perigosos (ex: aspas)
  // protegendo contra SQL Injection básico.

  // Filtro por SEXO (M / F / O)
  if (!empty($sexo)) {
      $sql .= " AND funcionario.sexo = '" . mysqli_real_escape_string($conexao, $sexo) . "'";
  }

  // Filtro por STATUS — usa !== '' em vez de !empty()
  // porque o valor '0' (inativo) seria considerado "vazio" pelo empty(),
  // o que causaria um bug: o filtro "inativo" nunca funcionaria.
  if ($status !== '') {
      $sql .= " AND funcionario.status = '" . mysqli_real_escape_string($conexao, $status) . "'";
  }

  // Filtro por CIDADE
  if (!empty($cidade)) {
      $sql .= " AND funcionario.cidade = '" . mysqli_real_escape_string($conexao, $cidade) . "'";
  }

  // Filtro por CARGO (usa o código numérico do cargo)
  if (!empty($cargo)) {
      $sql .= " AND funcionario.codigo_cargo = '" . mysqli_real_escape_string($conexao, $cargo) . "'";
  }

  // Filtro por NOME — usa LIKE com % nas duas pontas para busca parcial.
  // Ex: buscar "il" encontra "Milton", "Milena", "Gilberto", etc.
  if (!empty($nome)) {
      $sql .= " AND funcionario.nome LIKE '%" . mysqli_real_escape_string($conexao, $nome) . "%'";
  }

  // Ordena o resultado por nome em ordem crescente (A → Z)
  $sql .= " ORDER BY funcionario.nome ASC";

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
      while ($funcionario = mysqli_fetch_assoc($query)) {
?>
        <!-- Cada iteração do while gera uma linha <tr> da tabela HTML -->
        <tr>

          <!-- Código único do funcionário -->
          <td class="table-light"><?php echo $funcionario['codigo_funcionario']; ?></td>

          <!-- Foto do funcionário: se tiver foto cadastrada usa ela,
               senão usa uma imagem placeholder padrão.
               htmlspecialchars() evita XSS ao exibir o nome do arquivo. -->
          <td class="table-light">
            <?php 
              if (!empty($funcionario['foto'])) {
                echo '<img src="../../images/' . htmlspecialchars($funcionario['foto']) . '" 
                      alt="Foto do Funcionário" 
                      class="rounded-circle shadow-sm" 
                      style="width: 50px; height: 50px; object-fit: cover;">';
              } else {
                echo '<img src="../../assets/img/placeholder-funcionario.png" 
                      alt="Foto padrão" 
                      class="rounded-circle shadow-sm" 
                      style="width: 50px; height: 50px; object-fit: cover;">';
              }
            ?>
          </td>

          <!-- Nome do cargo (vem do JOIN com a tabela cargo) -->
          <td class="table-light"><?php echo htmlspecialchars($funcionario['cargo_nome']); ?></td>

          <!-- Nome do funcionário -->
          <td class="table-light"><?php echo htmlspecialchars($funcionario['nome']); ?></td>

          <!-- Data de nascimento: strtotime() converte a string do banco
               para timestamp Unix; date() formata para dd/mm/aaaa -->
          <td class="table-light"><?php echo date('d/m/Y', strtotime($funcionario['data_nascimento'])); ?></td>

          <!-- CPF do funcionário -->
          <td class="table-light"><?php echo htmlspecialchars($funcionario['cpf']); ?></td>

          <!-- Sexo: o banco guarda 'M', 'F' ou 'O' — aqui traduzimos
               para o texto legível. strtoupper() garante que 'm' e 'M'
               sejam tratados da mesma forma. -->
          <td class="table-light">
            <?php 
              $sexoFormatado = strtoupper($funcionario['sexo']);
              if      ($sexoFormatado == 'M') { echo 'Masculino'; } 
              elseif  ($sexoFormatado == 'F') { echo 'Feminino'; } 
              elseif  ($sexoFormatado == 'O') { echo 'Outro'; }
              else                            { echo 'Não Informado'; }
            ?>
          </td>

          <!-- Tipo de acesso: 1 = Administrador, qualquer outro = Comum -->
          <td class="table-light">
            <?php
              if ($funcionario['tipo_acesso'] == '1') {
                echo 'Administrador';
              } else {
                echo 'Comum';
              }
            ?>
          </td>

          <!-- Status: exibido como badge colorido do Bootstrap.
               1 = verde (Ativo), qualquer outro = vermelho (Inativo) -->
          <td class="table-light">
            <?php 
              if ($funcionario['status'] == 1) {
                echo '<span class="badge rounded-pill bg-success">Ativo</span>';
              } else {
                echo '<span class="badge rounded-pill bg-danger">Inativo</span>';
              }
            ?>
          </td>

          <!-- Data de cadastro no sistema, formatada igual à data de nascimento -->
          <td class="table-light"><?php echo date('d/m/Y', strtotime($funcionario['data_cadastro'])); ?></td>

          <!-- Botões de ação: Editar e Excluir.
               Passam o código do funcionário via GET na URL de destino. -->
          <td class="table-light"> 
            <a href="Editar.php?codigo_funcionario=<?php echo $funcionario['codigo_funcionario']; ?>" 
               class="btn btn-outline-success btn-sm" 
               title="Editar">
              <i class="bi bi-pencil"></i> <!-- Ícone de lápis (Bootstrap Icons) -->
            </a>
            <a href="Excluir.php?codigo_funcionario=<?php echo $funcionario['codigo_funcionario']; ?>" 
               class="btn btn-outline-danger btn-sm" 
               title="Excluir">
              <i class="bi bi-trash"></i> <!-- Ícone de lixeira (Bootstrap Icons) -->
            </a>
          </td>

        </tr>
<?php 
      } // Fim do while — próxima linha do resultado

  } else {
      // Nenhum funcionário encontrado: exibe mensagem centralizada
      // colspan="11" faz a célula ocupar todas as 11 colunas da tabela
      echo '<tr>
              <td colspan="11" class="text-center table-light text-danger py-3">
                Nenhum funcionário encontrado com estes filtros!
              </td>
            </tr>';
  }
?>