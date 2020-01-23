<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" xml:lang="fr" dir="ltr">
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="icon" type="image/png/gif" href="gif.gif" />
	</head>
	
	<body>
<div id="container">
		
		<form method= "POST" action="traitement.php">
			<h1>Inscription</h1>
		<div id="tableau">
						
            <table>
				<tr>
                    <td>
                        <b>Pseudo :</b> 
                    </td>
			 <td>
                <input type="text" name="pseudo" required>
            </td>
			   </tr>

			<tr>
			     <td>
                    <b>e-mail :</b> 
                </td>
			<td>
                <input type="text" name="e-mail" required
				pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}">
            </td>
            </tr>
                
            <tr>        
			     <td>
                    <b>MDP :</b> 
                </td>
			<td>
                <input type="password" name="pass" required>
            </td>
            </tr>
                        </table>
			<input type="submit" value="Envoyer">
			<input type="reset" value="Annuler">
            

    
			
			</div>
			</form>
		</div>
	</body>
	
</html>