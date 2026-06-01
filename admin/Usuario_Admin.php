<?php 
//Iniciando a sessão para gerenciar o estado de autenticação do usuário
if (!isset($_SESSION)) 
    {
    session_start();
    }


##Verificando se o usuário logado é administrador para permitir o acesso à página de administração##
if ($_SESSION['TYPE'] != 1) 
    {
        $_SESSION['naoAdm'] = "Apenas administradores podem acessar esta área."; // Armazenando a mensagem de erro na sessão para exibir na página de login
        header("Location: ../Admin.php"); // Redireciona para a página de login se o usuário não for administrador
    }


?>