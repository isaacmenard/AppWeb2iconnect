<?php
include( "../include.php" );
session_start();
$titre = null;
$comment = null;
$date = null;
$yes = null;
$no = null;
$listVoted = "";

if ( isset( $_GET[ "idIdea" ] ) ) {
  // On récupère tout le contenu de la table jeux_video
  $reponse = $bdd->query( 'SELECT * FROM idea  WHERE id = "' . $_GET[ "idIdea" ] . '" ORDER BY date DESC LIMIT 0, 5' );
  $count = 0;
  // On affiche chaque entrée une à une
  while ( $donnees = $reponse->fetch() ) {

    $titre = $donnees[ 'title' ];
    $comment = $donnees[ 'comment' ];
    $date = $donnees[ 'date' ];
    $yes = $donnees[ 'yes' ];
    $no = $donnees[ 'no' ];
	  if($donnees[ 'listVoted' ] != null){
	$listVoted = $donnees[ 'listVoted' ];}
  }
  $reponse->closeCursor(); // Termine le traitement de la requête
} else {
  echo( '<script>window.location = "./"</script>' );
}

mb_internal_encoding( 'UTF-8' );
setlocale( LC_CTYPE, 'fr_FR.UTF-8' );
header( 'content-type: text/html; charset=utf-8' );

if ( 'POST' == $_SERVER[ 'REQUEST_METHOD' ] ) {
	if(!array_search($_SESSION[ 'id' ],  explode('/', $listVoted) )){
	
	  if ( array_key_exists( 'yes', $_POST ) ) {
		  $yes += 1;
		  $listVoted = $listVoted."/".$_SESSION[ 'id' ];
		  $stmt = $bdd->prepare( 'UPDATE idea SET yes = :yes WHERE id = :id' );
        	$stmt->execute( [ 'id' => $_GET[ "idIdea" ] , 'yes' => $yes ] );
		  
	  }
	  if ( array_key_exists( 'no', $_POST ) ) {
		  $no += 1;
		  $listVoted = $listVoted."/".$_SESSION[ 'id' ];
		  $stmt = $bdd->prepare( 'UPDATE idea SET no = :no WHERE id = :id' );
        $stmt->execute( [ 'id' => $_GET[ "idIdea" ] , 'no' => $no ] );
	  }
		$stmt = $bdd->prepare( 'UPDATE idea SET listVoted = :listVoted WHERE id = :id' );
        $stmt->execute( [ 'id' => $_GET[ "idIdea" ] , 'listVoted' => $listVoted ] );
	}
}


?>

<!DOCTYPE html>
<html lang="en" >
<head>
<meta charset="UTF-8">
<title>2iconnect</title>
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
<link rel="stylesheet" href="./style.css">
	  <!-- Our project just needs Font Awesome Solid + Brands -->
  <!-- Our project just needs Font Awesome Solid + Brands -->
  <link href="./fontas/css/fontawesome.css" rel="stylesheet">
  <link href="./fontas/css/brands.css" rel="stylesheet">
  <link href="./fontas/css/solid.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Sen&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300&display=swap" rel="stylesheet">
</head>
<body>
<header>
  <h1>2ICONNECT</h1>
</header>
	
	<div class="contenaire">
		<h3><?php echo($titre); ?></h3>
		<p class="subtitle"><?php echo($date) ?></p>
		<br>
		<p><?php echo($comment); ?></p>
		<br>
		<p class="subtitle">Vote Carrément ! - <?php echo($yes) ?></p>
		<p class="subtitle">Vote Jamais ! - <?php echo($no) ?></p>
		<br>
		
		
		
		<?php
		
		if(isset( $_SESSION[ 'id' ] ) && !array_search($_SESSION[ 'id' ],  explode('/', $listVoted) )){ ?>
		<div class="sondage">
			<form method="POST" id="yes" class="form-style-2 ">      <input type="submit" name="yes" value="GREAT !" /></form>
			<form method="POST" id="no" class="form-style-2 ">      <input type="submit" name="no"  value="BOOF !" /></form>
		</div>
		<?php }if(!isset( $_SESSION[ 'id' ]) ){
			?>
			Vous devez être connecté pour voter
		<?php
		}if(array_search($_SESSION[ 'id' ],  explode('/', $listVoted) )){
			?>
			Vous avez déjà voté !
		<?php
		}
		
		?>
	</div><br><br>
	<h2 onClick="window.location = './'">Retour</h2>
	<br><br><br>
	<br><br><br><br><br><br><br><br><br><br><br><br><br>

<footer>Application lycéenne <i onclick="window.location = 'https://instagram.com/2iconnect_acf?igshid=19fwtkrbcdt2y	'" class="fab fa-instagram"></i></footer>
<script  src="./script.js"></script>
</body>
</html>