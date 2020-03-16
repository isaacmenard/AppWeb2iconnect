<?php
include("../include.php");
session_start();

$pdpUrl = "https://lh6.googleusercontent.com/oucxDw25YzIkYzOTExEsrO2uCob-br7Y9GhruotO_QBwMbRovgybILAB_JxNwT4UYgDosfzv08eh-Msa-IaF3GYnFF1CATfPW8Q5At31Hz5nKUNORtIX-EOkBer9E7QfSA=s412";

if ( isset( $_SESSION[ 'id' ] ) ) {
  $connected = true;
} else {
  $connected = false;
}

const MIN_PSEUDO_LEN = 3;
const MAX_PSEUDO_LEN = 80;
const MIN_PASSWORD_LEN = 6;
ini_set( 'display_errors', 'on' );
error_reporting( E_ALL );
$errors = [];
mb_internal_encoding( 'UTF-8' );

$fail = FALSE;

if ( 'POST' == $_SERVER[ 'REQUEST_METHOD' ] ) {
  if ( array_key_exists( 'mail', $_POST ) ) {
  $stmt = $bdd->prepare( 'SELECT * FROM membres WHERE mail = :mail' );
  $stmt->execute( [ 'mail' => $_POST[ 'mail' ] ] );
  if ( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ) {
    if ( password_verify( $_POST[ 'mdp' ], $row[ 'mot_de_passe' ] ) ) {
      $_SESSION[ 'id' ] = $row[ 'id_membres' ];
      $_SESSION[ 'name' ] = $row[ 'prenom' ];
      $_SESSION[ 'statue' ] = true;
		$connected = true;
      if ( password_needs_rehash( $row[ 'mot_de_passe' ], $password_options[ 'algo' ], $password_options[ 'options' ] ) ) {
        $stmt = $bdd->prepare( 'UPDATE membres SET mot_de_passe = :new_hash WHERE id = :id' );
        $stmt->execute( [ 'id' => $row[ 'id' ], 'new_hash' => password_hash( $_POST[ 'mdp' ], $password_options[ 'algo' ], $password_options[ 'options' ] ) ] );
      }

    } else {
		echo("<script>mot de passe ou pseudo incorrect</script>");
      $fail = TRUE;
    }
  } else {
	  		echo("<script>mot de passe ou pseudo incorrect</script>");
    $fail = TRUE;
  }
}
}

if ( 'POST' == $_SERVER[ 'REQUEST_METHOD' ] ) {
	if ( array_key_exists( 'comment', $_POST ) ) {
		if ( !$errors ) {
		  $insert = $bdd->prepare( 'INSERT INTO comment( user,comment,date) VALUES(:user, :comment,NOW())' );
		  $insert->execute( [ 'user' => strip_tags( $_SESSION['id']), 'comment' => strip_tags( $_POST[ 'comment' ] ) ] );
		  $fail = FALSE;

		}
	}
	
	if ( array_key_exists( 'pdp', $_POST ) ) {
		if ( !$errors ) {
		  $nb_modifs = $bdd->exec('UPDATE membres SET pdp = "'.strip_tags( $_POST[ 'pdp' ]).'" WHERE id_membres = \''.$_SESSION['id'].'\'');
		}
	}
	
	
  if ( array_key_exists( 'mailI', $_POST ) ) {
    if ( array_key_exists( 'mailI', $_POST ) ) {

      $stmt = $bdd->prepare( 'SELECT 1 FROM membres WHERE mail = :mail' );
      $stmt->execute( [ 'mail' => $_POST[ 'mailI' ] ] );
      if ( FALSE !== $stmt->fetchColumn() ) {
        $errors[ 'mail' ] = "Ce mail est d&eacute;j&agrave; utilis&eacute;";
      }

    } else {
      $errors[ 'mail' ] = "mail est absent";
    }

    if ( !array_key_exists( 'prenomI', $_POST ) ) {
      $errors[ 'prenom' ] = "Prénom est absent";
    }
    if ( !array_key_exists( 'nomI', $_POST ) ) {
      $errors[ 'nom' ] = "Nom est absent";
    }
    if ( array_key_exists( 'mdpI', $_POST ) ) {
      $mdp_length = mb_strlen( $_POST[ 'mdpI' ] );
      if ( $mdp_length < MIN_PASSWORD_LEN ) {
        $errors[ 'mdp' ] = sprintf( "La longueur du mot de passe doit 	&ecirc;tre d'au moins %d carat&egrave;res", MIN_PASSWORD_LEN );
      }
      if ( $_POST[ 'mdpI' ] != $_POST[ 'mdpconfirmI' ] ) {
        $errors[ 'mdpconfirm' ] = "Le mot de passe et sa confirmation ne co&iuml;cident pas";
      }
    } else {
      $errors[ 'mdp' ] = "mot de passe est absent";
    }

    if ( !$errors ) {
      $insert = $bdd->prepare( 'INSERT INTO membres( mail,mot_de_passe,nom,prenom) VALUES(:mail, :mdp,:nom,:prenom)' );
      $insert->execute( [ 'mail' => strip_tags( $_POST[ 'mailI' ] ), 'mdp' => password_hash( $_POST[ 'mdpI' ], $password_options[ 'algo' ], $password_options[ 'options' ] ), 'nom' => strip_tags( $_POST[ 'nomI' ] ), 'prenom' => strip_tags( $_POST[ 'prenomI' ] ) ] );
      $fail = FALSE;
		
		$stmt = $bdd->prepare('SELECT * FROM membres WHERE mail = :mail');
    $stmt->execute(['mail' => $_POST['mailI']]);
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (password_verify($_POST['mdpI'], $row['mot_de_passe'])) {
            $_SESSION['id'] = $row['id_membres'];
			$_SESSION['name'] = $row['prenom'];
			$_SESSION['statue'] = true;
			$connected = true;
            if (password_needs_rehash($row['mot_de_passe'], $password_options['algo'], $password_options['options'])) {
                $stmt = $bdd->prepare('UPDATE membres SET mot_de_passe = :new_hash WHERE id = :id');
                $stmt->execute(['id' => $row['id'], 'new_hash' => password_hash($_POST['mdpI'], $password_options['algo'], $password_options['options'])]);
            }

        } else {
            $fail = TRUE;
        }
    } else {
        $fail = TRUE;
    }
		
    }
	  
	  
	  
  }
}

mb_internal_encoding( 'UTF-8' );
setlocale( LC_CTYPE, 'fr_FR.UTF-8' );
header( 'content-type: text/html; charset=utf-8' );
?>

<!DOCTYPE html>
<html lang="en" >
<head>
<meta charset="UTF-8">
<title>2iconnect</title>
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
<link rel="stylesheet" href="./style.css">
<link href="https://fonts.googleapis.com/css?family=Sen&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300&display=swap" rel="stylesheet">
</head>
<body>
<header>
  <h1>2ICONNECT</h1>
</header>
<div class="contenaire">
  <h2 class="canCLick" id="messageBonjour">Good Morning !</h2>
  <h2 class="canCLick" id="hour">0 h 00</h2>
  <p  class="invisible">{pseudo}</p>
</div>
<?php
if ( $connected == false ) {
  ?>
<div class="contenaire">
  <h3 class="canCLick">Connexion</h3>
  <form method="POST" id="connexion" class="form-style-2 invisible">
    <label for="field1"><span>Email <span class="required">*</span></span>
      <input type="mail" class="input-field" id="mail" name="mail" value="" />
    </label>
    <label for="field2"><span>Mot de passe <span class="required">*</span></span>
      <input type="password" class="input-field" id="mdp" name="mdp" value="" />
    </label>
    <label><span> </span>
      <input type="submit" value="Connexion" />
    </label>
  </form>
</div>
<div class="contenaire">
  <h3 class="canCLick">Inscription</h3>
  <form method="POST" id="inscription" class="form-style-2 invisible">
    <label for="field1"><span>Email <span class="required">*</span></span>
      <input name="mailI" type="mail" class="input-field"  value="" />
    </label>
    <label for="field1"><span>Nom <span class="required">*</span></span>
      <input name="nomI" type="text" class="input-field"  value="" />
    </label>
    <label for="field1"><span>Prénom <span class="required">*</span></span>
      <input name="prenomI" type="text" class="input-field"  value="" />
    </label>
    <label for="field2"><span>Mot de passe <span class="required">*</span></span>
      <input name="mdpI" type="password" class="input-field"  value="" />
    </label>
    <label for="field2"><span>Confimation mot de passe <span class="required">*</span></span>
      <input   name="mdpconfirmI" type="password" class="input-field" value="" />
    </label>
    <label><span> </span>
      <input type="submit" value="Inscription" />
    </label>
  </form>
</div>
<?php
}
if ( $connected == true ) {
  ?>
<div class="contenaire">
  <h3 class="canCLick">Profil</h3>
  <p class="canCLick">Vous êtes connecté en tant que <?php echo($_SESSION[ 'name' ]);?> </p>
		<form method="POST" id="connexion" class="form-style-2 invisible">
			<br>
			<p>Vous pouvez ajouter une photo de profil en faisant "copier l'adresse de l'image" et en collant ici :</p>
			<br>
    <label for="field1"><span>Url de l'image <span class="required">*</span></span>
      <input type="text" class="input-field" id="pdp" name="pdp" value="" />
    </label>
    <label><span> </span>
      <input type="submit" value="poster !" />
    </label>
  </form>
</div>
<?php
}
?>
<div class="contenaire">
  <h3 class="canCLick">Note COVID-19</h3>
  <br>
  <p class="canCLick">Comme vous le savez, l'établissement est actuellement fermé toutes les informations sur <a href="https://www.education.gouv.fr/coronavirus-covid-19-note-aux-redactions-289400">ce lien !</a></p>
  <p class="invisible"><br>
    "Selon l’évolution du contexte sanitaire, l’autorité préfectorale compétente pourra décider de l’éventuelle fermeture d’écoles ou d’établissements scolaires pendant une durée définie en fonction de la situation. Le directeur d’école ou le chef d’établissement concerné veillera à informer, aussitôt que possible, les familles des modalités de continuité pédagogique."</p>
</div>
	
		
	<h2>DERNIERS COMMENTAIRES :</h2>
<div class="contenaire">
	
	<?php
// On récupère tout le contenu de la table jeux_video
$reponse = $bdd->query('SELECT * FROM comment  ORDER BY date DESC LIMIT 0, 5');
$count = 0;
// On affiche chaque entrée une à une
while ($donnees = $reponse->fetch())
{
			if($count != 0){
				echo('<hr>');
			}
	$count++;
// On récupère tout le contenu de la table jeux_video
$reponse2 = $bdd->query('SELECT * FROM membres WHERE id_membres = "'.$donnees['id'].'"');

// On affiche chaque entrée une à une
while ($donnees2 = $reponse2->fetch())
{
	if($donnees2['pdp'] != null){
		$pdpUrl = $donnees2['pdp'] ;
	}
	
?>
    <div class="profilContenaire">
			<div style="background-image: url('<?php echo($pdpUrl); ?>')" class="profil"></div>

			<div class="text">
				<h3><?php echo($donnees2['prenom']." ".$donnees2['nom']); ?></h3>
				<p class="subtitle"><?php echo($donnees['date']) ?></p>
				<p><?php echo($donnees['comment']) ?></p>
			</div>
		</div>
	
	<?php
	}
}
$reponse->closeCursor(); // Termine le traitement de la requête

?>
	

		
		
	</div>
	<?php
if ( $connected == true ) {
  ?>
<div class="contenaire"><h3 class="canCLick">Poster un commentaire : </h3>
	<form method="POST" id="connexion" class="form-style-2 ">
    <label for="field1"><span>Commentaire <span class="required">*</span></span>
      <input type="mail" class="input-field" id="comment" name="comment" value="" />
    </label>
    <label><span> </span>
      <input type="submit" value="poster !" />
    </label>
  </form>
	</div>
	<?php }?>
<div class="contenaire"><h3 class="canCLick">Le Menu</h3><p class="invisible"><br> INDISPONIBLE</p></div>
<div class="contenaire"><h3 class="canCLick">Signaler un problème</h3><p class="invisible"><br> INDISPONIBLE (oui c'est con)</p></div>
<div class="contenaire">
	<h3 class="canCLick">Une idée ?</h3>	
</div>
	
<footer>Application lycéenne</footer>
<script  src="./script.js"></script>
</body>
</html>
