<?php 

// Iniciando a sessão para gerenciar o estado de autenticação do usuário
//conexão com o banco de dados
require_once __DIR__ . '/../conexao/conecta.php';

//Iniciando a sessão para gerenciar o estado de autenticação do usuário
if (!isset($_SESSION)) 
    {
    session_start();
    }

// verificando se chegou usuário e senha para comparar com o banco de dados
if(isset($_POST['usuario']) && $_POST['usuario'] != ''&& isset($_POST['senha']) && $_POST['senha'] != '')
    {
        $usuario = mysqli_real_escape_string($conexao, $_POST['usuario']);
        $senha = mysqli_real_escape_string($conexao, $_POST['senha']);

        $sql = "SELECT * FROM funcionario WHERE usuario = '$usuario' AND senha = '$senha' AND status = 1";
        $query = mysqli_query($conexao, $sql);
        $funcionario = mysqli_fetch_assoc($query);

        //echo $funcionario['usuario'];

        if (isset($funcionario))
            {
                $_SESSION['ID'] = $funcionario['codigo_funcionario']; // Armazenando os dados do funcionário na sessão para uso posterior
                $_SESSION['USER'] = $funcionario['usuario']; 
                $_SESSION['TYPE'] = $funcionario['tipo_acesso']; 
                $_SESSION['NAME'] = $funcionario['nome'];

                // ESTA LINHA para exibir a foto do usuário logado no painel administrativo, armazenando o caminho da foto na variável de sessão PHOTO:
                $_SESSION['PHOTO'] = $funcionario['foto'];
                // ESTA LINHA para exibir o nome social do usuário logado no painel administrativo, armazenando o nome social na variável de sessão NOME_SOCIAL:
                $_SESSION['NOME_SOCIAL'] = $funcionario['nome_social'];

                header("Location: Admin.php"); // Redireciona para a página de dashboard após o login bem-sucedido
            }
            else
                {
                    $_SESSION['loginErro'] = "Usuário ou senha inválidos."; // Armazenando a mensagem de erro na sessão para exibir na página de login
                    header("Location: Index.php"); // Redireciona de volta para a página de login    
                }


    }
    else
    {
        $_SESSION['loginVazio'] = "Preencha os campos de usuário e senha para acessar o painel administrativo."; // Armazenando a mensagem de erro na sessão para exibir na página de login
        header("Location: Index.php"); // Redireciona de volta para a página de login    
    }
    
?>