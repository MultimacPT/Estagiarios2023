<?php
session_start();

$user = $_SESSION['username'];
$password = $_SESSION['password'];

$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://mx.multimac.pt/mxv5/api/v1/Assiduidade?select=createdById%2CcreatedByName%2CcreatedAt%2Ctipo&maxSize=10&offset=0&orderBy=createdAt&order=desc",
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

  date_default_timezone_set('Europe/Lisbon');
  $data_atual = date('Y-m-d');

  $data = json_decode($response);
  foreach ($data->list as $assiduidades) {

    $datetime = new DateTime($assiduidades->createdAt);

    $datetime->modify('+1 hour');

    $novaData = $datetime->format('Y-m-d');

    // Verifica se a data do registro é igual à data atual
    if ($novaData == $data_atual) {

      $datetime = new DateTime($assiduidades->createdAt);

      $datetime->modify('+1 hour');

      $novaDataHora = $datetime->format('Y-m-d H:i:s');
      
      echo "<div data-role='content' class='ui-content' role='main'>";
      echo  "<ul data-role='listview' data-inset='true' class='ui-listview ui-listview-inset ui-corner-all ui-shadow'>";

      if($assiduidades->tipo === " Entrada"){
        echo    "<li data-role='list-divider' role='heading' class='ui-li-divider ui-bar-inherit ui-first-child'><img src='images/green-button.png' alt='btn' style='width: 13px; height: 13px;'>" . $assiduidades->tipo . "</li>";
      }

      if($assiduidades->tipo === null){
        echo    "<li data-role='list-divider' role='heading' class='ui-li-divider ui-bar-inherit ui-first-child'>Registo vesão antiga </li>";
      }

      if($assiduidades->tipo === " Saida"){
        echo    "<li data-role='list-divider' role='heading' class='ui-li-divider ui-bar-inherit ui-first-child'><img src='images/red-button.png' alt='btn' style='width: 13px; height: 13px;'>" . $assiduidades->tipo . "</li>";
      }
      echo    "<li class='ui-li-static ui-body-inherit' style='display: flex;'>";
      echo      "<div style='width: 50%;'>";
      echo        "<div style='border-right: 1px solid #000000; padding-right: 10px;'>";
      echo          "<h2>Nome:</h2><h2>" . $assiduidades->createdByName . "</h2>";
      echo        "</div>";
      echo      "</div>";
      echo      "<div style='width: 50%; padding-left: 10px;'>";
      echo        "<h2>Picagem:</h2><h2>" . $novaDataHora . "</h2>";
      echo      "</div>";
      echo    "</li>";
      echo  "</ul>";
      echo "</div>";
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