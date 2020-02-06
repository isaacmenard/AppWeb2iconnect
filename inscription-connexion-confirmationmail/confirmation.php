 <?php
$bdd = new PDO('mysql:host=127.10.0.3;dbname=espace_membre', 'root', '');

if(isset($_GET['nom'], $_GET['key']) AND !empty($_GET['nom']) AND !empty($_GET['key'])) {
   $nom = htmlspecialchars(urldecode($_GET['nom']));
   $key = htmlspecialchars($_GET['key']);
   $requser = $bdd->prepare("SELECT * FROM membres WHERE nom = ? AND confirmkey = ?");
   $requser->execute(array($nom, $key));
   $userexist = $requser->rowCount();
   if($userexist == 1) {
      $user = $requser->fetch();
      if($user['confirme'] == 0) {
         $updateuser = $bdd->prepare("UPDATE membres SET confirme = 1 WHERE nom = ? AND confirmkey = ?");
         $updateuser->execute(array($nom,$key));
         echo "Votre compte a bien été confirmé !";
      } else {
         echo "Votre compte a déjà été confirmé !";
      }
   } else {
      echo "L'utilisateur n'existe pas !";
   }
}
?>