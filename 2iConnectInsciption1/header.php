<?php error_reporting(E_ALL);
ini_set("display_errors", 1);

if (stristr($_SERVER['HTTP_USER_AGENT'], "Android")
   || strpos($_SERVER['HTTP_USER_AGENT'], "iPod")
   || strpos($_SERVER['HTTP_USER_AGENT'], "iPhone") ){
		echo('<script>window.location="mobile/"</script>');	
   }

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" xml:lang="fr" dir="ltr">
<head>
	<META http-equiv="Content-Type" Content="text/html; charset=utf-8">
	<link rel="icon" href="logo.ico" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />

	<title>2iconnect</title>
	<meta name="description" content="2iConnect est une application lycéenne pour simpliefier la vie au lycée">
	<meta content=">> 2iConnect <<" property="og:title">	
	<link href="#" rel="canonical">
 
	<meta content="2iConnect est une application lycéenne pour simplifier la vie au lycée" property="og:description">
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


<script src="https://platform.twitter.com/js/moment~timeline~tweet.ec04a6cb5ba879d0e0db41f211639fdf.js" charset="utf-8"></script>
<script src="https://platform.twitter.com/js/timeline.0a7b4db67eacd23e35c5ce02e6ea3470.js" charset="utf-8"></script>
<script src="https://platform.twitter.com/js/button.d941c9a422e2e3faf474b82a1f39e936.js" charset="utf-8"></script>
</head>
<body>
	<!-- Header -->
	<header id="home">
		<!-- Background Image -->
		<div class="bg-img" style="background-image: url('./img/background15.jpg');">
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
							<img class="logo-alt" src="img/logo.png" alt="logo"	>
							
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
					<li><a href="./">Accueil</a></li>
					<li><a href="Infos">Infos</a></li>
					<li><a href="menu">Menu</a></li>
					<li><a href="Contact">Contact</a></li>
					<li><a href="espace_de_connexion_inscription">Espace Membre</a></li>
					<li><a href="creation_entreprise">Créer un compte entreprise</a></li>
				</ul>
				<!-- /Main navigation -->

			</div>
		</nav>
		<!-- /Nav -->
		
		
		<!-- home wrapper -->
		<div class="home-wrapper">
			<div class="container">
				<div class="row">

					<!-- home content -->
					<div class="col-md-10 col-md-offset-1">
						<div class="home-content">
							<h1 class="white-text">2iConnect</h1>
							<h4 class="white-text">Une application qui améliore la vie lycéenne.</h4>
							</h4>
						</div>
					</div>
					<!-- /home content -->

				</div>
			</div>
			
		</div>
		<!-- /home wrapper -->

	</header>
	<!-- /Header -->