// Armazena o nome do arquivo desejado no localStorage
localStorage.setItem("paginaAtual", "picagem-layout.php");

// Verifica se o nome do arquivo está armazenado no localStorage quando a página é recarregada
window.onload = function() {
  var paginaAtual = localStorage.getItem("paginaAtual");
  if (paginaAtual) {
    window.location.href = paginaAtual;
  }
}