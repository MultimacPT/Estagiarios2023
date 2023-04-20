<!DOCTYPE html>
<html lang="pt-pt">
    <head>
        <meta charset="UTF-8">
        <title>Picagem</title>
    </head>
    <body>

        <!--GET-->
        <?php
            
            $curl = curl_init();

            curl_setopt_array($curl, [
            CURLOPT_URL => "https://mx.multimac.pt/mxv5/api/v1/Assiduidade?select=nomecompleto%2CcolaboradorId%2CcolaboradorName%2Centrada%2Csaida%2Ctipo%2CcreatedAt&maxSize=25&offset=0&orderBy=createdAt&order=desc",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => [
                "Accept: application/json, text/javascript, */*; q=0.01",
                "Accept-Encoding: gzip, deflate, br",
                "Accept-Language: pt-PT,pt;q=0.8,en;q=0.5,en-US;q=0.3",
                "Authorization: Basic YXJhcG9zZWlybzoxNjNmMTYyZGVmYWMzNjk2MWFjMTU4MTRlYjVmNDdmMQ==",
                "Connection: keep-alive",
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
            CURLOPT_SSL_VERIFYPEER => false,
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