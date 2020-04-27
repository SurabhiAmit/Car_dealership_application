<?php

 /* destroy session data */
session_start();
session_destroy();
$_SESSION = array();

/* redirect to public seatch page */
header('Location: public_search.php');

?>