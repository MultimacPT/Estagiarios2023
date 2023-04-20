<!DOCTYPE html>
<html lang="pt-pt">
    <head>
        <meta charset="UTF-8">
        <title>Picagem</title>
    </head>
    <body>

        <input type="button" value="Picar">
        <!--POST-->
        <?php

            $curl = curl_init();

            curl_setopt_array($curl, [
            CURLOPT_URL => "https://mx.multimac.pt/mxv5/api/v1/Assiduidade?select=nomecompleto%2CcolaboradorId%2CcolaboradorName%2Centrada%2Csaida%2Ctipo%2CcreatedAt&maxSize=25&offset=0&orderBy=createdAt&order=desc",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n\t\t\t\"id\": \"64414c20d130d89e1\",\n\t\t\t\"createdAt\": \"2023-04-20 14:28:48\",\n\t\t\t\"tipo\": \"Férias\",\n\t\t\t\"entrada\": \"2023-04-20 09:00:00\",\n\t\t\t\"saida\": \"2023-04-20 13:00:00\",\n\t\t\t\"nomecompleto\": \"DIOGO ANDRÉ DA COSTA RIBEIRO CORREIA\",\n\t\t\t\"createdById\": \"63c6de7587dc85caf\",\n\t\t\t\"assignedUserId\": \"6262b8e6cf45ad8a6\",\n\t\t\t\"colaboradorId\": \"62b075e582d4e4ede\",\n\t\t\t\"colaboradorName\": \"Diogo Correia\"\n\t\t}",
            CURLOPT_HTTPHEADER => [
                "Accept: application/json, text/javascript, */*; q=0.01",
                "Accept-Encoding: gzip, deflate, br",
                "Accept-Language: pt-PT,pt;q=0.8,en;q=0.5,en-US;q=0.3",
                "Authorization: Basic YXJhcG9zZWlybzoxNjNmMTYyZGVmYWMzNjk2MWFjMTU4MTRlYjVmNDdmMQ==",
                "Connection: keep-alive",
                "Content-Type: application/json",
                "Cookie: auth-token-secret=e68a2e8e4dad6b2e52a48d89eadc697f; auth-username=araposeiro; auth-token=163f162defac36961ac15814eb5f47f1",
                "Espo-Authorization: YXJhcG9zZWlybzoxNjNmMTYyZGVmYWMzNjk2MWFjMTU4MTRlYjVmNDdmMQ==",
                "Espo-Authorization-By-Token: true",
                "Referer: https://mx.multimac.pt/mxv5/",
                "Sec-Fetch-Dest: empty",
                "Sec-Fetch-Mode: cors",
                "Sec-Fetch-Site: same-origin",
                "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/112.0",
                "X-Requested-With: XMLHttpRequest"
            ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
            echo "cURL Error #:" . $err;
            } else {
            echo $response;
            }
        ?>
    </body>
</html>