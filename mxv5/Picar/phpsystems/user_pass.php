<?php
session_start();


$user = $_POST['username'];
$password = $_POST['password'];

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

if ($status_code == 200) {
    // Enviar uma resposta de sucesso
    http_response_code(200);

} else {

    // Enviar uma resposta de erro
    http_response_code($status_code);

}

?>