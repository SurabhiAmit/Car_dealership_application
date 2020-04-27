<?php include('lib/common.php'); 
include('lib/header.php'); 
if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$clerk = mysqli_real_escape_string($mydb, $_POST['clerk']);
	$NHTSA = mysqli_real_escape_string($mydb, $_POST['NHTSA']);
	$NHTSA_1 = mysqli_real_escape_string($mydb, $_POST['NHTSA_1']);
	$manu_name = mysqli_real_escape_string($mydb, $_POST['manu_name']);
	$recall_description = mysqli_real_escape_string($mydb, $_POST['recall_description']);
	$state = mysqli_real_escape_string($mydb, $_POST['state']);
	$postal_code = mysqli_real_escape_string($mydb, $_POST['postal_code']);
	$cost = mysqli_real_escape_string($mydb, $_POST['cost']);
	$VIN = mysqli_real_escape_string($mydb, $_POST['VIN']);
	$start_date = mysqli_real_escape_string($mydb, $_POST['start_date']);
	$end_date = mysqli_real_escape_string($mydb, $_POST['end_date']);
	$repair_desc = mysqli_real_escape_string($mydb, $_POST['repair_desc']);
	$status = mysqli_real_escape_string($mydb, $_POST['status']);
	$total_cost = mysqli_real_escape_string($mydb, $_POST['total_cost']);
	$v_name = mysqli_real_escape_string($mydb, $_POST['v_name']);
	$phone = mysqli_real_escape_string($mydb, $_POST['phone']);
	$v_name1 = mysqli_real_escape_string($mydb, $_POST['v_name1']);
	$street = mysqli_real_escape_string($mydb, $_POST['street']);
	$city = mysqli_real_escape_string($mydb, $_POST['city']);
	$state = mysqli_real_escape_string($mydb, $_POST['state']);
	$postal_code = mysqli_real_escape_string($mydb, $_POST['postal_code']);
	
	$insert1= "INSERT INTO Determine (VIN, inventory_clerk_username)" . "VALUES 
( '$VIN', '$clerk')";
	$status1 = mysqli_query($mydb, $insert1);           
    if ($status1  == False) {  
					echo "Insertion error, recheck the entered VIN and clerk name" . '<br>';
                 array_push($msg, "Insertion error,  recheck the entered VIN and clerk name" );
          } 
	  
	$sql_query = "SELECT LAST_INSERT_ID() as repairID";
	$output = mysqli_query($mydb, $sql_query);
	$repairIDrow = mysqli_fetch_assoc($output);
	$repairID = $repairIDrow['repairID'];
	
	
	if(!empty($NHTSA)){$insert2= "INSERT INTO  Recall (NHTSA_recall_number, manu_name, recall_description )
	SELECT '$NHTSA', '$manu_name', '$recall_description'
	FROM dual WHERE NOT EXISTS(SELECT NHTSA_recall_number FROM Recall WHERE NHTSA_recall_number='$NHTSA')";
		
	$status2 = mysqli_query($mydb, $insert2);           
     }
	
	
	if (!empty($v_name) and !empty($NHTSA))
	{ 
		$insert3= "INSERT INTO Repairs (repairID, start_date, end_date, repair_status, total_cost, repair_description, vendor_name, NHTSA_recall_number)" . "VALUES
( $repairID, '$start_date', '$end_date', '$status',  $total_cost, '$repair_desc', '$v_name', '$NHTSA')";
		
	$status3 = mysqli_query($mydb, $insert3);   

    if ($status3  == False) {  
					echo "Insertion error, recheck the entered repair details" . '<br>';
                 array_push($msg, "Insertion error,  recheck the entered repair details" );
	} }
	else if (!empty($v_name1) and !empty($NHTSA))
		{
			
		$insert3= "INSERT INTO Repairs (repairID, start_date, end_date, repair_status, total_cost, repair_description, vendor_name, NHTSA_recall_number)" . "VALUES
( $repairID, '$start_date', '$end_date', '$status',  $total_cost, '$repair_desc', '$v_name1', '$NHTSA')";
	
	$status3 = mysqli_query($mydb, $insert3); 
		
    if ($status3  == False) {  
					echo "Insertion error, recheck the entered repair details" . '<br>';
                 array_push($msg, "Insertion error,  recheck the entered repair details" );
	} }
	else if (!empty($v_name) and !empty($NHTSA_1))
		{ 
	
		$insert3= "INSERT INTO Repairs (repairID, start_date, end_date, repair_status, total_cost, repair_description, vendor_name, NHTSA_recall_number)" . "VALUES
( $repairID, '$start_date', '$end_date', '$status',  $total_cost, '$repair_desc', '$v_name', '$NHTSA_1')";
	
	$status3 = mysqli_query($mydb, $insert3);           
    if ($status3  == False) {  
					echo "Insertion error, recheck the entered repair details" . '<br>';
                 array_push($msg, "Insertion error,  recheck the entered repair details" );
	} }
	else if (!empty($v_name1) and !empty($NHTSA_1))
		{
			
		$insert3= "INSERT INTO Repairs (repairID, start_date, end_date, repair_status, total_cost, repair_description, vendor_name, NHTSA_recall_number)" . "VALUES
( $repairID, '$start_date', '$end_date', '$status',  $total_cost, '$repair_desc', '$v_name1', '$NHTSA_1')";

	$status3 = mysqli_query($mydb, $insert3);           
    if ($status3  == False) {  
					echo "Insertion error, recheck the entered repair details" . '<br>';
                 array_push($msg, "Insertion error,  recheck the entered repair details" );
	} }
	

	if(!empty($v_name)){$insert4= "INSERT INTO Vendor(vendor_name, vendor_phone, street, city, state, postal_code)
SELECT '$v_name', '$phone', '$street', '$city', '$state', '$postal_code' FROM dual WHERE NOT EXISTS( 
SELECT vendor_name FROM Vendor WHERE vendor_name like '$v_name')";
	echo $insert4;
	$status4 = mysqli_query($mydb, $insert4);           
    if ($status4  == False) {  
					echo "Insertion error, recheck the entered repair details" . '<br>';
                 array_push($msg, "Insertion error,  recheck the entered repair details" );
          } 	  
	
}}

$query1 = "SELECT NHTSA_recall_number FROM Recall";
$result1 =  mysqli_query($mydb, $query1) or die(mysql_error());
while($row1 = mysqli_fetch_assoc($result1))
{
    $dd1 .= "<option value='{$row1['NHTSA_recall_number']}'>{$row1['NHTSA_recall_number']}</option>";
} 

$query1 = "SELECT NHTSA_recall_number FROM Recall";
$result1 =  mysqli_query($mydb, $query1) or die(mysql_error());
while($row1 = mysqli_fetch_assoc($result1))
{
    $dd1 .= "<option value='{$row1['NHTSA_recall_number']}'>{$row1['NHTSA_recall_number']}</option>";
} 
$query2 = "SELECT vendor_name FROM Vendor";
$result2 =  mysqli_query($mydb, $query2) or die(mysql_error());
while($row2 = mysqli_fetch_assoc($result2))
{
    $dd2 .= "<option value='{$row2['vendor_name']}'>{$row2['vendor_name']}</option>";
} 

?>

<title> Add repairs, recalls or vendors </title>

<form action = "add_repair.php" method = "post" >
<h2>Please enter the details of the new repair:</h2>
<label for="VIN">Vehicle identification number: </label> 
<input type = "text" name ="VIN" > <br />
<label for="clerk">Inventory clerk username: </label> 
<input type = "text" name ="clerk" > <br /> <br />

<h2>If the repair is associated with an existing recall, please select the NHTSA recall campaign number:</h2>
<label for="NHTSA_1">NHTSA recall campaign number: </label> 
<select name="NHTSA_1"><?php echo $dd1; ?></select> <br />

<h2>If the repair is associated with a new recall, please enter the following details:</h2>
<label for="NHTSA">NHTSA recall campaign number: </label> 
<input type = "text" name ="NHTSA" > <br />
<label for="manu_name">Manufacturer username: </label> 
<input type = "text" name ="manu_name" > <br />
<label for="recall_description">Recall description: </label> 
<input type = "text" name ="recall_description" > <br /> <br />


<h2>Please enter the following details for an existing vendor performing the repair:</h2>
<label for="v_name1">Vendor name(as already entered into the system): </label> 
<select name="v_name1"><?php echo $dd2; ?></select> <br />
<h2>Please enter the following details for a new vendor performing the repair:</h2>
<label for="v_name">Vendor name: </label> 
<input type = "text" name ="v_name" > <br />
<label for="phone">Phone number: </label> 
<input type = "text" name ="phone" > <br />
<label for="street">Street: </label> 
<input type = "text" name ="street" > <br /> <br />
<label for="city">City: </label> 
<input type = "text" name ="city" > <br /> <br />
<label for="state">State: </label> 
<input type = "text" name ="state" > <br /> <br />
<label for="postal_code">Postal code: </label> 
<input type = "text" name ="postal_code" > <br /> <br />

<h2>Please enter the following details for the repair::</h2>
<label for="start_date">Start date: </label> 
<input type = "text" name ="start_date" > <br />
<label for="end_date">End date: </label> 
<input type = "text" name ="end_date" > <br />
<label for="status">Repair status: </label> 
<input type = "text" name ="status"  value="pending"> <br />
<label for="total_cost">Repair cost: </label> 
<input type = "text" name ="total_cost" > <br />
<label for="repair_desc">Repair description: </label> 
<input type = "text" name ="repair_desc" > <br /><br />
<br /> <br /><input type = "submit" value=" Submit the new repair details "> <br /><br /><br />
<br><br><button type="button" onclick="location.href = 'privileged_search.php';">Go back to privileged search page</button> <br/> <br/>
<br><br><button type="button" onclick="location.href = 'logout.php';">Logout</button> <br/> <br/>
	
</form>
<br><br><br>
<?php include('lib/footer.php'); ?>
<?php include('lib/error.php'); ?>
