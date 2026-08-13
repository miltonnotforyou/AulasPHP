<?php 
    if (!isset($_SESSION)) {
        session_start();
    }

    // Verifica se o arquivo com as senhas existe e o importa
    if (file_exists('config.php')) {
        require_once 'config.php';
    } else {
        die("Erro de segurança: Arquivo de configuração não encontrado.");
    }

    // A conexão agora usa as constantes definidas no config.php
    $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

    // Verificar a conexão
    if (mysqli_connect_errno()) {
        die("Falha na conexão: " . mysqli_connect_error());
    }
?>