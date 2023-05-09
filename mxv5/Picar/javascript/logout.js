$(document).on('pageinit', function() {
    $( "#menu-popup" ).enhanceWithin().popup();
  });
  
  $(document).on("click", ".logout-btn", function() {
    $.ajax({
      url: "phpsystems/logout.php",
      method: "POST",
      success: function(data) {
        window.location.href = "login.php"; // redirecionar para a página de login
      },
      error: function(xhr, status, error) {
        console.log("Erro ao efetuar logout: " + error);
      }
    });
  });
