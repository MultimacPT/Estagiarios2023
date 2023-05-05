document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("login-form");
  const usernameField = document.getElementById("username");
  const passwordField = document.getElementById("password");

  form.addEventListener("submit", function (event) {
    event.preventDefault();

    if (usernameField.value === "") {
      alert("Por favor, preencha o campos.");
      return;
    }

    if (passwordField.value === "") {
      alert("Por favor, preencha os campos.");
      return;
    }

    const url = this.action;
    const formData = new FormData(this);

    fetch(url, {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (response.ok) {
          console.log("Dados do formulário enviados com sucesso!");
          // Faça alguma ação aqui, como exibir uma mensagem de sucesso

          // verifica se o servidor retornou uma resposta bem-sucedida
          if (response.status === 200) {
            window.location.href = "Picarform.php";
          }
        } else {
          console.error("Erro ao enviar dados do formulário");
          window.alert("Ocorreu um erro ao logar. Por favor, tente novamente.");
        }
      })
      .catch((error) => console.error(error));
  });
});
