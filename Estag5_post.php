<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <title>Exercicio 02</title>
    <link rel="stylesheet" href="themes/exec1.min.css" />
    <link rel="stylesheet" href="themes/jquery.mobile.icons.min.css" />
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css" />
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>
  <div data-role="page" data-theme="a">
  <div data-role="header" data-position="inline" class="ui-bar ui-header" style="text-align: center">
   <header>
    <h1>Formulário do Artur 8D</h1>
   </header>
  </div> 

  <div data-role="main" class="ui-content">
    <br>
    <h1 style="text-align: center;">ASSIDUIDADE</h1>
    <br>
    <form id="form" method="post">
        <div class="ui-field-contain">
        <label for="select-native-1">PESSOA:</label>
                    <select name="codigo" id="codigo">
                    <option value="">-- = --</option>
                    <option value="643800af484d69b88">Artur</option>
                    <option value="6262b8e6cf45ad8a6">Diogo Correia</option>
                    <option value="64007be64067f6210">João Costa</option>
                    <option value="63f89d02792dc7c45">Pedro Carvalho</option>
                    <option value="63bbf8d572c41d87d">Duarte Barros</option>
                </select>
        </div>

        <div class="ui-field-contain">
            <label for="text-basic">TIPO:</label>
            <input type="text" name="tipo" id="tipo" value="">
        </div>

        <div class="ui-field-contain">
            <label for="date">ENTRADA:</label>
            <input type="date" name="inicio" id="inicio" value="">
            <label for="date">HORA:</label>
            <input type="time" name="HoraInicio" id="HoraInicio" value="">
        </div>
        
        <div class="ui-field-contain">
            <label for="date">SAIDA:</label>
            <input type="date" name="saida" id="saida" value="">
            <label for="date">HORA:</label>
            <input type="time" name="HoraSaida" id="HoraSaida" value="">
        </div>
        
        <input href="Estag_1.php" data-transition="flow" type="submit" value="Submeter">
    </form>

    <?php
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $codigo = $_POST["codigo"];
                    $tipo = $_POST["tipo"];
                    $dataInicio = $_POST["inicio"];
                    $horaInicio = $_POST["HoraInicio"];
                    $dataSaida = $_POST["saida"];
                    $horaSaida = $_POST["HoraSaida"];

                    date_default_timezone_set('Europe/Lisbon');
                    $dataAtual = date('Y-m-d H:i:s');

                    $curl = curl_init();

                    curl_setopt_array($curl, [
                        CURLOPT_URL => "https://mx.multimac.pt/mxv5/api/v1/Assiduidade",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => "{\n\t\t\t\"id\": \"\",\n\t\t\t\"createdAt\": \"$dataAtual\",\n\t\t\t\"tipo\": \" $tipo \",\n\t\t\t\"entrada\": \" $dataInicio $horaInicio\",\n\t\t\t\"saida\": \"$dataSaida $horaSaida\",\n\t\t\t\"createdById\": \" \",\n\t\t\t\"assignedUserId\": \"$codigo\",\n\t\t\t\"assignedUserName\": \" \"\n\t\t}",
                        CURLOPT_HTTPHEADER => [
                            "Content-Type: application/json",
                            "x-api-key: 4551D74F0502A6409445E49961896B49"
                        ],
                        CURLOPT_SSL_VERIFYPEER => false
                    ]);

                    $response = curl_exec($curl);
                    $err = curl_error($curl);

                    curl_close($curl);

                    if ($err) {
                        echo "cURL Error #:" . $err;
                    } else {
                        echo $response;
                    }

                }?>
  </div>

  <div data-role="page" data-theme="a"></div>
  <div data-role="footer" data-position="inline">
    <footer>
      <p>Author: Artur Figueiredo</p>
    </footer>
  </div>
</body>
</html>
