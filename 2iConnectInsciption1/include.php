<?php


# param�tres pour le hachage des mots de passe
$password_options = [ 'algo' => PASSWORD_DEFAULT, 'options' => [ 'cost' => 12 ] ];

# la connexion � la base de donn�es

try
{
$bdd = new PDO('mysql:host=localhost;dbname=2iconnect', 'root', '');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
?>