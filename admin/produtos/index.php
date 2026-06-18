<?php 
  // Abrindo a Conexão com o banco de dados
  require_once __DIR__ .'/../../conexao/conecta.php';

 // Verificando se o usuário está autenticado para permitir o acesso à página de administração
  include_once '../Usuario_Comum.php'; // Verifica se o usuário está logado (qualquer tipo de usuário)
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PAINEL ADMINISTRATIVO</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="../../assets/css/dashboard.min.css">
  <link rel="stylesheet" href="../../assets/css/styles.min.css">
  <link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon">
</head>
<body>

  <?php include('../Topo.php'); 
  ?>

  <div class="container-fluid">
    <div class="row">
      <?php include('../Navegacao.php'); 
      ?>

      <main class="ms-auto col-lg-10 px-md-4">
        <?php 
        include('../Log.php');
        include('../Mensagem.php');
        ?>
        
        <div class="card">
          <div class="card-header d-flex justify-content-between" style="background-color: #2b3d4f; color: white;">
            <h4 class="m-0">Produtos</h4>
            <a href="Inserir.php" class="btn btn-light btn-sm">
              <i class="bi bi-plus"></i> Adicionar
            </a>
          </div>

            <?php 
            $sql = "SELECT * FROM produto ORDER BY nome ASC";
            $query = mysqli_query($conexao, $sql);
            if (mysqli_num_rows($query) > 0) {
            ?>
          
          <div class="card-body">
            <div class="row">
              <div class="col-2">
                <form action="" onsubmit="event.preventDefault();">
                  <select name="status" id="status" class="form-control" onchange="buscar()">
                    <option value="">Status</option>
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
                  </select>
                </form>
              </div>

              <div class="col-3">
                <form action="" onsubmit="event.preventDefault();">
                  <input type="search" name="pesquisa" id="pesquisa" class="form-control" placeholder="Pesquisar por nome..." onkeyup="buscar()">
                </form>
              </div>

              <div class="col-2">
                <form action="" onsubmit="event.preventDefault();">
                  <select name="promocao" id="promocao" class="form-control" onchange="buscar()">
                    <option value="">Promoção</option>
                    <option value="1">Sim</option>
                    <option value="0">Não</option>
                  </select>
                </form>
              </div>

              <div class="col-2">
                <form action="" onsubmit="event.preventDefault();">
                  <select name="estoque" id="estoque" class="form-control" onchange="buscar()">
                    <option value="">Estoque</option>
                    <option value="1">Em Estoque</option>
                    <option value="2">Estoque Baixo</option>
                    <option value="3">Fora de Estoque</option>
                  </select>
                </form>
              </div>

              <div class="col-md-3">
                <select name="marca" id="marca" class="form-control" onchange="buscar()">
                  <option value="">Marca</option>
                  <?php 
                    $sql_marca = "SELECT codigo_marca, nome FROM marca WHERE status = 1 ORDER BY nome";
                    $query_marca = mysqli_query($conexao, $sql_marca);
                    if ($query_marca) {
                      foreach($query_marca as $marca) {
                        echo '<option value="' . htmlspecialchars($marca['codigo_marca']) . '">' 
                             . htmlspecialchars($marca['nome']) . '</option>';
                      }
                    }
                  ?>
                </select>
              </div>
            </div>

        <div class="card-body mt-3 p-0">
          <table class="table table-striped table-hover">
              <thead>
                  <tr style="background-color: #2b3d4f; color: white;"> 
                      <th class="text-white" style="background-color: #2b3d4f; color: white;">Código</th>
                      <th class="text-white" style="background-color: #2b3d4f; color: white;">Produto</th>
                      <th class="text-white" style="background-color: #2b3d4f; color: white;">Foto</th>
                      <th class="text-white" style="background-color: #2b3d4f; color: white;">Descrição</th>
                      <th class="text-white" style="background-color: #2b3d4f; color: white;">Preço</th>
                      <th class="text-white" style="background-color: #2b3d4f; color: white;">Estoque</th>
                      <th class="text-white" style="background-color: #2b3d4f; color: white;">Promoção</th>
                      <th class="text-white" style="background-color: #2b3d4f; color: white;">Status</th>
                      <th class="text-white" style="background-color: #2b3d4f; color: white;">Data Cadastro</th>
                      <th class="text-white" style="background-color: #2b3d4f; color: white;">Ações</th>
                  </tr>
              </thead>
              <tbody id="resultado-pesquisa">
                <?php foreach ($query as $produto) { ?>
                <tr>
                  <td class="table-light"><?php echo $produto['codigo_produto'] ?></td>
                  <td class="table-light"><?php echo $produto['nome'] ?></td>
                  <td class="table-light">
                    <img src="../../images/<?php echo htmlspecialchars($produto['foto']); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                  </td>
                  <td class="table-light"><?php echo $produto['descricao'] ?></td>
                  <td class="table-light">R$ <?php echo number_format($produto['preco_venda'], 2, ',', '.') ?></td>
                  <td class="table-light"><?php echo $produto['qtde_estoque'] ?></td>
                  <td class="table-light"><?php 
                    if ($produto['status_promocao'] == 1) {
                      echo '<span class="badge rounded-pill bg-success">Sim</span>';
                    } else {
                      echo '<span class="badge rounded-pill bg-danger">Não</span>';
                    }
                  ?></td>
                  <td class="table-light"><?php 
                    if ($produto['status'] == 1) {
                      echo '<span class="badge rounded-pill bg-success">Ativo</span>';
                    } else {
                      echo '<span class="badge rounded-pill bg-danger">Inativo</span>';
                    }
                  ?></td>
                  <td class="table-light"><?php echo date('d/m/Y', strtotime($produto['data_cadastro'])) ?></td>
                  <td class="table-light">
                    <a href="Editar.php?codigo_produto=<?php echo $produto['codigo_produto'] ?>" class="btn btn-outline-success btn-sm" title="Editar">
                      <i class="bi bi-pencil"> </i>
                    </a>
                    <form action="Acoes.php" method="POST" class="d-inline">
                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Excluir" name="deletar_produto" value="<?php echo $produto['codigo_produto']; ?>" onclick="return confirm('Tem certeza que deseja excluir o produto <?php echo $produto['nome']; ?>?');">
                      <i class="bi bi-trash"> </i>
                    </button>
                  </form>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
        </div>

          <?php 
            } else {
              echo '<div class="alert alert-danger mx-3 mt-3" role="alert">Nenhum produto encontrado!</div>';
            }
          ?>

        </div>
      </main>
    </div>
  </div>

  <?php mysqli_close($conexao); ?>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

  <script>
    function buscar() {
      var pesquisa = $('#pesquisa').val();
      var status = $('#status').val();
      var promocao = $('#promocao').val();
      var estoque = $('#estoque').val();
      var marca = $('#marca').val();

      $.ajax({
        url: 'Tabela.php',
        type: 'POST',
        data: {
          produto: pesquisa,
          status: status,
          promocao: promocao,
          estoque: estoque,
          marca: marca
        },
        success: function(data) {
          // Atualiza apenas as linhas da tabela
          $('#resultado-pesquisa').html(data);
        }
      });
    }
  </script>
</body>
</html>