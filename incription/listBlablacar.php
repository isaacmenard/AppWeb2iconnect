<?php
  include("include.php");
?>
<h1>BlaBla2i !</h1>
<?php 
mb_internal_encoding('UTF-8');
setlocale(LC_CTYPE, 'fr_FR.UTF-8');
header('Content-type: text/html; charset=UTF-8'); 
    if(isset($_SESSION['id'])) {
        $fail = FALSE;
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            if(array_key_exists('type', $_POST) && array_key_exists('heure', $_POST) && array_key_exists('lieu', $_POST)){
                $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
                $requser->execute(array($_SESSION['id']));
                $user = $requser->fetch();

                $insert = $bdd->prepare('INSERT INTO blablacar( email,lieu,type,heure) VALUES(:mail, :lieu, :types, :heure)');
                $insert->execute([ 'mail' => $user['mail'],  'lieu' => $_POST['lieu'], 'types' => $_POST['type'], 'heure' =>  $_POST['heure']]);
            }else{
                echo("<script> alert('veuillez compléter tous les champs') </script>");
            }
        }
    ?>
      <div class="sign-up-modal">
        <form class="details" id="form" method="POST">
                <div class="input-container">
                    <input class="col-sm-5 smallInput username-input with-placeholder" type="text" id="lieu" name="lieu" placeholder="Ville" value="" />
			        	</div>
                <div class="input-container">
                <input class="col-sm-5 smallInput username-input with-placeholder" type="text" id="type" name="type" placeholder="Quel moyen de transport ?" value="" />
			    </div>
                <div class="input-container">
                    <label >Vers quelle heure ?</label>
                    <input class="col-sm-5 smallInput username-input with-placeholder" type="time" id="heure" name="heure" placeholder="Heure de départ" value="" />
			    </div>
				        <input id="submit" type="submit" value="Valider !">
         </form>
    </div>
        <?php
    }else{
      echo("veuillez vous connecter");
    }

?>

<div  class="sign-up-modal textBlablacar">
<?php
// On récupère tout le contenu de la table jeux_video
$reponse = $bdd->query('SELECT * FROM blablacar ORDER BY id DESC LIMIT 0, 1000');

// On affiche chaque entrée une à une
while ($donnees = $reponse->fetch())
{
?>
    <p>
    <strong><?php echo $donnees['email']; ?></strong> <br />
    fait ses trajets de <strong><?php echo $donnees['lieu']; ?></strong> en <?php echo $donnees['type']; ?> et part de chez lui/elle vers <?php echo $donnees['heure']; ?><br />
   </p>
<?php
}

$reponse->closeCursor(); // Termine le traitement de la requête
?>

</div>