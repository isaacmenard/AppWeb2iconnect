<?php
session_start();
$_SESSION = array();
session_destroy();
header("Location: ./");
setcookie('auth', null, time() + (365 * 24 * 3600) , null, null, false, true);
?>
<script>window.location = "./"</script>