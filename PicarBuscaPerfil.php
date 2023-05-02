
<?php

$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://mx.multimac.pt/mxv5/api/v1/User?select=salutationName%2CfirstName%2ClastName%2CmiddleName%2Cname%2CuserName%2CemailAddressIsOptedOut%2CemailAddress%2CemailAddressData&offset=0&orderBy=userName&order=asc&where%5B0%5D%5Btype%5D=primary&where%5B0%5D%5Bvalue%5D=active",
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

    $id = "6262b8e6cf45ad8a6";
    
  
    $data = json_decode($response);
    foreach ($data->list as $user) {
        if ($user->id == $id/*colocar id utilizador*/) {

          $id_user = $user->id;
          $name_user = $user->name;
          $email_user = $user->emailAddress;

        }
    
    }
    
}



