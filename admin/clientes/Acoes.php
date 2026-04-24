<?php 
// Conexão com o banco de dados
require_once '../../conexao/conecta.php';

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
        
    }
    ########################Insert no banco de dados########################

    $sql_insert = "INSERT INTO cliente VALUES (0,'$nome', '$nome_social', '$data_nascimento', '$sexo', '$CPF', '$RG', '$endereco', '$numero', '$complemento', '$bairro', '$cidade', '$estado', '$cep', '$telefone_residencial', '$telefone_celular', '$email', 1, NOW())";

    if(mysqli_query($conexao, $sql_insert)) {
        header('Location: index.php');
    } else {
        die("Erro ao cadastrar cliente: " . mysqli_error($conexao));
        
    }

?>