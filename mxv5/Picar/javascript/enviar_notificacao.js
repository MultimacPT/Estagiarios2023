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
              if ("Notification" in window) {
                // O navegador suporta notificações
                if ('Notification' in window) {
                  Notification.requestPermission().then(function(permission) {
                    if (permission === 'granted') {
                      console.log('Permissão concedida.');
                    }
                  });
                }
  
                if (Notification.permission === "granted") {
                  var notification = new Notification("Nova notificação", {
                    body: "Consulte o CRM",
                    icon: "images/logo-hito-4.png"
                  });
  
                  // Ação a ser executada quando o usuário clicar na notificação
                    notification.onclick = function() {
                    // Ação do clique na notificação
                    window.focus(); // Coloque o foco na janela do site, se necessário
                    notification.close(); // Feche a notificação, se necessário
                  };
                }
              } else {
                // O navegador não suporta notificações
              }
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
  
  

  