<?php
include('lib/common.php'); 
include('lib/header.php'); 
if (!isset($_SESSION['username'])) {
	header('Location: login.php');
exit();
}
$username=$_SESSION['username'];
$query3 = "SELECT role  FROM Users WHERE '$username' = username;";
$result3 =  mysqli_query($mydb, $query3) or die(mysql_error());
$row3 = mysqli_fetch_assoc($result3);
$role=$row3['role'];
 
?> 

<html>  
<title>Details for Vehicles</title>
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
<h2>Vehicle Details</h2>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<table>
<style>
table {
  border: 1px solid black;
  border-collapse: collapse;
  width: 100%;
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
        <th>VIN</th>
        <th>Vehicle Type</th>
        <th>Model Year</th>
        <th>Manufacturer</th>
        <th>Model Name</th>
        <th>Color</th>
        <th>Mileage</th>
        <th>Sales Price</th>
        <th>Vehicle Description</th>
    </tr>
   
	 

<?php 

   $ID=$_GET['id'];

  $sql = "SELECT V.VIN, type_name,model_year, manu_name,model_name,color,ifnull(I.sales_price,'not yet in Inventory') as sales_price,mileage,V.optional_desc FROM Vehicle AS V LEFT OUTER JOIN InventoryVehicle AS I ON I.VIN=V.VIN LEFT OUTER JOIN Vehicle_Color ON V.VIN=Vehicle_Color.VIN WHERE  V.VIN ='$ID'";
  $result2 = $mydb->query($sql);
    // output data of each row
   while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC) ) { 
     echo "\t<tr><td>".$row2['VIN']."</td><td>".$row2['type_name']."</td><td>".$row2['model_year']."</td><td>".$row2['manu_name']."</td><td>"
  .$row2['model_name']."</td><td>".$row2['color']."</td><td>".$row2['mileage']."</td><td>" . $row2['sales_price'] . "</td><td>".$row2['optional_desc']."</td>";  
    } //END of while
?>

</table>


<?php
$sql_p = "SELECT kbb_price FROM p_transaction WHERE VIN = '$ID'";
$result_p = mysqli_query($mydb, $sql_p) or die(mysql_error());
$row5 = mysqli_fetch_assoc($result_p);
echo "The purchase price of this vehicle is ".$row5['kbb_price']. "<br><br>";
$sql_r = "SELECT ifnull(SUM(R.total_cost),0) AS Total_R_Cost FROM determine AS D INNER JOIN repairs AS R ON D.repairID = R.repairID WHERE D.VIN = '$ID'";
$result_r = mysqli_query($mydb, $sql_r) or die(mysql_error());
$row6 = mysqli_fetch_assoc($result_r);
echo "The total repair cost of this vehicle is ".$row6['Total_R_Cost']. "<br><br>";

$sql_clerk = "SELECT Users .first_name, Users .last_name, purchase_date FROM P_Transaction INNER JOIN Users ON
P_Transaction . inventory_clerk_username= Users .username
WHERE P_Transaction .VIN= '$ID'";
$result_clerk = mysqli_query($mydb, $sql_clerk) or die(mysql_error());
$row7 = mysqli_fetch_assoc($result_clerk);
//$clerk_name = $row7['first_name']." ".$row7['last_name'];
echo "The vehicle was purchased by the inventory clerk named ".$row7['first_name']. " ".$row7['last_name']." on ".$row7['purchase_date'].".<br>";

?>

<br><br>
<label>Individual Customer (Seller) Contact Information: </label><br><br>
<table>
<tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Phone</th>
        <th>Street</th>
        <th>City</th>
        <th>State</th>
        <th>Postal Code</th>
        <th>Email</th>
    </tr>

<?php
$sql_individual = "SELECT I.first_name, I.last_name, C.phone, C.street, C.city, C.state,
C.postal_code, C.email FROM customer AS C INNER JOIN P_Transaction AS P ON
P.customerID= C.customerID INNER JOIN individual AS I ON P.customerID= I.customerID WHERE P.VIN= '$ID'";
$result_individual = mysqli_query($mydb, $sql_individual) or die(mysql_error());
//$row8 = mysqli_fetch_assoc($result_customer);
while($row8 = mysqli_fetch_array($result_individual, MYSQLI_ASSOC) ) { 
     echo "\t<tr><td>".$row8['first_name']."</td><td>".$row8['last_name']."</td><td>".$row8['phone']."</td><td>".$row8['street']."</td><td>"
  .$row8['city']."</td><td>".$row8['state']."</td><td>".$row8['postal_code']."</td><td>".$row8['email'];  
    }
?>

</table>

<br><br>
<lable>Business Customer (Seller) Contact Information: </lable><br><br>
<table>
        <th>Business Name</th>
        <th>Contact Name</th>
        <th>Contact Title</th>
        <th>Phone</th>
        <th>Street</th>
        <th>City</th>
        <th>State</th>
        <th>Postal Code</th>
        <th>Email</th>
<?php
$sql_business = "SELECT B.b_name, B.c_name, B.title, C.phone, C.street, C.city, C.state,
C.postal_code, C.email FROM customer AS C INNER JOIN P_Transaction AS P ON
P.customerID= C.customerID INNER JOIN business AS B ON P.customerID= B.customerID WHERE P.VIN= '$ID'";
$result_business = mysqli_query($mydb, $sql_business) or die(mysql_error());
//$row8 = mysqli_fetch_assoc($result_customer);
while($row9 = mysqli_fetch_array($result_business, MYSQLI_ASSOC) ) { 
     echo "\t<tr><td>".$row9['b_name']."</td><td>".$row9['c_name']."</td><td>".$row9['title']."</td><td>".$row9['phone']."</td><td>".$row9['street']."</td><td>"
  .$row9['city']."</td><td>".$row9['state']."</td><td>".$row9['postal_code']."</td><td>".$row9['email'];  
    }
?>


</table>
<br><br><button type="button" onclick="location.href = 'privileged_search.php';">Go back to privileged search page</button> <br/> <br/>

</form>

<?php
echo "<a href='repair_edit.php?id=".$ID."'><button>View Repair Detail and Edit Repair</button></a>";
echo "<a href='add_repair.php?id=".$ID."'><button>Add Repair</button></a><br><br>";
if($role == 'All Roles')
  {
    echo "<a href='perform_sale.php?id=".$ID."'><button>Sell this vehicle</button></a>";
  }
?>
   
   
</body>
</html>
<?php include('lib/footer.php'); ?>
<?php include('lib/error.php'); ?>
