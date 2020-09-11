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
           $dataora           = date_format($date, 'Y-m-d\TH:i');
           $luogo             = $riga['luogo'];
           $descrizione       = $riga['descrizione'];
           $spesa_totale      = $riga['spesa_totale'];
           $valuta            = $riga['valuta'];
           $cambio            = $riga['cambio']; 
           $spesa_totale_chf  = $riga['spesa_totale_chf'];
           $utente_pagante    = $riga['id_utente_pagante'];
           $utente_inserimento= $riga['id_utente_inserimento'];
           $timestamp_ins     = $riga['timestamp_inserimento'];   
          
        }
      } else {
        echo "ERRORE!";
      }

$admin = false;
$sql = "SELECT * FROM utenti WHERE id_utenti = $x_id";
      $result = $mysqli->query($sql);
      if ($result->num_rows == 1) {
        while($riga = $result->fetch_assoc()) {
           if ($riga['admin'] == 1) {$admin = true;}
        }
      }

if($x_id == $utente_pagante OR $admin) {} else {die("Non sei autorizzato ad accedere a questa pagina");} 
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>FM20 - Modifica </title>
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
  <script src="js/modifica.js"></script>
                                   
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
        <!--h2>Gestione Eventi Oratorio Balerna</h2-->
        <h3>Modifica spesa - ID <?echo $id_spesa?></h3>
        <hr style ="margin-top: -2rem;">
      </div>
    </div>
      
      <form action="x_modifica_spesa.php?id=<?echo $id_spesa?>" method="POST">
        
        <!-- INFO AFFITTANTE -->
        <!--h4>Informazioni base</h4-->
        
        
        <div class="row"> 
          <div class="four columns">
            <label for="nome">Nome</label>
            <input value="<?echo $nome?>" type="text" id="nome" name="nome" required>
          </div>
          
          <div class="four columns">
            <label for="dataora">Data e ora</label>
            <input value="<?echo $dataora?>" type="datetime-local" id="dataora" name="dataora" required>
          </div>
        </div>
        
        <div class="row">
          <div class="eight columns">  
            <label for="luogo">Luogo</label>
            <input value="<?echo $luogo?>" type="text" id="luogo" name="luogo">
          </div>
        </div>
        
        <div class="row">
          <div class="eight columns">
            <label for="descrizione">Descrizione / Riferimento</label>
            <textarea value="<?echo $descrizione?>" class="u-full-width" id="descrizione" name="descrizione"></textarea>
          </div>
        </div>
        
        <div class="row"> 
          <div class="four columns">
            <label for="spesa_totale">Spesa totale</label>
            <input value="<?echo $spesa_totale?>" type="number" id="spesa_totale" name="spesa_totale" step="any" required>  
          </div>
          
          <div class="four columns">     
              <label for="valuta">Valuta</label>
              <select class="u-full-width" id="valuta" name="valuta" readonly>
                <option value="<?echo $valuta?>"><?echo $valuta?></option>
              </select>
          </div>
        </div>
        
        <div class="row"> 
          <div class="four columns">
            <label for="spesa_totale_chf">Spesa totale CHF</label>
            <input value="<?echo $spesa_totale_chf?>" type="number" step='any' id="spesa_totale_chf" name="spesa_totale_chf" readonly>
          </div>
          
          <div class="four columns">
            <label for="cambio">Cambio</label>
            <input value="<?echo $cambio?>" type="number" step='any' id="cambio" name="cambio" readonly>
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
                  if ($riga['id_utenti'] == $utente_pagante) {$mio = 'selected';} else {$mio = '';}
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
                   
                  }
                } else {
                  echo "ERRORE!";
                }
                
                
                $sql = "SELECT * FROM soldi WHERE id_spesa = $id_spesa";
                $result = $mysqli->query($sql);
                if ($result->num_rows > 0) {
                  while($riga = $result->fetch_assoc()) {
                  
                     $debito        = $riga['debito'];
                     $utente        = chi($riga['id_utente']); 
                     $id_utente     = $riga['id_utente'];
                     
                     if (1 == 1) {                      
                       echo "<tr><td>$utente</td><td><input placeholder='0' type='number' step='any' class='spese' id='spesa[$id_utente]' name='spesa[$id_utente]' value='$debito' oninput='conti();'></td></tr>";
                     }
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
        
        
          
        <input type="submit" value="MODIFICA">
        


      </form>   
      Per cancellare:
      <button onclick="cancella(<?echo $id_spesa?>)" class="button-primary">CANCELLA SPESA !</button> 
  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
