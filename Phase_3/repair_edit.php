<?php include('lib/common.php'); 
include('lib/header.php'); 
if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$VIN = mysqli_real_escape_string($mydb, $_GET['id']);
	echo "Vehicle Identification Number is: " . $VIN . "<br> <br>";
	#$start_date = mysqli_real_escape_string($mydb, $_POST['start_date']);
	$query1 = "SELECT repairID, vendor_name, start_date, end_date, repair_status, repair_description, total_cost, NHTSA_recall_number FROM Repairs WHERE repair_status NOT LIKE 'completed' AND repairID IN (SELECT repairID FROM Determine WHERE VIN ='" . $VIN . "')";
	#echo $query1;
	$result1 =  mysqli_query($mydb, $query1) or die(mysql_error());?>
	
	<form action = "repair_edit.php?id=<?php echo $VIN;?>" method = "post" >
	<input type='hidden' name='VIN' value='<?php echo $VIN;?>' />
	<?php 
	echo"<table border='1'>";
	echo"<tr><td>Vendor name</td><td>start date</td><td>end date</td><td>repair status</td><td>repair description</td><td>total cost</td><td>NHTSA recall number</td></tr>\n";
	while ($row1 = mysqli_fetch_assoc($result1))
	{
		echo "<tr><td>{$row1['vendor_name']}</td><td>{$row1['start_date']}</td><td>{$row1['end_date']}</td><td><select name=new_status{$row1['repairID']}> "; 
			if ($row1['repair_status']=='pending' ) { 
		?>
				<option value="pending" selected>Pending</option>
				<option value="in progress">In progress</option>
		<?php 
			}
			else if($row1['repair_status']=='in progress' ) { 
		?>
				<option value="in progress" selected">In progress</option>
				<option value="completed">Completed</option>
		<?php 	
		} 
		
	$queryn = "SELECT recall_description FROM Recall WHERE NHTSA_recall_number  ='" . $row1['NHTSA_recall_number'] . "'";
	$resultn =  mysqli_query($mydb, $queryn) or die(mysql_error());	
	$rown = mysqli_fetch_assoc($resultn);
	echo "</select> <br /></td><td><a onclick=\"alert('{$row1['repair_description']}');return false;\">Click Here to see Repair Description</a></td><td>{$row1['total_cost']}</td><td>{$row1['NHTSA_recall_number']}</td><td><a onclick=\"alert('{$rown['recall_description']}');return false;\">Click Here to see Recall Description</a></td></tr>\n";
	}
	echo "</table>";
	echo "<br />
	<input type = \"submit\" value=\" Save the latest repair status \"> <br /><br />
	</form>";
	#$query2 = "SELECT repair_status FROM Repairs WHERE VIN ='$VIN' AND start_date = '#start_date'";
	#$result2 =  mysqli_query($mydb, $query2) or die(mysql_error());
	#$rep_status= mysqli_fetch_assoc($result2);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	echo "Thank you for the status updates! <br></br>";
	$VIN = mysqli_real_escape_string($mydb, $_POST['VIN']);
	$query1 = "SELECT repairID, vendor_name, start_date, end_date, repair_status, repair_description, total_cost, NHTSA_recall_number FROM Repairs WHERE repair_status NOT LIKE 'completed' AND repairID IN (SELECT repairID FROM Determine WHERE VIN ='" . $VIN . "')";
	$result1 =  mysqli_query($mydb, $query1) or die(mysql_error());	
	while ($row1 = mysqli_fetch_assoc($result1)){
		$repairID = $row1['repairID'];
		$latest_status = $_POST['new_status' . $row1['repairID']];
		$update = "UPDATE repairs SET repair_status ='" . $latest_status . "' where repairID = " . $repairID;
		$status = mysqli_query($mydb, $update);
		if ($status  == False) {  
					echo "Error while updating the repair status, please recheck the updated repair status" . '<br>';
	array_push($msg, "Error while updating the repair status, please recheck the updated repair status" );}}
				 
	$query2 = "SELECT repairID, vendor_name, start_date, end_date, repair_status, repair_description, total_cost, NHTSA_recall_number FROM Repairs WHERE repair_status NOT LIKE 'completed' AND repairID IN (SELECT repairID FROM Determine WHERE VIN ='" . $VIN . "')";
	$result2 =  mysqli_query($mydb, $query2) or die(mysql_error());	
	#echo "see";
	#echo mysqli_num_rows($result2);
	if (mysqli_num_rows($result2)==0) 
	{	$query3 = "SELECT sum(total_cost) AS total_repair_cost FROM Repairs WHERE repairID IN (SELECT repairID FROM Determine WHERE VIN ='" . $VIN . "')";
		$result3 =  mysqli_query($mydb, $query3) or die(mysql_error());	
		$row3 = mysqli_fetch_assoc($result3);
		$total_repair_cost = $row3['total_repair_cost'];
		$query4 = "SELECT kbb_price FROM P_Transaction WHERE VIN ='" . $VIN . "'";
		$result4 =  mysqli_query($mydb, $query4) or die(mysql_error());	
		$row4= mysqli_fetch_assoc($result4); 
		$pp = $row4['kbb_price'];
		#echo "cost" . $total_repair_cost;
		$sales_price = 1.1 * (floatval($total_repair_cost)) + 1.25 * (floatval( $pp )); 
		#echo $total_repair_cost;
		#echo $sales_price;
		$clerk = $_SESSION['username'];
		#echo $clerk;
		$insert1 = "INSERT INTO InventoryVehicle(VIN, repair_vehicle_VIN, sales_price,inventory_clerk_username) VALUES ('" . $VIN . "','" . $VIN . "'," .  $sales_price . ",'" . $clerk . "')" ;
		#echo $insert1;
		$status1 = mysqli_query($mydb, $insert1);
		if ($status1  == True) { 
		$delete1 = "DELETE FROM RepairVehicle WHERE VIN = '" . $VIN . "')" ;
		$status_delete = mysqli_query($mydb, $delete1);
		echo "The Vehicle with VIN=" . $VIN . " has no more repairs pending or in progress and is now available for public search and sale! ";
		}
		
	
	}
} 
?>
<title> Edit repair </title>
<form> 
<br><br><button type="button" onclick="location.href = 'clerk_view_vehicle.php?id=<?php echo $VIN ?>';">Go back to vehicle view page</button>  
<br><br><button type="button" onclick="location.href = 'privileged_search.php';">Go back to privileged search page</button>  
<br><br><button type="button" onclick="location.href = 'public_search.php';">Logout</button> <br/> <br/>
	</form>
<br><br><br>
<?php include('lib/footer.php'); ?>

<?php include('lib/error.php'); ?>