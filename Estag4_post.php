
<?php

    $dataInicio = $_POST["inicio"];
    $dataSaida = $_POST["saida"];
    $horaInicio = $_POST["HoraInicio"];
    $horaSaida = $_POST["HoraSaida"];
    $tipo = $_POST["tipo"];
    $codigo = $_POST["codigo"];

    date_default_timezone_set('Europe/Lisbon');
    $dataAtual = date('Y-m-d H:i:s');
    



    $curl = curl_init();

    curl_setopt_array($curl, [
    CURLOPT_URL => "https://mx.multimac.pt/mxv5/api/v1/Assiduidade?select=assignedUserId%2CassignedUserName%2Centrada%2Csaida%2Ctipo%2CcreatedAt&maxSize=25&offset=0&orderBy=createdAt&order=desc",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\n\t\t\t\"id\": \"\",\n\t\t\t\"createdAt\": \"$dataAtual\",\n\t\t\t\"tipo\": \" $tipo \",\n\t\t\t\"entrada\": \" $dataInicio $horaInicio\",\n\t\t\t\"saida\": \"$dataSaida $horaSaida\",\n\t\t\t\"createdById\": \" \",\n\t\t\t\"assignedUserId\": \"$codigo\",\n\t\t\t\"assignedUserName\": \" \"\n\t\t}",
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
    //echo '<script>window.location.href = "Estag5_form2.php";</script>';
    
    }

    ?>




