<?php 
//Iniciando a sessão para gerenciar o estado de autenticação do usuário
if (!isset($_SESSION)) 
    {
    session_start();
    }

unset($_SESSION['USER'] , $_SESSION['TYPE']); // Limpa a variável de sessão USER para efetuar o logoff do usuário
$_SESSION['logoff'] = "Você saiu da sua conta com sucesso."; // Armazenando a mensagem de sucesso na sessão para exibir na página de login
header("Location: Index.php"); // Redireciona para a página de login após o logoff do usuário


?>