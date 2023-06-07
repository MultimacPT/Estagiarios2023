document.addEventListener("DOMContentLoaded", function () {
    atualizarLista();
  
    function atualizarLista() {
      fetch("phpsystems/editar-get.php")
        .then((response) => response.text())
        .then((data) => {
          document.getElementById("lista").innerHTML = data;
        })
        .catch((error) => console.error(error));
    }
  
    
  });