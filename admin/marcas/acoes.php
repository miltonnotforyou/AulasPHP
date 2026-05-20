<?php 
// Conexão com o banco de dados
require_once __DIR__ .'/../../conexao/conecta.php';

######## Inicia a sessão#######

if (!isset($_SESSION)) {
    session_start();
}

// Cadastro de nova marca
if(isset($_POST['cadastrar']) && $_POST['cadastrar'] === 'cadastrar_marca') 
{
    $_marca = mysqli_real_escape_string($conexao, $_POST['marca']);
    $_observacao = mysqli_real_escape_string($conexao, $_POST['observacao']);

    $sql = "INSERT INTO marca VALUES (0, '$_marca','$_observacao', 1, NOW())";
    
    try {

            if(mysqli_query($conexao, $sql)) 
            {
                $_SESSION['mensagem'] = "Marca cadastrada com sucesso!";
            
            } else {
                // die("Erro: " .$sql . "<br>" . mysqli_error($conexao));

                $_SESSION['mensagem'] = "Erro ao cadastrar marca!";
                
            }
    
        } catch (mysqli_sql_exception) 
            {
            // Tratar exceção de SQL, como violação de chave única
            $_SESSION['mensagem'] = "Erro ao cadastrar marca";
            }

    header("Location: Inserir.php");
    exit();
}

// atualização de marca existente
if(isset($_POST['editar']) && $_POST['editar'] === 'editar_marca') 
{
    $_codigo = intval($_POST['codigo_marca']);
    $_marca = mysqli_real_escape_string($conexao, $_POST['marca']);
    $_observacao = mysqli_real_escape_string($conexao, $_POST['observacao']);
    $_status = mysqli_real_escape_string($conexao, $_POST['status']);

     ########################Update no banco de dados########################
    $sql = "UPDATE marca SET nome = '$_marca', observacao = '$_observacao', status = $_status WHERE codigo_marca = $_codigo";
    
    try {

            if(mysqli_query($conexao, $sql)) 
            {
                $_SESSION['mensagem'] = "Marca atualizada com sucesso!";
            
            } else {
                // die("Erro: " .$sql . "<br>" . mysqli_error($conexao));

                $_SESSION['mensagem'] = "Erro ao atualizar marca!";
                
            }
    
        } catch (mysqli_sql_exception) 
            {
            // Tratar exceção de SQL, como violação de chave única
            $_SESSION['mensagem'] = "Erro ao atualizar marca";
            }

    header("Location: index.php");
    exit();
}

?>