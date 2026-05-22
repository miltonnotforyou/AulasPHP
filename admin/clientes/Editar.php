<?php 
  // Conexão com o banco de dados
  require_once __DIR__ .'/../../conexao/conecta.php';

  ######## Inicia a sessão#######

if (!isset($_SESSION)) 
{
    session_start();
}

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

          if(isset($_GET['codigo_cliente']) && $_GET['codigo_cliente'] != '')          
        {

          $codigo = intval($_GET['codigo_cliente']); // Recebe o código via GET
          $sql = "SELECT * FROM cliente WHERE codigo_cliente = $codigo"; 
          $query = mysqli_query($conexao, $sql); 
          $cliente = mysqli_fetch_assoc($query); 
        ?>
        
        <div class="card">
          <div class="card-header d-flex justify-content-between" style="background-color: #2b3d4f; color: white;">
            <h4 class="m-0">Editar Cliente</h4>
            <a href="index.php" class="btn btn-light btn-sm" >
              <i class="bi bi-arrow-left-short"></i>
              Voltar
            </a>
          </div>

          <div class="card-body">
            <form action="Acoes.php" method="post" enctype="multipart/form-data"> 
                        
                <div class="row">       
                    <div class="col-8 hr mt-1">
                        <h6>Dados Pessoais</h6>
                    </div>
                                                
                    <div class="row mt-2">
                        <div class="col-2 mt-2">
                            <label for="data_cadastro"><strong class="text-danger">*</strong> Data Cadastro</label>
                            <input type="date" name="data_cadastro" id="data_cadastro" class="form-control" value="<?php echo date('Y-m-d', strtotime($cliente['data_cadastro'])); ?>" readonly>
                        </div>                               
                        <div class="col-5 mt-2">
                            <label for="nome"><strong class="text-danger">*</strong> Nome</label>
                            <input type="text" name="nome" id="nome" class="form-control" maxlength="60" value="<?php echo htmlspecialchars($cliente['nome']); ?>" required>
                        </div>

                        <div class="col-5 mt-2">
                            <label for="nome_social">Nome Social</label>
                            <input type="text" name="nome_social" id="nome_social" class="form-control" maxlength="60" value="<?php echo htmlspecialchars($cliente['nome_social']); ?>">
                        </div>

                        <div class="col-md-3 mt-2">
                            <label for="data_nascimento"><strong class="text-danger">*</strong> Data Nascimento</label>
                            <input type="date" name="data_nascimento" id="data_nascimento" class="form-control" placeholder="dd/mm/aaaa" value="<?php echo $cliente['data_nascimento']; ?>" required max="9999-12-31">
                        </div>

                        <div class="col-md-3 mt-2">
                            <label for="sexo"><strong class="text-danger">*</strong> Sexo</label>
                            <select name="sexo" id="sexo" class="form-control" required>
                                <option value="">Selecione</option>
                                <option value="M" <?php if($cliente['sexo'] == 'M') echo 'selected'; ?>>Masculino</option>
                                <option value="F" <?php if($cliente['sexo'] == 'F') echo 'selected'; ?>>Feminino</option>
                                <option value="O" <?php if($cliente['sexo'] == 'O') echo 'selected'; ?>>Não Informado</option>
                            </select>
                        </div>

                        <div class="col-md-3 mt-2">
                            <label for="CPF"><strong class="text-danger">*</strong> CPF</label>
                            <input type="text" name="CPF" id="CPF" class="form-control" placeholder="000.000.000-00" maxlength="14" required data-mask="000.000.000-00" value="<?php echo $cliente['cpf']; ?>">
                        </div>

                        <div class="col-md-3 mt-2">
                            <label for="RG">RG</label>
                            <input type="text" name="RG" id="RG" class="form-control" placeholder="00.000.000-A" maxlength="12" data-mask="00.000.000-A" value="<?php echo $cliente['rg']; ?>">
                        </div>
                    </div>
                            
                    <div class="row mt-3 mb-4"> 
                        <div class="hr">
                            <hr>
                            <h6>Endereço</h6>
                        </div>
                                            
                        <div class="col-md-2 mt-2">
                            <label for="cep"><strong class="text-danger">*</strong> CEP</label>
                            <input type="text" name="cep" id="cep" class="form-control" placeholder="00000-000" maxlength="9" required data-mask="00000-000" onblur="pesquisacep(this.value);" value="<?php echo htmlspecialchars($cliente['cep'] ?? $cliente['CEP'] ?? ''); ?>">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label for="endereco"><strong class="text-danger">*</strong> Endereço</label>
                            <input type="text" name="endereco" id="rua" class="form-control" maxlength="70" required value="<?php echo htmlspecialchars($cliente['endereco']); ?>">
                        </div>

                        <div class="col-md-2 mt-2">                    
                            <label for="numero"><strong class="text-danger">*</strong> Número</label>
                            <input type="text" name="numero" id="numero" class="form-control" maxlength="4" required value="<?php echo htmlspecialchars($cliente['numero']); ?>">
                        </div>

                        <div class="col-md-2 mt-2"> 
                            <label for="complemento"> Complemento</label>
                            <input type="text" name="complemento" id="complemento" class="form-control" maxlength="40" value="<?php echo htmlspecialchars($cliente['complemento']); ?>">
                        </div>

                        <div class="col-md-4 mt-2">
                            <label for="bairro"><strong class="text-danger">*</strong> Bairro</label>
                            <input type="text" name="bairro" id="bairro" class="form-control" maxlength="30" required value="<?php echo htmlspecialchars($cliente['bairro']); ?>">
                        </div>

                        <div class="col-md-4 mt-2">
                            <label for="cidade"><strong class="text-danger">*</strong> Cidade</label>
                            <input type="text" name="cidade" id="cidade" class="form-control" maxlength="40" required value="<?php echo htmlspecialchars($cliente['cidade']); ?>">
                        </div>

                        <div class="col-md-4 mt-2">
                            <label for="estado"><strong class="text-danger">*</strong> Estado</label>
                            <select name="estado" id="uf" class="form-control" required>
                                <option value="" disabled>Selecione</option>
                                <option value="AC" <?php if($cliente['estado'] == 'AC') echo 'selected'; ?>>AC</option>
                                <option value="AL" <?php if($cliente['estado'] == 'AL') echo 'selected'; ?>>AL</option>
                                <option value="AM" <?php if($cliente['estado'] == 'AM') echo 'selected'; ?>>AM</option>
                                <option value="AP" <?php if($cliente['estado'] == 'AP') echo 'selected'; ?>>AP</option>
                                <option value="BA" <?php if($cliente['estado'] == 'BA') echo 'selected'; ?>>BA</option>
                                <option value="CE" <?php if($cliente['estado'] == 'CE') echo 'selected'; ?>>CE</option>
                                <option value="DF" <?php if($cliente['estado'] == 'DF') echo 'selected'; ?>>DF</option>
                                <option value="ES" <?php if($cliente['estado'] == 'ES') echo 'selected'; ?>>ES</option>
                                <option value="GO" <?php if($cliente['estado'] == 'GO') echo 'selected'; ?>>GO</option>
                                <option value="MA" <?php if($cliente['estado'] == 'MA') echo 'selected'; ?>>MA</option>
                                <option value="MG" <?php if($cliente['estado'] == 'MG') echo 'selected'; ?>>MG</option>
                                <option value="MS" <?php if($cliente['estado'] == 'MS') echo 'selected'; ?>>MS</option>
                                <option value="MT" <?php if($cliente['estado'] == 'MT') echo 'selected'; ?>>MT</option>
                                <option value="PA" <?php if($cliente['estado'] == 'PA') echo 'selected'; ?>>PA</option>
                                <option value="PB" <?php if($cliente['estado'] == 'PB') echo 'selected'; ?>>PB</option>
                                <option value="PE" <?php if($cliente['estado'] == 'PE') echo 'selected'; ?>>PE</option>
                                <option value="PI" <?php if($cliente['estado'] == 'PI') echo 'selected'; ?>>PI</option>
                                <option value="PR" <?php if($cliente['estado'] == 'PR') echo 'selected'; ?>>PR</option>
                                <option value="RJ" <?php if($cliente['estado'] == 'RJ') echo 'selected'; ?>>RJ</option>
                                <option value="RN" <?php if($cliente['estado'] == 'RN') echo 'selected'; ?>>RN</option>
                                <option value="RO" <?php if($cliente['estado'] == 'RO') echo 'selected'; ?>>RO</option>
                                <option value="RR" <?php if($cliente['estado'] == 'RR') echo 'selected'; ?>>RR</option>
                                <option value="RS" <?php if($cliente['estado'] == 'RS') echo 'selected'; ?>>RS</option>
                                <option value="SC" <?php if($cliente['estado'] == 'SC') echo 'selected'; ?>>SC</option>
                                <option value="SE" <?php if($cliente['estado'] == 'SE') echo 'selected'; ?>>SE</option>
                                <option value="SP" <?php if($cliente['estado'] == 'SP') echo 'selected'; ?>>SP</option>
                                <option value="TO" <?php if($cliente['estado'] == 'TO') echo 'selected'; ?>>TO</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-2 mb-4"> 
                        <div class="hr">
                            <hr>
                            <h6>Dados de Contato</h6>
                        </div>
                
                        <div class="col-4 mt-2">
                            <label for="telefone_residencial">Telefone Residencial</label>
                            <input type="text" name="telefone_residencial" id="telefone_residencial" class="form-control" placeholder="(00) 0000-0000" maxlength="13" data-mask="(00) 0000-0000" value="<?php echo htmlspecialchars($cliente['telefone_residencial']); ?>">
                        </div>

                        <div class="col-4 mt-2">
                            <label for="telefone_celular"><strong class="text-danger">*</strong> Telefone Celular</label>
                            <input type="text" name="telefone_celular" id="telefone_celular" class="form-control" placeholder="(00) 00000-0000" maxlength="14" required data-mask="(00) 00000-0000" value="<?php echo htmlspecialchars($cliente['telefone_celular']); ?>">
                        </div>

                        <div class="col-4 mt-2">
                            <label for="email"><strong class="text-danger">*</strong> Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="exemplo@dominio.com" required value="<?php echo htmlspecialchars($cliente['email']); ?>">
                        </div>

                        <div class="col-3 mt-2">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" <?php if($cliente['status'] == 1) echo 'selected'; ?>>Ativo</option>
                                <option value="0" <?php if($cliente['status'] == 0) echo 'selected'; ?>>Inativo</option>
                            </select>
                        </div>
                                                               
                        <div class="col-3 mt-2 d-flex align-items-end">
                            <input type="hidden" name="editar" value="editar_cliente">
                            <input type="hidden" name="codigo_cliente" value="<?php echo $codigo; ?>">
                            
                            <input type="submit" value="Editar" class="btn btn-dark"> 
                        </div>
                    </div>   
                </div>                  
            </form>
          </div>
        </div>
        
      <?php 
        } else {
            echo '<div class="alert alert-warning text-center mt-4 mx-3">Nenhum cliente selecionado para edição!</div>';
        }
      ?>   

      </main>
    </div>
  </div>

  <?php 
    if(isset($conexao)) mysqli_close($conexao); 
  ?>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

  <script src= "../../assets/js/jquery.mask.js"></script>

  <script src= "../../assets/js/cep.js"></script>

  <script src="../../custom/js/script.js"></script>

</body>
</html>