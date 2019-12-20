<?php
session_start();
$_SESSION = array();
session_destroy();
session_start();
include("include.php");


$fail = FALSE;
if ('POST' == $_SERVER['REQUEST_METHOD']) {

    $stmt = $bdd->prepare('SELECT * FROM membres WHERE mail = :mail');
    $stmt->execute(['mail' => $_POST['mail']]);
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (password_verify($_POST['password'], $row['mot_de_passe'])) {
            $_SESSION['id'] = $row['id'];
            if (password_needs_rehash($row['mot_de_passe'], $password_options['algo'], $password_options['options'])) {
                $stmt = $bdd->prepare('UPDATE membres SET mot_de_passe = :new_hash WHERE id = :id');
                $stmt->execute(['id' => $row['id'], 'new_hash' => password_hash($_POST['password'], $password_options['algo'], $password_options['options'])]);
            }
            header('Location: accueil.php');
            exit;
        } else {
            $fail = TRUE;
        }
    } else {
        $fail = TRUE;
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
            if ($fail) {
                echo '<div class="box"><span class="botton2  bottonError1">Aucun utilisateur ne correspond à ce couple login/mot de passe.</span></div>';
            }
        ?>
		</div>

		<form class="details" id="form" method="POST">
        <div class="input-container mail">
                    <input class="col-sm-5 username-input with-placeholder noBorder" type="text" id="mail" name="mail" placeholder="Mail" value="<?php if (array_key_exists('mail', $_POST)) echo htmlspecialchars($_POST['mail']); ?>" required/>
                    <div class="noBorder lp2i">@lp2i-poitiers.fr</div>
                </div>
				<div class="input-container">
						<input class="col-sm-5 col-sm-push-2 password-input with-placeholder" name="password" id="password" type="password" placeholder="Password" required/>
				</div>
<!-- 
				<div class="col-sm-12 form-checkbox">
						<label>
								<input type="checkbox" value="true"> Keep me signed in</label>
				</div> -->

				<input id="submit" type="submit" value="Connexion !">

				<p>Vous n'avez pas de compte ? <a href="inscription">Inscription</a></p>

		</form>
</div>
</body>

</html>

