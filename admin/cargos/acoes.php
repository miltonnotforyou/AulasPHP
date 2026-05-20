<?php 
// Conexão com o banco de dados
require_once __DIR__ .'/../../conexao/conecta.php';

######## Inicia a sessão#######

if (!isset($_SESSION)) 
{
    session_start();
}

// Cadastro de novo cargo
if(isset($_POST['cadastrar']) && $_POST['cadastrar'] === 'cadastrar_cargo') 
{
    $_cargo = mysqli_real_escape_string($conexao, $_POST['cargo']);
    $_observacao = mysqli_real_escape_string($conexao, $_POST['observacao']);

     ########################Insert no banco de dados########################
    $sql = "INSERT INTO cargo VALUES (0, '$_cargo','$_observacao', 1, NOW())";
    
    try {

            if(mysqli_query($conexao, $sql)) 
            {
                $_SESSION['mensagem'] = "Cargo cadastrado com sucesso!";
            
            } else {
                // die("Erro: " .$sql . "<br>" . mysqli_error($conexao));

                $_SESSION['mensagem'] = "Erro ao cadastrar cargo!";
                
            }
    
        } catch (mysqli_sql_exception) 
            {
            // Tratar exceção de SQL, como violação de chave única
            $_SESSION['mensagem'] = "Erro ao cadastrar cargo";
            }

    header("Location: Inserir.php");
    exit();
}

// atualização de cargo
if(isset($_POST['editar']) && $_POST['editar'] === 'editar_cargo') 
{
    $_codigo = intval($_POST['codigo_cargo']);
    $_cargo = mysqli_real_escape_string($conexao, $_POST['cargo']);
    $_observacao = mysqli_real_escape_string($conexao, $_POST['observacao']);
    $_status = mysqli_real_escape_string($conexao, $_POST['status']);

     ########################Update no banco de dados########################
    $sql = "UPDATE cargo SET nome = '$_cargo', observacao = '$_observacao', status = $_status WHERE codigo_cargo = $_codigo";
    
    try {

            if(mysqli_query($conexao, $sql)) 
            {
                $_SESSION['mensagem'] = "Cargo atualizado com sucesso!";
            
            } else {
                // die("Erro: " .$sql . "<br>" . mysqli_error($conexao));

                $_SESSION['mensagem'] = "Erro ao atualizar cargo!";
                
            }
    
        } catch (mysqli_sql_exception) 
            {
            // Tratar exceção de SQL, como violação de chave única
            $_SESSION['mensagem'] = "Erro ao atualizar cargo";
            }

    header("Location: index.php");
    exit();
}


?>