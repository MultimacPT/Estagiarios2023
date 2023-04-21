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
			<h1>Entradas e saidas</h1>
		</div>
		<div data-role="content" data-theme="a">

			<?php

			include('PicarGetTotal.php');
			?>
            

		<div data-role="footer" data-theme="a"> 
		<h4>Multimac</h4> 
		</div> 
	</div>
</body>
</html>