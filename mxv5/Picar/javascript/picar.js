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
    submitButton.style.display = 'none';
    document.getElementById('tempo').textContent = 'Próxima picagem disponível em 15 segundos.';

    // Mostra o loader
    loader.style.display = 'block';

    // Verifica se a localização está disponível
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        // Envia os dados do formulário apenas se a localização estiver disponível
        formData.append('latitude', position.coords.latitude);
        formData.append('longitude', position.coords.longitude);
        enviarFormulario();
      }, function(error) {
        console.error(error);
        alert('Erro: Por favor, ative a localização para picar!');
        submitButton.disabled = false;
        submitButton.style.display = 'block';
        loader.style.display = 'none';
        document.getElementById('tempo').textContent = '';
      });
    } else {
      console.error('Geolocalização não suportada pelo navegador');
      alert('Por favor, use um navegador compatível com geolocalização para continuar!');
      submitButton.disabled = false;
      submitButton.style.display = 'block';
      loader.style.display = 'none';
    }

    function enviarFormulario() {
      fetch(url, {
        method: 'POST',
        body: formData
      })
      .then(response => {
        if (response.ok) {
          console.log('Dados do formulário enviados com sucesso!');

          atualizarLista(); // chama a função para atualizar o resultado
        } else {
          console.error('Erro ao enviar dados do formulário');
        }
      })
      .catch(error => console.error(error))
      .finally(() => {
        // Esconde o loader após terminar as operações
        loader.style.display = 'none';

        setTimeout(() => {
          document.getElementById('tempo').textContent = '';
          submitButton.disabled = false;
          submitButton.style.display = 'block';
        }, 15000);
      });
    }

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
