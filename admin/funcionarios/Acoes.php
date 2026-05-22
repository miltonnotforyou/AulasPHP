<?php 
// Conexão com o banco de dados
require_once __DIR__ .'/../../conexao/conecta.php';

######## Inicia a sessão #######

if (!isset($_SESSION)) 
{
    session_start();
}

################## Cadastrando novo funcionário ##################

if(isset($_POST['cadastrar']) && $_POST['cadastrar'] === 'cadastrar_funcionario') 
    {
    
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $nome_social = mysqli_real_escape_string($conexao, $_POST['nome_social']);
    $data_nascimento = mysqli_real_escape_string($conexao, $_POST['data_nascimento']);
    $sexo = mysqli_real_escape_string($conexao, $_POST['sexo']);
    $estado_civil = mysqli_real_escape_string($conexao, $_POST['estado_civil']);
    $CPF = mysqli_real_escape_string($conexao, $_POST['CPF']);
    $RG = mysqli_real_escape_string($conexao, $_POST['RG']);
    //$data_cadastro = mysqli_real_escape_string($conexao, $_POST['data_cadastro']);
    $cep = mysqli_real_escape_string($conexao, $_POST['cep']);
    $endereco = mysqli_real_escape_string($conexao, $_POST['endereco']);
    $numero = mysqli_real_escape_string($conexao, $_POST['numero']);
    $complemento = mysqli_real_escape_string($conexao, $_POST['complemento']);
    $bairro = mysqli_real_escape_string($conexao, $_POST['bairro']);
    $cidade = mysqli_real_escape_string($conexao, $_POST['cidade']);
    $estado = mysqli_real_escape_string($conexao, $_POST['estado']);
    $telefone_residencial = mysqli_real_escape_string($conexao, $_POST['telefone_residencial']);
    $telefone_celular = mysqli_real_escape_string($conexao, $_POST['telefone_celular']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $cargo = mysqli_real_escape_string($conexao, $_POST['cargo']);
    $codigo_cargo = mysqli_real_escape_string($conexao, $_POST['codigo_cargo'] ?? '');
    $salario = str_replace(',', '.', $_POST['salario']); ## Corrigido: Substituindo vírgula por ponto para o formato decimal
    $usuario = mysqli_real_escape_string($conexao, $_POST['usuario']); 
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']); 
    $tipo_acesso = mysqli_real_escape_string($conexao, $_POST['tipo_acesso']); 
    //$status = mysqli_real_escape_string($conexao, $_POST['status']);    

    ############################### Lógica para upload da foto no servidor ###############################
    
    $foto = basename($_FILES['foto']['name']); #####pega o nome do arquivo enviado
    #################### Salvando um caminho temporario na pasta "TMP" #####################
    $tmp = $_FILES['foto']['tmp_name']; #####pega o caminho temporário do arquivo enviado
    #################### Definindo o caminho final para onde a foto será movida #####################
    $caminho_final = '../../images/' . $foto; #####define o caminho final para onde a foto será movida
    #################### Movendo o arquivo da pasta temporária para a pasta final #####################
    move_uploaded_file($tmp, $caminho_final); #####move o arquivo da pasta temporária para a pasta final

    
    ######################## Insert no banco de dados ########################

    $sql = "INSERT INTO funcionario VALUES (0,'$nome', '$nome_social', '$data_nascimento', '$sexo', '$estado_civil', '$CPF', '$RG','$salario', '$endereco', '$numero', '$complemento', '$bairro', '$cidade', '$estado', '$cep', '$telefone_residencial', '$telefone_celular', '$email', 1, NOW(), '$usuario', '$senha', $tipo_acesso,'$foto', '$cargo')";

    try {
        if(mysqli_query($conexao, $sql)) {
            $_SESSION['mensagem'] = "Funcionário cadastrado com sucesso!";
        } else {
            $_SESSION['mensagem'] = "Erro ao cadastrar funcionário!";
        }

        } catch (mysqli_sql_exception) {
            $_SESSION['mensagem'] = "Erro ao cadastrar funcionário!";
        }

    header("Location: Inserir.php");
    exit();
    }


    ####################################### ATUALIZANDO FUNCIONÁRIO #######################################
    
    if(isset($_POST['editar']) && $_POST['editar'] === 'editar_funcionario') 
    {
    
    $codigo = mysqli_real_escape_string($conexao, $_POST['codigo_funcionario']);
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $nome_social = mysqli_real_escape_string($conexao, $_POST['nome_social']);
    $data_nascimento = mysqli_real_escape_string($conexao, $_POST['data_nascimento']);
    $sexo = mysqli_real_escape_string($conexao, $_POST['sexo']);
    $estado_civil = mysqli_real_escape_string($conexao, $_POST['estado_civil']);
    $CPF = mysqli_real_escape_string($conexao, $_POST['CPF']);
    $RG = mysqli_real_escape_string($conexao, $_POST['RG']);
    //$data_cadastro = mysqli_real_escape_string($conexao, $_POST['data_cadastro']);
    $cep = mysqli_real_escape_string($conexao, $_POST['cep']);
    $endereco = mysqli_real_escape_string($conexao, $_POST['endereco']);
    $numero = mysqli_real_escape_string($conexao, $_POST['numero']);
    $complemento = mysqli_real_escape_string($conexao, $_POST['complemento']);
    $bairro = mysqli_real_escape_string($conexao, $_POST['bairro']);
    $cidade = mysqli_real_escape_string($conexao, $_POST['cidade']);
    $estado = mysqli_real_escape_string($conexao, $_POST['estado']);
    $telefone_residencial = mysqli_real_escape_string($conexao, $_POST['telefone_residencial']);
    $telefone_celular = mysqli_real_escape_string($conexao, $_POST['telefone_celular']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $cargo = mysqli_real_escape_string($conexao, $_POST['cargo']);
    $codigo_cargo = mysqli_real_escape_string($conexao, $_POST['codigo_cargo'] ?? '');
    $salario = str_replace(',', '.', $_POST['salario']); 
    $usuario = mysqli_real_escape_string($conexao, $_POST['usuario']); 
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']); 
    $tipo_acesso = mysqli_real_escape_string($conexao, $_POST['tipo_acesso']); 
    $status = mysqli_real_escape_string($conexao, $_POST['status']);    

    ############################### Lógica para upload da foto no servidor ###############################
    
    $foto = basename($_FILES['foto']['name']); #####pega o nome do arquivo enviado
    #################### Salvando um caminho temporario na pasta "TMP" #####################
    $tmp = $_FILES['foto']['tmp_name']; #####pega o caminho temporário do arquivo enviado
    #################### Definindo o caminho final para onde a foto será movida #####################
    $caminho_final = '../../images/' . $foto; #####define o caminho final para onde a foto será movida
    #################### Movendo o arquivo da pasta temporária para a pasta final #####################
    move_uploaded_file($tmp, $caminho_final); #####move o arquivo da pasta temporária para a pasta final

    
    ########################UPDATE no banco de dados########################

    $sql = "UPDATE funcionario SET nome = '$nome', nome_social = '$nome_social', data_nascimento = '$data_nascimento', sexo = '$sexo', estado_civil = '$estado_civil', CPF = '$CPF', RG = '$RG', salario = '$salario', endereco = '$endereco', numero = '$numero', complemento = '$complemento', bairro = '$bairro', cidade = '$cidade', estado = '$estado', cep = '$cep', telefone_residencial = '$telefone_residencial', telefone_celular = '$telefone_celular', email = '$email', status = $status, usuario = '$usuario', senha = '$senha', tipo_acesso = $tipo_acesso, codigo_cargo = $cargo";

    ##################### SOMENTE PARA TABELAS QUE TEM FOTO ###########################
    //VERIFICNADO SE O USUÁRIO ENVIOU UMA NOVA FOTO PARA ATUALIZAR. SE SIM, INCLUIR A FOTO NO UPDATE, SE NÃO, MANTER A FOTO ANTIGA.
    if(!empty($foto))
    {
        $sql .= ", foto = '$foto'"; // Se o usuário enviou uma nova foto, adiciona a atualização da foto na query
    }

    //COMPLETA A QUERY DE UPDATE COM A CLÁUSULA WHERE PARA IDENTIFICAR O FUNCIONÁRIO PELO CÓDIGO SOMENTE PARA TABELAS QUE TEM FOTO
    $sql .= " WHERE codigo_funcionario = $codigo";

    try {
        if(mysqli_query($conexao, $sql)) {
            $_SESSION['mensagem'] = "Funcionário atualizado com sucesso!";
        } else {
            die("Erro: " . $sql . "<br>" . mysqli_error($conexao)); // Exibe o erro detalhado do MySQL para diagnóstico
            //$_SESSION['mensagem'] = "Erro ao atualizar funcionário!";
        }

        } catch (mysqli_sql_exception) {
            $_SESSION['mensagem'] = "Erro ao atualizar funcionário!";
        }

    header("Location: index.php");
    exit();
    }

    ####################################### EXCLUINDO FUNCIONÁRIO #######################################
    
    if(isset($_POST['deletar_funcionario'])) 
    {
        $codigo = intval($_POST['deletar_funcionario']); 

        $sql = "DELETE FROM funcionario WHERE codigo_funcionario = $codigo";

        if(mysqli_query($conexao, $sql)) {
            $_SESSION['mensagem'] = "Funcionário excluído com sucesso!";
        } else {
            $numero_erro = mysqli_errno($conexao);

            if($numero_erro == 1451) {
                // 1. O banco bloqueou a exclusão. Agora, vamos contar quantos registros estão atrapalhando.
                // ATENÇÃO: Substitua 'tabela_filha' pelo nome real da tabela que tem a chave estrangeira!
                $sql_conta = "SELECT COUNT(*) AS total FROM venda WHERE codigo_funcionario = $codigo";
                $resultado_conta = mysqli_query($conexao, $sql_conta);
                
                if($resultado_conta) {
                    $linha = mysqli_fetch_assoc($resultado_conta);
                    $quantidade = $linha['total'];
                    
                    $_SESSION['mensagem'] = "Aviso: Você não pode excluir este funcionário. Existem $quantidade venda(s) vinculado(s) a este funcionário.";
                } else {
                    // Caso a consulta de contagem falhe por algum motivo
                    $_SESSION['mensagem'] = "Aviso: Você não pode excluir este funcionário, pois existem dados vinculados a ele.";
                }

            } else {
                $_SESSION['mensagem'] = "Erro ao excluir funcionário!";
            }
        }

        header("Location: index.php");
        exit();
    }
?>