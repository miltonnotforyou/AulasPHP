<?php 
  // Conexão com o banco de dados
  require_once('../../conexao/conecta.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>PAINEL ADMINISTRATIVO</title>

  <!-- BOOTSTRAP CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

  <!-- BOOTSTRAP ICONS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

  <!-- CUSTOMIZAÇÃO DO TEMPLATE -->
  <link rel="stylesheet" href="../../assets/css/dashboard.min.css">
  <link rel="stylesheet" href="../../assets/css/styles.min.css">

  <!-- FAVICON -->
  <link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon">

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
        ?>
        
        <div class="card">
          <div class="card-header d-flex justify-content-between" style="background-color: #2b3d4f; color: white;">
            <h4 class="m-0">Novo Produto</h4>
            <a href="index.php" class="btn btn-light btn-sm" >
              <i class="bi bi-arrow-left-short"></i>

              Voltar
            </a>
            </div>

          
                                    
                           

               <div class="card-body">
                <form action="Acoes.php" method="post" enctype="multipart/form-data">
                    <div class="row ">
                        <div class="col-md-3 d-flex justify-content-center">
                            <img src="../../assets/img/placeholder-produto.jpg"
                                id="preview-foto" 
                                alt="Foto do Produto" 
                                class="rounded" 
                                style="width: 250px; height: 250px; object-fit: cover;">
                        </div>

                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-4 mt-2">
                                    <label for="foto">Foto do Produto</label>
                                    <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                    </div>
                    
                    <div class="col-md-5 mt-2">
                        <label for="nome"><strong class="text-danger">*</strong> Nome</label>
                        <input type="text" name="nome" id="nome" class="form-control" maxlength="60" required>
                    </div>

                    <div class="col-md-3 mt-2">
                        <label for="data_cadastro"><strong class="text-danger">*</strong> Data Cadastro</label>
                        <input type="date" name="data_cadastro" id="data_cadastro" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly>
                    </div>

                    <div class="col-md-3 mt-2">
                        <label for="preco_custo"><strong class="text-danger">*</strong> Preço de Custo</label>
                        <input type="number" name="preco_custo" id="preco_custo" class="form-control" step="0.01" min="0" required oninput="lucro()">
                    </div>

                     <div class="col-md-3 mt-2">
                        <label for="valor_lucro"><strong class="text-danger">*</strong> Lucro %</label>
                        <input type="number" name="valor_lucro" id="valor_lucro" class="form-control" step="0.01" min="0" required oninput="lucro()">
                    </div>

                    <div class="col-md-3 mt-2">
                        <label for="preco_venda"><strong class="text-danger">*</strong> Preço de Venda</label>
                        <input type="number" name="preco_venda" id="preco_venda" class="form-control" step="0.01" min="0" readonly>
                    </div>

                    <div class="col-md-2 mt-2">
                        <label for="qtde_estoque"><strong class="text-danger">*</strong> Quantidade em Estoque</label>
                        <input type="number" name="qtde_estoque" id="qtde_estoque" class="form-control" min="0" required>
                    </div>

                    <div class="col-md-2 mt-2">                    
                        <label for="status_promocao">Status Promoção</label>
                        <select name="status_promocao" id="status_promocao" class="form-control" onchange="desabilitar()">
                            <option value="">Selecione</option>
                            <option value="1">Ativo</option>
                            <option value="0">Inativo</option>                                                            
                        </select>
                    </div>

                    <div class="col-md-2 mt-2"> 
                        <label for="desconto_promocao"> Desconto %</label>
                        <input type="number" name="desconto_promocao" id="desconto_promocao" class="form-control" oninput="calcularPrecoPromocao()">
                    </div>

                    <div class="col-md-2 mt-2">
                        <label for="preco_promocao">Preço Promoção</label>
                        <input type="number" name="preco_promocao" id="preco_promocao" 
                            class="form-control" step="0.01" min="0" readonly>
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
                                        echo '<option value="' . $marca['codigo_marca'] . '">' . $marca['nome'] . '</option>';
                                    }
                                }
                            ?>
                        </select>                         
                    </div>

                    <div class="col-md-4 mt-2">
                        <label for="categoria"><strong class="text-danger">*</strong> Categoria</label>
                        <select name="categoria" id="categoria" class="form-control" required>
                            <option value="">Selecione</option>
                            <?php 
                                $sql_categoria = "SELECT codigo_categoria, nome FROM categoria WHERE status = 1";
                                $query_categoria = mysqli_query($conexao, $sql_categoria);
                                if($query_categoria){
                                    foreach($query_categoria as $categoria) {
                                        echo '<option value="' . $categoria['codigo_categoria'] . '">' . $categoria['nome'] . '</option>';
                                    }
                                }
                            ?>
                        </select>                         
                    </div>

                    <div class="col-md-3 mt-2">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" disabled>
                            <option value="1">Ativo</option>
                            <option value="0">Inativo</option>
                        </select>
                    </div>

                    <div class="col-12 mt-2">
                    <label for="observacao">Descrição:</label>
                    <textarea name="observacao" id="observacao" class="form-control" maxlength="100"></textarea>

                    <!-- Campo oculto para identificar a ação de cadastro de marca -->
                    <input type="hidden" name="cadastrar" value="cadastrar_produto"> 

                    <input type="submit" value="Cadastrar" class="btn btn-dark mt-3">
                </div>
                </div> 
            </div> 
        </form> 
    </div> 
</div>
</div>
        
        

      </main>
    </div>
  </div>

  <?php 
    // Fechando a conexão que abrimos no topo
    if(isset($conexao)) mysqli_close($conexao); 
  ?>

  <!-- JQUERY CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  
  
  <!-- BOOTSTRAP JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

  <!-- JQUERY MASK -->
  <script src="../../assets/js/jquery.mask.js"></script>

  <!-- JAVASCRIPT CEP -->
  <script src="../../assets/js/cep.js"></script>

   <!-- JAVASCRIPT PREVIEW FOTO -->
  
  <script src="../../assets/js/preview_foto.js"></script>

    <!-- JAVASCRIPT LUCRO e Desconto -->
   
  <script src="../../custom/js/script.js"></script>

</body>
</html>