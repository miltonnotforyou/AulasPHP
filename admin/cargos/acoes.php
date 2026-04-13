<?php 
// Conexão com o banco de dados
require_once '../../conexao/conecta.php';

######## Inicia a sessão#######

if (!isset($_SESSION)) {
    session_start();
}

// Cadastro de novo cargo
if(isset($_POST['cadastrar']) && $_POST['cadastrar'] === 'cadastrar_cargo') 
{
    $_cargo = mysqli_real_escape_string($conexao, $_POST['cargo']);
    $_observacao = mysqli_real_escape_string($conexao, $_POST['observacao']);

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

    header("Location: inserir.php");
}


?>