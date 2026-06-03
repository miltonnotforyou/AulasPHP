/**
 * ARQUIVO DE LÓGICA JAVASCRIPT - IOT STORE
 * Este arquivo contém as interações dinâmicas do site.
 */

/**
 * Função para copiar o código do cupom de desconto para a área de transferência.
 * Fornece feedback visual ao usuário após a cópia.
 */
function copiarCupom() {
    const cupom = "IOT5"; // O código do cupom
    
    // Tenta copiar o texto para a área de transferência do sistema
    navigator.clipboard.writeText(cupom).then(() => {
        // Seleciona o botão que foi clicado
        const botao = document.querySelector('.botao-cupom');
        const textoOriginal = botao.textContent;
        
        // Altera o texto e a cor para dar um feedback de sucesso
        botao.textContent = "COPIADO!";
        botao.style.color = "#10b981"; // Cor verde esmeralda
        
        // Após 2 segundos, volta o botão ao estado original
        setTimeout(() => {
            botao.textContent = textoOriginal;
            botao.style.color = ""; // Remove o estilo de cor customizado
        }, 2000);
    }).catch(err => {
        console.error('Erro ao copiar cupom: ', err);
    });
}

/**
 * Inicialização do site:
 * Adiciona os ouvintes de eventos (event listeners) assim que o conteúdo do site é carregado.
 */
document.addEventListener('DOMContentLoaded', () => {
    // Busca o botão de copiar cupom no documento
    const botaoCopiar = document.querySelector('.botao-cupom');
    
    // Se o botão existir, adiciona a função de clique a ele
    if (botaoCopiar) {
        botaoCopiar.addEventListener('click', copiarCupom);
    }
});


// --- CÓDIGOS PARA O CARROSSEL DE PRODUTOS ---

  $(document).ready(function()
  {
        $('.carrossel-produtos').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        
        // --- CONFIGURAÇÕES DO AUTOMÁTICO ---
        autoplay: true,         // O carrossel roda sozinho
        autoplaySpeed: 3000,    // Espera 3 segundos em cada produto
        pauseOnHover: true,     // PAUSA se o mouse estiver em cima do produto!
        // -----------------------------------
        
        dots: true,
        arrows: true,
        responsive: [
            {
            breakpoint: 1024,
            settings: { slidesToShow: 3 }
            },
            {
            breakpoint: 768,
            settings: { slidesToShow: 2 }
            },
            {
            breakpoint: 480,
            settings: { 
                slidesToShow: 1,
                arrows: false
            }
            }
        ]
        });
});
