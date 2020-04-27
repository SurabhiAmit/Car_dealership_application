<?php include('lib/common.php'); 
include('lib/header.php'); 
if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$phone = mysqli_real_escape_string($mydb, $_POST['phone']);
	$email = mysqli_real_escape_string($mydb, $_POST['email']);
	$street = mysqli_real_escape_string($mydb, $_POST['street']);
	$city = mysqli_real_escape_string($mydb, $_POST['city']);
	$state = mysqli_real_escape_string($mydb, $_POST['state']);
	$postal_code = mysqli_real_escape_string($mydb, $_POST['postal_code']);
	$license = mysqli_real_escape_string($mydb, $_POST['license']);
	$f_name = mysqli_real_escape_string($mydb, $_POST['f_name']);
	$l_name = mysqli_real_escape_string($mydb, $_POST['l_name']);
	$TIN = mysqli_real_escape_string($mydb, $_POST['TIN']);
	$b_name = mysqli_real_escape_string($mydb, $_POST['b_name']);
	$c_first_name = mysqli_real_escape_string($mydb, $_POST['c_first_name']);
	$c_last_name = mysqli_real_escape_string($mydb, $_POST['c_last_name']);
	$title = mysqli_real_escape_string($mydb, $_POST['title']);
	
	$insert1= "INSERT INTO Customer(phone, email, street, city, state, postal_code)" . "VALUES 
( '$phone', '$email', '$street', '$city', '$state', '$postal_code' )";
	$status1 = mysqli_query($mydb, $insert1);           
    if ($status1  == False) {  
					echo "1.Insertion error, recheck the entered customer details" . '<br>';
                 array_push($msg, "Insertion error, recheck the entered customer details" );
          } 
		  
	if (!empty($license)){
		$insert2= "INSERT INTO Individual(driver_license, first_name, last_name, customerID)" . "VALUES
( '$license','$f_name','$l_name', LAST_INSERT_ID() )";
echo $insert2;
	$status2 = mysqli_query($mydb, $insert2);           
    if ($status2  == False) {  
					echo "$insert2" . "2.Insertion error, recheck the entered individual customer details" . '<br>';
                 array_push($msg, "Insertion error, recheck the entered individual customer details" );
	} }
		  
	else if (!empty($TIN)){
		$insert3= "INSERT INTO Business(TIN, b_name, c_first_name, c_last_name,title, customerID)" . "VALUES
( '$TIN', '$b_name', '$c_first_name','$c_last_name', '$title', LAST_INSERT_ID() )";
echo $insert3;
	$status3 = mysqli_query($mydb, $insert3);           
    if ($status3  == False) {  
					echo "$insert3" . "3.Insertion error, recheck the entered individual customer details" . '<br>';
                 array_push($msg, "Insertion error, recheck the entered individual customer details" );
	} }
}
?>

<title> Add new customers </title>

<form action = "customer_add.php" method = "post" >
<h1>Please enter the details of the new customer:</h1>
<label for="phone">Please enter the phone number: </label> <br/>
<input type = "text" name ="phone" > <br />
<label for="email">Please enter the email address if the customer would like to receive notifications (optional):</label> <br/>
<input type = "text" name ="email" > <br /> <br />
<h4>Please enter the address below: </h4> 
<label for="street">Street: </label> <br/>
<input type = "text" name ="street" > <br />
<label for="city"> City : </label> <br/>
<input type = "text" name ="city" > <br />
<label for="state"> State : </label> <br/>
<input type = "text" name ="state" > <br />
<label for="postal_code"> Postal code: </label> <br/>
<input type = "text" name ="postal_code" > <br />

<br /> <br /> <h4>Please enter the following details if the customer is an individual: </h4> <br/>
<label for="license"> Drivers license : </label> <br/>
<input type = "text" name ="license" > <br />
<label for="f_name"> First name : </label> <br/>
<input type = "text" name ="f_name" > <br />
<label for="l_name"> Last name : </label> <br/>
<input type = "text" name ="l_name" > <br />

<br /> <br /> <h4>Please enter the following details if the customer is a business firm: </h4> <br/>
<label for="TIN"> Tax Identification Number: </label> <br/>
<input type = "text" name ="TIN" > <br />
<label for="b_name"> Business name: </label> <br/>
<input type = "text" name ="b_name" > <br />
<label for="c_first_name"> Primary contact first name: </label> <br/>
<input type = "text" name ="c_first_name" > <br />
<label for="c_last_name"> Primary contact last name: </label> <br/>
<input type = "text" name ="c_last_name" > <br />

<label for="title"> Title: </label> <br/>
<input type = "text" name ="title" > <br />

<br /> <br /><input type = "submit" value=" Submit the new customer details "> <br /><br /><br />
<br><br><button type="button" onclick="location.href = 'vehicle_add.php';return false;">Go to purchase transaction</button>  
<br><br><button type="button" onclick="location.href = 'lookup_customer.php';return false;">Go to lookup customer</button> <br/> <br/>

<br><br><button type="button" onclick="location.href = 'privileged_search.php';return false;">Go back to privileged search page</button> <br/> <br/>
<br><br><button type="button" onclick="location.href = 'logout.php';return false;">Logout</button> <br/> <br/>
	
</form>
<br><br><br>
<?php include('lib/footer.php'); ?>
<?php include('lib/error.php'); ?>

	