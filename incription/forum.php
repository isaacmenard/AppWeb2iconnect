<?php
  include("include.php");
  $sujet = $_GET['sujet'];
  session_start();
  include("header.php");
?>
<h1><?php echo($sujet);?> !</h1>
<?php 
mb_internal_encoding('UTF-8');
setlocale(LC_CTYPE, 'fr_FR.UTF-8');
header('Content-type: text/html; charset=UTF-8'); 
    if(isset($_SESSION['id'])) {
        $fail = FALSE;
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            if(array_key_exists('Question', $_POST) && array_key_exists('sujet', $_POST) ){
                $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
                $requser->execute(array($_SESSION['id']));
                $user = $requser->fetch();

                $insert = $bdd->prepare('INSERT INTO forumQuestion( user,Repertoire,Titre,Question) VALUES(:mail, :Repertoire, :Titre, :Question)');
                $insert->execute([ 'mail' => $user['mail'],  'Repertoire' => $sujet, 'Titre' => $_POST['Question'], 'Question' =>  $_POST['sujet']]);
            }else{
                echo("<script> alert('veuillez compléter tous les champs') </script>");
            }
        }
    ?>
      <div class="sign-up-modal">
        <form class="details" id="form" method="POST">
                <div class="input-container">
                    <input class="col-sm-5 smallInput username-input with-placeholder" type="text" id="Question" name="Question" placeholder="Titre de votre question" value="" />
			        	</div>
                <div class="input-container">
                <input class="col-sm-5 smallInput username-input with-placeholder" type="text" id="sujet" name="sujet" placeholder="description détaillé" value="" />
			    </div>
                <div class="input-container">
				        <input id="submit" type="submit" value="Valider !">
         </form>
    </div>
        <?php
    }else{
      echo("veuillez vous connecter");
    }

?></div>

<div  class="sign-up-modal textBlablacar">
<?php
// On récupère tout le contenu de la table jeux_video
$reponse = $bdd->query('SELECT * FROM forumQuestion WHERE Repertoire = "'.$sujet.'"');

// On affiche chaque entrée une à une
while ($donnees = $reponse->fetch())
{
?>
    <p>
    <a style="text-decoration:none;" href="forumReponse.php?titre=<?php echo $donnees['Titre']; ?>">
        <strong><?php echo $donnees['user']; ?></strong> dit :<br />
        <strong><?php echo $donnees['Titre']; ?></strong><br />
    </a>
   </p>
<?php
}

$reponse->closeCursor(); // Termine le traitement de la requête
?>

</div>