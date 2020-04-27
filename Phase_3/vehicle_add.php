<?php include('lib/common.php'); 
include('lib/header.php'); 
if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$license = mysqli_real_escape_string($mydb, $_POST['license']);
	$TIN = mysqli_real_escape_string($mydb, $_POST['TIN']);
	$VIN = mysqli_real_escape_string($mydb, $_POST['VIN']);
	$vehicle_type = mysqli_real_escape_string($mydb, $_POST['Vehicle_Type']);
	$manu_name = mysqli_real_escape_string($mydb, $_POST['Manufacturer_Name']);
	$model_name = mysqli_real_escape_string($mydb, $_POST['Model_name']);
	$model_year = mysqli_real_escape_string($mydb, $_POST['Model_year']);
	$mileage = mysqli_real_escape_string($mydb, $_POST['Mileage']);
	$description = mysqli_real_escape_string($mydb, $_POST['Description']);
	$p_date = mysqli_real_escape_string($mydb, $_POST['Purchase_date']);
	$condition = mysqli_real_escape_string($mydb, $_POST['Vehicle_condition']);
	$price = mysqli_real_escape_string($mydb, $_POST['KBB_price']);
	$clerk = mysqli_real_escape_string($mydb, $_POST['Inventory_clerk_username']);
	if ($model_year > date("Y") +1 )
		{	
		array_push($msg, "Entered model year is greater than current year+1 !! Please enter the correct model year.");
	}
	if ($model_year <1000 )
		{
		array_push($msg, "Entered model year is not of century digits.");
	}
	$insert1 = "INSERT INTO Vehicle (VIN, type_name, manu_name, model_name, model_year, mileage, optional_desc) " .
			 "VALUES ('$VIN', '$vehicle_type', '$manu_name', '$model_name', '$model_year','$mileage', '$description')";
	
	$status1 = mysqli_query($mydb, $insert1);
	
	$inserth = "INSERT INTO RepairVehicle (VIN)" .
			 "VALUES ('$VIN')";
	
	$statush = mysqli_query($mydb, $inserth);
                
    if ($status1  == False) {  
					echo "1.Insertion error on Vehicle, recheck the entered details" . '<br>';
                 array_push($msg, "Insertion error on Vehicle, recheck the entered details" );
          } 
	foreach ($_POST['colors'] as $color)
	{
	$colors = $colors . ";" . $color;	}
		
	$insert2 = "INSERT INTO Vehicle_Color(VIN, color)" . "VALUES ( '$VIN', '$colors')";
	
	$status2 = mysqli_query($mydb, $insert2);
              
    if ($status2  == False) {  
				echo "Recheck the colors entered" . '<br>';
                 array_push($msg, "Recheck the colors entered" );
	} 
	
	if (!empty($license))
	{	
		$custID = "SELECT customerID FROM Individual WHERE driver_license LIKE '$license'";
		$status=mysqli_query($mydb, $custID);
		$customerIDrow = mysqli_fetch_assoc($status);
		$customerID= $customerIDrow['customerID'];
	}
	else if (!empty($TIN))
	{
		$custID = "SELECT customerID FROM Business WHERE TIN LIKE  '$TIN'";
		$status=mysqli_query($mydb, $custID);
		$customerIDrow = mysqli_fetch_assoc($status);
		$customerID= $customerIDrow['customerID'];
	}
	
	if (!empty($customerID))
	{ 
		$insert3 = "INSERT INTO P_transaction(purchase_date, VIN, customerID, vehicle_condition, kbb_price, inventory_clerk_username)" . "VALUES ( '$p_date', '$VIN', '$customerID', '$condition', '$price', '$clerk')";
		echo $insert3; 
		$status3 = mysqli_query($mydb, $insert3);
					
		if ($status3  == False) {  
					echo  "Recheck the purchase details entered" . '<br>';
					 array_push($msg, "Recheck the purchase details entered" );
          } 
	}
	else
	{
		array_push($msg, "Please enter the customer details" );
	}
}
	
$query1 = "SELECT color FROM colors";

$result1 =  mysqli_query($mydb, $query1) or die(mysql_error());
while($row1 = mysqli_fetch_assoc($result1))
{
    $dd1 .= "<option value='{$row1['color']}'>{$row1['color']}</option>";
} 
$query2 = "SELECT color FROM colors";
$result2 =  mysqli_query($mydb, $query2) or die(mysql_error());
while($row2 = mysqli_fetch_assoc($result2))
{
    $dd2 .= "<option value='{$row2['color']}'>{$row2['color']}</option>";
} 
$query3 = "SELECT type_name FROM VehicleType";
$result3 =  mysqli_query($mydb, $query3) or die(mysql_error());
while($row3 = mysqli_fetch_assoc($result3))
{
    $dd3 .= "<option value='{$row3['type_name']}'>{$row3['type_name']}</option>";
} 

$query4 = "SELECT manu_name FROM Manufacturer";
$result4 =  mysqli_query($mydb, $query4) or die(mysql_error());
while($row4 = mysqli_fetch_assoc($result4))
{
    $dd4 .= "<option value='{$row4['manu_name']}'>{$row4['manu_name']}</option>";
} 
?>

<title> Purchase transaction and add vehicle </title>

<form action = "vehicle_add.php" method = "post" >
<h1>Enter the details of the newly purchased vehicle:</h1>
<label for="VIN">Please click on add new customer button if the customer is new: </label> <br/>
	<button type="button" onclick="location.href = 'customer_add.php';">Add new customer</button> <br/> <br/>
	<label for="VIN">Please click on lookup customer button if the customer is an already existing customer: </label> <br/>
	<button type="button" onclick="location.href = 'lookup_customer.php';">Lookup customer</button> <br/> <br/>
	<label for="license">Please enter the driver's license of the customer if the customer is an individual: </label> <br/>
	<input type = "text" name ="license" > <br />
	<label for="TIN">Please enter the TIN of the customer if the customer is a business firm: </label> <br/> 
	<input type = "text" name ="TIN" > <br /><br/>
	<label for="VIN">VIN: </label> 
	<input type = "text" name ="VIN" > <br />
	<label for="Vehicle_type">Vehicle type: </label> 
	<select name="Vehicle_type"><?php echo $dd3; ?></select> <br />
	<label for="Manufacturer_Name">Manufacturer Name: </label> 
	<select name="Manufacturer_Name"><?php echo $dd4; ?></select> <br />
	<label for="Model_name">Model name: </label> 
	<input type = "text" name ="Model_name" > <br />
	<label for="Model_year">Model year: </label> 
	<input type = "text" name ="Model_year" > <br />
	<label for="Mileage">Mileage: </label> 
	<input type = "text" name ="Mileage" > <br />
	<label for="Description">Description: </label> 
	<input type = "text" name ="Description" > <br />
	<label for="colors">Please select the colors of the car. You may control-click (Windows) or command-click (Mac) to select more than one. </label> 
	<select name="colors[]" multiple="multiple"><?php echo $dd1; ?></select> <br />
	<label for="Purchase_date">Purchase Date: </label> 
	<input type = "text" name ="Purchase_date" > <br />
	<label for="Vehicle_condition">Vehicle condition: </label> 
	<select name="condition">
	<option value = "Excellent">Excellent</option>
	<option value = "Very_good">Very good</option>
	<option value = "Good">Good</option>
	<option value = "Fair">Fair</option>
	</select> <br />
	<label for="KBB_price">Blue book value or purchase price: </label> 
	<input type = "text" name ="KBB_price" > <br />
	<label for="Inventory_clerk_username">Inventory clerk username: </label> 
	<input type = "text" name ="Inventory_clerk_username" > <br /> <br />
	
	
	<input type = "submit" value=" Add the purchase transaction "> <br />
	<br><br><button type="button" onclick="location.href = 'logout.php';">Logout</button> <br/> <br/>
	<br><br><button type="button" onclick="location.href = 'privileged_search.php';">Go back to privileged search page</button> <br/> <br/>
	<!-- improvise: return from customer_add page to this page on finishing.-->
</form>
<br><br><br>
<?php include('lib/footer.php'); ?>
<?php include('lib/error.php'); ?>