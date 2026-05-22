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
####################################### EXCLUINDO Cargo #######################################
    
    if(isset($_POST['deletar_cargo'])) 
    {
        $codigo = intval($_POST['deletar_cargo']); 

        $sql = "DELETE FROM cargo WHERE codigo_cargo = $codigo";

        if(mysqli_query($conexao, $sql)) {
            $_SESSION['mensagem'] = "Cargo excluído com sucesso!";
        } else {
            $numero_erro = mysqli_errno($conexao);

            if($numero_erro == 1451) {
                // 1. O banco bloqueou a exclusão. Agora, vamos contar quantos registros estão atrapalhando.
                
                $sql_conta = "SELECT COUNT(*) AS total FROM funcionario WHERE codigo_cargo = $codigo";
                $resultado_conta = mysqli_query($conexao, $sql_conta);
                
                if($resultado_conta) {
                    $linha = mysqli_fetch_assoc($resultado_conta);
                    $quantidade = $linha['total'];
                    
                    $_SESSION['mensagem'] = "Aviso: Você não pode excluir este cargo. Existem $quantidade funcionário(s) vinculado(s) a este Cargo.";
                } else {
                    // Caso a consulta de contagem falhe por algum motivo
                    $_SESSION['mensagem'] = "Aviso: Você não pode excluir este cargo, pois existem dados vinculados a ele.";
                }

            } else {
                $_SESSION['mensagem'] = "Erro ao excluir Cargo!";
            }
        }

        header("Location: index.php");
        exit();
    }

?>