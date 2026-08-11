<?php
// calcula_frete.php
if(isset($_POST['cep_destino'])) {
    
    // Limpa o CEP digitado (remove o traço)
    $cep_destino = preg_replace('/[^0-9]/', '', $_POST['cep_destino']);
    
    // O CEP de origem da sua Loja (Onde os produtos saem)
    $cep_origem = "13419030"; 
    
    // Token de Autenticação do Melhor Envio
    
    $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5NTYiLCJqdGkiOiJmNTlmODNmZWRiYzQxMjUwZDFjOGZmNmMzYmUwMTE5MGE4ODc2YzM4NmFiYjBiMjk3YWJiYzMyMmE4MWRmZDdiZGEzZTg0Y2U2ZjQzYWU1MSIsImlhdCI6MTc4NjM5ODM4MC44NzYzMTcsIm5iZiI6MTc4NjM5ODM4MC44NzYzMiwiZXhwIjoxODE3OTM0MzgwLjg2NzQxNywic3ViIjoiYTI3OGQxOTgtOTAwNS00MGYzLWI2ZDktNjZjOGQ2NzNlMDQ2Iiwic2NvcGVzIjpbInNoaXBwaW5nLWNhbGN1bGF0ZSJdfQ.Bsvs-s-0iez7g5X75oeHWxb7QgBlMnDHMFkMyXVCTEZbtb659JZtoNlQFFX5qjr7s6Ed6wJ8Rn6nVE1-8K8XSsTWGeUeN8oshyXBDYoSJ4Svalv8jB4TeBsVqbcGcFxmytYgDtSmGaxB3Xvl9ObSBJwFaw7ya5gquAI7t5Hdwp5BDZC3Hxw4torbWArbHQSVWChhLk7unQbe2CchV4mGnPsSdVPUuPv-jsDnqk0jYbuLKE3dBpc9Q9yvf9A0z9lXaznBDfAlS2DHbw2iH7bDhjfarXmbw_7ddUYM3K3A7i16hHbxfUK7manK4F4g3imH0uqRUmULjFIul4kzSaTKS7eehkBIpWbopSu8TdIcRDlIdm66EiprI5n_xMsAb2VHc9KMMDaeVVVU41G6SEXom8CFFCzjcLFGNv4sDnNlTsdskA_aU3aGEvmg88kGQUlDqGDK0YlIMLGvQ2IcdqXSzSWfwz0N58eo3EoAAt2LV1XZce6IS_ot0L4BLnNEgsztQBwZKEtKcXiin7hx4A7grrY_-D6Y3QTdm7Fg7PdosSFt-O7GyUXhIcgcegvUGFLvEWDoTrmP_2IyOwg971M8gmDXV5zrBrae4HJIdrS933t0xkbsTXvXei-ST6DJawTmpJBD4omAuWGxz58MMce_fxhRJmwnNn1YKFiyZE8pE8Q"; 

    // Configuração de uma "Caixa Padrão" de 1KG para o envio
    $dados_frete = [
        "from" => ["postal_code" => $cep_origem],
        "to" => ["postal_code" => $cep_destino],
        "package" => [
            "weight" => 1,      // Peso em KG
            "width" => 20,      // Largura em CM
            "height" => 15,     // Altura em CM
            "length" => 20      // Comprimento em CM
        ],
        "options" => [
            "receipt" => false,
            "own_hand" => false
        ]
    ];

    $curl = curl_init();

    curl_setopt_array($curl, [
        // URL da API de Testes (Sandbox). Depois que validar, é só mudar para a URL de Produção
        CURLOPT_URL => "https://sandbox.melhorenvio.com.br/api/v2/me/shipment/calculate",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($dados_frete),
        CURLOPT_HTTPHEADER => [
            "Accept: application/json",
            "Content-Type: application/json",
            "Authorization: Bearer " . $token,
            "User-Agent: Aplicacao IOT Store (seu_email@dominio.com)" 
        ],
    ]);

    $response = curl_exec($curl);
    $erro = curl_error($curl);
    curl_close($curl);

    if ($erro) {
        echo json_encode(["erro" => "Falha na comunicação com a API de frete."]);
    } else {
        // Devolve o JSON com os preços e prazos para o carrinho
        echo $response;
    }
}
?>