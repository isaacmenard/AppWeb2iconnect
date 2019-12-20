<?php
  include("include.php");
  session_start();
  include("header.php")
?>






<body>
  <?php 
    if(isset($_SESSION['id'])) {
      $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
      $requser->execute(array($_SESSION['id']));
      $user = $requser->fetch();
      echo("bienvenue <strong>".$user['mail']."</strong>");
    }else{
      echo("veuillez vous connecter");
    }
  ?>
</body>


<?php
  include("footer.php")
?>