<?php
include('lib/common.php'); 
include('lib/header.php'); 
if (!isset($_SESSION['username'])) {
	header('Location: login.php');
exit();
}
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

  $sql = "SELECT V.VIN, type_name,model_year, manu_name,model_name,color,ifnull(sales_price, 'not yet in inventory') as sales_price,mileage,V.optional_desc FROM Vehicle AS V LEFT OUTER JOIN inventoryvehicle AS I ON I.VIN=V.VIN LEFT OUTER JOIN Vehicle_Color ON V.VIN=Vehicle_Color.VIN WHERE  V.VIN ='$ID'";
  $result2 = $mydb->query($sql);
    // output data of each row
   while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC) ) { 
     echo "\t<tr><td>".$row2['VIN']."</td><td>".$row2['type_name']."</td><td>".$row2['model_year']."</td><td>".$row2['manu_name']."</td><td>"
  .$row2['model_name']."</td><td>".$row2['color']."</td><td>".$row2['mileage']."</td><td>".$row2['sales_price']."</td><td>".$row2['optional_desc']."</td>";  
    } //END of while 
?>

</table>


<?php
$sql_p = "SELECT kbb_price FROM p_transaction WHERE VIN = '$ID'";
$result_p = mysqli_query($mydb, $sql_p) or die(mysql_error());
$row5 = mysqli_fetch_assoc($result_p);
echo "The purchase price of this vehicle is ".$row5['kbb_price']. "<br><br>";
$sql_r = "SELECT SUM(R.total_cost) AS Total_R_Cost FROM determine AS D INNER JOIN repairs AS R ON D.repairID = R.repairID WHERE D.VIN = 'VROU7UEWYWK097688' ";
$result_r = mysqli_query($mydb, $sql_r) or die(mysql_error());
$row6 = mysqli_fetch_assoc($result_r);
echo "The total repair cost of this vehicle is ".$row6['Total_R_Cost']. "<br><br>";

echo "<button onclick=\"location.href = 'repair_edit.php?id=" . $ID . "';return false;\">View Repair Detail and Edit Repair</button>";
echo "<button onclick=\"location.href = 'add_repair.php?id=" . $ID . "';return false;\">Add Repair</button>";
?>
   <br><br><button type="button" onclick="location.href = 'privileged_search.php';">Go back to privileged search page</button> <br/> <br/>
</form>  
 
<?php include('lib/footer.php'); ?>
<?php include('lib/error.php'); ?>
 
</body>
</html>
