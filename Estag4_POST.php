<!DOCTYPE html>
<head>
    <html lang="pt-pt">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Página</title>
	<link rel="stylesheet" href="themes/Simples.min.css" />
	<link rel="stylesheet" href="themes/jquery.mobile.icons.min.css" />
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css" />
	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>
	<div data-role="page" data-theme="a">
		<div data-role="header" data-position="inline">
			<h1>Formulário Básico</h1>
		</div>
		<div data-role="content" data-theme="a">
			<h1>Formulário</h1>
            <form method="post">
				<div class="ui-grid-b">
            		<div class="ui-block-a">
                        <label for="date">Data Inicio:</label>
					    <input type="date" name="dateinicio" id="dateinicio" value="">

                        <label for="date">Hora Inicio:</label>
					    <input type="time" name="timeinicio" id="timeinicio" value="">
            		</div>
           			<div class="ui-block-b">
                        <label for="date">Data Fim:</label>
					    <input type="date" name="datefim" id="datefim" value="">

                        <label for="date">Hora Fim:</label>
					    <input type="time" name="timefim" id="timefim" value="">
            		</div>

					<br>
            		<br>
					<br>
					<br>
                    <br>
                    <br>
                    <br>
                    <br>

					<label for="text-basic">Tipo:</label>
					<input type="text" name="tipo" id="tipo" value="">

                    <form>
                    <div class="ui-field-contain">
                        <br>
                        <select name="escolha" id="escolha">
                        <option value="">Escolha Pessoa</option>
                        <option value="6262b8e6cf45ad8a6">Diogo Correia</option>
                        <option value="63bbf8d572c41d87d">Duarte Barros</option>
                        <option value="64007be64067f6210">João Costa</option>
                        <option value="63f89d02792dc7c45">Pedro Carvalho</option>
                        </select>
                    </div>
                    </form>

					
                    <input type="submit" value="Submeter">
					

				</div>
			</form> 
             
            <?php

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $datainicio = $_POST["dateinicio"];
                    $datafim = $_POST["datefim"];
                    $horainicio = $_POST["timeinicio"];
                    $horafim = $_POST["timefim"];
                    $tipo = $_POST["tipo"];
                    $escolha = $_POST["escolha"];

                    // Obter a data atual
                    date_default_timezone_set('Europe/Lisbon');
                    $dataAtual = date('Y-m-d');

                    $curl = curl_init();

                    // Verificar se a data selecionada é anterior ao dia atual
                    if (strtotime($datainicio) < strtotime($dataAtual) || strtotime($datafim) < strtotime($dataAtual)) {
                        echo "<script>alert('Selecione uma data igual ou posterior ao dia atual.');</script>";
                        exit();
                    } else {
                        // Submeter o formulário
                        curl_setopt_array($curl, [
                            CURLOPT_URL => "https://mx.multimac.pt/mxv5/api/v1/Assiduidade?select=assignedUserId%2CassignedUserName%2Centrada%2Csaida%2Ctipo%2CcreatedAt&maxSize=25&offset=0&orderBy=createdAt&order=desc",
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 30,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "POST",
                            CURLOPT_POSTFIELDS => "{\n\t\t\t\"id\": \"\",\n\t\t\t\"createdAt\": \"$dataAtual\",\n\t\t\t\"tipo\": \"$tipo \",\n\t\t\t\"entrada\": \"$datainicio $horainicio\",\n\t\t\t\"saida\": \"$datafim $horafim\",\n\t\t\t\"createdById\": \"63c6de7587dc85caf\",\n\t\t\t\"assignedUserId\": \"$escolha\",\n\t\t\t\"assignedUserName\": \"\"\n\t\t}",
                            CURLOPT_HTTPHEADER => [
                                "Accept: application/json, text/javascript, */*; q=0.01",
                                "Accept-Encoding: gzip, deflate, br",
                                "Accept-Language: pt-PT,pt;q=0.8,en;q=0.5,en-US;q=0.3",
                                "Authorization: Basic YXJhcG9zZWlybzpkYjExOGI1MzA5Mzg0NTdkNzlhOTg4ZmYzOTBkZmM1YQ==",
                                "Connection: keep-alive",
                                "Content-Type: application/json",
                                "Cookie: auth-token-secret=bcb295083cb6f917d69ff63649078160; auth-username=araposeiro; auth-token=db118b530938457d79a988ff390dfc5a",
                                "Espo-Authorization: YXJhcG9zZWlybzpkYjExOGI1MzA5Mzg0NTdkNzlhOTg4ZmYzOTBkZmM1YQ==",
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

                        echo "<script>alert('Formulário submetido com sucesso.');</script>";

                        $response = curl_exec($curl);
                        $err = curl_error($curl);

                        curl_close($curl);

                        if ($err) {
                        echo "cURL Error #:" . $err;
                        } else {
                        echo $response;
                        }
                    }
                }
            ?>

        </div>
		<div data-role="footer" data-theme="a">
            <h4>André Raposeiro</h4>
		</div>
	</div>
</body>
</html>