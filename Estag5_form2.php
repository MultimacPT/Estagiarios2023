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
            <form action="Estag4_post.php" method="post">
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
		</div>

		<div data-role="footer" data-theme="a"> 
		<h4>Feito por: Ricardo Fernandes</h4> 
		</div> 
	</div>
</body>
</html>