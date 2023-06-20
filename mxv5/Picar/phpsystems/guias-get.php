<?php

session_start();

$user = $_SESSION['username'];
$password = $_SESSION['password'];


$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "http://192.168.30.31/mxv5/api/v1/Guiastransporte?select=name%2CcreatedById%2CcreatedByName%2CcreatedAt%2Ccodigoat%2Cnumeroguia%2Cfeito%2Ccopiabr%2Ccopiacor&offset=0&orderBy=createdAt&order=desc",
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
    //$registros_dia = false;

    date_default_timezone_set('Europe/Lisbon');
    $data_atual = date('Y-m-d');


    $data = json_decode($response);
    foreach ($data->list as $guias) {

        $datetime = new DateTime($guias->createdAt);

        $datetime->modify('+1 hour');

        $novaData = $datetime->format('Y-m-d');


        // Verifica se a data do registro é igual à data atual
        if ($guias->feito == false) {

            $datetime = new DateTime($guias->createdAt);

            $datetime->modify('+1 hour');

            $novaDataHora = $datetime->format('Y-m-d H:i:s');

            echo "<div data-role='content' class='ui-content' role='main'>";
            echo "<ul data-role='listview' data-inset='true' class='ui-listview ui-listview-inset ui-corner-all ui-shadow'>";

            echo "<li class='ui-li-static ui-body-inherit' style='display: flex;'>";
            echo "<div style='width: 50%;'>";
            echo "<div style='border-right: 1px solid #000000; padding-right: 10px;'>";
            echo "<h2>Nome:</h2><h2>" . $guias->name . "</h2>";
            echo "</div>";
            echo "</div>";
            echo "<div style='width: 50%; padding-left: 10px;'>";
            echo "<h2>Criada em:</h2><h2>" . $novaDataHora . "</h2>";
            echo "</div>";

            echo "<a href='#' onclick='redirectToEditar(\"" . $guias->id . "\")'>";
            echo '<button style="background-color: black; color: white; display: block; margin: 0 auto; text-align: center; width: 45px; height: 65px; font-size: 13px;"> VER </button>';
            echo '</a>';                       
            echo "</li>";
            echo "</ul>";
            echo "</div>";
            $registros_encontrados = true;
        }
        
    }

    // Verifica se foram encontrados registros e se algum foi feito no dia atual
    if (!$registros_encontrados) {
        
        echo "<br><br>Nenhuma Guia de transporte encontrada";


    }
}
?>