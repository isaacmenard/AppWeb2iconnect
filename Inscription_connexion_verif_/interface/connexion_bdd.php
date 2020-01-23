<?php
//PHP --> MySQL
						//Paramètres de la BdD (hôte,nom de la BdD, nom de la table à afficher)
							$host='localhost';
							$DB='espace-membres';
							
						// Titre du tableau
							$titre_tab="Résultat de la requête";
						// Pourcentage d'occupation de l'écran
							$width_tab=40;

						//Définition du nom de la source de données (Data Source Name dsn)
							$dsn = 'mysql:host='.$host.';dbname='.$DB.';charset=utf8';

						//Définition du logueur
							$login = 'root';
							$mdp = '';

						//Définition des options de PHP Data Objects (PDO)
							$pdo_options=array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
						
							
 ?>