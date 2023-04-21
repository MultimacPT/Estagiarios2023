<?php

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      

      // Faz uma solicitação HTTP para o servidor de tempo do Observatório Astronómico de Lisboa
      $contents = file_get_contents('http://einstein.oal.ul.pt/cgi-bin/v/time');

      // Extrai a data e hora da resposta do servidor
      preg_match('/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/', $contents, $matches);
      $date = $matches[0];

      // Converte a data e hora para o fuso horário desejado
      $timezone = new DateTimeZone('Europe/Lisbon');
      $datetime = new DateTime($date, $timezone);
      $datetime->setTimezone(new DateTimeZone('UTC'));
      $DataHora = $datetime->format('Y-m-d H:i:s');
      $Hora = $datetime->format('H:i:s');


      $horaTarde = "12:30:00";

      // Validação da data de entrada
      if ($Hora > $horaTarde) {
        $tipo = "Tarde";
        
      } else {
        $tipo = "Manhã";
      }

      $id = "62b075e582d4e4ede";


      $curl = curl_init();
      
      curl_setopt_array($curl, [
        CURLOPT_URL => "https://mx.multimac.pt/mxv5/api/v1/Assiduidade?select=nomecompleto%2CcolaboradorId%2CcolaboradorName%2Centrada%2Csaida%2Ctipo%2CcreatedAt&maxSize=25&offset=0&orderBy=createdAt&order=desc",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "\t\t{\n\t\t\t\"id\": \"\",\n\t\t\t\"createdAt\": \" \",\n\t\t\t\"tipo\": \"$tipo\",\n\t\t\t\"entrada\": \"$DataHora\",\n\t\t\t\"saida\": \"$DataHora\",\n\t\t\t\"nomecompleto\": \"DIOGO ANDRÉ DA COSTA RIBEIRO CORREIA\",\n\t\t\t\"createdById\": \"63c6de7587dc85caf\",\n\t\t\t\"assignedUserId\": \"6262b8e6cf45ad8a6\",\n\t\t\t\"colaboradorId\": \"$id\",\n\t\t\t\"colaboradorName\": \"\"\n\t\t}",
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
