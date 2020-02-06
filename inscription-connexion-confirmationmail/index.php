<?php
try
{
$bdd = new PDO('mysql:host=127.10.0.3;dbname=espace_membre', 'root', '');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
if(isset($_POST['forminscription'])) {
   $nom = strip_tags(htmlspecialchars($_POST['nom']));
   $prenom = strip_tags(htmlspecialchars($_POST['prenom']));
   $mail = strip_tags(htmlspecialchars($_POST['mail']));
   $mail2 = strip_tags(htmlspecialchars($_POST['mail2']));
   $mdp = strip_tags(sha1($_POST['mdp']));
   $mdp2 = strip_tags(sha1($_POST['mdp2']));
   if(!empty($_POST['nom']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])) {
      $nomlength = strlen($nom);
      $prenomlength = strlen($prenom);
      if($nomlength <= 255) {
         if($mail == $mail2) {
            if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
               $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");
               $reqmail->execute(array($mail));
               $mailexist = $reqmail->rowCount();
               if($mailexist == 0) {
                  if($mdp == $mdp2) {
                     $longueurKey = 15;
                     $key = "";
                     for($i=1;$i<$longueurKey;$i++) {
                        $key .= mt_rand(0,9);
                     }
					  
                     $insert = $bdd->prepare("INSERT INTO membres(nom, prenom, mail, motdepasse, confirmkey, uniqid) VALUES(:nom, :prenom, :mail, :motdepasse, :confirmkey, :uniqid)");

                     $insert->execute([ 'nom' => $nom,  'prenom' => $prenom,'mail' => $mail,'motdepasse' => $mdp,'confirmkey' => 0,'uniqid' => uniqid()]);
					
					  
                     $header="MIME-Version: 1.0\r\n";
                     $header.='From:"2iConnect.fr"<2iconnect.lp2i@gmail.com>'."\n";
                     $header.='Content-Type:text/html; charset="uft-8"'."\n";
                     $header.='Content-Transfer-Encoding: 8bit';
                     $message='
                     <html>
                        <body>
                           <div align="center">
                              <a href="http://127.10.0.3/confirmation.php?nom='.urlencode($nom).'&key='.$key.'">Confirmez votre compte !</a>
                           </div>
                        </body>
                     </html>
                     ';
                     mail($mail, "Confirmation de compte", $message, $header);
                     $erreur = "Votre compte a bien été créé ! <a href=\"connexion.php\">Me connecter</a>";
                  } else {
                     $erreur = "Vos mots de passes ne correspondent pas !";
                  }
               } else {
                  $erreur = "Adresse mail déjà utilisée !";
               }
            } else {
               $erreur = "Votre adresse mail n'est pas valide !";
            }
         } else {
            $erreur = "Vos adresses mail ne correspondent pas !";
         }
      } else {
         $erreur = "Votre nom ne doit pas dépasser 255 caractères !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
}
?>
<html>
   <head>
      <title>TUTO PHP</title>
      <meta charset="utf-8">
   </head>
   <body>
      <div align="center">
         <h2>Inscription</h2>
         <br /><br />
         <form method="POST" action="">
            <table>
               <tr>
                  <td align="right">
                     <label for="prenom">Prenom :</label>
                  </td>
                  <td>
                     <input type="text" placeholder="Votre prenom" id="prenom" name="prenom" value="<?php if(isset($prenom)) { echo $prenom; } ?>" />
                  </td>
               </tr>
               <tr>
                  <td align="right">
                     <label for="nom">Nom :</label>
                  </td>
                  <td>
                     <input type="text" placeholder="Votre nom" id="nom" name="nom" value="<?php if(isset($nom)) { echo $nom; } ?>" />
                  </td>
               </tr>
               <tr>
                  <td align="right">
                     <label for="mail">Mail :</label>
                  </td>
                  <td>
                     <input type="email" placeholder="Votre mail" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>" />
                  </td>
               </tr>
               <tr>
                  <td align="right">
                     <label for="mail2">Confirmation du mail :</label>
                  </td>
                  <td>
                     <input type="email" placeholder="Confirmez votre mail" id="mail2" name="mail2" value="<?php if(isset($mail2)) { echo $mail2; } ?>" />
                  </td>
               </tr>
               <tr>
                  <td align="right">
                     <label for="mdp">Mot de passe :</label>
                  </td>
                  <td>
                     <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp" />
                  </td>
               </tr>
               <tr>
                  <td align="right">
                     <label for="mdp2">Confirmation du mot de passe :</label>
                  </td>
                  <td>
                     <input type="password" placeholder="Confirmez votre mdp" id="mdp2" name="mdp2" />
                  </td>
               </tr>
               <tr>
                  <td></td>
                  <td align="center">
                     <br />
                     <input type="submit" name="forminscription" value="Je m'inscris" />
                  </td>
               </tr>
            </table>
         </form>
         <?php
         if(isset($erreur))
         {
            echo '<font color="red">'.$erreur."</font>";
         }
         ?>
      </div>
   </body>
</html>