<?php
session_start();

	$user = $_SESSION['username'];
	$password = $_SESSION['password'];

	$curl = curl_init();


	$id = $_POST["idGuia"];
    $nomeGuia = $_POST["nomeGuia"];
    $codigoAT = $_POST["codigoAT"];
    $numeroGuia = $_POST["numeroGuia"];
    $copiaBr = $_POST["copiaBr"];
    $copiaCor = $_POST["copiaCor"];
	$feito = $_POST["feito"];

    //$id = '64809924ccb86b5ab';
    //$nomeGuia = 'teste de nome';
    //$codigoAT = 'codigoat';
    //$numeroGuia = '1234554';
    //$copiaBr = '500';
    //$copiaCor = '600';



	curl_setopt_array($curl, [
		CURLOPT_URL => "http://192.168.30.31/mxv5/api/v1/Guiastransporte/$id?select=name%2CcreatedById%2CcreatedByName%2CcreatedAt%2Ccodigoat%2Cnumeroguia%2Cfeito%2Ccopiabr%2Ccopiacor&offset=0&orderBy=createdAt&order=desc",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "PUT",
		CURLOPT_POSTFIELDS => "{\n\"name\": \"$nomeGuia\",\n\"codigoat\": \"$codigoAT\",\n\"numeroguia\": $numeroGuia,\n\"copiabr\": $copiaBr,\n\"copiacor\": $copiaCor,\n\"feito\": $feito\n}",
		CURLOPT_HTTPHEADER => [
			'Authorization: Basic ' . base64_encode($user . ':' . $password),
			"Content-Type: application/json"
		],
	]);

	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
        exit;
	}
?>