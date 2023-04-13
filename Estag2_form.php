<!DOCTYPE html>
<html lang="pt-pt">
<head>
<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>jQuery Mobile</title>
	<link rel="stylesheet" href="themes/tema.min.css" />
	<link rel="stylesheet" href="themes/jquery.mobile.icons.min.css" />
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css" />
	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>
	<div data-role="page" data-theme="a">
		<div data-role="header">
			<h1>Formulário Básico</h1>
		</div>
		<div data-role="content" data-theme="a">
			<h1>Formulário</h1>
            <form>
            <div class="ui-grid-a">
            <div class="ui-block-a">
                <label for="text-basic">Primeiro nome:</label>
                <input type="text" name="text-basic" id="text-basic" value="">
            </div>
            <div class="ui-block-b">
                <label for="text-basic">Ultimo nome:</label>
                <input type="text" name="text-basic" id="text-basic" value="">
            </div>

            <label for="text-basic">Email:</label>
            <input type="text" name="text-basic" id="text-basic" value="">

            <label for="textarea">Descrição:</label>
            <textarea cols="40" rows="8" name="textarea" id="textarea"></textarea>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" value="" autocomplete="off">

            <label for="date">Data:</label>
            <input type="date" name="date" id="date" value="">

            <fieldset data-role="controlgroup">
            <legend>Escolha as linguagens:</legend>
            <input type="checkbox" name="checkbox-1a" id="checkbox-1a">
            <label for="checkbox-1a">Javascript</label>
            <input type="checkbox" name="checkbox-2a" id="checkbox-2a">
            <label for="checkbox-2a">PHP</label>
            <input type="checkbox" name="checkbox-3a" id="checkbox-3a">
            <label for="checkbox-3a">C</label>
            <input type="checkbox" name="checkbox-4a" id="checkbox-4a">
            <label for="checkbox-4a">C#</label>
        </fieldset>
            <input type="submit" value="Submeter">
            <a href="Estag_1.php" data-transition="pop" class="ui-btn ui-corner-all ui-shadow">Próxima pagina</a>
            </form>
		</div>

		<div data-role="footer" data-theme="a"> 
		<h4>Feito por: Ricardo Fernandes</h4> 
		</div> 
	</div>
</body>
</html>