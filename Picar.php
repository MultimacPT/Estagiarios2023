<?php

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      

      //$codigo = $_POST["codigo"];

      $horaTarde = '12:00:00';

      date_default_timezone_set('Europe/Lisbon');
      $dataAtual = date('Y-m-d');
      $horaAtual = date('H:i:s');

          // Validação da data de entrada
      if ($horaAtual > $horaTarde) {
          $tipo = "Tarde";

      }
      else{
          $tipo = "Manhã";

      }


      $curl = curl_init();
      
      curl_setopt_array($curl, [
        CURLOPT_URL => "https://mx.multimac.pt/mxv5/api/v1/Assiduidade?select=nomecompleto%2CcolaboradorId%2CcolaboradorName%2Centrada%2Csaida%2Ctipo%2CcreatedAt&maxSize=25&offset=0&orderBy=createdAt&order=desc",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "\t\t{\n\t\t\t\"id\": \"64414c20d130d89e1\",\n\t\t\t\"createdAt\": \"$dataAtual $horaAtual\",\n\t\t\t\"tipo\": \"$tipo\",\n\t\t\t\"entrada\": \"$dataAtual $horaAtual\",\n\t\t\t\"saida\": \"$dataAtual $horaAtual\",\n\t\t\t\"nomecompleto\": \"DIOGO ANDRÉ DA COSTA RIBEIRO CORREIA\",\n\t\t\t\"createdById\": \"63c6de7587dc85caf\",\n\t\t\t\"assignedUserId\": \"6262b8e6cf45ad8a6\",\n\t\t\t\"colaboradorId\": \"62b075e582d4e4ede\",\n\t\t\t\"colaboradorName\": \"Diogo Correia\"\n\t\t}",
        CURLOPT_HTTPHEADER => [
          "Accept: application/json, text/javascript, */*; q=0.01",
          "Accept-Language: pt-PT,pt;q=0.9,en-US;q=0.8,en;q=0.7",
          "Content-Type: application/json",
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
        header('Location: Picarform.php');
      }
  }   
            

?>
