<?php 
mb_internal_encoding('UTF-8');
setlocale(LC_CTYPE, 'fr_FR.UTF-8');
header('Content-type: text/html; charset=UTF-8'); 
    if(isset($_SESSION['id'])) {
        $fail = FALSE;
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            if(array_key_exists('pdp', $_POST))
            $stmt = $bdd->prepare('UPDATE membres SET pdp = :pdp WHERE id = :id');
            $stmt->execute([ 'pdp' => $_POST['pdp'],'id' => $_SESSION['id']]);
            $fail = FALSE;
                
            if(array_key_exists('classe', $_POST))
            $stmt = $bdd->prepare('UPDATE membres SET division = :classe WHERE id = :id');
            $stmt->execute([ 'classe' => $_POST['classe'],'id' => $_SESSION['id']]);
            $fail = FALSE;

            if(array_key_exists('devise', $_POST))
            $stmt = $bdd->prepare('UPDATE membres SET devise = :devise WHERE id = :id');
            $stmt->execute([ 'devise' => $_POST['devise'],'id' => $_SESSION['id']]);
            $fail = FALSE;
        }
      $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
      $requser->execute(array($_SESSION['id']));
      $user = $requser->fetch();
      echo("<center><h2>bienvenue <strong>".$user['mail']."</strong></h2></center><br>");
      $pdp = $user['pdp'];
      $classe = $user['division'];
      $devise = $user['devise'];
      if($pdp == ""){
        $pdp = "https://i.pinimg.com/originals/09/94/5f/09945fe83c94669cd0cfcddce4bae788.jpg";
      }
      echo("<img class='avatar1' src='".$pdp."'>");
      ?>
      <div class="sign-up-modal">
        <form class="details" id="form" method="POST">
                <div class="input-container">
                    <input class="col-sm-5 smallInput username-input with-placeholder" type="text" id="pdp" name="pdp" placeholder="URL Photo de profil" value="<?php echo htmlspecialchars($user['pdp']); ?>" />
			        	</div>
                <div class="input-container">
                    <input class="col-sm-5 smallInput username-input with-placeholder" type="text" id="classe" name="classe" placeholder="Classe" value="<?php echo htmlspecialchars($classe); ?>" required/>
			        	</div>
                <div class="input-container">
                    <input class="col-sm-5 smallInput username-input with-placeholder" type="text" id="devise" name="devise" placeholder="Devise" value="<?php echo htmlspecialchars($devise); ?>" />
			        	</div>
				        <input id="submit" type="submit" value="modifier vos données personnelles !">
         </form>
    </div>
        <?php
    }else{
      echo("veuillez vous connecter");
    }

?>
