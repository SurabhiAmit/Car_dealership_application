<?php 

if (!isset($_SESSION)) {
    session_start();
}
$msg = [];
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Expires: 0");

define('REF_TIME', 'Refresh: 1; ');
define('DB_HOST', "localhost");
define('DB_PORT', "3307");
define('DB_USER', "gatechUser");
define('DB_PASS', "gatech123");
define('DB_SCHEMA', "cs6400_su19_team023");
$mydb=mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_SCHEMA, DB_PORT);

if (mysqli_connect_errno())
{
	echo "Could not connect to the database: " . mysqli_connect_error() . '<br>';
	exit();
}
?>