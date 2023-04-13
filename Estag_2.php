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
    <h1 style="text-align: center;">Formulário</h1>
    <br>
    <form id="form">
        <div class="ui-field-contain">
            <label for="primeiro-nome">Primeiro Nome:</label>
            <input type="text" name="primeiro-nome" id="primeiro-nome">
        </div>

        <div class="ui-field-contain">
            <label for="ultimo-nome">Último Nome:</label>
            <input type="text" name="ultimo-nome" id="ultimo-nome">
        </div>

        <div class="ui-field-contain">
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email">
        </div>

        <div class="ui-field-contain">
            <label for="textarea">Descrição:</label>
            <textarea name="descricao" id="descricao"></textarea>
        </div>
        
        <div class="ui-field-contain">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
        </div>

        <div class="ui-field-contain">
            <label for="data-role">Data:</label>
            <input type="date" name="data" id="data">
        </div>
        
        <div class="ui-field-contain">
            <fieldset data-role="controlgroup">
                <legend>Linguagens de Programação:</legend>
                <input type="checkbox" name="linguagem[]" id="linguagem1" value="javascript">
                <label for="linguagem1">JavaScript</label>
                <input type="checkbox" name="linguagem[]" id="linguagem2" value="csharp">
                <label for="linguagem2">C#</label>
                <input type="checkbox" name="linguagem[]" id="linguagem3" value="kotlin">
                <label for="linguagem3">Kotlin</label>
                <input type="checkbox" name="linguagem[]" id="linguagem4" value="python">
                <label for="linguagem4">Python</label>
            </fieldset>
        </div>
        <input href="Estag_1.php" data-transition="flow" type="submit" value="Submeter">
    </form>
    <div data-role="main" class="ui-content">
        <a href="Estag_1.php" data-role="button" data-transition="flow">VOLTAR PARA O INICIO</a>
    </div>
  </div>

  <div data-role="page" data-theme="a"></div>
  <div data-role="footer" data-position="inline">
    <footer>
      <p>Author: Artur Figueiredo</p>
    </footer>
  </div>

   

</body>
</html>