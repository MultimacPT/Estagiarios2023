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


    // Mostra o loader
    loader.style.display = 'block';
    //alert('teste');

    // Verifica se a localização está disponível
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        // Envia os dados do formulário apenas se a localização estiver disponível
        enviarFormulario(url, formData);
      }, function(error) {
        console.error(error);
        alert('Erro: Por favor, verifique permissões para picar!');
        submitButton.disabled = false;
        submitButton.style.display = 'block';
        loader.style.display = 'none';
        document.getElementById('tempo').textContent = '';
      });
    } else {
      console.error('Geolocalização não suportada pelo navegador');
      alert('Por favor, use um navegador compatível!');
      submitButton.disabled = false;
      submitButton.style.display = 'block';
      loader.style.display = 'none';
    }

  });

  function enviarFormulario(url, formData) {
    fetch(url, {
      method: 'POST',
      body: formData
    })
    .then(response => {
      if (response.ok) {
        var mensagem = 'Picagem feita com sucesso.';
        document.getElementById('tempo').textContent = mensagem + ' Aguarde 15 segundos.';
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
      notificacao();

      setTimeout(() => {
        document.getElementById('tempo').textContent = '';
        submitButton.disabled = false;
        submitButton.style.display = 'block';
      }, 15000);
    });
  }

  
  function atualizarLista() {
    fetch('phpsystems/picar-get.php')
    .then(response => response.text())
    .then(data => {
      document.getElementById('lista').innerHTML = data;
    })
    .catch(error => console.error(error));
  }

  function notificacao(){
    $(document).ready(function() {
      $.ajax({
        url: 'phpsystems/verifica-notificacao.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response !== '0') {
            // Notificações encontradas, ative o botão aqui
            $("div[data-role='form']").addClass("blur-effect");
            $("body").css("overflow", "hidden");
            $("#notification-popup").popup("open");
    
            $("#notification-popup").on("click", "a[data-rel='close']", function() {
              $("#notification-popup").popup("close");
              $("body").css("overflow", "auto"); // Restaura a barra de rolagem
              $("div[data-role='form']").removeClass("blur-effect"); // Remove o desfoque
            });
          }
        },
        error: function(xhr, status, error) {
          console.log('Erro na solicitação AJAX:', error);
        }
      });
    });
  }
});
