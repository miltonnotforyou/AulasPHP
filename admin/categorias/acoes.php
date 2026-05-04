<?php 
// Conexão com o banco de dados
require_once __DIR__ .'/../../conexao/conecta.php';

######## Inicia a sessão#######

if (!isset($_SESSION)) {
    session_start();
}

// Cadastro de nova categoria
if(isset($_POST['cadastrar']) && $_POST['cadastrar'] === 'cadastrar_categoria') 
{
    $_categoria = mysqli_real_escape_string($conexao, $_POST['categoria']);
    $_observacao = mysqli_real_escape_string($conexao, $_POST['observacao']);

    ########################Insert no banco de dados########################
    
    $sql = "INSERT INTO categoria VALUES (0, '$_categoria','$_observacao', 1, NOW())";
    
    try {

            if(mysqli_query($conexao, $sql)) 
            {
                $_SESSION['mensagem'] = "Categoria cadastrada com sucesso!";
            
            } else {
                // die("Erro: " .$sql . "<br>" . mysqli_error($conexao));

                $_SESSION['mensagem'] = "Erro ao cadastrar categoria!";
                
            }
    
        } catch (mysqli_sql_exception) 
            {
            // Tratar exceção de SQL, como violação de chave única
            $_SESSION['mensagem'] = "Erro ao cadastrar categoria";
            }

    header("Location: Inserir.php");
    exit();
}


?>