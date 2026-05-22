document.addEventListener("DOMContentLoaded", function() {

    // ==========================================
    // PREVIEW EM TEMPO REAL DA FOTO SELECIONADA
    // ==========================================
    let inputFoto = document.getElementById('foto');
    let previewFoto = document.getElementById('preview-foto');

    if (inputFoto && previewFoto) {
        inputFoto.addEventListener('change', function(event) {
            // Pega o arquivo que o usuário selecionou no computador/celular
            let arquivo = event.target.files[0];
            
            // Se ele realmente escolheu um arquivo válido
            if (arquivo) {
                // Cria uma URL temporária local para o arquivo e atualiza o 'src' da imagem na tela
                previewFoto.src = URL.createObjectURL(arquivo);
            }
        });
    }

    // ==========================================
    // 1 e 2. LÓGICA DE PRODUTOS, LUCRO E PROMOÇÃO
    // ==========================================
    let campoCusto = document.querySelector("#preco_custo");
    let inputDesconto = document.getElementById("desconto_promocao");
    let selectPromocao = document.getElementById("status_promocao");

    if (selectPromocao && inputDesconto) {
        // Função para habilitar ou desabilitar o campo de desconto
        window.desabilitar = function() {
            if (selectPromocao.value == "1") {
                inputDesconto.disabled = false;
            } else {
                inputDesconto.disabled = true;
                inputDesconto.value = "";
                let precoPromo = document.querySelector("#preco_promocao");
                if (precoPromo) precoPromo.value = ""; 
            }
        };

        // Sincroniza o estado inicial no carregamento da página sem apagar os dados
        if (selectPromocao.value == "1") {
            inputDesconto.disabled = false;
        } else {
            inputDesconto.disabled = true;
        }

        // Calcula o preço promocional
        window.calcularPrecoPromocao = function() {
            let precoVendaAtual = Number(document.querySelector("#preco_venda").value);
            let descontoAtual   = Number(document.querySelector("#desconto_promocao").value);

            if (precoVendaAtual > 0 && descontoAtual > 0) {
                let precoPromo = precoVendaAtual - (precoVendaAtual * descontoAtual / 100);
                document.querySelector("#preco_promocao").value = precoPromo.toFixed(2);
            } else {
                document.querySelector("#preco_promocao").value = "";
            }
        };
    }

    // Calcula o preço de venda e engatilha a atualização da promoção
    if (campoCusto) {
        window.calcularLucro = function() {
            let custo  = Number(document.querySelector("#preco_custo").value);
            let margem = Number(document.querySelector("#lucro").value); 

            if (custo > 0 && margem > 0) {
                let precoVendaNovo = custo * (1 + margem / 100);
                document.querySelector("#preco_venda").value = precoVendaNovo.toFixed(2);
                
                // Dispara o recálculo da promoção se ela estiver ativa
                if (typeof window.calcularPrecoPromocao === "function" && selectPromocao && selectPromocao.value == "1") {
                    window.calcularPrecoPromocao();
                }
            } else {
                document.querySelector("#preco_venda").value = "";
                let precoPromo = document.querySelector("#preco_promocao");
                if (precoPromo) precoPromo.value = "";
            }
        };
    }

    // ==========================================
    // 3. VALIDAÇÃO DE DATA DE NASCIMENTO
    // ==========================================
    const inputData = document.getElementById("data_nascimento");
    
    if (inputData) {
        const dataAtual = new Date();
        const ano = dataAtual.getFullYear();
        const mes = String(dataAtual.getMonth() + 1).padStart(2, '0');
        const dia = String(dataAtual.getDate()).padStart(2, '0');
        const hoje = `${ano}-${mes}-${dia}`;

        inputData.setAttribute("max", hoje);

        inputData.addEventListener("change", function() {
            if (this.value > hoje) {
                alert("A data de nascimento não pode ser no futuro!");
                this.value = "";
            }
        });

        inputData.addEventListener("input", function() {
            if (this.value > hoje) {
                this.setCustomValidity("A data não pode ser futura.");
            } else {
                this.setCustomValidity("");
            }
            this.reportValidity();
        });
    }
});