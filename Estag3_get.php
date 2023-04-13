<?php



$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://mx.multimac.pt/mxv5/api/v1/Equipamentos?select=name%2CinstaladoMxtech%2Cip%2Cmodelo%2Cnumserie%2Cemailmxtech%2Cdatavenda%2CcreatedById%2CcreatedByName&maxSize=25&offset=0&orderBy=createdAt&order=desc",
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
  echo $response;

  
      $data = json_decode($response);
    foreach ($data->list as $equipamentos) {
      echo " <br>_______________________________<br><br> ID: " . $equipamentos->id . "<br>";
      echo "Nome: " . $equipamentos->name . "<br>";
      echo "Modelo: " . $equipamentos->modelo ;
    }


  
}




?>