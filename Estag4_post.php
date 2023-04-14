

<?php

$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://mx.multimac.pt/mxv5/api/v1/Assiduidade",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\n\t\t\t\"id\": \"64395e29ae8a48734\",\n\t\t\t\"createdAt\": \"2023-04-14 14:07:37\",\n\t\t\t\"tipo\": \"Queimaram minha papelada\",\n\t\t\t\"entrada\": \"2023-04-13 00:00:00\",\n\t\t\t\"saida\": \"2023-04-14 00:00:00\",\n\t\t\t\"createdById\": \"6438015c2c13da4df\",\n\t\t\t\"assignedUserId\": \"4\",\n\t\t\t\"assignedUserName\": \"\"\n\t\t}",
  CURLOPT_HTTPHEADER => [
    "Content-Type: application/json",
    "x-api-key: 4551D74F0502A6409445E49961896B49"
  ],
  CURLOPT_SSL_VERIFYPEER => false
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}