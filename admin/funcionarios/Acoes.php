<?php 
// Conexão com o banco de dados
require_once '../../conexao/conecta.php';

######## Inicia a sessão#######

if (!isset($_SESSION)) 
{
    session_start();
}

##################Cadastrando novo funcionário##################

if(isset($_POST['cadastrar']) && $_POST['cadastrar'] === 'cadastrar_funcionario') 
    {
    //$foto = mysqli_real_escape_string($conexao, $_POST['foto']);
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $nome_social = mysqli_real_escape_string($conexao, $_POST['nome_social']);
    $data_nascimento = mysqli_real_escape_string($conexao, $_POST['data_nascimento']);
    $sexo = mysqli_real_escape_string($conexao, $_POST['sexo']);
    $estado_civil = mysqli_real_escape_string($conexao, $_POST['estado_civil']);
    $CPF = mysqli_real_escape_string($conexao, $_POST['CPF']);
    $RG = mysqli_real_escape_string($conexao, $_POST['RG']);
    //$data_cadastro = mysqli_real_escape_string($conexao, $_POST['data_cadastro']);
    $cep = mysqli_real_escape_string($conexao, $_POST['cep']);
    $endereco = mysqli_real_escape_string($conexao, $_POST['endereco']);
    $numero = mysqli_real_escape_string($conexao, $_POST['numero']);
    $complemento = mysqli_real_escape_string($conexao, $_POST['complemento']);
    $bairro = mysqli_real_escape_string($conexao, $_POST['bairro']);
    $cidade = mysqli_real_escape_string($conexao, $_POST['cidade']);
    $estado = mysqli_real_escape_string($conexao, $_POST['estado']);
    $telefone_residencial = mysqli_real_escape_string($conexao, $_POST['telefone_residencial']);
    $telefone_celular = mysqli_real_escape_string($conexao, $_POST['telefone_celular']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $cargo = mysqli_real_escape_string($conexao, $_POST['cargo']);
    $codigo_cargo = mysqli_real_escape_string($conexao, $_POST['codigo_cargo']); 
    $salario = str_replace(',', '.', $_POST['salario']); ## Corrigido: Substituindo vírgula por ponto para o formato decimal
    $usuario = mysqli_real_escape_string($conexao, $_POST['usuario']); 
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']); 
    $tipo_acesso = mysqli_real_escape_string($conexao, $_POST['tipo_acesso']); 
    //$status = mysqli_real_escape_string($conexao, $_POST['status']);    

    ############################### Lógica para upload da foto no servidor ###############################
    
    $foto = basename($_FILES['foto']['name']); #####pega o nome do arquivo enviado
    #################### Salvando um caminho temporario na pasta "TMP" #####################
    $tmp = $_FILES['foto']['tmp_name']; #####pega o caminho temporário do arquivo enviado
    #################### Definindo o caminho final para onde a foto será movida #####################
    $caminho_final = '../../images/' . $foto; #####define o caminho final para onde a foto será movida
    #################### Movendo o arquivo da pasta temporária para a pasta final #####################
    move_uploaded_file($tmp, $caminho_final); #####move o arquivo da pasta temporária para a pasta final

    }
    ########################Insert no banco de dados########################

    $sql_insert = "INSERT INTO funcionario VALUES (0,'$nome', '$nome_social', '$data_nascimento', '$sexo', '$estado_civil', '$CPF', '$RG','$salario', '$endereco', '$numero', '$complemento', '$bairro', '$cidade', '$estado', '$cep', '$telefone_residencial', '$telefone_celular', '$email', 1, NOW(), '$usuario', '$senha', $tipo_acesso,'$foto', '$cargo')";

    if(mysqli_query($conexao, $sql_insert)) {
        header('Location: index.php');
    } else {
        die("Erro ao cadastrar funcionário: " . mysqli_error($conexao));
        
    }

?>