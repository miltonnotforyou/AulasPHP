/**
 * ARQUIVO DE LÓGICA JAVASCRIPT - IOT STORE
 * Este arquivo contém as interações dinâmicas do site.
 */

// ============================================================
// 1. FUNÇÕES GERAIS
// ============================================================

/**
 * Função para copiar o código do cupom de desconto para a área de transferência.
 */
function copiarCupom() {
    const cupom = "IOT10"; // Código do cupom
    
    // Tenta copiar o texto para a área de transferência do sistema
    navigator.clipboard.writeText(cupom).then(() => {
        const botao = document.querySelector('.botao-cupom');
        const textoOriginal = botao.textContent;
        
        botao.textContent = "COPIADO!";
        botao.style.color = "#10b981"; // Cor verde de sucesso
        
        // Retorna ao estado original após 2 segundos
        setTimeout(() => {
            botao.textContent = textoOriginal;
            botao.style.color = ""; 
        }, 2000);
    }).catch(err => {
        console.error('Erro ao copiar cupom: ', err);
    });
}

// ============================================================
// 2. FUNÇÃO para trocar a imagem principal ao clicar nas miniaturas
// ============================================================

// Essa função é chamada quando o usuário clica em uma miniatura. Ela recebe o elemento da miniatura clicada e o nome do arquivo da imagem correspondente.
function trocarImagem(elementoMiniatura, nomeArquivoImagem) {
    // Pega a imagem principal pelo ID e atualiza seu atributo 'src' para mostrar a nova imagem. O caminho é construído concatenando a pasta 'images/' com o nome do arquivo passado como parâmetro.
    const imgPrincipal = document.getElementById('img-destaque');
    
    // Atualiza a imagem principal para mostrar a nova imagem. O caminho é construído concatenando a pasta 'images/' com o nome do arquivo passado como parâmetro.
    imgPrincipal.src = './images/' + nomeArquivoImagem;
    const todasMiniaturas = document.querySelectorAll('.miniatura'); // Seleciona todas as miniaturas para remover a classe 'ativa' delas, garantindo que apenas a miniatura clicada fique destacada.
    todasMiniaturas.forEach(function(min) { // Para cada miniatura encontrada, remove a classe 'ativa' para que ela não fique destacada.
      min.classList.remove('ativa');
    });
    // Adiciona a classe 'ativa' apenas à miniatura clicada, destacando-a visualmente para indicar que é a imagem atualmente exibida como principal.
    elementoMiniatura.classList.add('ativa');
  }

/**
 * Função para buscar os produtos no banco via AJAX (Filtros)
 */
function buscar() {
    // Pega as categorias marcadas
    var categoriasSelecionadas = [];
    $('.filtro-categoria:checked').each(function() {
        categoriasSelecionadas.push($(this).val());
    });

    // Pega a marca, preço máximo e status de promoção
    var marcaSelecionada = $('.filtro-marca:checked').val() || '';
    var precoMax = $('.preco-slider').val();
    var promocaoAtiva = $('#filtro-promocao').is(':checked') ? '1' : '';

    // Envia para o Tabela.php e atualiza a grade
    $.ajax({
        url: 'Tabela.php',
        type: 'POST',
        data: {
            categoria: categoriasSelecionadas,
            marca: marcaSelecionada,
            preco_max: precoMax,
            promocao: promocaoAtiva
        },
        success: function(data) {
            $('.grade-produtos').html(data);
        }
    });
}

// ============================================================
// 2. INICIALIZAÇÃO DE EVENTOS (Ao carregar a página)
// ============================================================

$(document).ready(function() {

    // ============================================================
    // --- LÓGICA DO TEMA CLARO/ESCURO (DARK MODE) ---
    // ============================================================
    const btnTema = document.getElementById('btn-tema');
    const iconeTema = btnTema ? btnTema.querySelector('i') : null;
    const htmlElement = document.documentElement; // Pega a tag <html>

    if (btnTema) {
        // 1. Verifica qual é o tema salvo ou a preferência do sistema
        const temaSalvo = localStorage.getItem('tema');
        const prefereEscuro = window.matchMedia('(prefers-color-scheme: dark)').matches;

        // 2. Aplica o tema inicial
        if (temaSalvo === 'dark' || (!temaSalvo && prefereEscuro)) {
            htmlElement.setAttribute('data-theme', 'dark');
            iconeTema.classList.replace('fa-moon', 'fa-sun');
        }

        // 3. Evento de clique no botão
        btnTema.addEventListener('click', function() {
            // Se o tema atual for dark, muda para claro. Se for claro, muda para dark.
            if (htmlElement.getAttribute('data-theme') === 'dark') {
                htmlElement.removeAttribute('data-theme');
                iconeTema.classList.replace('fa-sun', 'fa-moon');
                localStorage.setItem('tema', 'light'); // Salva a escolha
            } else {
                htmlElement.setAttribute('data-theme', 'dark');
                iconeTema.classList.replace('fa-moon', 'fa-sun');
                localStorage.setItem('tema', 'dark'); // Salva a escolha
            }
        });
    }

    // --- COPIAR CUPOM ---
    const botaoCopiar = document.querySelector('.botao-cupom');
    if (botaoCopiar) {
        botaoCopiar.addEventListener('click', copiarCupom);
    }

    // --- CARROSSEL DE PRODUTOS ---
    if ($('.carrossel-produtos').length > 0) { // Só executa se o carrossel existir na página
        $('.carrossel-produtos').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true,         
            autoplaySpeed: 3000,    
            pauseOnHover: true,     
            dots: true,
            arrows: true,
            responsive: [
                { breakpoint: 1024, settings: { slidesToShow: 3 } },
                { breakpoint: 768, settings: { slidesToShow: 2 } },
                { breakpoint: 480, settings: { slidesToShow: 1, arrows: false } }
            ]
        });
    }

    // --- BARRA DE PESQUISA (MOBILE) ---
    $('.botao-pesquisa-mobile').click(function() {
        $('.barra-pesquisa').toggleClass('ativa');
        
        if ($('.barra-pesquisa').hasClass('ativa')) {
            $('.barra-pesquisa input').focus();
        }
    });

    // --- MENU LATERAL DE FILTROS (MOBILE) ---
    $('.botao-abrir-filtros').click(function() {
        $('.sidebar').addClass('ativa');
    });

    $('.botao-fechar-filtros').click(function() {
        $('.sidebar').removeClass('ativa');
    });

    // --- ATUALIZAÇÃO VISUAL DO SLIDER DE PREÇO ---
    const precoSlider = document.querySelector('.preco-slider');
    const precoLabel = document.querySelectorAll('.preco-labels span')[1]; 

    if(precoSlider) {
        precoSlider.addEventListener('input', function() {
            let valorFormatado = parseInt(this.value).toLocaleString('pt-BR');
            precoLabel.textContent = 'R$ ' + valorFormatado;
        });
    }

    // --- DISPARO AUTOMÁTICO DA BUSCA (FILTROS) ---
    $('.filtro-categoria, .filtro-marca, #filtro-promocao').on('change', buscar);
    $('.preco-slider').on('change', buscar); 

});

