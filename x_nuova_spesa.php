<?
require("x_session.php");
require("db_config.php");
$mysqli = new mysqli($host, $username, $password, $database);
if ($mysqli->connect_errno) {
	printf("Connect failed: %s\n", $mysqli->connect_error);
	exit();
}
// Controllo
$success = false;
if (!isset($_POST['nome']) OR !isset($_POST['dataora']) OR !isset($_POST['spesa_totale']) OR !isset($_POST['valuta']) OR !isset($_POST['cambio']) OR !isset($_POST['id_utente_pagante']) OR !isset($_POST['spesa_totale_chf']) ) {die("Non tutti i campi sono stati completati correttamente!");}

// Informazioni spesa
$nome                   = mysqli_real_escape_string($mysqli, $_POST['nome']);
$dataora                = mysqli_real_escape_string($mysqli, $_POST['dataora']);
$luogo                  = mysqli_real_escape_string($mysqli, $_POST['luogo']);
$descrizione            = mysqli_real_escape_string($mysqli, $_POST['descrizione']);
$spesa_totale	        = mysqli_real_escape_string($mysqli, $_POST['spesa_totale']);
$valuta	                = mysqli_real_escape_string($mysqli, $_POST['valuta']);
$cambio                 = mysqli_real_escape_string($mysqli, $_POST['cambio']);
$spesa_totale_chf       = mysqli_real_escape_string($mysqli, $_POST['spesa_totale_chf']);
$id_utente_pagante      = mysqli_real_escape_string($mysqli, $_POST['id_utente_pagante']);
$id_utente_inserimento  = $x_id;


$sql = "INSERT INTO `spesa` (`nome`, `dataora`, `luogo`, `descrizione`, `spesa_totale`, `valuta`, `cambio`, `spesa_totale_chf`, `id_utente_pagante`, `id_utente_inserimento`, `timestamp_inserimento`) VALUES ('$nome', '$dataora', '$luogo', '$descrizione', '$spesa_totale', '$valuta', '$cambio', '$spesa_totale_chf', '$id_utente_pagante', '$id_utente_inserimento', CURRENT_TIMESTAMP)";

if ($mysqli->query($sql) === TRUE) {
    $success = true;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;  $success = false;
}

// Soldi singoli
$id_spesa	= $mysqli->insert_id;

foreach ($_POST['spesa'] as $id_utente => $debito) {
  if ($id_utente == $id_utente_pagante) { $credito = $spesa_totale; $credito_chf = $spesa_totale_chf;}
    else {$credito = 0; $credito_chf = 0;}
  $debito_chf = round(($debito * $cambio),2);
  
  $sql = "INSERT INTO `soldi` (`id_spesa`, `id_utente`, `debito`, `credito`, `debito_chf`, `credito_chf`, `valuta`) VALUES ('$id_spesa', '$id_utente', '$debito', '$credito', '$debito_chf', '$credito_chf', '$valuta')";
  if ($mysqli->query($sql) === TRUE) {
    $success = true;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error; $success = false;
  }
}

if($success) {
echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>GE19</title><meta name="description" content=""><meta name="author" content=""><meta name="viewport" content="width=device-width, initial-scale=1"><link href="https://fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css"><link rel="stylesheet" href="css/normalize.css"><link rel="stylesheet" href="css/skeleton.css"><link rel="stylesheet" href="css/alerts.css"><link rel="icon" type="image/png" href="images/favicon.png"></head><body><div class="alert succ"><span class="closebtn" onclick="this.parentElement.style.display="none";">&times;</span>
<strong>Evvai!</strong> Spesa aggiunta con successo.</div>
<div class="container"><div class="row" style="margin-top: 30px;"><a class="button" href="index.php">Torna alla HOME</a></div></div></body></html>';
} else {
'<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>GE19</title><meta name="description" content=""><meta name="author" content=""><meta name="viewport" content="width=device-width, initial-scale=1"><link href="https://fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css"><link rel="stylesheet" href="css/normalize.css"><link rel="stylesheet" href="css/skeleton.css"><link rel="stylesheet" href="css/alerts.css"><link rel="icon" type="image/png" href="images/favicon.png"></head><body><div class="alert"><span class="closebtn" onclick="this.parentElement.style.display="none";">&times;</span>
<strong>Errore!</strong> Si &egrave; verificato un errore. Maggiori informazioni su questa pagina.</div>
<div class="container"><div class="row" style="margin-top: 30px;"><a class="button" href="index.php">Torna alla HOME</a></div></div></body></html>';
}
$mysqli->close();
?>
     