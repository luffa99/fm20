<?php
  require("db_config.php");
	$mysqli = new mysqli($host, $username, $password, $database);
	if ($mysqli->connect_errno) {
		printf("Connect failed: %s\n", $mysqli->connect_error);
		exit();
	}
	session_start();

   $x_user_check = $_SESSION['login_user'];
   $x_ses_sql = mysqli_query($mysqli,"SELECT * FROM utenti WHERE nome_utente = '$x_user_check' ");
   $x_row = mysqli_fetch_array($x_ses_sql, MYSQLI_ASSOC);
   
   
   $x_ll = $x_row['last_login'];
   $x_id = $x_row['id_utenti'];
   $x_nu = $x_row['nome_utente'];

   if(!isset($_SESSION['login_user'])){
      header("location: login.php");
      exit();
   }
?>
