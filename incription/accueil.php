<?php
  include("include.php");
  session_start();
  include("header.php");
  mb_internal_encoding('UTF-8');
setlocale(LC_CTYPE, 'fr_FR.UTF-8');
header('Content-type: text/html; charset=UTF-8'); 
?>






<body>


<?php 
  include("selectAForum.php")
?>


<?php
  include("footer.php");
?>
</body>


