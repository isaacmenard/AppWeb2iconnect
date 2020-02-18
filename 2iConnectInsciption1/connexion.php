<?php
session_start();
$_SESSION = array();
session_destroy();

session_start();
include("include.php");
if (isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

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
            header('Location: espacemembre.php');
            echo "<script>window.location.replace('espacemembre.php');</script><p>Connexion en cours</p>";
            exit;
        } else {
            $fail = TRUE;
        }
    } else {
        $fail = TRUE;
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
                                        <h1 class="black-text">Connexion</h1>
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
        <?php
            if ($fail) {
                echo '<span style="color:red">Aucun utilisateur ne correspond &agrave; ce couple login/mot de passe.</span>';}
        ?>

		<form class="details" id="form" method="POST"><br/>
                <div class="auto-style1">
                    <label id="Label1">E-mail<br />
                    <input class="auto-style1" id="mail" name="mail" placeholder="E-mail" style="width: 300px" type="text" value="<?php if (array_key_exists('mail', $_POST)) echo htmlspecialchars($_POST['mail']); ?>" required/><br />
                    <br />
                    <label id="Label1">Mot de passe<br />
                     <input class="auto-style1" name="password" id="password" style="width: 300px" type="password" placeholder="Mot de passe " required/></label><br />
                    <br />
						<label>
								<input type="checkbox" value="true"> Gardez-moi connect&eacute; !</label><br />
                <br />
				<input id="submit" type="submit" value="Connexion !">
                <br /><br />
				<p>Vous n'avez pas de compte ? <a href="inscription.php">Inscription</a></p>
            </div>
		</form>
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
                        <br/><br/><br/><br/><br/><br/>
       <?php include('footer.php') ?>


	
	
	