/*
 * ARQUIVO DE LÓGICA JAVASCRIPT - IOT STORE
 * Este arquivo contém as interações dinâmicas do site.
 */

// ============================================================
// -----------------FUNÇÕES PRINCIPAIS-------------------------
// ============================================================

// ============================================================
// 1. Função para copiar o código do cupom de desconto para a área de transferência.
// ============================================================

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

// ============================================================
// 3. Função para buscar os produtos no banco via AJAX (Filtros)
// ============================================================
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

    // Pega o que foi digitado na barra de pesquisa do admin
    var termoPesquisa = $('#termo-pesquisa').val();

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
// 4. Função para pesquisar dentro do Painel Administrativo 
// ============================================================
function buscarAdmin() {
    var termoPesquisa = $('#termo-pesquisa').val();

    // Se o campo de pesquisa estiver vazio
    if (termoPesquisa.trim() === '') {
        $('#area-resultados-pesquisa').hide().html(''); // Limpa e esconde a área de busca
        $('.corpo-dashboard').show(); // Mostra o dashboard original com gráficos
        return;
    }

    // Se tiver algo digitado, envia pro PHP
    $.ajax({
        url: '../buscaadmin.php', 
        type: 'POST',
        data: { pesquisa: termoPesquisa },
        success: function(data) {
            $('.corpo-dashboard').hide(); // Esconde o dashboard original
            $('#area-resultados-pesquisa').show().html(data); // Injeta e mostra a tabela
        }
    });
}

// ============================================================
// 5. Função para inicializar os gráficos do Dashboard usando Chart.js  
// ============================================================

function inicializarGraficosDashboard() {
// --- GRÁFICO DE BARRAS (Vendas) ---
    const canvasVendas = document.getElementById('graficoVendas');
    
    // Verifica se o elemento existe (evita erros em páginas que não têm o dashboard)
    if (canvasVendas) {
        // Faz o parse do JSON que foi colocado no atributo data-* pelo PHP
        const rotulosVendas = JSON.parse(canvasVendas.getAttribute('data-rotulos') || '[]');
        const dadosVendas = JSON.parse(canvasVendas.getAttribute('data-valores') || '[]');

        new Chart(canvasVendas, {
            type: 'bar',
            data: {
                labels: rotulosVendas.length > 0 ? rotulosVendas : ['Sem dados'],
                datasets: [{
                    label: 'Faturamento Mensal (R$)',
                    data: dadosVendas.length > 0 ? dadosVendas : [0],
                backgroundColor: [
                    'rgba(23, 37, 56, 0.8)',    // Azul Escuro
                    'rgba(31, 97, 214, 0.8)',   // Azul Royal 
                    'rgba(103, 118, 138, 0.8)', // Azul Acinzentado 
                    'rgba(178, 77, 15, 0.8)',   // Ferrugem/Marrom 
                    'rgba(206, 216, 226, 0.8)', // Cinza Claro 
                    'rgba(71, 85, 105, 0.8)'    // Cinza Chumbo Escuro
                ],
                borderColor: [
                    'rgba(23, 37, 56, 1)',      // Azul Escuro
                    'rgba(31, 97, 214, 1)',     // Azul Royal
                    'rgba(103, 118, 138, 1)',   // Azul Acinzentado
                    'rgba(178, 77, 15, 1)',     // Ferrugem/Marrom
                    'rgba(206, 216, 226, 1)',   // Cinza Claro
                    'rgba(71, 85, 105, 1)'      // Cinza Chumbo Escuro
                ],
                borderWidth: 1,
                borderRadius: 4 // Deixa as pontas das barras levemente arredondadas (opcional)
            }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true } }
            }
        });
    }

// --- GRÁFICO DE ROSCA (Categorias) ---
    const canvasCat = document.getElementById('graficoCategorias');
    
    if (canvasCat) {
        const rotulosCat = JSON.parse(canvasCat.getAttribute('data-rotulos') || '[]');
        const dadosCat = JSON.parse(canvasCat.getAttribute('data-valores') || '[]');

        new Chart(canvasCat, {
            type: 'doughnut',
            data: {
                labels: rotulosCat,
                datasets: [{
                    data: dadosCat,
                    backgroundColor: ['#152738', '#1d4ed8', '#64748b', '#b45309', '#cbd5e1'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                cutout: '70%'
            }
        });
    }
}

// =========================================================================
// -----------INICIALIZAÇÃO DE EVENTOS (Ao carregar a página)---------------
// =========================================================================

$(document).ready(function() {

    // ============================================================
    // --- LÓGICA DO TEMA CLARO/ESCURO (DARK MODE) ---
    // ============================================================
    const btnTema = document.getElementById('btn-tema'); // Pega o botão de alternar tema
    const iconeTema = btnTema ? btnTema.querySelector('i') : null; // Pega o ícone dentro do botão
    const htmlElement = document.documentElement; // Pega a tag <html>

    if (btnTema) {
        // 1. Verifica qual é o tema salvo ou a preferência do sistema
        const temaSalvo = localStorage.getItem('tema'); // Pega o tema salvo no localStorage (se houver)
        const prefereEscuro = window.matchMedia('(prefers-color-scheme: dark)').matches; // Verifica se o usuário prefere o tema escuro pelo sistema operacional

        // 2. Aplica o tema inicial
        if (temaSalvo === 'dark' || (!temaSalvo && prefereEscuro)) {
            htmlElement.setAttribute('data-theme', 'dark'); // Aplica o tema escuro
            iconeTema.classList.replace('fa-moon', 'fa-sun'); // Muda o ícone para o sol (indicando que está no modo escuro)
        }

        // 3. Evento de clique no botão
        btnTema.addEventListener('click', function() {
            // Se o tema atual for dark, muda para claro. Se for claro, muda para dark.
            if (htmlElement.getAttribute('data-theme') === 'dark') {
                htmlElement.removeAttribute('data-theme'); // Remove o atributo para voltar ao tema claro
                iconeTema.classList.replace('fa-sun', 'fa-moon'); // Muda o ícone para a lua (indicando que está no modo claro)
                localStorage.setItem('tema', 'light'); // Salva a escolha
            } else {
                htmlElement.setAttribute('data-theme', 'dark'); // Aplica o tema escuro
                iconeTema.classList.replace('fa-moon', 'fa-sun'); // Muda o ícone para o sol (indicando que está no modo escuro)
                localStorage.setItem('tema', 'dark'); // Salva a escolha
            }
        });
    }
// ============================================================
    // --- COPIAR CUPOM ---
// ============================================================
    const botaoCopiar = document.querySelector('.botao-cupom');
    if (botaoCopiar) {
        botaoCopiar.addEventListener('click', copiarCupom);
    }

// ============================================================
    // --- CARROSSEL DE PRODUTOS ---
// ============================================================
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
// ============================================================
    // --- BARRA DE PESQUISA (MOBILE) ---
// ============================================================
    $('.botao-pesquisa-mobile').click(function() {
        $('.barra-pesquisa').toggleClass('ativa');
        
        if ($('.barra-pesquisa').hasClass('ativa')) {
            $('.barra-pesquisa input').focus();
        }
    });

// ============================================================
    // --- MENU LATERAL DE FILTROS (MOBILE) ---
// ============================================================
    $('.botao-abrir-filtros').click(function() {
        $('.sidebar').addClass('ativa');
    });

    $('.botao-fechar-filtros').click(function() {
        $('.sidebar').removeClass('ativa');
    });

// ============================================================
    // --- ATUALIZAÇÃO VISUAL DO SLIDER DE PREÇO ---
// ============================================================
    const precoSlider = document.querySelector('.preco-slider');
    const precoLabel = document.querySelectorAll('.preco-labels span')[1]; 

    if(precoSlider) {
        precoSlider.addEventListener('input', function() {
            let valorFormatado = parseInt(this.value).toLocaleString('pt-BR');
            precoLabel.textContent = 'R$ ' + valorFormatado;
        });
    }
// ============================================================
    // --- DISPARO AUTOMÁTICO DA BUSCA (FILTROS) ---
// ============================================================
    // Dispara a busca quando o usuário altera qualquer filtro (categoria, marca, promoção ou preço)
    $('.filtro-categoria, .filtro-marca, #filtro-promocao').on('change', buscar);
    $('.preco-slider').on('change', buscar);

    // Dispara a busca em tempo real enquanto o usuário digita na barra de pesquisa do admin
    $('#termo-pesquisa').on('input', buscarAdmin);

// ============================================================
    // --- INICIALIZAÇÃO DO DASHBOARD ADMIN ---
// ============================================================
    inicializarGraficosDashboard();

});

