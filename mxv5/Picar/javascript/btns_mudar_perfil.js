var btnPicar = document.getElementById("btn-page-picar");
var btnNotificacao = document.getElementById("notificacao");


// Adicione os ouvintes de evento para cada botão
btnPicar.addEventListener("click", function() {
  window.location.href = "Picarform.php";
});

btnNotificacao.addEventListener("click", function() {
  window.location.href = "https://mx.multimac.pt/mxv5/#Notification";
});
