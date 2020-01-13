<?php
  include("include.php");
  $sujet = $_GET['titre'];
  session_start();
  include("header.php");
?>
<h1><?php echo($sujet);?> !</h1>
<a href="accueil.php">retour</a>
<?php 
mb_internal_encoding('UTF-8');
setlocale(LC_CTYPE, 'fr_FR.UTF-8');
header('Content-type: text/html; charset=UTF-8'); 
    if(isset($_SESSION['id'])) {
        ?>
      <div class="sign-up-modal">
        <form class="details" id="form" method="POST">
        <?php
// On récupère tout le contenu de la table jeux_video
$reponse = $bdd->query('SELECT * FROM forumQuestion WHERE Titre="'.$sujet.'"');

// On affiche chaque entrée une à une
while ($donnees = $reponse->fetch())
{
?>
    <p>
        <strong><?php echo $donnees['user']; ?></strong> dit :<br />
        <strong><?php echo $donnees['Titre']; ?></strong><br />
        <?php echo $donnees['Question']; ?><br />
   </p>
<?php
}

$reponse->closeCursor(); // Termine le traitement de la requête
?>

                <div class="input-container">
                    <input class="col-sm-5 smallInput username-input with-placeholder" type="text" id="repondre" name="repondre" placeholder="Votre réponse" value="" />
			        	</div>
                <div class="input-container">
				        <input id="submit" type="submit" value="Valider !">
         </form>
    </div>
        <?php
        $fail = FALSE;
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            if(array_key_exists('repondre', $_POST) ){
                $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
                $requser->execute(array($_SESSION['id']));
                $user = $requser->fetch();

                $insert = $bdd->prepare('INSERT INTO forumReponse( user,titre,reponse) VALUES(:mail, :Titre, :reponse)');
                $insert->execute([ 'mail' => $user['mail'],  'Titre' => $sujet, 'reponse' =>  $_POST['repondre']]);
            }else{
                echo("<script> alert('veuillez compléter tous les champs') </script>");
            }
        }
    
    }else{
      echo("veuillez vous connecter");
    }

?></div>

<div  class="sign-up-modal textBlablacar">
<?php
// On récupère tout le contenu de la table jeux_video
$reponse = $bdd->query('SELECT * FROM forumReponse WHERE titre="'.$sujet.'"');

// On affiche chaque entrée une à une
while ($donnees = $reponse->fetch())
{
?>
    <p>
        <strong><?php echo $donnees['user']; ?></strong> répond :<br />
        <?php echo $donnees['reponse']; ?><br />
   </p>
<?php
}

$reponse->closeCursor(); // Termine le traitement de la requête
?>

</div>