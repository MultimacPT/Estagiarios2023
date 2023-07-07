document.addEventListener("DOMContentLoaded", function () {
  const url = new URL(window.location.href);
  const id = url.searchParams.get("id");
  busca_guia(id);

    const botaoEditar = document.getElementById("editar");
    const divBotoes = document.getElementById("botoes");
    const botaocancelar = document.getElementById("cancelar");
    const botaosalvar = document.getElementById("salvar");

    botaoEditar.addEventListener("click", function() {
      var inputs = document.getElementsByTagName("input");
      for (var i = 0; i < inputs.length; i++) {

        inputs[i].addEventListener("keyup", function() {
          this.setAttribute("value", this.value);
        });
        
      }
      var checkboxValue = document.getElementById("checkbox_conclusao").checked;

      if(checkboxValue === true){
        alert('Não tem autorização para editar guias concluídas! Entre em contacto com um supervisor se for necessária alguma alteração.');
        return;
      }


      document.getElementById("copiaPB").readOnly = false;
      document.getElementById("copiaCor").readOnly = false;


      document.getElementById("checkbox_conclusao").disabled = false;
      document.getElementById("copiaPB").style.backgroundColor = 'white';
      document.getElementById("copiaCor").style.backgroundColor = 'white';

      botaoEditar.style.display = "none";
      divBotoes.style.display = "block";
    });

    botaosalvar.addEventListener("click", function() {
      const url = new URL(window.location.href);
      const id = url.searchParams.get("id");
    
      //var nomeGuia = document.getElementById("nomeGuia").value;
      //var codigoAT = document.getElementById("codigoAT").value;
      //var numeroGuia = document.getElementById("numeroGuia").value;
      var copiaPB = document.getElementById("copiaPB").value;
      var copiaCor = document.getElementById("copiaCor").value;


      var checkboxValue = document.getElementById("checkbox_conclusao").checked;

    
      var data = new FormData();
      data.append("idGuia", id);
      //data.append("nomeGuia", nomeGuia);
      //data.append("codigoAT", codigoAT);
      //data.append("numeroGuia", numeroGuia);
      data.append("copiaPB", copiaPB);
      data.append("copiaCor", copiaCor);
      data.append("conclusao", checkboxValue);
    
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
  
