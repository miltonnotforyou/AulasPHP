// document.getElementById('foto').addEventListener('change', function(event) {
//       // Pega o arquivo que o usuário selecionou
//       let arquivo = event.target.files[0];
//      // Se ele realmente escolheu um arquivo
//      if (arquivo) {
//          let leitor = new FileReader();
//             // Quando o leitor terminar de carregar a foto na memória do navegador...
//             document.getElementById('preview-foto').src = URL.createObjectURL(arquivo);
//             }
            
//             // Inicia a leitura do arquivo como uma URL de dados
//     });



    //Função para calcular o preço de venda com base no preço de custo e na margem de lucro
    
    function lucro() 
      {
    let custo = Number(document.querySelector("#preco_custo").value);
    let margem = Number(document.querySelector("#valor_lucro").value);

    if (custo > 0 && margem > 0) {
        let preco_venda = custo * (1 + margem / 100);
        document.querySelector("#preco_venda").value = preco_venda.toFixed(2);
    } else {
        document.querySelector("#preco_venda").value = "";
    }
        }

       // DESABILITAR CAMPOS DE PROMOÇÃO
            let inputDesconto = document.getElementById("desconto_promocao");

            inputDesconto.disabled = true;

            function desabilitar() {
                let status_promocao = document.getElementById("status_promocao").value;

                if (status_promocao == "1") {
                    inputDesconto.disabled = false;
                } else {
                    inputDesconto.disabled = true;
                    inputDesconto.value = "";
                    document.querySelector("#preco_promocao").value = ""; // limpa junto
                }
            }

        //calcular preço promocional com base no preço de venda e no desconto
        function calcularPrecoPromocao() {
            let preco_venda = Number(document.querySelector("#preco_venda").value);
            let desconto    = Number(document.querySelector("#desconto_promocao").value);

            if (preco_venda > 0 && desconto > 0) {
                let preco_promo = preco_venda - (preco_venda * desconto / 100);
                document.querySelector("#preco_promocao").value = preco_promo.toFixed(2);
            } else {
                document.querySelector("#preco_promocao").value = "";
            }
        }