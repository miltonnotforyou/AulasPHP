<?php 
    if (!isset($_SESSION)) {
        session_start();
    }

    // 1. Tenta carregar o arquivo localmente (para funcionar no seu VS Code/XAMPP)
    if (file_exists('config.php')) {
        require_once 'config.php';
    }

    // 2. Pega as credenciais: Se estiver no PC usa as Constantes, se estiver no Coolify usa as Variáveis de Ambiente
    $host = defined('DB_HOST') ? DB_HOST : getenv('DB_HOST');
    $user = defined('DB_USER') ? DB_USER : getenv('DB_USER');
    $pass = defined('DB_PASS') ? DB_PASS : getenv('DB_PASS');
    $name = defined('DB_NAME') ? DB_NAME : getenv('DB_NAME');
    $port = defined('DB_PORT') ? DB_PORT : getenv('DB_PORT');

    // Verifica se as credenciais foram carregadas de algum lugar
    if (!$host || !$user) {
        die("Erro: Credenciais do banco não encontradas no servidor.");
    }

    // 3. Realiza a conexão
    $conexao = mysqli_connect($host, $user, $pass, $name, $port);

    // Verificar a conexão
    if (mysqli_connect_errno()) {
        die("Falha na conexão: " . mysqli_connect_error());
    }
?>
