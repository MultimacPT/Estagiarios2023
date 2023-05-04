<?php
session_start();

$user = $_SESSION['username'];
$password = $_SESSION['password'];

$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://mx.multimac.pt/mxv5/api/v1/Assiduidade?select=createdById%2CcreatedByName%2CcreatedAt&maxSize=10&offset=0&orderBy=createdAt&order=desc",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_POSTFIELDS => "",
  CURLOPT_HTTPHEADER => array(
    'Authorization: Basic ' . base64_encode($user . ':' . $password),
    'Accept: application/json, text/javascript, */*; q=0.01',
    'Accept-Language: pt-PT,pt;q=0.9,en-US;q=0.8,en;q=0.7'
  ),
]);

curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {

  $registros_encontrados = false;
  $registros_dia = false;
  
  $data_atual = date('Y-m-d');

  $data = json_decode($response);
  foreach ($data->list as $assiduidades) {

    $timestamp_data = strtotime($assiduidades->createdAt);
    $timestamp_data_atual = strtotime($data_atual);

    // Verifica se a data do registro é igual à data atual
    if (date('Y-m-d', $timestamp_data) == $data_atual) {
      echo " <br>_______________________________<br><br>";
      echo "Nome: " . $assiduidades->createdByName . "<br>";
      echo "Picagem: " . $assiduidades->createdAt;
      $registros_dia = true;
    }
    $registros_encontrados = true;
  }
  
  // Verifica se foram encontrados registros e se algum foi feito no dia atual
  if ($registros_encontrados) {
    if (!$registros_dia) {
      echo "<br><br>Nenhum registro encontrado para o dia " . $data_atual;
    }

  } else {
    echo "<br><br>Nenhum registro encontrado";
  }
  

}

?>