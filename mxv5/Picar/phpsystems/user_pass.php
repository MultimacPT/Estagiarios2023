<?php
session_start();

$user = $_POST['username'];
$password = $_POST['password'];
$check = $_POST['lembrar'];

$_SESSION['username'] = $user;
$_SESSION['password'] = $password;

$url = 'https://mx.multimac.pt/mxv5/api/v1/App/user';
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Authorization: Basic ' . base64_encode($user . ':' . $password)
));
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($curl);
$status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);


$data = json_decode($response);
$nome = $data->user->name;
$id = $data->user->id;
$email = $data->user->emailAddress;


$_SESSION['name'] = $nome;
$_SESSION['id'] = $id;
$_SESSION['email'] = $email;

if ($status_code == 200) {
    if ($check == 'on'){
        // Define o valor do cookie
        $valorCookie_user_pass = urlencode($user) . ',' . urlencode($password);
        // Define a data de expiração do cookie (por exemplo, em 30 dias)
        $dataExpiracao = time() + (365 * 24 * 60 * 60);
        // Define o caminho do cookie (opcional, padrão é "/")
        $caminhoCookie = "/";
        // Define o domínio do cookie (opcional, padrão é o domínio atual)
        $dominioCookie = "";
        // Define se o cookie só deve ser enviado por conexões seguras (HTTPS) (opcional, padrão é false)
        $cookieSeguro = false;
        // Define se o cookie só deve ser acessível via HTTP (opcional, padrão é true)
        $apenasHTTP = false;

        // Cria o cookie
        setcookie("credenciais", $valorCookie_user_pass, $dataExpiracao, $caminhoCookie, $dominioCookie, $cookieSeguro, $apenasHTTP);
    }
    http_response_code(200);
} else {
    // Enviar uma resposta de erro
    http_response_code($status_code);
}

?>