<div class="sign-up-modal">

<?php
include("include.php");
mb_internal_encoding('UTF-8');
setlocale(LC_CTYPE, 'fr_FR.UTF-8');
header('Content-type: text/html; charset=UTF-8'); 
$requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
$requser->execute(array($_SESSION['id']));
$user = $requser->fetch();


echo("<center><h2>Prêt à tchatcher ? voici : <strong>".$user['mail']."</strong></h2></center><br>");
$pdp = $user['pdp'];
$classe = $user['division'];
$devise = $user['devise'];
if($pdp == ""){
    $pdp = "https://scontent-mad1-1.cdninstagram.com/v/t51.2885-19/57506345_447552312657086_8156245888419758080_n.jpg?_nc_ht=scontent-mad1-1.cdninstagram.com&_nc_ohc=4K0PR3ZgnFEAX8As4S8&oh=be3b99af69845afd4d58524f94967dcb&oe=5E929336";
}
echo("<center><img class='avatar1' src='".$pdp."'></center>");
?>
<img class="icon" style="margin-right:200px;" src="https://cdn4.iconfinder.com/data/icons/defaulticon/icons/png/256x256/no.png">
<img class="icon" src="https://cdn2.iconfinder.com/data/icons/pittogrammi/142/80-512.png">


</div>