var btnPerfil = document.getElementById("btn-page-perfil");
var btnNotificacao = document.getElementById("notificacao");
var btnGuias = document.getElementById("btn-page-guias");


// Adicione os ouvintes de evento para cada botão
btnPerfil.addEventListener("click", function() {
  window.location.href = "perfilform.php";
});

btnNotificacao.addEventListener("click", function() {
  window.location.href = "https://mx.multimac.pt/mxv5/#Notification";
});

btnGuias.addEventListener("click", function() {
  window.location.href = "guias.php";
});


