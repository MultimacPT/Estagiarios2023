<?php
session_start();


$user = $_SESSION['username'];
$password = $_SESSION['password'];

$url = 'https://mx.multimac.pt/mxv5/api/v1/Notification/action/notReadCount';
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


$num_notificacoes = json_decode($response);
  
header('Content-Type: application/json');
echo json_encode($response);


?>