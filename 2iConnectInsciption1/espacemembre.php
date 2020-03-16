<?php
include( 'header.php' );;
session_start();
if ( isset( $_SESSION[ 'statue' ] ) != true ) {
  echo( "<script>window.location.replace('connexion');</script>" );
  header( 'Location: connexion' );
  exit;
}

?>
<br />
<div align="center">
  <h3>Espace Membre</h3>
  <p>Bon retour parmis nous <?php echo($_SESSION['name']);?></p>
	
	
</div>


<?php include('footer.php') ?>
