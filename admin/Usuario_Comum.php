<?php 
// Iniciando a sessão para gerenciar o estado de autenticação do usuário
//conexão com o banco de dados
require_once __DIR__ . '/../conexao/conecta.php';

//Iniciando a sessão para gerenciar o estado de autenticação do usuário
if (!isset($_SESSION)) 
    {
    session_start();
    }

    // Verificando se o usuário está autenticado para permitir o acesso à página de administração
    if (!isset($_SESSION['USER']))
        {
                  
            $_SESSION['naoAutorizado'] = "Apenas usuários autenticados podem acessar o painel administrativo."; // Armazenando a mensagem de erro na sessão para exibir na página de login
            header("Location: ../Index.php"); // Redireciona para a página de login se o usuário não estiver autenticado

          
                   
          
        }

?>