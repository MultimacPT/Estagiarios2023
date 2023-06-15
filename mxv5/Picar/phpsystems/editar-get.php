<?php

session_start();

$user = $_SESSION['username'];
$password = $_SESSION['password'];

$id_guia = $_GET['id'];

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "http://192.168.30.31/mxv5/api/v1/Guiastransporte?select=name,createdById,createdByName,createdAt,codigoat,numeroguia,copiabr,copiacor&maxSize=25&offset=0&orderBy=createdAt&order=desc",
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

    $data = json_decode($response);
    foreach ($data->list as $guias) {

        if ($guias->id == $id_guia) {

            echo "<div data-role='content' class='ui-content' role='main'>";
            echo "<ul data-role='listview' data-inset='true' class='ui-listview ui-listview-inset ui-corner-all ui-shadow'>";
            echo "<li class='ui-li-static ui-body-inherit'>";

            echo "<div class='ui-grid-solo'>";

            echo "<div class='ui-block-a'>";
            echo "<h2>Nome:</h2><input id='nomeGuia' type='text' value='" . $guias->name . "' readonly size='" . strlen($guias->name) . "'>";
            echo "</div>";

            echo "<div class='ui-block-a'>";
            echo "<h2>Código AT:</h2><input id='codigoAT' type='text' value='" . $guias->codigoat . "' readonly size='" . strlen($guias->codigoat) . "'>";
            echo "</div>";

            echo "<div class='ui-block-a'>";
            echo "<h2>Número Guia:</h2><input id='numeroGuia' type='text' value='" . $guias->numeroguia . "' readonly size='" . strlen($guias->numeroguia) . "'>";
            echo "</div>";

            echo "<div class='ui-block-a'>";
            echo "<h2>Cópia BR:</h2><input id='copiaBr' type='text' value='" . $guias->copiabr . "' readonly size='" . strlen($guias->copiabr) . "'>";
            echo "</div>";

            echo "<div class='ui-block-a'>";
            echo "<h2>Cópia Cor:</h2><input id='copiaCor' type='text' value='" . $guias->copiacor . "' readonly size='" . strlen($guias->copiacor) . "'>";
            echo "</div>";

            echo "</div>";
            echo "</li>";
            echo "</ul>";
            echo "</div>";

            
        }

    }
}
?>