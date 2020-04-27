<?php
include('lib/common.php'); 
include('lib/header.php'); 
if (!isset($_SESSION['username'])) {
	header('Location: login.php');
exit();
}
?> 
<html>  
<title>Burdell's Ramblin's Wrecks Search for Vehicles</title>
 
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
<h2>Burdell's Ramblin's Wrecks Search</h2>
<?php
  
$query4 = "SELECT COUNT(*) AS Calculation_result FROM InventoryVehicle";
$result4 =  mysqli_query($mydb, $query4) or die(mysql_error());
$row4 = mysqli_fetch_assoc($result4);

echo "There are " .$row4['Calculation_result']. " vehicles available for sale.<br><br>"; 
 ?>
 
  
<?php
$query = "SELECT manu_name FROM Manufacturer";
$result =  mysqli_query($mydb, $query) or die(mysql_error());
while($row = mysqli_fetch_assoc($result))
{
    $manu  .= "<option value='{$row['manu_name']}'>{$row['manu_name']}</option>";
}

$query1 = "SELECT type_name FROM VehicleType";
$result1 =  mysqli_query($mydb, $query1) or die(mysql_error());
while($row1 = mysqli_fetch_assoc($result1))
{
    $vehicletype  .= "<option value='{$row1['type_name']}'>{$row1['type_name']}</option>";
}
 ?>
 

 
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  
  <label for="manu_name">Select Vehicle Manufacturer: </label> <br>
  <select name="manu_name"><option disabled selected value> - 	Select an Manufacturer - </option><?php echo $manu; ?></select> 
  <br></br>
  Select Vehicle Type:<br>
  
  <select name="type_name"><option disabled selected value> - Select an Vehicle Type - </option><?php echo $vehicletype; ?></select> <br />
  <br></br>

  Or enter Model_year:<br>
  <input type="text" name="model_year"   >
   <br></br>

  Or enter Color:<br>
  <select name="color"><option disabled selected value> - Select Vehicle Color - </option>
    <option value="Aluminum">Aluminum</option>
    <option value="Beige">Beige</option>
    <option value="Black">Black</option>
    <option value="Blue">Blue</option>
    <option value="Brown">Brown</option>
    <option value="Bronze">Bronze</option>
    <option value="Claret">Claret</option>
    <option value="Copper">Copper</option>
    <option value="Cream">Cream</option>
    <option value="Gold">Gold</option>
    <option value="Gray">Gray</option>
    <option value="Green">Green</option>
    <option value="Maroon">Maroon</option>
    <option value="Metallic">Metallic</option>
    <option value="Navy">Navy</option>
    <option value="Orange">Orange</option>
    <option value="Pink">Pink</option>
    <option value="Purple">Purple</option>
    <option value="Red">Red</option>
    <option value="Rose">Rose</option>
    <option value="Rust">Rust</option>
    <option value="Silver">Silver</option>
    <option value="Tan">Tan</option>
    <option value="Turquoise">Turquoise</option>
    <option value="White">White</option>
    <option value="Yellow">Yellow</option>
  </select><br>
  
  Or enter keyword:<br>
  <input type="text" name="keyword"   >
  <br></br>
 
  <input type="submit" value="Search">
  <br></br>
</form>

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
		<th>View vehicle detail</th>
		
    </tr>
	 

<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST")
 {
 
 $m_name=" 1 = 1 ";
if(!empty($_POST['manu_name'])) {
	$Mname=  $_POST['manu_name'] ; 
  $m_name="manu_name='$Mname'";
	echo "Search by manufacturer name: $Mname  <br>";
}

$T_name=" 1 = 1 ";
if(!empty($_POST['type_name'])) {
	$type_name= $_POST['type_name'] ;
  $T_name="type_name='$type_name'";
	echo "Search by vehicle type:  $type_name  <br>";
}
   
  $Y_name=" 1 = 1 ";
if(!empty($_POST['model_year'])) {
	$model_year= $_POST['model_year'];
   $Y_name="model_year='$model_year'";
	echo "Search by model year:  $model_year  <br>";
}

$C_name=" 1 = 1 ";
if(!empty($_POST['color'])) {
	$color=$_POST['color'];
  $C_name="color='$color'";
	echo "Search by color:  $color  <br>";
}

  
$k_name=" 1 = 1 ";
if(!empty($_POST['keyword'])) {
	$keyword=$_POST['keyword'];
  $k_name="(optional_desc LIKE '%" . $keyword . "%' or model_year LIKE '%" . $keyword . "%' or manu_name LIKE '%" . $keyword . "%' or model_name LIKE '%" . $keyword . "%')";
	echo "Search by keyword:  $keyword <br>";
}
 

   $sql = "SELECT V.VIN, type_name,model_year, manu_name,model_name,color,sales_price,mileage, optional_desc FROM InventoryVehicle  AS I,Vehicle AS V, Vehicle_Color WHERE {$m_name} and {$T_name} and {$Y_name} and {$C_name} and {$k_name} and I.VIN=V.VIN AND I.VIN=Vehicle_Color.VIN order by V.VIN asc"; 

  $result2 = $mydb->query($sql);
  
   
if (  !is_bool($result2) && (mysqli_num_rows($result2) > 0) ) {
    // output data of each row
   echo "Your search results: ";
   while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC) ) { 
     echo "\t<tr><td>".$row2['VIN']."</td><td>".$row2['type_name']."</td><td>".$row2['model_year']."</td><td>".$row2['manu_name']."</td><td>"
	.$row2['model_name']."</td><td>".$row2['color']."</td><td>".$row2['mileage']."</td><td>".$row2['sales_price']."</td><td>"."<a href='public_view_vehicle.php?id=".$row2['VIN']."'><button>View Vehicle Detail</button></a>|";     } //END of while   
 }
else {
    echo "Sorry, it looks like we don't have that in stock! <br><br>";
    }  

}//end of if ($_SERVER["REQUEST_METHOD"] == "POST")  
?>
</table>
   
  
 
<h2>Burdell's Ramblin's Wrecks Login</h2>

   <form action="login.php"  >
 
  <input type="submit" value="Login">
</form>  
 
<?php include('lib/footer.php'); ?>
<?php include('lib/error.php'); ?>
 
</body>
</html>
