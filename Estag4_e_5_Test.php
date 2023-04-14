<!DOCTYPE html>
<html lang="pt-pt">
<head>
<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Entradas e saidas</title>
	<link rel="stylesheet" href="themes/tema.min.css" />
	<link rel="stylesheet" href="themes/jquery.mobile.icons.min.css" />
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css" />
	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>
	<div data-role="page" data-theme="a">
		<div data-role="header">
			<h1>Formulário de entradas e saidas</h1>
		</div>
		<div data-role="content" data-theme="a">
			<h1>Formulário</h1>
            <form method="post">
            <div class="ui-grid-a">
            <div class="ui-block-a">
            <label for="date">entrada:</label>
            <input type="date" name="inicio" id="inicio" value="">
            <label for="date">hora:</label>
            <input type="time" name="HoraInicio" id="HoraInicio" value="">
            </div>
            <div class="ui-block-b">
            <label for="date">saida:</label>
            <input type="date" name="saida" id="saida" value="">
            <label for="date">hora:</label>
            <input type="time" name="HoraSaida" id="HoraSaida" value="">
            </div>

            <label for="text-basic">tipo:</label>
            <input type="text" name="tipo" id="tipo" value="">
            <div class="ui-field-contain">
            <label for="select-native-1">Escolha uma pessoa:</label>
                    <select name="codigo" id="codigo">
                    <option value="">-- Escolha --</option>
                    <option value="6262b8e6cf45ad8a6">Diogo Correia</option>
                    <option value="64007be64067f6210">João Costa</option>
                    <option value="63f89d02792dc7c45">Pedro Carvalho</option>
                    <option value="63bbf8d572c41d87d">Duarte Barros</option>
                    <option value="643800af484d69b88">Artur Figueiredo</option>
                    <option value="643800fdd5d14c61a">Ricardo Fernandes</option>
                    <option value="6438015c2c13da4df">Andre Raposeiro</option>
                </select>
            </div>


            
                <input type="submit" value="Submeter">
            </form>
            <?php

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
                    
                    }
                }
                    
            
                    ?>

		<div data-role="footer" data-theme="a"> 
		<h4>Feito por: Ricardo Fernandes</h4> 
		</div> 
	</div>
</body>
</html>
