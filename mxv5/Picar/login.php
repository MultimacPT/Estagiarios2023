<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link rel="stylesheet" href="themes/aa.min.css" />
	<link rel="stylesheet" href="themes/jquery.mobile.icons.min.css" />
	<link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css" />
	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
  <link rel="icon" href="images/logo.ico" type="images/favicon">
	<link rel="shortcut icon" href="images/logo.ico" type="images/favicon">
	<link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="javascript/login.js"></script>
  </head>
  <body>
    <div data-role="page" data-theme="a">
      <div data-role="header" data-theme="a" class="ui-header-fixed">
          <div style="text-align: center; margin: 0 auto;">
            <img src="images/logo-hito-3.png" alt="Hito">
          </div>
      </div>

      <br>
      <br>
      <br>
      <br>

      <?php
        session_start(); // inicia a sessão

        if (isset($_COOKIE['credenciais'])) {
          $valorDoCookie = $_COOKIE['credenciais'];
          // Faça algo com o valor do cookie

          $partes = explode(',', $valorDoCookie);
          $metadeuser = $partes[0];
          $metadepass = $partes[1];
          // Faça algo com as metades do cookie
          
        } else {
          // O cookie não está definido
          $metadeuser="";
          $metadepass="";
        }
        
			?>

      <div data-role="content">
        <form action="phpsystems/user_pass.php" id="login-form" method="get">
          <div data-role="fieldcontain">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" value="<?= $metadeuser ?>">
          </div>
          <div data-role="fieldcontain">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" value="<?= $metadepass ?>">
          </div>
          <div data-role="fieldcontain">
            <input type="checkbox" name="lembrar" id="remember">
            <label for="remember">Lembrar da minha sessão</label>
          </div>
          <div data-role="fieldcontain">
            <button type="submit" value="Login" style="background-color: black; color: white;">Login</button>
          </div>
        </form>
      </div>

    </div>
  </body>
</html>