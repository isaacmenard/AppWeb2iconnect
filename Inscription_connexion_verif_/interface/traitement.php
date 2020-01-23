<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" xml:lang="fr" dir="ltr">
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="icon" type="image/png/gif" href="gif.gif" />
<?php
$Pseudo=htmlspecialchars($_POST ['pseudo']);
$password =htmlspecialchars($_POST ['pass']);
$Email =htmlspecialchars($_POST ['e-mail']);
$date=date("Y-m-d");

echo "Date : $date <br>";
echo "Pseudo : $Pseudo <br>";
echo "Password : $password <br>";
echo "Email : $Email <br>";


?>	
	
</header>
<body >
<?php
require 'connexion_bdd.php';
try{
$bdd = new PDO($dsn,$login,$mdp,$pdo_options);
$sql = "INSERT INTO `membres`(`pseudo`,`pass`,`email`,`date`) VALUES ('".$Pseudo."','".$password."','".$Email."','".$date."')";
$reponse = $bdd->query($sql);

}

catch (Expension $e)
{
	echo "Connexion a MySQL impossible" ,$e->getMessage();
	die();
}

?>

<a href="index.php">login</a>
			
</body>
</html>