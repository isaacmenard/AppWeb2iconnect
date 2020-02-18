<?php  
include("include.php")
?>
<link rel="stylesheet" href="style.css">
<?php
session_start();
if(isset($_SESSION['id'])){
	header('Location:connexion.php');
	exit;
}

const MIN_PSEUDO_LEN = 3;
const MAX_PSEUDO_LEN = 80;
const MIN_PASSWORD_LEN = 6;
ini_set('display_errors','on');
error_reporting(E_ALL);
$errors = [];
mb_internal_encoding('UTF-8');
if ('POST' == $_SERVER['REQUEST_METHOD']) {

    if (array_key_exists('mail', $_POST)) {
        
            $stmt = $bdd->prepare('SELECT 1 FROM membres WHERE mail = :mail');
            $stmt->execute(['mail' => $_POST['mail']]);
            if (FALSE !== $stmt->fetchColumn()) {
                $errors['mail'] = "Ce mail est d&eacute;j&agrave; utilis&eacute;";
            }
            
	} else {
		$errors['mail'] = "mail est absent";
	}
	
    if (!array_key_exists('prenom', $_POST)) {
		$errors['prenom'] = "Prénom est absent";
	}
	if (!array_key_exists('nom', $_POST)) {
		$errors['nom'] = "Nom est absent";
	}
	if(array_key_exists('mdp', $_POST)){
		$mdp_length = mb_strlen($_POST['mdp']);
		if ($mdp_length < MIN_PASSWORD_LEN){
			$errors['mdp'] = sprintf("La longueur du mot de passe doit 	&ecirc;tre d'au moins %d carat&egrave;res", MIN_PASSWORD_LEN);
		}
		if($_POST['mdp'] != $_POST['mdpconfirm']){
			$errors['mdpconfirm'] = "Le mot de passe et sa confirmation ne co&iuml;cident pas";
		}
    } else {
        $errors['mdp'] = "mot de passe est absent";
    }

    if (!$errors) {
        $insert = $bdd->prepare('INSERT INTO membres( mail,mot_de_passe,nom,prenom) VALUES(:mail, :mdp,:nom,:prenom)');
        $insert->execute([ 'mail' => strip_tags(['mail']),  'mdp' => password_hash($_POST['mdp'], $password_options['algo'], $password_options['options']),'nom' => strip_tags($_POST['nom']),'prenom' => strip_tags($_POST['prenom'])]);
       $fail = FALSE;
if ('POST' == $_SERVER['REQUEST_METHOD']) {

    $stmt = $bdd->prepare('SELECT * FROM membres WHERE mail = :mail');
    $stmt->execute(['mail' => $_POST['mail']]);
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (password_verify($_POST['mdp'], $row['mot_de_passe'])) {
            $_SESSION['id'] = $row['id'];
            if (password_needs_rehash($row['mot_de_passe'], $password_options['algo'], $password_options['options'])) {
                $stmt = $bdd->prepare('UPDATE membres SET mot_de_passe = :new_hash WHERE id = :id');
                $stmt->execute(['id' => $row['id'], 'new_hash' => password_hash($_POST['password'], $password_options['algo'], $password_options['options'])]);
            }
            header('Location: connexion.php');
            echo "<script>window.location.replace('connexion.php');</script><p>connexion</p>";
            exit;
        } else {
            $fail = TRUE;
        }
    } else {
        $fail = TRUE;
    }
}
		
    }
}
?>
<?php include('header.php') ?>
		<div class="home-wrapper">
			<div class="container">
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<div class ="middle">
							<div class="home-content">
									<br />
									<br />
									<div>
										<h1 class="black-text">Inscription</h1>
										<h3 class="black-text">Pour acc&eacute;der &agrave; la platforme de signalisation.</h3>
										<br/>
									</div>
							</div>
						</div>
					</div>
				</div>
			</div>	
		</div>	
<div class="aligncenter">
	<div class="sign-up-modal">
		<div id="close-modal-button">
		</div>

		<div class="logo-container">
        <?php
            if ($errors) {
                echo '<div class="box"><span class="botton1 bottonError1" class="red">Veuillez corriger les erreurs ci-dessous afin de finaliser votre inscription :</span><span class="red" class="botton2 bottonError"><ul><li>', implode('</li><li>', $errors), '</li></ul></span></div>';
            }
        ?>
		</div>
		<br />
	<form method="POST" id="form">		<!-- Création d'un formulaire donc POST est le script à charger, action est le fichier php de notre formulaire, ainsi que autocomplete permet de préremplir automatiquement les données de l'utilisateur.--> 
	<div><h4 class="auto-style1">Email (@lp2i-poitiers.fr)</h4>
	<div class="auto-style1">
		<input name="Hidden1" type="hidden" />
		<input class="nouveauStyle1" type="email" id="mail" name="mail" placeholder="Mail" pattern=".+@lp2i-poitiers.fr" required style="width:300px" value="<?php if (array_key_exists('mail', $_POST)) echo htmlspecialchars($_POST['mail']); ?>" required/></div>
	<h2></h2>
		<div><h4 class="auto-style1">Prénom - Nom</h4>
	<div class="auto-style1">
		<input name="Hidden1" type="hidden" />
		<input class="nouveauStyle1" type="text" id="prenom" name="prenom" placeholder="Prénom"  required style="width:300px" value="<?php if (array_key_exists('prenom', $_POST)) echo htmlspecialchars($_POST['prenom']); ?>" required/></div>
			<input class="nouveauStyle1" type="text" id="nom" name="nom" placeholder="Nom"  required style="width:300px" value="<?php if (array_key_exists('nom', $_POST)) echo htmlspecialchars($_POST['nom']); ?>" required/></div>
	<h2></h2>
	<h4 class="auto-style1">Mot de passe</h4>
	<div class="auto-style1">
		<input class="auto-style2" type="password" name="mdp" placeholder="Mot de passe" required="required" style="width: 300px"/></div>
	<h2></h2>
	<h4 class="auto-style1">Confirmation mot de passe</h4>
	<div class="auto-style1">
		<input class="nouveauStyle1" type="password" name="mdpconfirm" placeholder="Confirmation Mot de passe" required="required" style="width: 300px"/><br />
	</div><br />
	<div class="black-text"><h4><p class = "keeplogin" ><input  type = "checkbox"  name = "souvenir"  id = "loginkeeping"  value = "loginkeeping"><label id="loginkeeping" for ="loginkeeping">&nbsp;&nbsp;Gardez-moi connect&eacute;</h4></label>
	</div>
	<br />
	<p class="auto-style1">
	<input class="auto-style2" style="width: 130px" type="submit" value="Je m'inscris " /></p>
	</form><br />
</div>
<script>
function app_sel(valeur) { // Le param valeur servira à savoir <uel select afficher
 var sels = document.getElementById("select2").getElementsByTagName("select"); // On récupère tous les selects dans le span id="select2"
 for(var i=0,l=sels.length;i<l;i++) { // Et on les cache tous
  sels[i].style.display = "none";
}
 document.getElementById("select2"+valeur).style.display = "inline"; // pour n'afficher finalement que celui qu'on veut.
}
</script>
						<br/><br/><br/>
		<!-- /home wrapper -->
	<?php include('footer.php') ?>