<!DOCTYPE html>
<html>
<head>
  <title>Perfil</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
  <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
  <script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>

  <div data-role="page">
    <div data-role="header">
      <h1>Perfil</h1>
    </div>
    <?php include('PicarBuscaPerfil.php'); ?>

    <div data-role="content">
      <ul data-role="listview" data-inset="true">
        <li data-role="list-divider">Informações de Perfil</li>

        <li><h2>ID: <?php echo $id_user ?></h2></li>
        <li><h2>Empresa: Multimac</h2><p></p></li>
        <li><h2>Nome: <?php echo $name_user ?></h2></li>
        <li><h2>email: <?php echo $email_user ?></h2></li>
        <li><button type="button"><h2>Irregularidades</h2><p>Clique aqui para ver as suas irregularidades</p></button></li>
        <li><button type="button" value="Logout"><h2>Logout</h2><p>Clique aqui para sair</p></button></li>
      </ul>
    </div>

    <div data-role="footer">
      <h4>Multimac</h4>
    </div>
  </div>

</body>
</html>
