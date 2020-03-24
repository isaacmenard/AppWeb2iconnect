<?php
include( "../include.php" );
session_start();
$comment = null;
$date = null;
$user = null;


if ( isset( $_GET[ "idComment" ] ) ) {
  // On récupère tout le contenu de la table jeux_video
  $reponse = $bdd->query( 'SELECT * FROM comment  WHERE id = "' . $_GET[ "idComment" ] . '" ORDER BY date DESC LIMIT 0, 5' );
  $count = 0;
  // On affiche chaque entrée une à une
  while ( $donnees = $reponse->fetch() ) {
    $comment = $donnees[ 'comment' ];
    $date = $donnees[ 'date' ];
	  $user = $donnees[ 'user' ];
  }
  $reponse->closeCursor(); // Termine le traitement de la requête
	} else {
	  echo( '<script>window.location = "./"</script>' );
	}


$reponse = $bdd->query( 'SELECT * FROM membres  WHERE id_membres = "' . $user . '" ' );
  $count = 0;
  // On affiche chaque entrée une à une
  while ( $donnees = $reponse->fetch() ) {
    $user = $donnees;
  }
  $reponse->closeCursor(); // Termine le traitement de la requête




mb_internal_encoding( 'UTF-8' );
setlocale( LC_CTYPE, 'fr_FR.UTF-8' );
header( 'content-type: text/html; charset=utf-8' );

if ( 'POST' == $_SERVER[ 'REQUEST_METHOD' ] ) {
	  if ( array_key_exists( 'comment', $_POST ) ) {
		  $stmt = $bdd->prepare( 'INSERT INTO commentresponse( idResponse,user,comment,date) VALUES(:idResponse, :user,:comment,NOW())' );
          $stmt->execute( [ 'idResponse' => $_GET[ "idComment" ] , 'user' => $_SESSION['id'], 'comment' =>  $_POST['comment']] );
		  
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
		<h3><?php echo($user['prenom']); ?></h3>
		<p class="subtitle"><?php echo($date) ?></p>
		<br>
		<p><?php echo($comment); ?></p>
		<br>

		
		
		
		<?php
		
		if(isset( $_SESSION[ 'id' ] )){ ?>
		<div class="sondage">
			<form method="POST" class="form-style-2 ">   
				<input type="text"  class="input-field" name="comment"/>
				<input type="submit" value="REPONDRE !" />
			</form>
		</div>
		<?php }if(!isset( $_SESSION[ 'id' ]) ){
			?>
			Vous devez être connecté pour voter
		<?php
		}
		?>
	</div>
		<?php 
	$reponse = $bdd->query( 'SELECT * FROM commentresponse  WHERE idResponse = "' . $_GET[ "idComment" ] . '" ' );
  $count = 0;
  // On affiche chaque entrée une à une
  while ( $donnees = $reponse->fetch() ) {
    if ( $count != 0 ) {
      echo( '<hr>' );
    }else{
		 echo( '<div class="contenaire">' );
	}
    $count++;

    // On récupère tout le contenu de la table jeux_video
    $reponse2 = $bdd->query( 'SELECT * FROM membres WHERE id_membres = "' . $donnees[ 'user' ] . '"' );

    // On affiche chaque entrée une à une
    while ( $donnees2 = $reponse2->fetch() ) {
		$elCommet = $donnees['comment'];
	if(strlen($donnees['comment']) > 50){
		$donnees['comment'] = "<a onclick='window.location = `comment.php?idComment=".$donnees['id']."`'>".substr($donnees['comment'], 0, 50)." <strong>...</strong></a>";
	}
		
      if ( $donnees2[ 'pdp' ] != null ) {
        $pdpUrl = "img/" . $donnees2[ 'pdp' ];
      }else{
		  $pdpUrl = "https://lh6.googleusercontent.com/oucxDw25YzIkYzOTExEsrO2uCob-br7Y9GhruotO_QBwMbRovgybILAB_JxNwT4UYgDosfzv08eh-Msa-IaF3GYnFF1CATfPW8Q5At31Hz5nKUNORtIX-EOkBer9E7QfSA=s412";
	  }

      ?>
  <div class="profilContenaire">
    <div style="background-image: url('<?php echo($pdpUrl); ?>')" class="profil"></div>
    <div class="text">
      <h3><?php echo($donnees2['prenom']." ".$donnees2['nom']); ?></h3>
      <p class="subtitle"><?php echo($donnees['date']) ?></p>
      <p class="contenueText"><?php echo($donnees['comment']) ?></p>
    </div>
  </div>
  <?php
  }
	  $reponse2->closeCursor(); // Termine le traitement de la requête
  }
	if($count > 0){
		echo('</div>');
	}
  $reponse->closeCursor(); // Termine le traitement de la requête
	?>
	</div>

	<br><br>
	
	
	
	<h2 onClick="window.location = './'">Retour</h2>
	<br><br><br>
	<br><br><br><br><br><br><br><br><br><br><br><br><br>

<footer>Application lycéenne <i onclick="window.location = 'https://instagram.com/2iconnect_acf?igshid=19fwtkrbcdt2y	'" class="fab fa-instagram"></i></footer>
<script  src="./script.js"></script>
</body>
</html>