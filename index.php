<?php
require ("x_session.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>FM20</title>
  <meta name="author" content="Lucas Falardi">

  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="apple-touch-icon" href="images/icon.png">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-title" content="GE19">

  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link href="https://fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/skeleton.css">
  <link rel="stylesheet" href="css/index.css">
  
  <!-- Javascript
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script-->
  <!--script src="js/index.php"></script-->
                                   
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
        <h2>Giretto in Europa 2019</h2>
        <p>Login come: <?echo $x_nu;?></p></div>
    </div>
     <!--div id="chart_div"></div-->
    <div class="row">
         <table class='u-full-width'>
            <thead>
              <tr>
                <th>Nome</th>
                <th>Bilancio</th>
              </tr>
            </thead>
            <tbody>
             <?php  
              require("db_config.php");
              $mysqli = new mysqli($host, $username, $password, $database);
              if ($mysqli->connect_errno) {
              	printf("Connect failed: %s\n", $mysqli->connect_error);
              	exit();
              }
              
              $tutti = array();
              $sql = "SELECT * FROM utenti";
              $result = $mysqli->query($sql);
              if ($result->num_rows > 0) {
                while($riga = $result->fetch_assoc()) {
                  $nome = $riga['nome'];
                  $sql_2 = "SELECT * FROM soldi WHERE id_utente = ".$riga['id_utenti'];
                  $result_2 = $mysqli->query($sql_2);
                  if ($result_2->num_rows > 0) {
                    $debito_chf  = 0;
                    $credito_chf = 0;
                    $bilancio = 0;
                    while($riga_2 = $result_2->fetch_assoc()) {  
                      $debito_chf = $debito_chf + $riga_2['debito_chf'];
                      $credito_chf = $credito_chf + $riga_2['credito_chf'];
                    } 
                  }
                  $bilancio = $credito_chf - $debito_chf;
				  $tutti[$nome]=$bilancio;}
              } else {
              echo "ERRORE!";
              }
              asort($tutti);
              foreach($tutti as $nome => $bilancio) {
                  if ($bilancio < 0) {$stile = "bilancio red";} else {$stile = "bilancio";}$bilancio=round($bilancio,2);echo "<tr><td>$nome</td><td class='$stile'>$bilancio CHF</td></tr>";}
              ?> 
            </tbody>
          </table>

        <a class="button" href="spese.php">Dettagli spese</a>
    </div>
    <div class="row" style="margin-top: 5%">
        <h5>Gestione spese</h5>
        <a class="button button-primary" href="nuova_spesa.php">Inserisci spesa</a>
        <a class="button button-primary" href="bilancio.php">Mio Bilancio</a>
    </div>
    
    <div class="row" style="margin-top: 5%">
        <h5>Altro</h5>
        <a class="button button-primary" href="x_logout.php">Logout</a>    
		<a class="button button-primary" href="check.php">Check</a>
        <a class="button button-primary" href="backup_dump.php">Download Backup Data</a>
        <a class="button button-primary" href="password.php">Cambia password</a>
    </div>
    
    <div class="row" style="margin-top: 1em;">
        <h6>developed by Lucas Falardi -.- 2019</h6>
    </div>
  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
