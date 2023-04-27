document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('myForm');
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
                // Faça alguma ação aqui, como exibir uma mensagem de sucesso
                atualizarResultado(); // chama a função para atualizar o resultado
            } else {
                console.error('Erro ao enviar dados do formulário');
            }
        })
        .catch(error => console.error(error));
    });

    function atualizarResultado() {
        fetch('PicarGet.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('resultado').innerHTML = data;
        })
        .catch(error => console.error(error));
    }

});