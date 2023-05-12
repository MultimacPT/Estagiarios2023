document.addEventListener("DOMContentLoaded", function() {
  
    setInterval(function() {
      $.ajax({
        url: 'phpsystems/verifica-notificacao.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response !== '0') {
              
            document.getElementById('contar-not').textContent = ' (' + response + ')';
            
          }
          else
          {
            document.getElementById('contar-not').textContent = ' (0)';
          }
        },
        error: function(xhr, status, error) {
          console.log('Erro na solicitação AJAX:', error);
        }
      });
    }, 5000);



  });
  


  
  

  