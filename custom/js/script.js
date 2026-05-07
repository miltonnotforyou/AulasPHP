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


document.addEventListener("DOMContentLoaded", function() {
    
    // ==========================================
    // 1. LÓGICA DE PRODUTOS / LUCRO
    // ==========================================
    let btnLucro = document.querySelector("#preco_custo"); // Apenas para checar se estamos na tela de produto
    if (btnLucro) {
        // Torna as funções globais caso você as chame no HTML (ex: onchange="lucro()")
        window.lucro = function() {
            let custo = Number(document.querySelector("#preco_custo").value);
            let margem = Number(document.querySelector("#valor_lucro").value);

            if (custo > 0 && margem > 0) {
                let preco_venda = custo * (1 + margem / 100);
                document.querySelector("#preco_venda").value = preco_venda.toFixed(2);
            } else {
                document.querySelector("#preco_venda").value = "";
            }
        };
    }

    // ==========================================
    // 2. LÓGICA DE PROMOÇÃO
    // ==========================================
    let inputDesconto = document.getElementById("desconto_promocao");
    
    // Só tenta desabilitar se o campo existir na página atual!
    if (inputDesconto) {
        inputDesconto.disabled = true;

        window.desabilitar = function() {
            let status_promocao = document.getElementById("status_promocao").value;

            if (status_promocao == "1") {
                inputDesconto.disabled = false;
            } else {
                inputDesconto.disabled = true;
                inputDesconto.value = "";
                let precoPromo = document.querySelector("#preco_promocao");
                if (precoPromo) precoPromo.value = ""; 
            }
        };

        window.calcularPrecoPromocao = function() {
            let preco_venda = Number(document.querySelector("#preco_venda").value);
            let desconto    = Number(document.querySelector("#desconto_promocao").value);

            if (preco_venda > 0 && desconto > 0) {
                let preco_promo = preco_venda - (preco_venda * desconto / 100);
                document.querySelector("#preco_promocao").value = preco_promo.toFixed(2);
            } else {
                document.querySelector("#preco_promocao").value = "";
            }
        };
    }


    // ==========================================
    // 3. VALIDAÇÃO DE DATA DE NASCIMENTO
    // ==========================================
    const inputData = document.getElementById("data_nascimento");
    
    if (inputData) {
        // Criando a data no fuso horário local
        const dataAtual = new Date();
        const ano = dataAtual.getFullYear();
        const mes = String(dataAtual.getMonth() + 1).padStart(2, '0');
        const dia = String(dataAtual.getDate()).padStart(2, '0');
        const hoje = `${ano}-${mes}-${dia}`; // Formato YYYY-MM-DD

        // Define a data máxima como hoje
        inputData.setAttribute("max", hoje);

      

        // Validação ao tirar o foco ou escolher no calendário
        inputData.addEventListener("change", function() {
            if (this.value > hoje) {
                alert("A data de nascimento não pode ser no futuro!");
                this.value = ""; // Limpa o campo
            }
        });

        // Validação enquanto digita
        inputData.addEventListener("input", function() {
            if (this.value > hoje) {
                this.setCustomValidity("A data não pode ser futura.");
            } else {
                this.setCustomValidity(""); // Remove o erro
            }
            this.reportValidity(); // Mostra o alerta de erro visual
        });
    }
});