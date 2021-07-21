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
  <title>FM20 - Lista Spese</title>
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
  <link rel="stylesheet" href="css/spese.css?v=1001">
  
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
    <a href='index.php'><img src='images/left.png' style='height: 25px;width: 25px;margin-right: 20px;'></a> 
    <h2 style='text-align:left;display: inline-block'>Lista spese</h2>
    <div class="row"> 

    </div>
  </div>  
      <?php   
      if (isset($_GET['page_no']) && $_GET['page_no']!="") {
        $page_no = $_GET['page_no'];
      } else {
        $page_no = 1;
      }
      $total_records_per_page = 10;
      $offset = ($page_no-1) * $total_records_per_page;
      $previous_page = $page_no - 1;
      $next_page = $page_no + 1;
      $adjacents = "2";
      $result_count = mysqli_query(
        $mysqli, "SELECT COUNT(*) AS total_records FROM `spesa`"
      );
      $total_records = mysqli_fetch_array($result_count);
      $total_records = $total_records['total_records'];
      $total_no_of_pages = ceil($total_records / $total_records_per_page);
      $second_last = $total_no_of_pages - 1; // total pages minus 1
        
   
      $sql = "SELECT * FROM spesa ORDER by dataora DESC LIMIT $offset, $total_records_per_page";
      $result = $mysqli->query($sql);
      if ($result->num_rows > 0) {
        while($riga = $result->fetch_assoc()) {
           $id_spesa = $riga['id_spesa'];
           $nome = $riga['nome'];
           $date = date_create($riga['dataora']);
           $dataora = date_format($date, 'l d.m.y H:i');
           $luogo = $riga['luogo'];
           if ($riga['luogo']) {
            $luogo = "<i class='fas fa-map-marker-alt'></i> $luogo<br />";
           }
           $chi =  chi($riga['id_utente_pagante']);
           $spesa_totale     =  $riga['spesa_totale'];
           $spesa_totale_chf =  $riga['spesa_totale_chf'];
           $valuta = $riga['valuta'];
           echo "<a href='dettaglio_spesa.php?id=$id_spesa' class='spesa'><div class='spesa'><div class='interno'><div class='prezzo'>$spesa_totale_chf <span class='valuta_1'>CHF</span><span class='secondo'>$spesa_totale <span class='valuta_2'>$valuta</span></span></div>
           <h4>$nome</h4>
           <i class='far fa-clock'></i> $dataora<br />
           $luogo
           <i class='fas fa-money-check'></i> $chi
           </div></div></a>";
        }
      } else {
      echo "ERRORE!";
      }
      ?>
<div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;text-align: center;'>
  <strong>Pagina <?php echo $page_no." di ".$total_no_of_pages; ?></strong>
</div>

<div class="pagination">
	<?php // if($page_no > 1){ echo "<span><a href='?page_no=1'>First Page</a></span>"; } ?>
    
	<span <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
	<a <?php if($page_no > 1){ echo "href='?page_no=$previous_page'"; } ?>>Indietro</a>
	</span>
    
	<span <?php if($page_no >= $total_no_of_pages){ echo "class='disabled'"; } ?>>
	<a <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page'"; } ?>>Avanti</a>
	</span>
    <?php if($page_no < $total_no_of_pages){
		echo "<span><a href='?page_no=$total_no_of_pages'>Ultima &rsaquo;&rsaquo;</a></span>";
		} ?>
</div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
