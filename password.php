<?php
require ("x_session.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>FM20 - Cambio Password</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link href="https://fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/skeleton.css">
  <link rel="stylesheet" href="css/nuova_spesa.css">

  
  <!-- Javascript
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script-->
  <script src="js/password.js"></script>
                                   
  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="images/favicon.png">

</head>
<body>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <div class="container">
    <div class="row">
      <div style="margin-top: 10%">
        <p>Login come: <?echo $x_nu;?></p></div>
    </div>
    
    <form action="x_password.php" method="POST">
    
      <div class="row">
        <div class="eight columns">
              <label for="password">Vecchia Password</label>
              <input type="password" id="vpassword" name="vpassword" required>
        </div>
      </div>
      
      <div class="row">
        <div class="eight columns">
              <label for="npassword">Nuova Password</label>
              <input type="password" id="npassword" name="npassword" required>
        </div>
      </div>
      
      <div class="row">
        <div class="eight columns">
              <label for="rnpassword">Ripeti Nuova Password</label>
              <input type="password" id="rnpassword" name="rnpassword" oninput="conti();" required>
        </div>
      </div>
      
      <div id="controllo"></div>
      
       <div class="row">
        <div class="four columns">
              <br />
              <input type="submit" id="bottone" value="Salva">
              <br />
              Le password vengono criptate e salvate nel nostro database.
        </div>
      </div>
      
      
    </form>
  </div>
    

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
