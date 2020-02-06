<?php
include( 'include.php' );
?>
<?php
if ( 'POST' == $_SERVER[ 'REQUEST_METHOD' ] ) {
  $result = "";
  $errors = false;
  $verifDate = false;
  if ( array_key_exists( 'entree', $_POST ) || array_key_exists( 'plat', $_POST ) || array_key_exists( 'dessert', $_POST ) ) {
    $result = strip_tags( $_POST[ 'entree' ] ) . "<br>" . strip_tags( $_POST[ 'plat' ] ) . "<br>" . strip_tags( $_POST[ 'dessert' ] );
    $reponse = $bdd->query( 'SELECT * FROM menu WHERE date = "' . $_POST[ 'date' ] . '"' );
    while ( $donnees = $reponse->fetch() ) {
      $verifDate = true;
    }
    $reponse->closeCursor(); // Termine le traitement de la requête	  
  } else {
    $errors = true;
  }
  if ( !$errors && $verifDate == false ) {
    $insert = $bdd->prepare( 'INSERT INTO menu( date, contenu) VALUES(:date, :contenu)' );
    $insert->execute( [ 'date' => strip_tags( $_POST[ 'date' ] ), 'contenu' => ( $result ) ] );
    $fail = FALSE;
  } else if ( $verifDate == true ) {
    $req = $bdd->prepare( 'UPDATE menu SET contenu = :contenu WHERE date = :date' );
    $req->execute( array(
      'contenu' => $result,
      'date' => strip_tags( $_POST[ 'date' ] )
    ) );
  }
}

include( 'header.php' );
$dateSelect = date( "Y-m-d" );
$dateSValue = date( "Y-m-d");
if ( 'POST' == $_SERVER[ 'REQUEST_METHOD' ] ) {
  if ( array_key_exists( 'dateSelect', $_POST ) ) {
    $format = 'Y-m-d';
    $date = DateTime::createFromFormat( $format, $_POST[ 'dateSelect' ] );
    $dateSelect = $date->format( 'd/m/Y' );
    $dateSValue = $date->format( 'Y-m-d' );
  }
}
?>
<br>
<div class="aligncenter">
  <div class="sign-up-modal" style="font-size: 20px;border-bottom : 1px solid #868F9B;">
    <?php
    $verifDonnees = false;
    $reponse = $bdd->query( 'SELECT * FROM menu WHERE date = "' . $dateSelect . '"' );
    while ( $donnees = $reponse->fetch() ) {
      $verifDonnees = true;
      $format = 'Y-m-d';
      $date = DateTime::createFromFormat( $format, $donnees[ 'date' ] );
      ?>
    <p> <strong>Menu du </strong> : <?php echo $date->format('d/m/Y'); ?><br />
      <?php echo $donnees['contenu']; ?> </p>
    <?php
    }
    if ( $verifDonnees == false ) {
      echo( "aucun menu pour cette date" );
    }
    $reponse->closeCursor(); // Termine le traitement de la requête
    ?>
    <form method="POST" id="form">
      <br>
      <h4 class="auto-style1">Autre jour :</h4>
      <input name="Hidden1" type="hidden" />
      <input class="nouveauStyle1" type="date" id="dateSelect" name="dateSelect" placeholder="date"   style="width:300px" value="<?php echo($dateSValue); ?>" required/>
      <br><br>
      <p class="auto-style1">
        <input class="auto-style2" style="width: 130px" type="submit" value="Valider" />
      </p>
    </form>
  </div>
</div>
      <br>
<br>
<div class="aligncenter">
  <div class="sign-up-modal">
    <form method="POST" id="form">
      <!-- Création d'un formulaire donc POST est le script à charger, action est le fichier php de notre formulaire, ainsi que autocomplete permet de préremplir automatiquement les données de l'utilisateur.-->
      <div>
        <h4 class="auto-style1">Ajouter un menu :</h4>
        <input name="Hidden1" type="hidden" />
        <input class="nouveauStyle1" type="text" id="entree" name="entree" placeholder="entree"   style="width:300px" value="<?php if (array_key_exists('entree', $_POST)) echo htmlspecialchars($_POST['entree']); ?>" />
        <br>
        <input class="nouveauStyle1" type="text" id="plat" name="plat" placeholder="plat"   style="width:300px" value="<?php if (array_key_exists('plat', $_POST)) echo htmlspecialchars($_POST['plat']); ?>" />
        <br>
        <input class="nouveauStyle1" type="text" id="dessert" name="dessert" placeholder="dessert"   style="width:300px" value="<?php if (array_key_exists('dessert', $_POST)) echo htmlspecialchars($_POST['dessert']); ?>" />
        <br>
        <br>
        <h4 class="auto-style1">Date :</h4>
        <input name="Hidden1" type="hidden" />
        <input class="nouveauStyle1" type="date" id="date" name="date" placeholder="date"   style="width:300px" value="<?php echo($dateSValue); ?>" required/>
        <br>
        <br />
        <p class="auto-style1">
          <input class="auto-style2" style="width: 130px" type="submit" value="Valider" />
        </p>
        <br>
      </div>
    </form>
  </div>
</div>
<?php include('footer.php'); ?>
