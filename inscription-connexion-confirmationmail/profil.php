<?php
session_start();

$bdd = new PDO('mysql:host=127.10.0.3;dbname=espace_membre', 'root', '');

if(isset($_GET['id']) AND $_GET['id'] > 0) {
   $getid = intval($_GET['id']);
   $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
   $requser->execute(array($getid));
   $userinfo = $requser->fetch();
?>
<html>
   <head>
      <title>TUTO PHP</title>
      <meta charset="utf-8">
   </head>
   <body>
      <div align="center">
         <br />
         <h2>Profil de <?php echo $userinfo['prenom']; echo'&nbsp;'; echo $userinfo['nom']; ?></h2>
         <br /><br />
         <?php
         if(!empty($userinfo['avatar']))
         {
         ?>
         <img src="membres/avatars/<?php echo $userinfo['avatar']; ?>" width="150" />
         <?php
         }
         ?>
         <br /><br />
         Prenom = <?php echo $userinfo['prenom']; ?>
         <br />
         Nom = <?php echo $userinfo['nom']; ?>
         <br />
         Mail = <?php echo $userinfo['mail']; ?>
         <br />
         <?php
         if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) {
         ?>
         <br />
         <a href="editionprofil.php">Editer mon profil</a>
         <a href="deconnexion.php">Se déconnecter</a>
         <?php
         }
         ?>
      </div>
   </body>
</html>
<?php   
}
?>