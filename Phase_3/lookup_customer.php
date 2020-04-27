<?php
include('lib/common.php'); 
include('lib/header.php'); 
if (!isset($_SESSION['username'])) {
	header('Location: login.php');
exit();}
?>


<title>Lookup Customer</title>
<form  method = "post" action = "lookup_customer.php?id=<?php echo $_GET['id'];?>">
<br /> <br /> <h4>Please enter the driver license number if the customer is an individual: </h4> <br/>
<label for="license"> Drivers license : </label> <br/>
<input type = "text" name ="license" > <br />


<br /> <br /> <h4>Please enter tax ID if the customer is a business firm: </h4> <br/>
<label for="TIN"> Tax Identification Number: </label> <br/>
<input type = "text" name ="TIN" > <br />

<br /> <br /><input type = "submit" value=" Submit to lookup customer"> <br /><br /><br />

</form>

<table>
<style>
table {
  border: 1px solid black;
  border-collapse: collapse;
  width: 100%;
  margin: 40px;
}

th, td {
  border: 1px solid black;
  border-collapse: collapse;
  text-align: left;
  padding: 1px;
}
 

th {
  background-color: #4CAF50;
  color: white;
}
</style>
	
   

    <tr>
        <th>Driver License</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Phone</th>
        <th>Street</th>
        <th>City</th>
        <th>State</th>
        <th>postal_code</th>
        <th>Customer ID</th>
    </tr>



<?php
$VIN4Sell = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!empty($_POST['license']) && empty($_POST['TIN'])){
	$license = mysqli_real_escape_string($mydb, $_POST['license']);
	$sql1= "SELECT Individual. driver_license, Individual. first_name, Individual. last_name, phone, street, city, state, postal_code, Individual. customerID
	FROM Individual INNER JOIN Customer ON Individual. customerID= Customer .customerID
	WHERE Individual .driver_license= '$license'";

	$status1= mysqli_query($mydb, $sql1);
	if ($status1 == False){
		echo "Lookup error, recheck the driver license input" . '<br>';
	}
	if (mysqli_num_rows($status1) <= 0) {
		echo "No search result. Please press add new customer button to add new customer." . '<br>';
	}
	
	if (  !is_bool($status1) && (mysqli_num_rows($status1) > 0) ) {
		echo "Individual customer information:";
		while($row = mysqli_fetch_array($status1, MYSQLI_ASSOC)){
			echo "\t<tr><td>".$row['driver_license']."</td><td>".$row['first_name']."</td><td>".$row['last_name']."</td><td>".$row['phone']."</td><td>"
	.$row['street']."</td><td>".$row['city']."</td><td>".$row['state']."</td><td>" .$row['postal_code']."</td><td>".$row['customerID']."</td><td>"."<a href='perform_sale.php?id=".$_GET['id']."'><button>Load Customer information for Sale Transaction</button></a>|"."<a href='vehicle_add.php?id=".$_GET['id']."'><button>Load Customer information for Purchase Transaction</button></a>|";
		}

	}	
	}}
	?>
	</table>


	<table>
	 <tr>
        <th>TIN</th>
        <th>Business Name</th>
        <th>First Name of the contact person</th>
		<th>Last Name of the contact person</th>
        <th>Title</th>
        <th>Phone</th>
        <th>Street</th>
        <th>City</th>
        <th>State</th>
        <th>Postal code</th>
        <th>Customer ID</th>
    </tr>



<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!empty($_POST['TIN']) && empty($_POST['license'])){
	$TIN = mysqli_real_escape_string($mydb, $_POST['TIN']);
	$sql2= "SELECT TIN, b_name, c_last_name,c_first_name, title, phone, street, city, state, postal_code, Customer.customerID
	FROM Business INNER JOIN Customer ON Business.customerID=Customer.customerID
	WHERE Business.TIN= '" . $TIN . "'" ;
	$status2= mysqli_query($mydb, $sql2);
	if ($status2 == False){
		echo "lookup error, recheck TIN input" . '<br>';
	}
	if (mysqli_num_rows($status2) <= 0) {
		echo "No search result. Please press add new customer button to add new customer." . '<br>';
	}
	if (  !is_bool($status2) && (mysqli_num_rows($status2) > 0) ) {
		echo "Business customer information:";
		while($row1 = mysqli_fetch_array($status2, MYSQLI_ASSOC)){
			echo "\t<tr><td>".$row1['TIN']."</td><td>".$row1['b_name']."</td><td>".$row1['c_first_name']."</td><td>".$row1['c_last_name']."</td><td>".$row1['title']."</td><td>"
	.$row1['phone']."</td><td>".$row1['street']."</td><td>".$row1['city']."</td><td>" .$row1['state']."</td><td>".$row1['postal_code']."</td><td>".$row1['customerID']."</td><td>"."<a href='perform_sale.php?id=".$_GET['id']."'><button>Go back to Sale Transaction</button></a>|"."<a href='vehicle_add.php'><button>Go back to Purchase Transaction</button></a>|";
		}

	}

}}



?>
</table>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!empty($_POST['TIN']) && !empty($_POST['license'])){
echo "Please lookup one customer at a time.";}}?>

<form action = "customer_add.php" method = "post">

<br /> <br /><input type = "submit" value=" Add New Customer"> <br />
</form>

<?php include('lib/footer.php'); ?>
<?php include('lib/error.php'); ?>
