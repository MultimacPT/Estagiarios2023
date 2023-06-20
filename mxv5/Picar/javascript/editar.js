document.addEventListener("DOMContentLoaded", function () {
  const url = new URL(window.location.href);
  const id = url.searchParams.get("id");
  busca_guia(id);

    const botaoEditar = document.getElementById("editar");
    const divBotoes = document.getElementById("botoes");cancelar
    const botaocancelar = document.getElementById("cancelar");
    const botaosalvar = document.getElementById("salvar");

    botaoEditar.addEventListener("click", function() {
      var inputs = document.getElementsByTagName("input");
      for (var i = 0; i < inputs.length; i++) {
        inputs[i].readOnly = false;
        

            inputs[i].addEventListener("keyup", function() {
              this.setAttribute("value", this.value);
            });
      }
      document.getElementById("checkbox_feito").disabled = false;

      botaoEditar.style.display = "none";
      divBotoes.style.display = "block";
    });

    botaosalvar.addEventListener("click", function() {
      const url = new URL(window.location.href);
      const id = url.searchParams.get("id");
    
      var nomeGuia = document.getElementById("nomeGuia").value;
      var codigoAT = document.getElementById("codigoAT").value;
      var numeroGuia = document.getElementById("numeroGuia").value;
      var copiaBr = document.getElementById("copiaBr").value;
      var copiaCor = document.getElementById("copiaCor").value;


      var checkboxValue = document.getElementById("checkbox_feito").checked;

    
      var data = new FormData();
      data.append("idGuia", id);
      data.append("nomeGuia", nomeGuia);
      data.append("codigoAT", codigoAT);
      data.append("numeroGuia", numeroGuia);
      data.append("copiaBr", copiaBr);
      data.append("copiaCor", copiaCor);
      data.append("feito", checkboxValue);
    
      fetch("phpsystems/editar-put.php", {
        method: "POST",
        body: data
      })
      .then(function(response) {
        if (response.ok) {
          alert('foi editado com sucesso');
          botaoEditar.style.display = "block";
          divBotoes.style.display = "none";
          busca_guia(id);
        } else {
          alert("Erro ao salvar os dados");
        }
      })
      .catch(function(error) {
        alert("Erro ao salvar os dados");
      });
    });
    

    botaocancelar.addEventListener("click", function() {
      botaoEditar.style.display = "block";
      divBotoes.style.display = "none";

      busca_guia(id);
    });

});


function busca_guia(id) {
  fetch("phpsystems/editar-get.php?id=" + id)
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("lista").innerHTML = data;
    })
    .catch((error) => console.error(error));
}
  
