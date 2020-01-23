<?php
echo"<script>document.write('<script src=\"http://' + (location.host || '127.10.0.1').split(':')[0] + ':35729/livereload.js?snipver=1\"></' + 'script>')</script>";
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

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" xml:lang="fr" dir="ltr">
<head>
<link rel="icon" href="logo.ico" />
    <meta http-equiv="Content-Type" content="text/html;
        charset=utf-8" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    


    <title>2iConnect - Connexion</title>
    <meta name="description" content="Pour accéder à la platforme de signalisation">
    <meta content=">> 2iConnect <<" property="og:title">    
    <link href="#" rel="canonical">
 
    <meta content="2iConnect est une application lycéenne pour simpliefier la vie au lycée" property="og:description">
    <meta content="#" property="og:url">
    <meta content="2iConnect" property="og:site_name">
    <meta content="website" property="og:type">
    <meta content="" property="og:image">
    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700%7CVarela+Round" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <!-- Owl Carousel -->
    <link href="css/owl.carousel.css" rel="stylesheet" type="text/css">
    <link href="css/owl.theme.default.css" rel="stylesheet" type="text/css">

    <!-- Magnific Popup -->
    <link href="css/magnific-popup.css" rel="stylesheet" type="text/css">

    <!-- Font Awesome Icon -->
    <link href="css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom stlylesheet -->
    <link href="css/style.css" rel="stylesheet" type="text/css">

</head>
<body>
<!-- Header -->
    <header id="connexion.html">
        <!-- Background Image -->
        <div class="bg-img" style="background-image: url('./img/background1.jpg');">
            <div class="overlay"></div>
        </div>
        <!-- /Background Image -->

        <!-- Nav -->
        <nav id="nav" class="navbar nav-transparent">   
            <div class="container">

                <div class="navbar-header">
                    <!-- Logo -->
                    <div class="navbar-brand">
                        <a href="#">
                            <img class="logo" src="img/logo.png" alt="logo">
                            <img class="logo-alt" src="img/logo.png" alt="logo" >
                            
                        </a>
                        
                    </div>
                    <!-- /Logo -->

                    <!-- Collapse nav button -->
                    <div class="nav-collapse">
                        <span></span>
                    </div>
                    <!-- /Collapse nav button -->
                </div>

                <!--  Main navigation  -->
                <ul class="main-nav nav navbar-nav navbar-right">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="Infos.php">Infos</a></li>
                    <li><a href="Contact.php">Contact</a></li>
                    <li><a href="espace_de_connexion_inscription.php">Espace Membre</a></li>
                </ul>
            </div>
        </nav>
    </header>
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
        <!-- /home wrapper -->
    <header id="footer" class="sm-padding bg-grey">

        <!-- Container -->
        <div class="container">

            <!-- Row -->
            <div class="row">

                <div class="col-md-12">

                    <!-- footer logo -->
                    <div class="footer-logo">
                        <a href="http://www.lp2i-poitiers.fr/" target="_blank"><img src="img/lp2i.png" alt="logo"></a>
                    </div>
                    <!-- /footer logo -->



                    <!-- footer copyright -->
                    <div class="footer-copyright">
                        <p>Copyright © 2019. 2iConnect - Tout droits réservés</p><br/>
            
                    </div>
                    <!-- /footer copyright -->
                </div>
               
            </div>
            <!-- /Row -->

        </div>
        <!-- /Container -->

    </header>
    <!-- /Footer -->

    <!-- Back to top -->
    <div id="back-to-top"></div>
    <!-- /Back to top -->

    <!-- Preloader -->
    <div id="preloader">
        <div class="preloader">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <!-- /Preloader -->

    <!-- jQuery Plugins -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.magnific-popup.js"></script>
    <script src="js/main.js"></script>
</body>

</html>

