<?php
session_start();
$_SESSION = array();
session_destroy();
header("Location: ./");
?>
<script>window.location = "./"</script>