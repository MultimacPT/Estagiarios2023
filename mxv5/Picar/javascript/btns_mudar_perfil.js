var btnPicar = document.getElementById("btn-page-picar");
var btnNotificacao = document.getElementById("notificacao");
var btnGuias = document.getElementById("btn-page-guias");


// Adicione os ouvintes de evento para cada botão
btnPicar.addEventListener("click", function() {
  window.location.href = "Picarform.php";
});

btnNotificacao.addEventListener("click", function() {
  window.location.href = "https://mx.multimac.pt/mxv5/#Notification";
});

btnGuias.addEventListener("click", function() {
  window.location.href = "guias.php";
});
