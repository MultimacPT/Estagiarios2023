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



  });
  


  
  

  