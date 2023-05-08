document.addEventListener("DOMContentLoaded", function() {
  atualizarLista();

  const form = document.getElementById('myForm');
  const loader = document.getElementById('loader');
  const submitButton = document.getElementById('submitButton');

  form.addEventListener('submit', function(event) {
    event.preventDefault();
    const url = this.action;
    const formData = new FormData(this);

    // Desativa o botão de envio
    submitButton.disabled = true;

    // Mostra o loader
    loader.style.display = 'block';

    fetch(url, {
      method: 'POST',
      body: formData
    })
    .then(response => {
      if (response.ok) {
        console.log('Dados do formulário enviados com sucesso!');
        // Faça alguma ação aqui, como exibir uma mensagem de sucesso
        atualizarLista(); // chama a função para atualizar o resultado
      } else {
        console.error('Erro ao enviar dados do formulário');
      }
    })
    .catch(error => console.error(error))
    .finally(() => {
      // Esconde o loader após terminar as operações
      loader.style.display = 'none';

      // Reativa o botão de envio após 2 segundos
      setTimeout(() => {
        submitButton.disabled = false;
      }, 20000);
    });
  });

  function atualizarLista() {
    fetch('phpsystems/picar-get.php')
    .then(response => response.text())
    .then(data => {
      document.getElementById('lista').innerHTML = data;
    })
    .catch(error => console.error(error));
  }
});