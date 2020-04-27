<?php
include('lib/common.php'); 
include('lib/header.php'); 
if (!isset($_SESSION['username'])) {
	header('Location: login.php');
exit();}
?>
<html>  
<title>Burdell's Ramblin's Wrecks Perform Sale</title>
 
<head>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
  text-align: center; 
}
</style>
 
</head>
<body style="background-color:powderblue;">
<h2>Burdell's Ramblin's Wrecks Perform Sale</h2>
    
<form method="post" action="perform_sale.php">
  
  
  
  Enter customerID from lookup/add customer:<br>
  <input type="text" name="customerID"   >
   <br></br>
 
  Enter today's date to confirm the sale:<br>
  <input type="text" name="input_date"   >
  <br></br>
 
  <input type="submit" value="Confirm">
  <br></br>
  <input type="hidden" name="id" value="<?=$_GET['id']?>">
</form>
 

<?php 
$username = $_SESSION['username'];

 $VIN4Sell = $_GET['id'];
 //echo "$VIN4Sell";
if ($_SERVER["REQUEST_METHOD"] == "POST")
 { $VIN4Sell = $_POST['id'];
  
if(!empty($_POST['customerID'])) {
	$customerID= $_POST['customerID'];
	//echo "Search by model year:  $customerID  <br>";
}


if(!empty($_POST['input_date'])) {
	$input_date=$_POST['input_date'];
	//echo "Search by keyword:  $input_date <br>";
}

if (!empty($_POST['customerID'])) {
	$select1 = "SELECT sales_price FROM InventoryVehicle where VIN like '$VIN4Sell' ";
	$output= mysqli_query($mydb, $select1);
	$row = mysqli_fetch_assoc($output);
	$sales_price = $row['sales_price'];
$insert = "INSERT INTO salestransaction (sales_date, VIN, customerID, salespeople_username, salesPrice)" . "VALUES('$input_date', '$VIN4Sell', $customerID,'$username',$sales_price)";
echo $insert;
 $status = mysqli_query($mydb, $insert);

 if ($status == False) {  
          echo "Insertion error on salestransaction, recheck the entered details" . '<br>';
      }
 $delete = "DELETE FROM InventoryVehicle WHERE VIN='" . $VIN4Sell. "'";
echo $delete;
 $status2 = mysqli_query($mydb, $delete);
 if ($status == False) {  
          echo "Delete error on inventoryvehicle, recheck the entered details" . '<br>';
      } 
}
}//end of if ($_SERVER["REQUEST_METHOD"] == "POST")


?>
 
<h2>Burdell's Ramblin's Wrecks Lookup Customer</h2>

   <form method="post" action="lookup_customer.php"  >
 
  <input type="submit" value="Lookup Customer">
  <input type="hidden" name="id" value="<?=$_GET['id']?>">
  
  <br><br><button type="button" onclick="location.href = 'privileged_search.php';">Go back to privileged search page</button> <br/> <br/>
</form>  
 
</body>
</html>
<?php include('lib/footer.php'); ?>
<?php include('lib/error.php'); ?>
