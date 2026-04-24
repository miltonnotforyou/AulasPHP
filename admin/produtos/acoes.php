<?php 
require_once '../../conexao/conecta.php';

if (!isset($_SESSION)) {
    session_start();
}

if(isset($_POST['cadastrar']) && $_POST['cadastrar'] === 'cadastrar_produto') 
{
    $_nome              = mysqli_real_escape_string($conexao, $_POST['nome']);
    $_descricao         = mysqli_real_escape_string($conexao, $_POST['observacao']);     
    $_qtde_estoque      = mysqli_real_escape_string($conexao, $_POST['qtde_estoque']);
    $_preco_custo       = str_replace(',', '.', $_POST['preco_custo']); ## Corrigido: Substituindo vírgula por ponto para o formato decimal
    $_preco_venda       = str_replace(',', '.', $_POST['preco_venda']); ## Corrigido: Substituindo vírgula por ponto para o formato decimal
    $_status_promocao   = mysqli_real_escape_string($conexao, $_POST['status_promocao']);
    $_desconto_promocao = str_replace(',', '.', $_POST['desconto_promocao']); ## Corrigido: Substituindo vírgula por ponto para o formato decimal
    $_preco_promocao    = str_replace(',', '.', $_POST['preco_promocao']); ## Corrigido: Substituindo vírgula por ponto para o formato decimal
    $_codigo_marca      = mysqli_real_escape_string($conexao, $_POST['marca']);          
    $_codigo_categoria  = mysqli_real_escape_string($conexao, $_POST['categoria']);      

    $foto         = basename($_FILES['foto']['name']);
    $tmp          = $_FILES['foto']['tmp_name'];
    $caminho_final = '../../images/' . $foto;
    move_uploaded_file($tmp, $caminho_final);

    
    $sql = "INSERT INTO produto VALUES (0, '$_nome', '$_descricao', '$_qtde_estoque', '$_preco_custo', '$_preco_venda', '$_status_promocao', '$_desconto_promocao', '$_preco_promocao', '$foto', NOW(), 1, '$_codigo_marca', '$_codigo_categoria' )";

    try {
        if(mysqli_query($conexao, $sql)) {
            $_SESSION['mensagem'] = "Produto cadastrado com sucesso!";
        } else {
            $_SESSION['mensagem'] = "Erro ao cadastrar produto: " . mysqli_error($conexao);
        }
    } catch (mysqli_sql_exception $e) {
        $_SESSION['mensagem'] = "Erro ao cadastrar produto: " . $e->getMessage();
    }

    header("Location: Inserir.php");
    exit();
}
?>