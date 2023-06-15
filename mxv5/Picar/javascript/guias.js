function redirectToEditar(id) {
  var url = 'editar.php?id=' + id;
  window.location.href = url;
}

document.addEventListener("DOMContentLoaded", function () {
  atualizarLista();

  function atualizarLista() {
    fetch("phpsystems/guias-get.php")
      .then((response) => response.text())
      .then((data) => {
        document.getElementById("lista").innerHTML = data;
      })
      .catch((error) => console.error(error));
  }


  
  
  
});
