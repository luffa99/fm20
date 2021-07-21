<?php
require ("x_session.php");
require("db_config.php");
$mysqli = new mysqli($host, $username, $password, $database);
if ($mysqli->connect_errno) {
	printf("Connect failed: %s\n", $mysqli->connect_error);
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>FM20</title>
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
  <!--script src="js/hnl.mobileConsole.js"></script-->

	
  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="images/favicon.png">

</head>
<body>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->

  <div id="overlay" onclick="off()">
    <div id="reader"></div>
  </div>

  <div class="container">
    <div class="row">
      <div style="margin-top: 10%">
        <a href='index.php'><img src='images/left.png' style='height: 25px;width: 25px;margin-right: 20px;'></a> 
        <h3 style='text-align:left;display: inline-block'>Aggiungi spesa</h3>
        <hr style ="margin-top: -2rem;">
      </div>
    </div>

      <a class="button" href="#" onclick="on()"> 
          <img src="images/qrcode-solid.svg" width="15" height="15" style="vertical-align: sub;"/> 
          QR-SCAN SCONTRINO MIGROS
      </a>
      
      <form action="x_nuova_spesa.php" method="POST">
        
        <!-- INFO AFFITTANTE -->
        <!--h4>Informazioni base</h4-->
        
        
        <div class="row"> 
          <div class="four columns">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" required>
          </div>
          
          <div class="four columns">
            <label for="dataora">Data e ora</label>
            <input type="datetime-local" id="dataora" name="dataora" required>
          </div>
        </div>
        
        <div class="row">
          <div class="eight columns">  
            <label for="luogo">Luogo</label>
            <input type="text" id="luogo" name="luogo">
          </div>
        </div>
        
        <div class="row">
          <div class="eight columns">
            <label for="descrizione">Descrizione / Riferimento</label>
            <textarea class="u-full-width" id="descrizione" name="descrizione"></textarea>
          </div>
        </div>
        
        <div class="row"> 
          <div class="four columns">
            <label for="spesa_totale">Spesa totale</label>
            <input type="number" id="spesa_totale" name="spesa_totale" step="any" required>  
          </div>
          
          <div class="four columns">     
              <label for="valuta">Valuta</label>
              <select class="u-full-width" id="valuta" name="valuta">
                <option id="cur_CHF" value="CHF" rate="1.00">CHF - Franco Svizzero</option>
                <!--option value="EUR" disabled>EUR - Euro</option>
                <option value="PLN" disabled>PLN - Złoty polacco</option>
                <option value="HUF" disabled>HUF - Fiorino ungherese</option>
                <option value="CZK" disabled>CZK  - Corona ceca</option-->
                <?php $url = "https://www.backend-rates.ezv.admin.ch/api/xmldaily?locale=en";
                  $xml = simplexml_load_file($url);

                  foreach ($xml->devise as $curr) {
                      $curr_nome = $curr->land_it[0];
                      $curr_rate = 1.0/$curr->kurs[0];
                      $curr_code = strtoupper($curr->attributes()["code"][0]);
                      echo "<option id=\"cur_$curr_code\"value=\"$curr_code\" rate=\"$curr_rate\">$curr_code - $curr_nome</option>";
                  } 
                ?>
              </select>
          </div>
        </div>
        
        <div class="row"> 
          <div class="four columns">
            <label for="spesa_totale_chf">Spesa totale CHF</label>
            <input type="number" step='any' id="spesa_totale_chf" name="spesa_totale_chf" readonly>
          </div>
          
          <div class="four columns">
            <label for="cambio">Cambio</label>
            <input type="number" step='any' id="cambio" name="cambio" readonly>
          </div>
        </div>
        
        <h4 style ="margin-top: 2rem;">Suddivisione</h4>
        <hr style ="margin-top: -2rem;">
        
        <div class="row">
          <div class="four columns"> 
              <label for="id_utente_pagante">Creditore</label>
              <select class="u-full-width" id="id_utente_pagante" name="id_utente_pagante">
                <?
                $sql = "SELECT * FROM utenti";
                $result = $mysqli->query($sql);
                if ($result->num_rows > 0) {
                  while($riga = $result->fetch_assoc()) {
                  if ($riga['id_utenti'] == $x_id) {$mio = 'selected';} else {$mio = '';}
                  echo "<option value='".$riga['id_utenti']."'".$mio.">".$riga['nome']."</option>";
                  }
                } else {
                  echo "ERRORE!";
                }
                ?>          
              </select>
            </div>
        </div>
        
        <div class="row">
          <div class="four columns">  
            <label for="romana">Opzioni</label>
            <a class="button" id="romana" onclick="romana();">Alla romana</a>
			  <!--a class="button" id="romana" onclick="romana_sei();">A SEI</a>
			  <a class="button" id="romana" onclick="romana_cinque();">A CINQUE</a-->
            <a class="button" id="azzera" onclick="azzera();">Azzera</a>
          </div>
        </div>
        
        <div class="row"> 
          <div class="eight columns">
            <table class="u-full-width">
              <thead>
                <tr>
                  <th>Spese</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?
                $sql = "SELECT * FROM utenti";
                $result = $mysqli->query($sql);
                if ($result->num_rows > 0) {
                  while($riga = $result->fetch_assoc()) {
                    echo "<tr><td>".$riga['nome']."</td><td><input placeholder='0' type='number' step='any' class='spese' id='spesa[".$riga['id_utenti']."]' name='spesa[".$riga['id_utenti']."]' oninput='conti();'></td></tr>";
                  }
                } else {
                  echo "ERRORE!";
                }
                $mysqli->close();
                ?>  
              </tbody>
            </table>
          </div>
        </div>
        
        <div class="row"> 
          <div class="four columns">
            <span id="controllo"></span>
          </div>
        </div>
        
        
          
        <input type="submit" value="submit input">

      </form>    
  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>

<script src="js/nuova_spesa.js?1130"></script>
<script src="https://unpkg.com/html5-qrcode@2.0.11/dist/html5-qrcode.min.js"></script>
<script src="js/qrscan.js?1001"></script>
<script src="js/geo.js"></script>