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
            <form>
				<div class="ui-grid-b">
            		<div class="ui-block-a">
                		<label for="text-basic">Primeiro nome:</label>
                		<input type="text" name="text-basic" id="text-basic" value="">
            		</div>
           			<div class="ui-block-b">
                		<label for="text-basic">Ultimo nome:</label>
                		<input type="text" name="text-basic" id="text-basic" value="">
            		</div>

					<br>
            		<br>
					<br>
					<br>

					<label for="text-basic">Email:</label>
					<input type="text" name="text-basic" id="text-basic" value="">

					<label for="textarea">Descrição:</label>
					<textarea cols="40" rows="8" name="textarea" id="textarea"></textarea>

					<label for="password">Password:</label>
					<input type="password" name="password" id="password" value="" autocomplete="off">

					<label for="date">Data:</label>
					<input type="date" name="date" id="date" value="">

					<fieldset data-role="controlgroup">
						<legend>Linguagens de Proramação:</legend>
						<input type="radio" name="radio-choice-1" id="radio-choice-1" value="choice-1">
						<label for="radio-choice-1">Javasript</label>
						<input type="radio" name="radio-choice-1" id="radio-choice-2" value="choice-2">
						<label for="radio-choice-2">PHP</label>
						<input type="radio" name="radio-choice-1" id="radio-choice-3" value="choice-3">
						<label for="radio-choice-3">CSS</label>
						<input type="radio" name="radio-choice-1" id="radio-choice-4" value="choice-4">
						<label for="radio-choice-4">HTML</label>
					</fieldset>

					<a href="Estag2_form.php" data-transition="flip" class="ui-btn ui-corner-all ui-shadow ui-btn-inline">
						Submeter
					</a>

				</div>
			</form>  
        </div>
		<div data-role="footer" data-theme="a">
            <h4>André Raposeiro</h4>
		</div>
	</div>
</body>
</html>