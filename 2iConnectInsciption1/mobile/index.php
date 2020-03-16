<?php
include("../include.php");
session_start();
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
      if ( password_needs_rehash( $row[ 'mot_de_passe' ], $password_options[ 'algo' ], $password_options[ 'options' ] ) ) {
        $stmt = $bdd->prepare( 'UPDATE membres SET mot_de_passe = :new_hash WHERE id = :id' );
        $stmt->execute( [ 'id' => $row[ 'id' ], 'new_hash' => password_hash( $_POST[ 'mdp' ], $password_options[ 'algo' ], $password_options[ 'options' ] ) ] );
      }

    } else {
      $fail = TRUE;
    }
  } else {
    $fail = TRUE;
  }
}
}

if ( 'POST' == $_SERVER[ 'REQUEST_METHOD' ] ) {
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
            $_SESSION['id'] = $row['id'];
			$_SESSION['name'] = $row['prenom'];
			$_SESSION['statue'] = true;
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
</head>
<body>
<header>
  <h1>2ICONNECT</h1>
</header>
<div class="contenaire">
  <h2 id="messageBonjour">Good Morning !</h2>
  <h2 id="hour">0 h 00</h2>
  <p class="invisible">{pseudo}</p>
</div>
<?php
if ( $connected == false ) {
  ?>
<div class="contenaire">
  <h3>Connexion</h3>
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
  <h3>Inscription</h3>
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
  <h3>Profil</h3>
  <p>Vous êtes connecté en tant que <?php echo($_SESSION[ 'name' ]);?> </p>
</div>
<?php
}
?>
<div class="contenaire">
  <h3>Note COVID-19</h3>
  <br>
  <p>Comme vous le savez, l'établissement est actuellement fermé toutes les informations sur <a href="https://www.education.gouv.fr/coronavirus-covid-19-note-aux-redactions-289400">ce lien !</a></p>
  <p class="invisible"><br>
    "Selon l’évolution du contexte sanitaire, l’autorité préfectorale compétente pourra décider de l’éventuelle fermeture d’écoles ou d’établissements scolaires pendant une durée définie en fonction de la situation. Le directeur d’école ou le chef d’établissement concerné veillera à informer, aussitôt que possible, les familles des modalités de continuité pédagogique."</p>
</div>
<div class="contenaire">Le Menu</div>
<div class="contenaire">Signaler un problème</div>
<div class="contenaire">liste du personnel</div>
<footer>Application lycéenne</footer>
<script  src="./script.js"></script>
</body>
</html>
