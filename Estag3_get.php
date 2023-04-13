<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://mx.multimac.pt/mxv5/api/v1/Equipamentos?select=name%252CinstaladoMxtech%252Cip%252Cmodelo%252Cnumserie%252Cemailmxtech%252Cdatavenda%252CcreatedById%252CcreatedByName&maxSize=25&offset=0&orderBy=createdAt&order=desc',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json, text/javascript, */*; q=0.01',
    'Accept-Language: pt-PT,pt;q=0.9,en-US;q=0.8,en;q=0.7',
    'x-api-key: 4551D74F0502A6409445E49961896B49'
  ),
  CURLOPT_SSL_VERIFYPEER => false
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

$data = json_decode($response);
    foreach ($data->list as $equipamentos) {
      echo " <br>_______________________________<br> ID: " . $equipamentos->id . "<br>";
      echo "Nome: " . $equipamentos->name . "<br>";
      echo "Modelo: " . $equipamentos->modelo . "<br>_______________________________<br>";
    }