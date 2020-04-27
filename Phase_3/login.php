
<?php include('lib/common.php'); 
include('lib/header.php'); 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$usernameEntered = mysqli_real_escape_string($mydb, $_POST['username']);
	$passwordEntered = mysqli_real_escape_string($mydb, $_POST['password']);
	#echo $usernameEntered . $passwordEntered;
	if (empty($usernameEntered)){
		array_push($msg, "No username entered");
	}
	if (empty($passwordEntered)){
		array_push($msg, "No password entered");
	}
	 if ( !empty($usernameEntered) && !empty($passwordEntered) )   { 
		$sql_query = "SELECT passwords FROM Users WHERE username='$usernameEntered'";
		$output = mysqli_query($mydb, $sql_query);
		#echo "entered password is " . $passwordEntered . '<br>';
		$instances = mysqli_num_rows($output); 
		#echo "count of rows is " . $instances . '<br>';
		if ($instances == 1){
			#$tuple = mysqli_fetch_array($output, MYSQLI_ASSOC);
			$tuple = mysqli_fetch_assoc($output);
			$correctPwd= $tuple['passwords'];
			#echo "correct pwd is " . $correctPwd;			
			if ($correctPwd == $passwordEntered) {
				array_push($msg, "correct credentials!" . '<br>');
				$_SESSION['username'] = $usernameEntered;
				header (REF_TIME . 'url=privileged_search.php');
			}
			else {
				array_push($msg, "Incorrect password!");
			}
		}
		else {
			array_push($msg, "User account not found!");
		}
	 }
}
	
?>
<title> Burdell's Car Sale </title>

<form action = "login.php" method = "post" >
<label >Username: </label> 
	<input type = "text" name ="username" > <br></br>
	<label >Password: </label> 
	<input type = "password" name ="password" ><br>
	<input type = "submit" value="Login"> 
	
</form> 
<br><br><br>
<?php include('lib/footer.php'); ?>
<?php include('lib/error.php'); ?>

<?php #include('lib/logout.php'); ?>