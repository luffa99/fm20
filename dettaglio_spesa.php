<?php
require ("x_session.php");
require("db_config.php");
$mysqli = new mysqli($host, $username, $password, $database);
if ($mysqli->connect_errno) {
	printf("Connect failed: %s\n", $mysqli->connect_error);
	exit();
}

function chi($id_utenti){
  require("db_config.php");
  $mysqli = new mysqli($host, $username, $password, $database);
  if ($mysqli->connect_errno) {
  	printf("Connect failed: %s\n", $mysqli->connect_error);
  	exit();
  }
  $sql = "SELECT * FROM utenti WHERE id_utenti = $id_utenti";
      $result = $mysqli->query($sql);
      if ($result->num_rows == 1) {
        while($riga = $result->fetch_assoc()) {
          return $riga['nome'];
        }
      }  
}

$id_spesa = $_GET['id'];

$sql = "SELECT * FROM spesa WHERE id_spesa = $id_spesa";
      $result = $mysqli->query($sql);
      if ($result->num_rows == 1) {
        while($riga = $result->fetch_assoc()) {
        
           $id_spesa          = $_GET['id']; 
           $nome              = $riga['nome'];
           $date              = date_create($riga['dataora']);
           $dataora           = date_format($date, 'l d F Y H:i');
           $luogo             = $riga['luogo'];
           $descrizione       = $riga['descrizione'];
           $spesa_totale      = $riga['spesa_totale'];
           $valuta            = $riga['valuta'];
           $cambio            = $riga['cambio']; 
           $spesa_totale_chf  = $riga['spesa_totale_chf'];
           $utente_pagante    = chi($riga['id_utente_pagante']);
           $id_pagante        = $riga['id_utente_pagante'];
           $utente_inserimento= chi($riga['id_utente_inserimento']);
           $timestamp_ins     = $riga['timestamp_inserimento'];   
          
        }
      } else {
        echo "ERRORE!";
      }
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>FM20 - Dettaglio spesa</title>
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
  <link rel="stylesheet" href="css/spese.css">

  
  <!-- Javascript
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script-->
  <script src="https://kit.fontawesome.com/9c92183a78.js"></script>
  <script src="js/swipe.js"></script>
                                   
  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="images/favicon.png">

</head>
<body>
  <div class="container">
    <?php
    echo "<h2>$nome</h2>
          <div class='row'>
            $descrizione
            <h3 style='margin-bottom: 0px;text-align:center;margin-top:1em;'>$spesa_totale_chf CHF</h3>
            <h5 style='text-align:center'>$spesa_totale $valuta</h5>
          
            <i class='far fa-clock'></i> $dataora<br />
            <i class='fas fa-map-marker-alt'></i> $luogo<br />
            <i class='fas fa-money-check'></i> $utente_pagante<br />
            <i class='fas fa-coins'></i> 1 $valuta = $cambio CHF<br />
            <i class='fas fa-fingerprint'></i> $id_spesa<br />
            <i class='fas fa-pen-square'></i> $utente_inserimento | $timestamp_ins
          </div>";
      echo  "<br /><h4>Suddivisone</h4><div class='row'>
            <table class='u-full-width'>
            <thead>
              <tr>
                <th>Nome</th>
                <th>Spesa</th>
                <th>in CHF</th>
              </tr>
            </thead>
            <tbody>";
                $sql = "SELECT * FROM soldi WHERE id_spesa = $id_spesa";
                $result = $mysqli->query($sql);
                if ($result->num_rows > 0) {
                  while($riga = $result->fetch_assoc()) {
                  
                     $debito_chf    = $riga['debito_chf']; 
                     $debito        = $riga['debito'];
                     $valuta        = $riga['valuta'];
                     $utente        = chi($riga['id_utente']); 
                     
                     if ($debito != 0) {
                      echo "<tr><td>$utente</td><td>$debito $valuta</td><td>$debito_chf</td></tr>";
                     }
                  }
                } else {
                  echo "ERRORE!";
                }
      echo "</tbody>
            </table>
          </div>";
          
      $admin = false;
      $sql = "SELECT * FROM utenti WHERE id_utenti = $x_id";
      $result = $mysqli->query($sql);
      if ($result->num_rows == 1) {
        while($riga = $result->fetch_assoc()) {
           if ($riga['admin'] == 1) {$admin = true;}
        }
      }   
      
      if($x_id == $id_pagante OR $admin) {echo "<a class='button' href='modifica_spesa.php?id=$id_spesa'>Modifica</a>";} 
      ?>
  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
