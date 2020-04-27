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
        <th>Vehicle Decr</th>
    </tr>
	 

<?php 

   $ID=$_GET['id'];

$sql = "SELECT V.VIN, type_name,model_year, manu_name,model_name,color,sales_price,mileage,V.optional_desc FROM inventoryvehicle AS I,Vehicle AS V, Vehicle_Color WHERE  V.VIN ='$ID' AND I.VIN=V.VIN AND I.VIN=Vehicle_Color.VIN";
 $result2 = $mydb->query($sql);
    // output data of each row
   while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC) ) { 
     echo "\t<tr><td>".$row2['VIN']."</td><td>".$row2['type_name']."</td><td>".$row2['model_year']."</td><td>".$row2['manu_name']."</td><td>"
  .$row2['model_name']."</td><td>".$row2['color']."</td><td>".$row2['mileage']."</td><td>".$row2['sales_price']."</td><td>".$row2['optional_desc'] . "</td></tr>";  
    } //END of while   

?>



</table>
  <br><br><button type="button" onclick="location.href = 'public_search.php';">Go back to public search page</button> <br/> <br/>
	
</form>  
 
<?php include('lib/footer.php'); ?>
<?php include('lib/error.php'); ?>
 
</body>
</html>
