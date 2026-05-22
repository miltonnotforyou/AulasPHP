<?php 
require_once __DIR__ .'/../../conexao/conecta.php';

if (!isset($_SESSION)) {
    session_start();
}

if(isset($_POST['cadastrar']) && $_POST['cadastrar'] === 'cadastrar_produto') 
{
    $_nome              = mysqli_real_escape_string($conexao, $_POST['nome']);
    $_descricao         = mysqli_real_escape_string($conexao, $_POST['descricao']);     
    $_qtde_estoque      = mysqli_real_escape_string($conexao, $_POST['qtde_estoque']);
    $_preco_custo       = str_replace(',', '.', $_POST['preco_custo']); ## Substituindo vírgula por ponto para o formato decimal
    $_lucro             = str_replace(',', '.', $_POST['lucro']); ## Substituindo vírgula por ponto para o formato decimal
    $_preco_venda       = str_replace(',', '.', $_POST['preco_venda']); ## Substituindo vírgula por ponto para o formato decimal
    // Força para inteiro e se não existir ou for vazio, manda 0 (Inativo)
    $_status_promocao   = (isset($_POST['status_promocao']) && $_POST['status_promocao'] !== '') ? intval($_POST['status_promocao']) : 0;
    
    // Tratamento seguro para os campos que o JavaScript desabilita
    $_desconto_promocao = (isset($_POST['desconto_promocao']) && $_POST['desconto_promocao'] !== '') ? str_replace(',', '.', $_POST['desconto_promocao']) : 0;
    $_preco_promocao    = (isset($_POST['preco_promocao']) && $_POST['preco_promocao'] !== '') ? str_replace(',', '.', $_POST['preco_promocao']) : 0;
    $_codigo_produto      = mysqli_real_escape_string($conexao, $_POST['produto']);          
    $_codigo_categoria  = mysqli_real_escape_string($conexao, $_POST['categoria']);      
################################## Upload da foto do produto ##########################
    $foto = basename($_FILES['foto']['name']);
    $tmp = $_FILES['foto']['tmp_name'];
    $caminho_final = '../../images/' . $foto;
    move_uploaded_file($tmp, $caminho_final);

    
    $sql = "INSERT INTO produto VALUES (0, '$_nome', '$_descricao', '$_qtde_estoque', '$_preco_custo', '$_lucro', '$_preco_venda', $_status_promocao, '$_desconto_promocao', '$_preco_promocao', '$foto', NOW(), 1, '$_codigo_produto', '$_codigo_categoria' )";

    try {
        if(mysqli_query($conexao, $sql)) {
            $_SESSION['mensagem'] = "Produto cadastrado com sucesso!";
        } else {
            $_SESSION['mensagem'] = "Erro ao cadastrar produto!";
        }

        } catch (mysqli_sql_exception) {
            $_SESSION['mensagem'] = "Erro ao cadastrar produto!";
        }

    header("Location: Inserir.php");
    exit();
}

 ####################################### ATUALIZANDO PRODUTO #######################################
    
if(isset($_POST['editar']) && $_POST['editar'] === 'editar_produto') 
{
    // 1. Recebe o Código e Status (usando intval por segurança)
    $codigo_produto = intval($_POST['codigo_produto']);
    $status         = intval($_POST['status']);

    // 2. Recebe os dados em texto e números inteiros
    $nome              = mysqli_real_escape_string($conexao, $_POST['nome']);
    $descricao         = mysqli_real_escape_string($conexao, $_POST['descricao']);     
    $qtde_estoque      = intval($_POST['qtde_estoque']);
    $status_promocao   = (isset($_POST['status_promocao']) && $_POST['status_promocao'] !== '') ? intval($_POST['status_promocao']) : 0;
    
    // Recebe as chaves estrangeiras de produto e categoria
    $codigo_produto      = intval($_POST['produto']);          
    $codigo_categoria  = intval($_POST['categoria']);  

    // 3. Recebe os valores monetários/decimais substituindo vírgula por ponto
    $preco_custo       = str_replace(',', '.', $_POST['preco_custo']); 
    $lucro             = str_replace(',', '.', $_POST['lucro']); 
    $preco_venda       = str_replace(',', '.', $_POST['preco_venda']); 
    // Tratamento seguro evitando erro fatal no SQL quando o $_POST vier vazio
    $desconto_promocao = (isset($_POST['desconto_promocao']) && $_POST['desconto_promocao'] !== '') ? str_replace(',', '.', $_POST['desconto_promocao']) : 0; 
    $preco_promocao    = (isset($_POST['preco_promocao']) && $_POST['preco_promocao'] !== '') ? str_replace(',', '.', $_POST['preco_promocao']) : 0;
    ############################### Lógica para upload da nova foto ###############################
    $foto = '';
    // Verifica se o array de arquivo existe e se algum arquivo foi enviado sem erros
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = basename($_FILES['foto']['name']);
        $tmp = $_FILES['foto']['tmp_name'];
        $caminho_final = '../../images/' . $foto;
        move_uploaded_file($tmp, $caminho_final);
    }

    ######################## UPDATE no banco de dados ########################
    
    $sql = "UPDATE produto SET 
            nome = '$nome', descricao = '$descricao', qtde_estoque = '$qtde_estoque', preco_custo = '$preco_custo', lucro = '$lucro', preco_venda = '$preco_venda', status_promocao = $status_promocao, desconto_promocao = '$desconto_promocao', preco_promocao = '$preco_promocao', codigo_produto = $codigo_produto, codigo_categoria = $codigo_categoria, status = $status";

    // Verifica se uma nova foto foi enviada. Se sim, adiciona ela na query.
    if(!empty($foto))
    {
        $sql .= ", foto = '$foto'"; 
    }

    // Finaliza a query restringindo ao produto específico
    $sql .= " WHERE codigo_produto = $codigo_produto";

    try {
        if(mysqli_query($conexao, $sql)) {
            $_SESSION['mensagem'] = "Produto atualizado com sucesso!";
        } else {
            $_SESSION['mensagem'] = "Erro ao atualizar produto!";
        }
    } catch (mysqli_sql_exception $e) {
        $_SESSION['mensagem'] = "Erro ao atualizar produto!";
    }

    // Redireciona para a tela de listagem de produtos
    header("Location: index.php");
    exit();
}

####################################### EXCLUINDO produto #######################################
    
    if(isset($_POST['deletar_produto'])) 
    {
        $codigo = intval($_POST['deletar_produto']); 

        $sql = "DELETE FROM produto WHERE codigo_produto = $codigo";

        if(mysqli_query($conexao, $sql)) {
            $_SESSION['mensagem'] = "produto excluído com sucesso!";
        } else {
            $numero_erro = mysqli_errno($conexao);

            if($numero_erro == 1451) {
                // 1. O banco bloqueou a exclusão. Agora, vamos contar quantos registros estão atrapalhando.
                
                $sql_conta = "SELECT COUNT(*) AS total FROM item_venda WHERE codigo_produto = $codigo";
                $resultado_conta = mysqli_query($conexao, $sql_conta);
                
                if($resultado_conta) {
                    $linha = mysqli_fetch_assoc($resultado_conta);
                    $quantidade = $linha['total'];
                    
                    $_SESSION['mensagem'] = "Aviso: Você não pode excluir este produto. Existem $quantidade item(s) de venda vinculado(s) a este produto.";
                } else {
                    // Caso a consulta de contagem falhe por algum motivo
                    $_SESSION['mensagem'] = "Aviso: Você não pode excluir este produto, pois existem dados vinculados a ele.";
                }

            } else {
                $_SESSION['mensagem'] = "Erro ao excluir produto!";
            }
        }

        header("Location: index.php");
        exit();
    }
?>