<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Crie sua Conta - IOT Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
   
     <!-- FontAwesome (ícones) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Arquivo de Estilos CSS -->
    <link rel="stylesheet" href="./src/style.css" />
    <!-- FAVICON -->
    <link rel="shortcut icon" href="../IOT_Store/logo/logotipo_light.png" type="image/x-icon">

</head>
<body>
    <!-- Container principal que envolve todo o site -->
    <div class="site-container">
        <!-- Cabeçalho-->
        <?php
        
            include('cabecalho.php');       
        ?>
        <!-- Fim do Cabeçalho -->

        <!-- Dados Pessoais -->
        <main class="container mt-5 mb-5">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between" style="background-color: #2b3d4f; color: white;">
                    <h4 class="m-0">Crie sua Conta</h4>
                </div>
                <div class="card-body">
                    <form action="processa_cadastro.php" method="POST">
                        
                        <div class="row">       
                            <div class="col-12 hr mt-1">
                                <h6 class="border-bottom pb-2">Dados Pessoais Os itens com <strong class="text-danger">*</strong> são obrigatórios!</h6>
                                                                
                            </div>
                                                    
                            <div class="row mt-2">
                                <div class="col-md-2 mt-2">
                                    <label for="data_cadastro"><strong class="text-danger">*</strong> Data Cadastro</label>
                                    <input type="date" name="data_cadastro" id="data_cadastro" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly>
                                </div>                               
                                <div class="col-md-5 mt-2">
                                    <label for="nome"><strong class="text-danger">*</strong> Nome</label>
                                    <input type="text" name="nome" id="nome" class="form-control" maxlength="60" required>
                                </div>

                                <div class="col-md-5 mt-2">
                                    <label for="nome_social">Nome Social</label>
                                    <input type="text" name="nome_social" id="nome_social" class="form-control" maxlength="60">
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label for="data_nascimento"><strong class="text-danger">*</strong> Data Nascimento</label>
                                    <input type="date" name="data_nascimento" id="data_nascimento" class="form-control" required max="9999-12-31">
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label for="sexo"><strong class="text-danger">*</strong> Sexo</label>
                                    <select name="sexo" id="sexo" class="form-control" required>
                                        <option value="">Selecione</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Feminino</option>
                                        <option value="O">Não Informado</option>
                                    </select>
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label for="CPF"><strong class="text-danger">*</strong> CPF</label>
                                    <input type="text" name="CPF" id="CPF" class="form-control" placeholder="000.000.000-00" maxlength="14" required>
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label for="RG">RG</label>
                                    <input type="text" name="RG" id="RG" class="form-control" placeholder="00.000.000-A" maxlength="12">
                                </div>
                            </div>
                                
                            <!-- Dados de Endereço -->
                            <div class="row mt-4 mb-4"> 
                                <div class="col-12 hr">
                                    <h6 class="border-bottom pb-2">Endereço</h6>
                                </div>
                                                
                                <div class="col-md-2 mt-2">
                                    <label for="cep"><strong class="text-danger">*</strong> CEP</label>
                                    <input type="text" name="cep" id="cep" class="form-control" placeholder="00000-000" maxlength="9" required onblur="pesquisacep(this.value);">
                                </div>

                                <div class="col-md-6 mt-2">
                                    <label for="endereco"><strong class="text-danger">*</strong> Endereço</label>
                                    <input type="text" name="endereco" id="rua" class="form-control" maxlength="70" required>
                                </div>

                                <div class="col-md-2 mt-2">                    
                                    <label for="numero"><strong class="text-danger">*</strong> Número</label>
                                    <input type="text" name="numero" id="numero" class="form-control" maxlength="4" required>
                                </div>

                                <div class="col-md-2 mt-2"> 
                                    <label for="complemento"> Complemento</label>
                                    <input type="text" name="complemento" id="complemento" class="form-control" maxlength="40">
                                </div>

                                <div class="col-md-4 mt-2">
                                    <label for="bairro"><strong class="text-danger">*</strong> Bairro</label>
                                    <input type="text" name="bairro" id="bairro" class="form-control" maxlength="30" required>
                                </div>

                                <div class="col-md-4 mt-2">
                                    <label for="cidade"><strong class="text-danger">*</strong> Cidade</label>
                                    <input type="text" name="cidade" id="cidade" class="form-control" maxlength="40" required>
                                </div>

                                <div class="col-md-4 mt-2">
                                    <label for="estado"><strong class="text-danger">*</strong> Estado</label>
                                    <select name="estado" id="uf" class="form-control" required>
                                        <option value="" selected disabled>Selecione</option>
                                        <option value="AC">AC</option><option value="AL">AL</option><option value="AM">AM</option>
                                        <option value="AP">AP</option><option value="BA">BA</option><option value="CE">CE</option>
                                        <option value="DF">DF</option><option value="ES">ES</option><option value="GO">GO</option>
                                        <option value="MA">MA</option><option value="MG">MG</option><option value="MS">MS</option>
                                        <option value="MT">MT</option><option value="PA">PA</option><option value="PB">PB</option>
                                        <option value="PE">PE</option><option value="PI">PI</option><option value="PR">PR</option>
                                        <option value="RJ">RJ</option><option value="RN">RN</option><option value="RO">RO</option>
                                        <option value="RR">RR</option><option value="RS">RS</option><option value="SC">SC</option>
                                        <option value="SE">SE</option><option value="SP">SP</option><option value="TO">TO</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Dados Contato -->
                            <div class="row mt-2 mb-4"> 
                                <div class="col-12 hr">
                                    <h6 class="border-bottom pb-2">Dados de Contato e Acesso</h6>
                                </div>
                    
                                <div class="col-md-3 mt-2">
                                    <label for="telefone_residencial">Telefone Residencial</label>
                                    <input type="text" name="telefone_residencial" id="telefone_residencial" class="form-control" placeholder="(00) 0000-0000" maxlength="13">
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label for="telefone_celular"><strong class="text-danger">*</strong> Telefone Celular</label>
                                    <input type="text" name="telefone_celular" id="telefone_celular" class="form-control" placeholder="(00) 00000-0000" maxlength="14" required>
                                </div>
                    
                                <div class="col-md-3 mt-2">
                                    <label for="email"><strong class="text-danger">*</strong> Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="exemplo@dominio.com" required>
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label for="senha"><strong class="text-danger">*</strong> Senha</label>
                                    <input type="password" name="senha" id="senha" class="form-control" minlength="6" required>
                                </div>
                                                                
                                <div class="col-12 mt-4 d-flex justify-content-end">
                                    <input type="submit" value="Cadastrar" class="btn btn-dark btn-lg" > 
                                </div>
                                <div class="text-center mt-3">
                                    <a href="login_cliente.php">Já tem uma conta? Faça login</a>
                                </div>

                            </div>   
                        </div>                  
                    </form>
                </div>
            </div>
        </main>
         <footer>
            <div class="caixa-conteudo">
            <div class="grade-rodape">
                <!-- Informações da marca e redes sociais -->
                <div class="informacao-rodape">
                <a href="index.php" class="logotipo-rodape">
                    <div class="logotipo-rodape-icone">
                    <img src="./logo/logotipo_light.png" alt="IOT STORE Logo" class="logotipo-img"> 
                    </div>
                    <h2 class="logotipo-texto">IOT STORE</h2>
                </a>
                <p class="descricao-rodape">Sua parceira premium em automação e tecnologia inteligente para casa e negócios.</p>
                <div class="links-sociais">
                    <a href="https://www.linkedin.com/in/milton-nascimento-alves-da-silva/" target="_blank" class="botao-social"><i class="fa-brands fa-linkedin"></i></a>
                    <a href="https://www.facebook.com/profile.html?id=100013903541113" target="_blank" class="botao-social"><i class="fa-brands fa-facebook"></i></a>
                    <a href="https://www.instagram.com/mnsilvanavegantes/" target="_blank" class="botao-social"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://web.whatsapp.com/" target="_blank" class="botao-social"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
                </div>

                <!-- Colunas de links institucionais -->
                <div class="coluna-rodape">
                <h4>Institucional</h4>
                <ul>
                    <li><a href="sobreNos.php">Sobre Nós</a></li>
                    <li><a href="#">Minha Conta</a></li>
                    <li><a href="#">Trabalhe Conosco</a></li>
                    <li><a href="#">Blog Tech</a></li>
                </ul>
                </div>

                <div class="coluna-rodape">
                <h4>Informações</h4>
                <ul>
                    <li><a href="#">Política de Entrega</a></li>
                    <li><a href="#">Privacidade e Segurança</a></li>
                    <li><a href="#">Trocas e Devoluções</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
                </div>

                <!-- Informações de contato -->
                <div class="coluna-rodape">
                <h4>Contato</h4>
                <ul class="lista-contato">
                    <li><i class="fa-solid fa-phone"></i> (19) 4002-8922</li>
                    <li><i class="fa-solid fa-envelope"></i> contato@iotstore.com.br</li>
                    <li><i class="fa-regular fa-clock"></i> Seg - Sex: 09h às 18h</li>
                </ul>
                </div>
            </div>

            <!-- Parte inferior do rodapé com selos e direitos autorais -->
            <div class="rodape-inferior">
                <div class="item-rodape-inferior">
                <span>Pagamento</span>
                <div class="icones-pagamento">
                    <a href="https://www.visa.com.br" target="_blank" class="botao-social"><i class="fa-brands fa-cc-visa"></i></a>
                    <a href="https://www.mastercard.com" target="_blank" class="botao-social"><i class="fa-brands fa-cc-mastercard"></i></a>
                    <a href="https://www.bcb.gov.br/estabilidadefinanceira/pix" target="_blank" class="botao-social"><i class="fa-brands fa-pix"></i></a>
                    
                </div>
                </div>
                <div class="item-rodape-inferior">
                <span>Segurança</span>
                <div class="icones-seguranca">
                    <i class="fa-solid fa-shield-halved" style="color: #10b981;"></i>
                    <i class="fa-solid fa-circle-check" style="color: #3b82f6;"></i>
                </div>
                </div>
                <p class="direitos-autorais">&copy; 2026 IOT STORE. Todos os direitos reservados.</p>
                <p class="direitos-autorais">Desenvolvido por <a href="https://github.com/miltonnotforyou" target="_blank">Milton Silva
                <i class="fa-brands fa-github"></i></a></p>
            </div>
            </div>
        </footer>
    

    </div>
 

  <!-- JQUERY CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  
  
  <!-- BOOTSTRAP JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

  <!-- JQUERY MASK -->
  <script src= "assets/js/jquery.mask.js"></script>
  
  <!-- JAVASCRIPT CEP -->
  <script src= "assets/js/cep.js"></script>

  <!-- JAVASCRIPT Data Nascimento-->
   
  <script src="custom/js/script.js"></script>
</html>