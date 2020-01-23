<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" xml:lang="fr" dir="ltr">
  <head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png/gif" href="gif.gif" />
    <title>Page de test</title>
    <meta charset="utf-8">
</head>

<body>
        <?php
        session_start();
        require 'connexion_bdd.php';

        $user=$_POST["user"];
        $pass=$_POST["pass"];

        $pdo_options=array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        if($user!="" && $pass!="" )
        {
          $bdd = new PDO($dsn,$login,$mdp,$pdo_options);
          $query = $bdd->prepare("SELECT * FROM `membres` WHERE pseudo= ? AND pass= ?");
          $query->execute(array($user,$pass));
          $count= $query->rowCount();

        if($count==1)
        {
          $userinfo = $query->fetch();
          $_SESSION['id_m']=$userinfo['id_m'];
          $_SESSION['id']=$userinfo['id_g'];
          $_SESSION['pseudo']=$userinfo['pseudo'];
          $_SESSION['email']=$userinfo['email'];
          $msg="Vous êtes conecté en tant que :'".$_SESSION['pseudo']."'";
       }
          if($_SESSION['id'] == 1)
          {
            header("Location:admin.php?id=".$userinfo['id_g']);
          }
          if($_SESSION['id'] == 2)
          {
            header("Location:user.php?id=".$userinfo['id_g']);
          }
      }
      if($_SESSION['id']!=1 && $_SESSION['id']!=2) {
        header("Location:index.php");
      }
        ?>
</body>
</html>
