<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link rel="stylesheet" href="themes/Hitto.min.css" />
	<link rel="stylesheet" href="themes/jquery.mobile.icons.min.css" />
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css" />
	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
    <script src="mainLogin.js"></script>
  </head>
  <body>
    <div data-role="page">
        <div data-role="header" data-theme="a" class="ui-header-fixed">
            <div style="text-align: center; margin: 0 auto;">
              <img src="logo_hitto.png"> 
            </div>
	    </div>

        <br>
        <br>
        <br>
        <br>

      <div data-role="content">
        <form action="User_pass.php" id="login-form" method="get" >
          <div data-role="fieldcontain">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username">
          </div>
          <div data-role="fieldcontain">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
          </div>
          <div data-role="fieldcontain">
            <input type="submit" value="Login">
          </div>
        </form>
      </div>
    </div>

  </body>
</html>