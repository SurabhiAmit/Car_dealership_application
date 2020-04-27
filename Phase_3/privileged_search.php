<?php
include('lib/common.php'); 
include('lib/header.php'); 
if (!isset($_SESSION['username'])) {
  header('Location: login.php');
exit();
}
//echo "Database Connected successfully <br> ";
 
$username=$_SESSION['username'];
$query3 = "SELECT role  FROM Users WHERE '$username' = username;";
$result3 =  mysqli_query($mydb, $query3) or die(mysql_error());
$row3 = mysqli_fetch_assoc($result3);
$role=$row3['role'];
//echo "role $role";  
?> 
<html>  
<title>Burdell's Ramblin's Wrecks Search for Vehicles</title>
 

<body style="background-color:powderblue;">
<h2>Burdell's Ramblin's Wrecks Search</h2>

<?php
//show # of vehicles currently ready for sale
$query4 = "SELECT COUNT(*) AS Calculation_result FROM InventoryVehicle";
$result4 =  mysqli_query($mydb, $query4) or die(mysql_error());
$row4 = mysqli_fetch_assoc($result4);
echo "There are " .$row4['Calculation_result']. " vehicles available for sale.<br><br>"; 
//show # of vehicles currently with repair pending or in progress for clerk and burdell
$query5 = "SELECT COUNT(*) AS repair_vehicle FROM RepairVehicle" ;

$result5 =  mysqli_query($mydb, $query5) or die(mysql_error());

$row5 = mysqli_fetch_assoc($result5);

if($role=='Clerk' or $role=='All Roles' or $role=='Manager'){

echo "There are " .$row5['repair_vehicle']. " vehicles currently with repair pending or in progress.<br><br>"; }

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
  <select name="manu_name"><option disabled selected value> -   Select an Manufacturer - </option><?php echo $manu; ?></select> <br />
  
  Select Vehicle Type:<br>
  
  <select name="type_name"><option disabled selected value> - Select an Vehicle Type - </option><?php echo $vehicletype; ?></select> <br />

  Or enter Model_year:<br>
  <input type="text" name="model_year"   >
  <br> 

  Or select Color:<br>
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
  <br> 
 
  Or enter VIN:<br>
  <input type="text" name="VIN"   >
  <br> 
  <input type="submit" value="Submit"><br><br>
<?php 
if($role=='Manager' or $role=='All Roles')
{ $sorting  = "<option selected='selected' value='unsold'>unsold</option><option value='sold'>Sold</option><option value='unsold'>Unsold</option><option value='all'>All</option>";
?>
  <br>Filter Vehicles by:<br>
  <select name="sort_by"><option> </option><?php echo $sorting; ?></select> <br />
   
<?php 

} 
?>

   
  
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
 $V_name="1 = 1";
 if(!empty($_POST['VIN'])) {
  $VIN= $_POST['VIN'];
  $V_name="V.VIN='$VIN'";
  echo "Search by VIN name: $VIN  <br>";
 }
 
 $m_name=" 1 = 1 ";
if(!empty($_POST['manu_name'])) {
  $Mname=  $_POST['manu_name'] ; 
  $m_name="manu_name='$Mname'";
  echo "Search by manufacturer name: $manu_name  <br>";
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
  $k_name="optional_desc LIKE '%$keyword%'";
  echo "Search by keyword:  $keyword <br>";
}
 

if ($role=='Clerk') {

  $sql = "SELECT DISTINCT V.VIN, type_name,model_year, manu_name,model_name,color,ifnull(sales_price, 'not yet in inventory') as sales_price,mileage FROM inventoryvehicle  AS I,Vehicle AS V, Vehicle_Color WHERE {$V_name} and {$m_name} and {$T_name} and {$Y_name} and {$C_name} and {$k_name} and I.VIN=V.VIN AND I.VIN=Vehicle_Color.VIN UNION (SELECT V.VIN, type_name,model_year, manu_name,model_name,color,'not yet in inventory' as sales_price,mileage FROM Vehicle AS V, repairvehicle AS R, Vehicle_Color WHERE {$V_name} and {$m_name} and {$T_name} and {$Y_name} and {$C_name} and {$k_name} and R.VIN=V.VIN AND R.VIN=Vehicle_Color.VIN)"; 

  $result2 = $mydb->query($sql);
}

if ($role=='Sales Person') {

   $sql = "SELECT DISTINCT V.VIN, type_name,model_year, manu_name,model_name,color,sales_price,mileage FROM InventoryVehicle AS I,Vehicle AS V, Vehicle_Color WHERE {$V_name} and {$m_name} and {$T_name} and {$Y_name} and {$C_name} and {$k_name} and I.VIN=V.VIN AND I.VIN=Vehicle_Color.VIN"; 

  $result2 = $mydb->query($sql);

}
if ($role=='Manager' or $role=='All Roles') {

   $sql = "SELECT DISTINCT V.VIN, type_name,model_year, manu_name,model_name,color,ifnull(sales_price, 'not yet in inventory') as sales_price,mileage FROM Vehicle AS V LEFT OUTER JOIN inventoryvehicle AS I ON V.VIN=I.VIN INNER JOIN Vehicle_Color AS C ON C.VIN = V.VIN WHERE {$V_name} and {$m_name} and {$T_name} and {$Y_name} and {$C_name} and {$k_name}"; 

  $result2 = $mydb->query($sql);

  $sql_sold = "SELECT DISTINCT V.VIN, type_name,model_year, manu_name,model_name,color, salesPrice, mileage 
  FROM  SalesTransaction AS S, Vehicle AS V, Vehicle_Color WHERE {$V_name} and {$m_name} and {$T_name} and {$Y_name} and {$C_name} and {$k_name} AND S.VIN=V.VIN AND S.VIN=Vehicle_Color.VIN ORDER BY V.VIN";
  
  $result_sold = $mydb->query($sql_sold);
  $sql_unsold = "SELECT DISTINCT V.VIN, type_name,model_year, manu_name,model_name,color,sales_price,mileage FROM inventoryvehicle  AS I,Vehicle AS V, Vehicle_Color WHERE {$V_name} and {$m_name} and {$T_name} and {$Y_name} and {$C_name} and {$k_name} and I.VIN=V.VIN AND I.VIN=Vehicle_Color.VIN UNION (SELECT V.VIN, type_name,model_year, manu_name,model_name,color,'not yet in inventory' as sales_price,mileage FROM Vehicle AS V, repairvehicle AS R, Vehicle_Color WHERE {$V_name} and {$m_name} and {$T_name} and {$Y_name} and {$C_name} and {$k_name} and R.VIN=V.VIN AND R.VIN=Vehicle_Color.VIN)"; 

  $result_unsold = $mydb->query($sql_unsold);

}

  
if ($role=='Clerk') { 
if (  !is_bool($result2) && (mysqli_num_rows($result2) > 0) ) {
    // output data of each row
   echo "Your search results: ";
   while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC) ) { 
     echo "\t<tr><td>".$row2['VIN']."</td><td>".$row2['type_name']."</td><td>".$row2['model_year']."</td><td>".$row2['manu_name']."</td><td>"
  .$row2['model_name']."</td><td>".$row2['color']."</td><td>".$row2['mileage']."</td><td>".$row2['sales_price']."</td><td>"."<a href='clerk_view_vehicle.php?id=".$row2['VIN']."'><button>View Vehicle Detail</button></a>|"; 
    } //END of while   
 }
else {
    echo "Sorry, it looks like we don't have that in stock! <br><br>";
    }  

}//end of if role = clerk

if ($role=='Sales Person') { 
if (  !is_bool($result2) && (mysqli_num_rows($result2) > 0) ) {
    // output data of each row
   echo "Your search results: ";
   while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC) ) { 
     echo "\t<tr><td>".$row2['VIN']."</td><td>".$row2['type_name']."</td><td>".$row2['model_year']."</td><td>".$row2['manu_name']."</td><td>"
  .$row2['model_name']."</td><td>".$row2['color']."</td><td>".$row2['mileage']."</td><td>".$row2['sales_price']."</td><td>"."<a href='salespeople_view_vehicle.php?id=".$row2['VIN']."'><button>View Vehicle Detail</button></a>"; 
    } //END of while   
 }
else {
    echo "Sorry, it looks like we don't have that in stock! <br><br>";
    }  

}//end of if role = clerk

if (!empty($_POST['sort_by']) ) {
 
  $sort_by=$_POST['sort_by'];
  echo "Filter by $sort_by <br>";
  if($sort_by=='sold'){
    echo mysqli_num_rows($result_sold).'vehicle sold<br>';
    while($row2 = mysqli_fetch_array($result_sold, MYSQLI_ASSOC) ) { 
     echo "\t<tr><td>".$row2['VIN']."</td><td>".$row2['type_name']."</td><td>".$row2['model_year']."</td><td>".$row2['manu_name']."</td><td>"
  .$row2['model_name']."</td><td>".$row2['color']."</td><td>".$row2['mileage']."</td><td>".$row2['salesPrice']."</td><td>"."<a href='manager_burdell_view_vehicle.php?id=".$row2['VIN']."'><button>View Vehicle Detail</button></a>|"; 
    } //END of while 
  }
  if($sort_by=='unsold'){
    echo mysqli_num_rows($result_unsold).'vehicle unsold<br>';
    while($row2 = mysqli_fetch_array($result_unsold, MYSQLI_ASSOC) ) { 
     echo "\t<tr><td>".$row2['VIN']."</td><td>".$row2['type_name']."</td><td>".$row2['model_year']."</td><td>".$row2['manu_name']."</td><td>"
  .$row2['model_name']."</td><td>".$row2['color']."</td><td>".$row2['mileage']."</td><td>".$row2['sales_price']."</td><td>"."<a href='manager_burdell_view_vehicle.php?id=".$row2['VIN']."'><button>View Vehicle Detail</button></a>|"; 
    } //END of while 
  }
  if($sort_by=='all'){
    echo mysqli_num_rows($result2).'vehicles<br>';
    while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC) ) { 
     echo "\t<tr><td>".$row2['VIN']."</td><td>".$row2['type_name']."</td><td>".$row2['model_year']."</td><td>".$row2['manu_name']."</td><td>"
  .$row2['model_name']."</td><td>".$row2['color']."</td><td>".$row2['mileage']."</td><td>".$row2['sales_price']."</td><td>"."<a href='manager_burdell_view_vehicle.php?id=".$row2['VIN']."'><button>View Vehicle Detail</button></a>|"; 
    } //END of while 
  }


}
}

?>
</table>
   
  
 
<?php
if (  $role=='Manager'){
  echo "<br>";
//  echo "<a href='view_vehicle.php'> <button>View Vehicle Detail</button></a> "."<br><br>";  
    include 'report_menu.php';
}
 
if (  $role=='Clerk'){
  echo "<br>";
//  echo "<a href='view_vehicle.php'> <button>View Vehicle Detail</button></a> "."<br><br>"; 
  echo "<a href='vehicle_add.php'> <button>Add Vehicle/Purchase Transaction</button></a> "."<br><br>";  
  echo "<a href='add_repair.php'> <button>Add Repair</button></a> "."<br><br>";   
//  echo "<a href='repair_edit.php'> <button>Edit Repair</button></a> "."<br><br>"; 
//  echo "<a href='lookup_customer.php'> <button>Look up customer</button></a> "."<br><br>"; 
  echo "<a href='logout.php'> <button>Log out</button></a> "."<br><br>";  
}
if (  $role=='Sales Person'){
  echo "<br>";
//  echo "<a href='view_vehicle.php'> <button>View Vehicle Detail</button></a> "."<br><br>"; 
//  echo "<a href='perform_sale.php'> <button>Sell/Sales Transaction</button></a> "."<br><br>";   
  echo "<a href='logout.php'> <button>Log out</button></a> "."<br><br>";  
}
if (  $role=='All Roles'){
  echo "<br>";
//  echo "<a href='view_vehicle.php'> <button>View Vehicle Detail</button></a> "."<br><br>"; 
//  echo "<a href='perform_sale.php'> <button>Sell/Sales Transaction</button></a> "."<br><br>"; 
  echo "<a href='vehicle_add.php'> <button>Add Vehicle/Purchase Transaction</button></a> "."<br><br>";  
//  echo "<a href='add_repair.php'> <button>Add Repair</button></a> "."<br><br>";   
//  echo "<a href='repair_edit.php'> <button>Edit Repair</button></a> "."<br><br>"; 
//  echo "<a href='lookup_customer.php'> <button>Look up customer</button></a> "."<br><br>";  
  include 'report_menu.php';
}
?>
 
 
</body>
</html>
<?php include('lib/footer.php'); ?>
<?php include('lib/error.php'); ?>

