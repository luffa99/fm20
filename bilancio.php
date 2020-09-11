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
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>FM20 - Bilancio</title>
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
  <link rel="stylesheet" href="css/bilancio.css">

  
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
    <h2>Mio Bilancio</h2>
    <h6>Bilancio di: <?php echo $x_nu; ?> </h6>
    <div class="centro">
    <?php  
        $sql = "SELECT * FROM utenti WHERE id_utenti = $x_id";
        $result = $mysqli->query($sql);
        if ($result->num_rows == 1) {
          while($riga = $result->fetch_assoc()) {
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
          }
        } else {
          echo "ERRORE!";
        }
        if ($bilancio < 0) {$stile = "bilancio red";} else {$stile = "bilancio";}
        echo "<h2 class='$stile'>$bilancio <span class='valuta_1'>CHF</span></h2>";
		echo "<h4 class='totale'>in totale: $debito_chf <span class='valuta_1'>CHF</span></h4>";
    ?>
      
    </div>
    <div class="row">
    </div>
  </div>   
      <?php     
      $sql = "SELECT * FROM soldi WHERE id_utente = $x_id ORDER by id_spesa DESC";
      $result = $mysqli->query($sql);
      if ($result->num_rows > 0) {
        while($riga = $result->fetch_assoc()) {
           $id_spesa        = $riga['id_spesa'];
           $debito_chf      = $riga['debito_chf'];
           $credito_chf     = $riga['credito_chf'];
           
           if ($debito_chf != 0 OR $credito_chf != 0) {
           
            $sql_1 = "SELECT * FROM spesa WHERE id_spesa = $id_spesa";
            $result_1 = $mysqli->query($sql_1);
            if ($result_1->num_rows > 0) {
               while($riga_1 = $result_1->fetch_assoc()) {
                 $id_spesa = $riga_1['id_spesa'];
                 $nome = $riga_1['nome'];
                 $date = date_create($riga_1['dataora']);
                 $dataora = date_format($date, 'l d.m.y H:i');
                 $luogo = $riga_1['luogo'];
                 
                 if ($debito_chf != 0) {
                 echo "<a href='dettaglio_spesa.php?id=$id_spesa' class='spesa'><div class='spesa'><div class='interno'>
                      <div class='prezzo'>- $debito_chf <span class='valuta_1'>CHF</span></div>
                      $nome<br />
                      <i class='far fa-clock'></i> $dataora<br />
                      <i class='fas fa-map-marker-alt'></i> $luogo<br />
                      </div></div></a>";
                  }
                      
                  if ($credito_chf != 0) {
                     echo "<a href='dettaglio_spesa.php?id=$id_spesa' class='spesa'><div class='spesa'><div class='interno'>
                      <div class='prezzo guadagno'>+ $credito_chf <span class='valuta_1'>CHF</span></div>
                      $nome<br />
                      <i class='far fa-clock'></i> $dataora<br />
                      <i class='fas fa-map-marker-alt'></i> $luogo<br />
                      </div></div></a>";
                  }
               }
            }
          }
        }
      } else {
      echo "ERRORE!";
      }
      ?>
    

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
