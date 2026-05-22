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

// atualização de categoria existente
if(isset($_POST['editar']) && $_POST['editar'] === 'editar_categoria') 
{
    $_codigo = intval($_POST['codigo_categoria']);
    $_categoria = mysqli_real_escape_string($conexao, $_POST['categoria']);
    $_observacao = mysqli_real_escape_string($conexao, $_POST['observacao']);
    $_status = mysqli_real_escape_string($conexao, $_POST['status']);

     ########################Update no banco de dados########################
    $sql = "UPDATE categoria SET nome = '$_categoria', observacao = '$_observacao', status = $_status WHERE codigo_categoria = $_codigo";
    
    try {

            if(mysqli_query($conexao, $sql)) 
            {
                $_SESSION['mensagem'] = "Categoria atualizada com sucesso!";
            
            } else {
                // die("Erro: " .$sql . "<br>" . mysqli_error($conexao));

                $_SESSION['mensagem'] = "Erro ao atualizar categoria!";
                
            }
    
        } catch (mysqli_sql_exception) 
            {
            // Tratar exceção de SQL, como violação de chave única
            $_SESSION['mensagem'] = "Erro ao atualizar categoria";
            }

    header("Location: index.php");
    exit();
}

####################################### EXCLUINDO categoria #######################################
    
    if(isset($_POST['deletar_categoria'])) 
    {
        $codigo = intval($_POST['deletar_categoria']); 

        $sql = "DELETE FROM categoria WHERE codigo_categoria = $codigo";

        if(mysqli_query($conexao, $sql)) {
            $_SESSION['mensagem'] = "categoria excluído com sucesso!";
        } else {
            $numero_erro = mysqli_errno($conexao);

            if($numero_erro == 1451) {
                // 1. O banco bloqueou a exclusão. Agora, vamos contar quantos registros estão atrapalhando.
        
                $sql_conta = "SELECT COUNT(*) AS total FROM produto WHERE codigo_categoria = $codigo";
                $resultado_conta = mysqli_query($conexao, $sql_conta);
                
                if($resultado_conta) {
                    $linha = mysqli_fetch_assoc($resultado_conta);
                    $quantidade = $linha['total'];
                    
                    $_SESSION['mensagem'] = "Aviso: Você não pode excluir esta categoria. Existem $quantidade produto(s) vinculado(s) a esta categoria.";
                } else {
                    // Caso a consulta de contagem falhe por algum motivo
                    $_SESSION['mensagem'] = "Aviso: Você não pode excluir esta categoria, pois existem dados vinculados a ela.";
                }

            } else {
                $_SESSION['mensagem'] = "Erro ao excluir categoria!";
            }
        }

        header("Location: index.php");
        exit();
    }
?>