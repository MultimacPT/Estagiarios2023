<?php
session_start();

$user = $_SESSION['username'];
$password = $_SESSION['password'];
$nome = $_SESSION['name'];

$entrada_saida = '';

$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://mx.multimac.pt/mxv5/api/v1/Assiduidade?select=createdById%2CcreatedByName%2CcreatedAt&offset=0&orderBy=createdAt&order=desc",
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

  $num_registros = 0;

  $data_atual = date('Y-m-d');
  
  $data = json_decode($response);
  
  foreach ($data->list as $assiduidades) {
  
    $timestamp_data = strtotime($assiduidades->createdAt);
    $data_registro = date('Y-m-d', $timestamp_data);
  
    // Verifica se a data do registro é igual à data atual
    if ($data_registro == $data_atual) {

      if($assiduidades->createdByName == $nome){
        $num_registros++;
      }

    }
  
  }
  
  if ($num_registros % 2 == 0) {
    
    $entrada_saida = 'Entrada';


  } else {
    $entrada_saida = 'Saida';
  }

}

  

  $localiza = $_POST['localizacao'];



  $curl = curl_init();
  
  curl_setopt_array($curl, [
    CURLOPT_URL => "https://mx.multimac.pt/mxv5/api/v1/Assiduidade?select=createdById%2CcreatedByName%2CcreatedAt&maxSize=25&offset=0&orderBy=createdAt&order=desc",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "\t\t{\n\t\t\t\"id\": \"\",\n\t\t\t\"createdAt\": \"\",\n\t\t\t\"createdById\": \"\",\n\t\t\t\"createdByName\": \"\",\n\t\t\t\"assignedUserId\": \" \",\n\t\t\n\t\t\t\"localizacao\": \" $localiza\",\n\t\t\n\t\t\t\"tipo\": \" $entrada_saida\"}",
    CURLOPT_HTTPHEADER =>  array(
      'Authorization: Basic ' . base64_encode($user . ':' . $password),
      'Accept: application/json, text/javascript, */*; q=0.01',
      'Accept-Language: pt-PT,pt;q=0.9,en-US;q=0.8,en;q=0.7',
      "Content-Type: application/json"
    ),
  ]);

  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

  $response = curl_exec($curl);
  $err = curl_error($curl);
  
  curl_close($curl);
  
  if ($err) {

    echo "cURL Error #:" . $err;

  } else {

    exit;
  }  
      
?>
