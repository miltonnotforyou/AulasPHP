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
            <h4 class="m-0">Novo Funcionário</h4>
            <a href="index.php" class="btn btn-light btn-sm" >
              <i class="bi bi-arrow-left-short"></i>

              Voltar
            </a>
            </div>

          

                

          <div class="card-body">
            <form action="" method="post">
                
                <!-- Dados Pessoais -->
               

               <div class="card-body">
                    <form action="" method="post">
                        
                        <div class="hr ms-5">
                            <h6>Dados Pessoais</h6>
                        </div>

                        <div class="row mt-3">
                            <div class="col-mt-2 col-3 d-flex ">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/d/d8/El_Chapul%C3%ADn_Colorado_logo.svg" 
                                    alt="Foto de Perfil" 
                                    class="rounded" 
                                    style="width: 250px; height: 250px; object-fit: cover;">
                            </div>

                            <div class="col">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <label for="foto"><strong class="text-danger">*</strong> Foto de Perfil</label>
                                        <input type="file" name="foto" id="foto" class="form-control" accept="image/*" required>
                                    </div>
                                    
                                    <div class="col-6 mt-2">
                                        <label for="nome"><strong class="text-danger">*</strong> Nome</label>
                                        <input type="text" name="nome" id="nome" class="form-control" maxlength="60" required>
                                    </div>

                                    <div class="col-6 mt-2">
                                        <label for="nome_social">Nome Social</label>
                                        <input type="text" name="nome_social" id="nome_social" class="form-control" maxlength="60">
                                    </div>

                                    <div class="col-md-3 mt-2">
                                        <label for="data_nascimento"><strong class="text-danger">*</strong> Data Nascimento</label>
                                        <input type="text" name="data_nascimento" id="data_nascimento" class="form-control" placeholder="dd/mm/aaaa" required>
                                    </div>

                                    <div class="col-md-3 mt-2">
                                        <label for="sexo"><strong class="text-danger">*</strong> Sexo</label>
                                        <select name="sexo" id="sexo" class="form-control" required>
                                            <option value="">Selecione</option>
                                            <option value="M">Masculino</option>
                                            <option value="F">Feminino</option>
                                            <option value="O">Outro</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 mt-2">
                                        <label for="estado_civil"><strong class="text-danger">*</strong> Estado Civil</label>
                                        <select name="estado_civil" id="estado_civil" class="form-control" required>
                                            <option value="">Selecione</option>
                                            <option value="S">Solteiro(a)</option>
                                            <option value="C">Casado(a)</option>
                                            <option value="D">Divorciado(a)</option>
                                            <option value="V">Viúvo(a)</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 mt-2">
                                        <label for="CPF"><strong class="text-danger">*</strong> CPF</label>
                                        <input type="text" name="CPF" id="CPF" class="form-control" placeholder="000.000.000-00" maxlength="14" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Dados de Endereço -->
                <div class="hr mt-2">
                <hr>
                <h6>Endereço</h6>
                </div>
                                            

                <div class="col-2 mt-2">
                    <label for="cep"><strong class="text-danger">*</strong> CEP</label>
                    <input type="text" name="cep" id="cep" class="form-control" placeholder="00000-000" maxlength="9" required>
                </div>

                <div class="col-6 mt-2">
                    <label for="endereco"><strong class="text-danger">*</strong> Endereço</label>
                    <input type="text" name="endereco" id="endereco" class="form-control" maxlength="70" required>
                </div>

                <div class="col-2 mt-2">                    
                    <label for="numero"><strong class="text-danger">*</strong> Número</label>
                    <input type="text" name="numero" id="numero" class="form-control" maxlength="4" required>
                </div>

                <div class="col-2 mt-2"> 
                    <label for="complemento"> Complemento</label>
                    <input type="text" name="complemento" id="complemento" class="form-control" maxlength="40">
                </div>

                <div class="col-4 mt-2">
                    <label for="bairro"><strong class="text-danger">*</strong> Bairro</label>
                    <input type="text" name="bairro" id="bairro" class="form-control" maxlength="30" required>
                </div>

                <div class="col-4 mt-2">
                    <label for="cidade"><strong class="text-danger">*</strong> Cidade</label>
                    <input type="text" name="cidade" id="cidade" class="form-control" maxlength="40" required>
                </div>

                <div class="col-4 mt-2">
                    <label for="estado"><strong class="text-danger">*</strong> Estado</label>
                    <select name="estado" id="estado" class="form-control" required>
                        <option value="" selected disabled>Selecione</option>
                        <option value="AC">AC</option>
                        <option value="AL">AL</option>
                        <option value="AM">AM</option>
                        <option value="AP">AP</option>
                        <option value="BA">BA</option>
                        <option value="CE">CE</option>
                        <option value="DF">DF</option>
                        <option value="ES">ES</option>
                        <option value="GO">GO</option>
                        <option value="MA">MA</option>
                        <option value="MG">MG</option>
                        <option value="MS">MS</option>
                        <option value="MT">MT</option>
                        <option value="PA">PA</option>
                        <option value="PB">PB</option>
                        <option value="PE">PE</option>
                        <option value="PI">PI</option>
                        <option value="PR">PR</option>
                        <option value="RJ">RJ</option>
                        <option value="RN">RN</option>
                        <option value="RO">RO</option>
                        <option value="RR">RR</option>
                        <option value="RS">RS</option>
                        <option value="SC">SC</option>
                        <option value="SE">SE</option>
                        <option value="SP">SP</option>
                        <option value="TO">TO</option>
                    </select>
                </div>

                <!-- Dados Contato -->
                <div class="hr mt-2">
                <hr>
                <h6>Dados de Contato</h6>
                </div>
                
                <div class="col-4 mt-2">
                    <label for="telefone_residencial">Telefone Residencial</label>
                    <input type="text" name="telefone_residencial" id="telefone_residencial" class="form-control" placeholder="(00) 0000-0000" maxlength="13">
                </div>

                <div class="col-4 mt-2">
                    <label for="telefone_celular"><strong class="text-danger">*</strong> Telefone Celular</label>
                    <input type="text" name="telefone_celular" id="telefone_celular" class="form-control" placeholder="(00) 0000-0000" maxlength="14" required>
                </div>

                
                <div class="col-4 mt-2">
                    
                    <label for="email"><strong class="text-danger">*</strong> Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="exemplo@dominio.com" required>
                </div>

                <!-- Dados Profissionais -->

                <div class="hr mt-2">
                <hr>
                <h6>Dados Profissionais</h6>
                </div>

                <div class="col-3 mt-2">
                    
                    <label for="cargo">Cargo</label>
                    <select name="cargo" id="cargo" class="form-control">
                        <option value="" >Selecione</option>
                        <option value="0">Gerente</option>
                        <option value="1" >Vendedor</option>
                                                                    
                      
                    </select>
                </div>

                <div class="col-3 mt-2">                    
                    <label for="salario"><strong class="text-danger">*</strong> Salário</label>
                    <input type="text" name="salario" id="salario" class="form-control" placeholder="0000,00" required>
                </div>
                                  
                              
                <div class="col-3 mt-2">
                    
                    <label for="usuario"><strong class="text-danger">*</strong> Usuário</label>
                    <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Nome de usuário" maxlength="15" required>
                </div>

                <div class="col-3 mt-2">
                    
                    <label for="senha"><strong class="text-danger">*</strong> Senha</label>
                    <input type="password" name="senha" id="senha" class="form-control" placeholder="Senha" maxlength="8" required>
                </div>

                <div class="col-3 mt-2">
                    
                    <label for="tipo_acesso"><strong class="text-danger">*</strong> Tipo de Acesso</label>
                    <select name="tipo_acesso" id="tipo_acesso" class="form-control" required>
                        <option value="">Selecione</option>
                        <option value="1">Administrador</option>
                        <option value="2">Funcionário</option>
                    </select>
                </div>

                <div class="col-3 mt-2">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" disabled>
                        <option value="1" >Ativo</option>
                        <option value="0">Inativo</option>
                                             
                      
                    </select>
                    
                 
               
                </div>
                                                               
                <div class="col-3 mt-2 d-flex align-items-end">
                    
                 <input type="submit" value="Cadastrar" class="btn btn-dark"> 
                </div>

                          

                     

                
                                              
                                     
               
                </div>                  
                
                             
                         
              
                             
                
            




            </div>
        </div>
        
        

      </main>
    </div>
  </div>
  
  <!-- JQUERY CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!-- BOOTSTRAP JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>