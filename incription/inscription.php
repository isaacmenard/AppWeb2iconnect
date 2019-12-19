
<?php
include("include.php");
?>
<link rel="stylesheet" href="styles.css">
<?php
session_start();
if (isset($_SESSION['id'])) {
    header('Location: accueil.php');
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
                $errors['mail'] = "Ce mail est d�j� utilis�";
            }
            
    } else {
        $errors['mail'] = "mail est absent";
    }
    if (array_key_exists('mdp', $_POST)) {
        $mdp_length = mb_strlen($_POST['mdp']);
        if ($mdp_length < MIN_PASSWORD_LEN) {
            $errors['mdp'] = sprintf("La longueur du mot de passe doit �tre d'au moins %d caract�res", MIN_PASSWORD_LEN);
        }
        if ($_POST['mdp'] != $_POST['mdpconfirm']) {
            $errors['mdpconfirm'] = "Le mot de passe et sa confirmation ne co�ncident pas";
        }
    } else {
        $errors['mdp'] = "mot de passe est absent";
    }

    if (!$errors) {
        $insert = $bdd->prepare('INSERT INTO membres( mail,mot_de_passe) VALUES(:mail, :mdp)');
        $insert->execute([ 'mail' => $_POST['mail'],  'mdp' => password_hash($_POST['mdp'], $password_options['algo'], $password_options['options'])]);
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
            header('Location: 2iconnect');
            echo "<script>window.location.replace('2iconnect');</script><p>connexion</p>";
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


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    
    <br>
<br>
<div class="sign-up-modal">
		<div id="close-modal-button">
		</div>

		<div class="logo-container">
        <?php
            if ($errors) {
                echo '<div class="box"><span class="botton1 bottonError1">Veuillez corriger les erreurs ci-dessous afin de finaliser votre inscription :</span><span class="botton2 bottonError"><ul><li>', implode('</li><li>', $errors), '</li></ul></span></div>';
            }
        ?>
		</div>

		<form class="details" id="form" method="POST">
				<div class="input-container mail">
                    <input class="col-sm-5 username-input with-placeholder noBorder" type="text" id="mail" name="mail" placeholder="Mail" value="<?php if (array_key_exists('mail', $_POST)) echo htmlspecialchars($_POST['mail']); ?>" required/>
                    <div class="noBorder lp2i">@lp2i-poitiers.fr</div>
                </div>

                
				<div class="input-container">
						<input class="col-sm-5 username-input with-placeholder" name="mdp" id="mdp" type="password" placeholder="Password" required/>
                </div>
                <div class="input-container">
						<input class="col-sm-5  username-input with-placeholder" name="mdpconfirm" id="mdpconfirm" type="password" placeholder="Confirm Password" required/>
				</div>

				<div class="col-sm-12 form-checkbox">
						<label>
								<input type="checkbox" value="true"> Keep me signed in</label>
				</div>

				<input id="submit" type="submit" value="Inscription !">

				<p>Vous avez déjà un compte ? <a href="Connexion">Connexion</a></p>

		</form>
</div>
</body>

</html>