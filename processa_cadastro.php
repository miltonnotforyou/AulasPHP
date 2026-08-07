<?php
// Inclui o arquivo de conexão com o banco de dados
require_once './conexao/conecta.php';

// Inicia a sessão
if (!isset($_SESSION)) {
    session_start();
}

// Verifica se os dados mínimos foram enviados
if(isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['cpf'])) {
    
    // Proteção básica contra SQL Injection e captura dos Dados de Acesso
    $email = mysqli_real_escape_string($conexao, trim($_POST['email']));
    $senha_pura = $_POST['senha'];
    $senha_criptografada = password_hash($senha_pura, PASSWORD_DEFAULT);

    // Captura dos Dados Pessoais
    $nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
    $nome_social = mysqli_real_escape_string($conexao, trim($_POST['nome_social']));
    $cpf = mysqli_real_escape_string($conexao, trim($_POST['cpf']));
    $rg = mysqli_real_escape_string($conexao, trim($_POST['rg']));
    $data_nascimento = mysqli_real_escape_string($conexao, $_POST['data_nascimento']);
    $sexo = mysqli_real_escape_string($conexao, $_POST['sexo']);
    $telefone_celular = mysqli_real_escape_string($conexao, trim($_POST['telefone_celular']));
    $telefone_residencial = mysqli_real_escape_string($conexao, trim($_POST['telefone_residencial']));
    
    // Captura dos Dados de Endereço
    $cep = mysqli_real_escape_string($conexao, trim($_POST['cep']));
    $endereco = mysqli_real_escape_string($conexao, trim($_POST['endereco']));
    $numero = intval($_POST['numero']); // Converte para inteiro por segurança
    $complemento = mysqli_real_escape_string($conexao, trim($_POST['complemento']));
    $bairro = mysqli_real_escape_string($conexao, trim($_POST['bairro']));
    $cidade = mysqli_real_escape_string($conexao, trim($_POST['cidade']));
    $estado = mysqli_real_escape_string($conexao, trim($_POST['estado']));

    // Dados fixos do sistema
    $status = 1; // 1 = Ativo[cite: 12]
    $data_cadastro = date('Y-m-d H:i:s'); // Data e hora atual
    
    // Montagem da Query completa (incluindo a nova coluna 'senha')
    $sql = "INSERT INTO cliente (
                nome, nome_social, data_nascimento, sexo, cpf, rg, 
                endereco, numero, complemento, bairro, cidade, estado, CEP, 
                telefone_residencial, telefone_celular, email, senha, status, data_cadastro
            ) VALUES (
                '$nome', '$nome_social', '$data_nascimento', '$sexo', '$cpf', '$rg', 
                '$endereco', $numero, '$complemento', '$bairro', '$cidade', '$estado', '$cep', 
                '$telefone_residencial', '$telefone_celular', '$email', '$senha_criptografada', b'$status', '$data_cadastro'
            )";

    // Executa a query
    if(mysqli_query($conexao, $sql)) {
        
        // Cadastrado com sucesso! Logamos o cliente na sessão automaticamente.
        $_SESSION['CLIENTE_ID'] = mysqli_insert_id($conexao); // Pega o código gerado do cliente
        $_SESSION['CLIENTE_NOME'] = $nome;
        
        // Redireciona direto para o carrinho para não atrapalhar a jornada de compra
        echo "<script>
                alert('Conta criada com sucesso! Redirecionando para o carrinho...');
                window.location.href = 'carrinho.php';
              </script>";
        exit;

    } else {
        // Em caso de erro (ex: CPF já cadastrado)
        echo "<script>
                alert('Erro ao criar conta. Verifique se o E-mail ou CPF já estão cadastrados. Detalhes: " . addslashes(mysqli_error($conexao)) . "');
                window.history.back(); // Volta para o formulário
              </script>";
        exit;
    }
} else {
    // Se tentarem acessar a página diretamente sem enviar POST
    header("Location: cadastro.php");
    exit;
}
?>