<?php 
  // Conexão com o banco de dados
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

  <!-- FAVICON -->
    <link rel="shortcut icon" href="../../logo/logotipo_light.png" type="image/x-icon">

</head>

<body>
  <?php
    #Início TOPO
    include('../Topo.php');
    #Final TOPO
  ?>

  <div class="container-fluid">
    <div class="row">
      <?php
        #Início MENU
        include('../Navegacao.php');
        #Final MENU
      ?>

      <main class="ms-auto col-lg-10 px-md-4">
         <?php
          include('../Log.php');
          include('../Mensagem.php');

          // Verifica se o ID do produto foi passado na URL
          if(isset($_GET['codigo_produto']) && $_GET['codigo_produto'] != '')          
          {
              $codigo = intval($_GET['codigo_produto']); // Recebe o código via GET
              $sql = "SELECT * FROM produto WHERE codigo_produto = $codigo"; 
              $query = mysqli_query($conexao, $sql); 
              $produto = mysqli_fetch_assoc($query);
        ?>
        
        <div class="card">
          <div class="card-header d-flex justify-content-between" style="background-color: #2b3d4f; color: white;">
            <h4 class="m-0">Editar Produto</h4>
            <a href="index.php" class="btn btn-light btn-sm" >
              <i class="bi bi-arrow-left-short"></i>
              Voltar
            </a>
          </div>

          <div class="card-body">
            <form action="Acoes.php" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3 mt-4 d-flex justify-content-center" img-fluid>
                        <?php 
// 1. Pega o nome da foto e limpa os espaços
$nome_foto = trim($produto['foto'] ?? '');

// 2. Caminho FÍSICO para o PHP verificar (usando __DIR__ para não ter erro de include)
$caminho_fisico = __DIR__ . '/../../images/' . $nome_foto;

// 3. Caminho da URL para o navegador (HTML) renderizar a imagem
$caminho_url = '../../images/' . $nome_foto;

// 4. Verifica se tem nome no banco e se o arquivo está lá na pasta do servidor
if(!empty($nome_foto) && file_exists($caminho_fisico)) {
    
    echo '<img src="' . $caminho_url . '" id="preview-foto" alt="Foto do Produto" class="rounded" style="width: 350px; height: 350px; object-fit: cover;">';
    
} else {
    
    // Placeholder caso a foto não exista na pasta
    echo '<img src="../../assets/img/placeholder-produto.jpg" id="preview-foto" alt="Foto sem Imagem" class="rounded" style="width: 350px; height: 350px; object-fit: cover;">';
    
}
?>
                    </div>

                    <div class="col-md-9">
                        <div class="row">
                            
                            <div class="col-md-4 mt-2">
                                <label for="foto">Foto Principal (Capa)</label>
                                <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                                <small class="text-muted" style="font-size: 0.75rem;">Deixe em branco para manter a atual.</small>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="foto2">Foto Extra 1</label>
                                <input type="file" name="foto2" id="foto2" class="form-control" accept="image/*">
                                <small class="text-muted" style="font-size: 0.75rem;">Deixe em branco para manter a atual.</small>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="foto3">Foto Extra 2</label>
                                <input type="file" name="foto3" id="foto3" class="form-control" accept="image/*">
                                <small class="text-muted" style="font-size: 0.75rem;">Deixe em branco para manter a atual.</small>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="foto4">Foto Extra 3</label>
                                <input type="file" name="foto4" id="foto4" class="form-control" accept="image/*">
                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="foto5">Foto Extra 4</label>
                                <input type="file" name="foto5" id="foto5" class="form-control" accept="image/*">
                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="foto6">Foto Extra 5</label>
                                <input type="file" name="foto6" id="foto6" class="form-control" accept="image/*">
                            </div>

                            <div class="col-12 mt-3"><hr class="text-secondary"></div>

                            <div class="col-md-7 mt-2">
                                <label for="nome"><strong class="text-danger">*</strong> Nome</label>
                                <input type="text" name="nome" id="nome" class="form-control" maxlength="60" required value="<?php echo htmlspecialchars($produto['nome']); ?>">
                            </div>
                            <div class="col-md-2 mt-2">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1" <?php if($produto['status'] == 1) echo 'selected'; ?>>Ativo</option>
                                    <option value="0" <?php if($produto['status'] == 0) echo 'selected'; ?>>Inativo</option>
                                </select>
                            </div>
                            <div class="col-md-3 mt-2">
                                <label for="data_cadastro"><strong class="text-danger">*</strong> Data Cadastro</label>
                                <input type="date" name="data_cadastro" id="data_cadastro" class="form-control" value="<?php echo date('Y-m-d', strtotime($produto['data_cadastro'])); ?>" readonly>
                            </div>

                            <div class="col-md-3 mt-2">
                                <label for="preco_custo"><strong class="text-danger">*</strong> Preço de Custo</label>
                                <input type="number" name="preco_custo" id="preco_custo" class="form-control" step="0.01" min="0" required oninput="calcularLucro()" value="<?php echo $produto['preco_custo']; ?>">
                            </div>
                            <div class="col-md-3 mt-2">
                                <label for="lucro"><strong class="text-danger">*</strong> Lucro %</label>
                                <input type="number" name="lucro" id="lucro" class="form-control" step="0.01" min="0" required oninput="calcularLucro()" value="<?php echo $produto['lucro']; ?>">
                            </div>
                            <div class="col-md-3 mt-2">
                                <label for="preco_venda"><strong class="text-danger">*</strong> Preço de Venda</label>
                                <input type="number" name="preco_venda" id="preco_venda" class="form-control" step="0.01" min="0" readonly value="<?php echo $produto['preco_venda']; ?>">
                            </div>
                            <div class="col-md-3 mt-2">
                                <label for="qtde_estoque"><strong class="text-danger">*</strong> Estoque</label>
                                <input type="number" name="qtde_estoque" id="qtde_estoque" class="form-control" min="0" required value="<?php echo $produto['qtde_estoque']; ?>">
                            </div>
                            
                            <div class="col-md-2 mt-2">                    
                                <label for="status_promocao">Status Promo</label>
                                <select name="status_promocao" id="status_promocao" class="form-control" onchange="desabilitar()">
                                    <option value="1" <?php if($produto['status_promocao'] == 1) echo 'selected'; ?>>Ativo</option>
                                    <option value="0" <?php if($produto['status_promocao'] == 0) echo 'selected'; ?>>Inativo</option>                                                            
                                </select>
                            </div>

                            <div class="col-md-2 mt-2"> 
                                <label for="desconto_promocao"> Desc %</label>
                                <input type="number" name="desconto_promocao" id="desconto_promocao" class="form-control" oninput="calcularPrecoPromocao()" value="<?php echo $produto['desconto_promocao']; ?>">
                            </div>

                            <div class="col-md-2 mt-2">
                                <label for="preco_promocao">Preço Promo</label>
                                <input type="number" name="preco_promocao" id="preco_promocao" class="form-control" step="0.01" min="0" readonly value="<?php echo $produto['preco_promocao']; ?>">
                            </div>

                            <div class="col-md-3 mt-2">
                                <label for="marca"><strong class="text-danger">*</strong>Marca</label>
                                <select name="marca" id="marca" class="form-control" required>
                                    <option value="">Selecione</option>
                                    <?php 
                                        $sql_marca = "SELECT codigo_marca, nome FROM marca WHERE status = 1";
                                        $query_marca = mysqli_query($conexao, $sql_marca);
                                        if($query_marca){
                                            foreach($query_marca as $marca) {
                                                $selecionado = ($produto['codigo_marca'] == $marca['codigo_marca']) ? 'selected' : '';
                                                echo '<option value="' . $marca['codigo_marca'] . '" ' . $selecionado . '>' . $marca['nome'] . '</option>';
                                            }
                                        }
                                    ?>
                                </select>                         
                            </div>

                            <div class="col-md-3 mt-2">
                                <label for="categoria"><strong class="text-danger">*</strong> Categoria</label>
                                <select name="categoria" id="categoria" class="form-control" required>
                                    <option value="">Selecione</option>
                                    <?php 
                                        $sql_categoria = "SELECT codigo_categoria, nome FROM categoria WHERE status = 1";
                                        $query_categoria = mysqli_query($conexao, $sql_categoria);
                                        if($query_categoria){
                                            foreach($query_categoria as $categoria) {
                                                $selecionado = ($produto['codigo_categoria'] == $categoria['codigo_categoria']) ? 'selected' : '';
                                                echo '<option value="' . $categoria['codigo_categoria'] . '" ' . $selecionado . '>' . $categoria['nome'] . '</option>';
                                            }
                                        }
                                    ?>
                                </select>                         
                            </div>

                            <div class="col-12 mt-3">
                                <label for="descricao">Descrição:</label>
                                <textarea name="descricao" id="descricao" class="form-control" maxlength="100" rows="3"><?php echo htmlspecialchars($produto['descricao']); ?></textarea>

                                <input type="hidden" name="editar" value="editar_produto"> 
                                <input type="hidden" name="codigo_produto" value="<?php echo $codigo; ?>"> 

                                <button type="submit" class="btn btn-dark mt-3 px-4">Salvar Alterações</button>
                            </div>

                        </div> </div> </div> </form> 
          </div>
        </div>
        
        <?php 
          } else {
              echo '<div class="alert alert-warning text-center mt-4 mx-3">Nenhum produto selecionado para edição!</div>';
          }
        ?>

      </main>
    </div>
  </div>

  <?php 
    // Fechando a conexão que abrimos no topo
    if(isset($conexao)) mysqli_close($conexao); 
  ?>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

  <script src="../../assets/js/jquery.mask.js"></script>

  <script src="../../assets/js/cep.js"></script>

   <script src="../../assets/js/preview_foto.js"></script>

    <script src="../../custom/js/script.js"></script>

</body>
</html>