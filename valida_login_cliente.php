<?php 
// Conexão com o banco de dados
require_once __DIR__ . '/conexao/conecta.php';

// Iniciando a sessão para gerenciar o estado de autenticação
if (!isset($_SESSION)) {
    session_start();
}

// Verificando se chegou e-mail e senha[cite: 18]
if(isset($_POST['email']) && $_POST['email'] != '' && isset($_POST['senha']) && $_POST['senha'] != '') {
    
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $senha_digitada = $_POST['senha']; 

    // Busca o cliente APENAS pelo e-mail e verifica se está ativo[cite: 18]
    $sql = "SELECT * FROM cliente WHERE email = '$email' AND status = 1";
    $query = mysqli_query($conexao, $sql);
    $cliente = mysqli_fetch_assoc($query);

    // Se o cliente existir e a senha criptografada for igual à digitada
    if ($cliente && password_verify($senha_digitada, $cliente['senha'])) {
        
        // Armazenando os dados do cliente na sessão (isolado da sessão de funcionário)
        $_SESSION['CLIENTE_ID'] = $cliente['codigo_cliente']; 
        $_SESSION['CLIENTE_NOME'] = $cliente['nome'];
        
        // Redireciona para o carrinho para finalizar a compra[cite: 18]
        header("Location: carrinho.php"); 
        exit;
    } else {
        // Armazenando a mensagem de erro na sessão para exibir na página de login[cite: 18]
        $_SESSION['loginClienteErro'] = "E-mail ou senha inválidos."; 
        header("Location: login_cliente.php"); 
        exit;
    }

} else {
    // Se faltou preencher algo[cite: 18]
    $_SESSION['loginClienteVazio'] = "Preencha os campos de e-mail e senha para comprar."; 
    header("Location: login_cliente.php"); 
    exit;
}
?>