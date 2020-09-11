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
<?php
require("db_config.php");
$mysqli = new mysqli($host, $username, $password, $database);
if ($mysqli->connect_errno) {
	printf("Connect failed: %s\n", $mysqli->connect_error);
	exit();
}
$errori = 0;
	// #0 Le somme dei totali fanno ZERO
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
                  $tutti[$nome] = $bilancio;
                }
              } else {
              echo "ERRORE!";
              }
			  $bilancio_totale = 0;
              foreach($tutti as $nome => $bilancio) {
                 $bilancio_totale = $bilancio_totale + $bilancio; 
              }
			  $bilancio_totale = round($bilancio_totale, 2);
			  if (abs($bilancio_totale) < 1) {
			  	echo "OK: le somme dei totali fanno ZERO ($bilancio_totale CHF)<br />";
			  } else {
			  	echo "Errore $errori: le somme dei totali fanno $bilancio_totale CHF!<br />";
			  }
				echo "Check #0 done.<br /><br />";

	// #1 Le spese assegnate ai soldi esistono (no spese fantasma causate da errori di inserimento)
        $sql_2 = "SELECT * FROM soldi";
        $result_2 = $mysqli->query($sql_2);
		$totale_soldi = 0;
        if ($result_2->num_rows > 0) {
           while($riga_2 = $result_2->fetch_assoc()) {  
		     $id_soldi = $riga_2['id_soldi'];
			 $id_spesa = $riga_2['id_spesa'];			 			 
			 
				$sql_3 = "SELECT * FROM spesa WHERE id_spesa = $id_spesa";
        		$result_3 = $mysqli->query($sql_3);
				if ($result_3->num_rows == 0) { 
					$errori++;
					$totale_soldi = $totale_soldi + $riga_2['debito_chf'];
					echo "Errore $errori: non trovata la spesa $id_spesa per i soldi $id_soldi (tot: $totale_soldi)<br />";
				} 
           } 
        } else {
          echo "ERRORE!";
		}
		echo "Check #1 done.<br/><br />";
	
	// #2 L'ammontare delle spese è formato dalla somma dei soldi ed è assegnato al corretto utente
		$sql_2 = "SELECT * FROM spesa";
        $result_2 = $mysqli->query($sql_2);
        if ($result_2->num_rows > 0) {
           while($riga_2 = $result_2->fetch_assoc()) {  
			 $id_spesa = $riga_2['id_spesa'];
			 $spesa_totale_chf = $riga_2['spesa_totale_chf'];			 			 
			 $id_utente_pagante = $riga_2['id_utente_pagante'];	
			 $spesa_totale = $riga_2['spesa_totale'];	
			 $valuta = $riga_2['valuta'];	
			 $cambio = $riga_2['cambio'];	
			   
			 $totale_soldi = 0;
			 $totale_soldi_chf = 0;
			 $totale_credito = 0;
			 $totale_credito_chf = 0;
			   
				$sql_3 = "SELECT * FROM soldi WHERE id_spesa = $id_spesa";
        		$result_3 = $mysqli->query($sql_3);
				if ($result_3->num_rows > 0) { 
					while($riga_3 = $result_3->fetch_assoc()) {  
						$id_soldi		= $riga_3['id_soldi'];
						$id_spesa		= $riga_3['id_spesa'];
						$id_utente		= $riga_3['id_utente'];
						$debito			= $riga_3['debito'];
						$credito		= $riga_3['credito'];
						$debito_chf		= $riga_3['debito_chf'];
						$credito_chf	= $riga_3['credito_chf'];
						
						$totale_soldi = $totale_soldi + $debito;
						$totale_soldi_chf = $totale_soldi_chf + $debito_chf;
						$totale_credito = $totale_credito + $credito;
						$totale_credito_chf = $totale_credito_chf + $credito_chf;
						
						// Controllo credito all'utente corretto
						if ($credito > 0 OR $credito_chf > 0) {
							if ($id_utente != $id_utente_pagante) {
								$errori++;
								echo "Errore $errori: assegnazione credito sbagliata al soldo $id_soldi per la spesa $id_spesa per l'utente $id_utente <br />";
							}
						}
					}
				} 
			   
			   // Controllo delle somme
			   if (abs($spesa_totale - $totale_soldi) >= 1) {
				   $errori++;
				   echo "Errore $errori: la somma delle spese (valuta $valuta) non corrisponde alla spesa $id_spesa! $spesa_totale vs $totale_soldi $valuta<br />";
			   
			   }
			   if (abs($spesa_totale_chf - $totale_soldi_chf) >= 1) {
				   $errori++;
				   echo "Errore $errori: la somma delle spese (valuta franchi) non corrisponde alla spesa $id_spesa! $spesa_totale_chf vs $totale_soldi_chf<br />";
			   
			   }
			   if ($spesa_totale != $totale_credito) {
				   $errori++;
				   echo "Errore $errori: il credito (valuta $valuta) non corrisponde alla spesa $id_spesa! $spesa_totale vs $totale_credito $valuta<br />";
			   
			   }
			   if ($spesa_totale_chf != $totale_credito_chf) {
				   $errori++;
				   echo "Errore $errori: il credito (valuta franchi) non corrisponde alla spesa $id_spesa! $spesa_totale vs $totale_credito_chf<br />";
			   
			   }
           } 
        } else {
          echo "ERRORE!";
		}
		echo "Check #2 done.<br/><br />";
?>
		<br /><a class="button" href="index.php">Torna alla HOME</a>
</div>
  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>		
