<?
$success = false;
require("x_session.php");
require("db_config.php");
$mysqli = new mysqli($host, $username, $password, $database);
if ($mysqli->connect_errno) {
	printf("Connect failed: %s\n", $mysqli->connect_error);
	exit();
}
$vpassword = md5($_POST['vpassword']);
$npassword = md5($_POST['npassword']);

$sql = "SELECT * FROM utenti WHERE `id_utenti` = '$x_id' AND password = '$vpassword'";
		$query = mysqli_query($mysqli, $sql);
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		$count = mysqli_num_rows($query);
		if ($count == 1) {
    
      $sql = "UPDATE `utenti` SET `password`='$npassword' WHERE id_utenti= $x_id";

      if ($mysqli->query($sql) === TRUE) {
        $success = true;
      } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
          $success = false;
      }
							
		} else {
      $success = false;
    }



if($success) {
echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>GE19</title><meta name="description" content=""><meta name="author" content=""><meta name="viewport" content="width=device-width, initial-scale=1"><link href="https://fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css"><link rel="stylesheet" href="css/normalize.css"><link rel="stylesheet" href="css/skeleton.css"><link rel="stylesheet" href="css/alerts.css"><link rel="icon" type="image/png" href="images/favicon.png"></head><body><div class="alert succ"><span class="closebtn" onclick="this.parentElement.style.display="none";">&times;</span>
<strong>Successo!</strong> Password modificata con successo.</div>
<div class="container"><div class="row" style="margin-top: 30px;"><a class="button" href="index.php">Torna alla HOME</a></div></div></body></html>';
} else {
'<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>GE19</title><meta name="description" content=""><meta name="author" content=""><meta name="viewport" content="width=device-width, initial-scale=1"><link href="https://fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css"><link rel="stylesheet" href="css/normalize.css"><link rel="stylesheet" href="css/skeleton.css"><link rel="stylesheet" href="css/alerts.css"><link rel="icon" type="image/png" href="images/favicon.png"></head><body><div class="alert"><span class="closebtn" onclick="this.parentElement.style.display="none";">&times;</span>
<strong>Errore!</strong> Si &egrave; verificato un errore. Maggiori informazioni su questa pagina.</div>
<div class="container"><div class="row" style="margin-top: 30px;"><a class="button" href="index.php">Torna alla HOME</a></div></div></body></html>';
}


$mysqli->close();
?>
     