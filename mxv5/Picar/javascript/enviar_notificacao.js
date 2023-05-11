document.addEventListener("DOMContentLoaded", function() {
    var contar_response = null;
  
    setInterval(function() {
      $.ajax({
        url: 'phpsystems/verifica-notificacao.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response !== '0') {
            if (contar_response !== response) {
              
              contar_response = response; // Atualiza contar_response com o novo valor de response
              document.getElementById('contar-not').textContent = ' (' + contar_response + ')';
            }
          }
        },
        error: function(xhr, status, error) {
          console.log('Erro na solicitação AJAX:', error);
        }
      });
    }, 5000);
  });
  
  

  