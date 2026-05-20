<?php 
// Conexão com o banco de dados
require_once __DIR__ .'/../../conexao/conecta.php';
# COLOCAR O CAMINHO CORRETO PARA O ARQUIVO DE CONEXÃO COM O BANCO DE DADOS USANDO __DIR__ PARA GARANTIR QUE O CAMINHO SEJA RELATIVO AO DIRETÓRIO ATUAL DO ARQUIVO

######## Inicia a sessão#######

if (!isset($_SESSION)) 
{
    session_start();
}

##################Cadastrando novo cliente##################

if(isset($_POST['cadastrar']) && $_POST['cadastrar'] === 'cadastrar_cliente') 
    {
   
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $nome_social = mysqli_real_escape_string($conexao, $_POST['nome_social']);
    $data_nascimento = mysqli_real_escape_string($conexao, $_POST['data_nascimento']);
    $sexo = mysqli_real_escape_string($conexao, $_POST['sexo']);
    $CPF = mysqli_real_escape_string($conexao, $_POST['CPF']);
    $RG = mysqli_real_escape_string($conexao, $_POST['RG']);
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
        
    
    ########################Insert no banco de dados########################

    $sql_insert = "INSERT INTO cliente VALUES (0,'$nome', '$nome_social', '$data_nascimento', '$sexo', '$CPF', '$RG', '$endereco', '$numero', '$complemento', '$bairro', '$cidade', '$estado', '$cep', '$telefone_residencial', '$telefone_celular', '$email', 1, NOW())";

    try {
        if(mysqli_query($conexao, $sql_insert)) {
            $_SESSION['mensagem'] = "Cliente cadastrado com sucesso!";
        } else {
            $_SESSION['mensagem'] = "Erro ao cadastrar cliente!";
        }

        } catch (mysqli_sql_exception) {
            $_SESSION['mensagem'] = "Erro ao cadastrar cliente!";
        }

    header("Location: Inserir.php");
    exit();
     }

##################Atualizando cliente existente##################

if(isset($_POST['editar']) && $_POST['editar'] === 'editar_cliente') 
{
    // 1. Recebe o ID do cliente e o Status (forçando para número inteiro por segurança)
    $codigo_cliente = intval($_POST['codigo_cliente']);
    $status = intval($_POST['status']);

    // 2. Recebe e escapa os demais campos
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $nome_social = mysqli_real_escape_string($conexao, $_POST['nome_social']);
    $data_nascimento = mysqli_real_escape_string($conexao, $_POST['data_nascimento']);
    $sexo = mysqli_real_escape_string($conexao, $_POST['sexo']);
    $CPF = mysqli_real_escape_string($conexao, $_POST['CPF']);
    $RG = mysqli_real_escape_string($conexao, $_POST['RG']);
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
        
    
    ########################Update no banco de dados########################
   
    $sql_update = "UPDATE cliente SET nome = '$nome', nome_social = '$nome_social', data_nascimento = '$data_nascimento', sexo = '$sexo', cpf = '$CPF', rg = '$RG', endereco = '$endereco', numero = '$numero', complemento = '$complemento', bairro = '$bairro', cidade = '$cidade', estado = '$estado', cep = '$cep', telefone_residencial = '$telefone_residencial', telefone_celular = '$telefone_celular', email = '$email', status = $status 
    WHERE codigo_cliente = $codigo_cliente";

    try {
        if(mysqli_query($conexao, $sql_update)) {
            $_SESSION['mensagem'] = "Cliente atualizado com sucesso!";
        } else {
            $_SESSION['mensagem'] = "Erro ao atualizar cliente!";
        }

    } catch (mysqli_sql_exception $e) {
        $_SESSION['mensagem'] = "Erro ao atualizar cliente!";
    }

    // Após editar, redireciona o usuário para a tabela geral de clientes
    header("Location: index.php");
    exit();
}
?>