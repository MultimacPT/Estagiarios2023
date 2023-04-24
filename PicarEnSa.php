<?php

$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://mx.multimac.pt/mxv5/api/v1/Assiduidade?select=nomecompleto%2CcolaboradorId%2CcolaboradorName%2Centrada%2Csaida%2Ctipo%2CcreatedAt&maxSize=25&offset=0&orderBy=createdAt&order=desc",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_POSTFIELDS => "",
  CURLOPT_HTTPHEADER => [
    "Accept: application/json, text/javascript, */*; q=0.01",
    "Accept-Language: pt-PT,pt;q=0.9,en-US;q=0.8,en;q=0.7",
    "x-api-key: 4551D74F0502A6409445E49961896B49"
  ],
]);

curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {

  $id = "62b075e582d4e4ede";
  $registros_encontrados = false;
  $registros_dia = false;
  $Entrada ="";
  $Saida="";
  
  $data_atual = date('Y-m-d');

  $data = json_decode($response);
  foreach($data->list as $assiduidades) {
    if ($assiduidades->colaboradorId == $id/*colocar id utilizador*/) {
      // Converte a data e hora em um timestamp Unix
      $timestamp_entrada = strtotime($assiduidades->entrada);
      $timestamp_data_atual = strtotime($data_atual);
  
      // Verifica se a data do registro é igual à data atual
      if (date('Y-m-d', $timestamp_entrada) == $data_atual) {
        $Entrada = $assiduidades->entrada;
        $Saida= $assiduidades->saida;
        echo "Entrada: " . $Entrada . "<br>";
        echo "Saída: " . $Saida . "<br>";
        


        $registros_dia = true;
      }
      $registros_encontrados = true;

    }
    break;
  }

  if($Entrada == "0000-00-00 00:00:00"){
    echo "Entrada: " . $Entrada . "<br>";
    $Saida = "0000-00-00 00:00:00";
    //é entrada
  }
  else
  {
    echo "Saída: " . $Saida . "<br>";
    $Entrada = "0000-00-00 00:00:00";
    //é saida
  }
  
  // Verifica se foram encontrados registros e se algum foi feito no dia atual
  if ($registros_encontrados) {
    if (!$registros_dia) {
      echo "<br><br>Nenhum registro encontrado para o dia " . $data_atual;
      //é entrada
    }

  } else {
    echo "<br><br>Nenhum registro encontrado";
    //é entrada
  }
  

}

?>