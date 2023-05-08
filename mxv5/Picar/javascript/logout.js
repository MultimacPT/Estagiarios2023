document.addEventListener("DOMContentLoaded", function() {


      const form = document.getElementById('logout');
    
      form.addEventListener('submit', function(event) {
        event.preventDefault();
        const url = this.action;
        const formData = new FormData(this);
    
        fetch(url, {
          method: 'POST',
          body: formData
        })
        .then(response => {
          if (response.ok) {
            console.log('Dados do formulário enviados com sucesso!');
          } else {
            console.error('Erro');
          }
        })
        .catch(error => console.error(error))
        .finally(() => {
          window.location.href = "login.php";
        });
      });
    


});
