<?php
	require ("db_config.php");
	$mysqli = new mysqli($host, $username, $password, $database);
	if ($mysqli->connect_errno) {
		printf("Connect failed: %s\n", $mysqli->connect_error);
		exit();
	}
	session_start();


	if (isset($_SESSION['login_user'])) {
		header("location: index.php");
	}
	
	if ($_SERVER["REQUEST_METHOD"] === "POST") {
  
		$user = mysqli_real_escape_string($mysqli, $_POST['user']);
		$pass = md5(mysqli_real_escape_string($mysqli, $_POST['pass']));
    
		$sql = "SELECT * FROM utenti WHERE `nome_utente` = '$user' AND password = '$pass'";
		$query = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		$count = mysqli_num_rows($query);
		if ($count == 1) {
      $_SESSION['login_user'] = $user;
			$_SESSION['id_utenti'] = $row['id_utenti'];
			$_SESSION['user_class'] = $row['classe'];
        $sql_2 = "UPDATE `utenti` SET `last_login`= CURRENT_TIMESTAMP WHERE `id_utenti` = ".$row['id_utenti'];
		    $query_2 = mysqli_query($mysqli, $sql_2) or die(mysqli_error($mysqli));
			header("location: index.php");				
		} else {
      header("location: login.php");
    }
	}
?>