<?php 
      
    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "iot_store";


    $conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

    // Verificar a conexão
    if (mysqli_connect_errno()) {
        die("Falha na conexão: " . mysqli_connect_error());
    }

   ?>