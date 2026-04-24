
  // Pega o campo de arquivo e a imagem de preview
  const inputFoto = document.getElementById('foto');
  const previewFoto = document.getElementById('preview-foto');

  // Fica escutando qualquer mudança no campo de foto
  inputFoto.addEventListener('change', function(event) {
      // Pega o arquivo que o usuário selecionou
      const arquivo = event.target.files[0];

      // Se ele realmente escolheu um arquivo
      if (arquivo) {
          const leitor = new FileReader();

          // Quando o leitor terminar de carregar a foto na memória do navegador...
          leitor.onload = function(e) {
              // ...ele troca o 'src' da imagem pelo arquivo carregado
              previewFoto.src = e.target.result;
          }

          // Inicia a leitura do arquivo como uma URL de dados
          leitor.readAsDataURL(arquivo);
      } else {
          // Se o usuário cancelar a seleção, volta para a imagem padrão
          previewFoto.src = "../../assets/img/placeholder-funcionario.png";
      }
    });