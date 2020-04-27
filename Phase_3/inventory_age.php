<!DOCTYPE html>
<html>  
 

<title>Burdell's Ramblin's Wrecks report</title>
<head>

<style>
table, th, td {
  border: 2px solid black;
  border-collapse: collapse;
  text-align: center; 
}
</style>

  <meta charset="UTF-8">
  <meta name="description" content="inventory age">
  <meta name="keywords" content="HTML,CSS,PHP,SQL">
 <meta name="author" content="Yougui Xiang">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="background-color:powderblue;">
 
			 
<?php
//  
$DB_HOST="localhost";
$DB_PORT ="3307";
$DB_USER="gatechUser";
$DB_PASS= "gatech123";
$DB_SCHEMA= "cs6400_su19_team023";

// Create connection
$db = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_SCHEMA, $DB_PORT);

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Database Connected successfully";
?>			
			  
<h1> Inventory Age Report </h1>

<table>
    <tr>
        <th>type_name</th>
        <th>min_inventory_age(days)</th>
        <th>max_inventory_age(days)</th>
        <th>average_inventory_age(days)</th>
    </tr>


<?php
//echo "Generating Inventory Age Report...........<br><br>";
 
    $query = "SELECT type_name, MIN(DATEDIFF(CURDATE(),purchase_date)) AS
min_inventory_age, MAX(DATEDIFF(CURDATE(),purchase_date)) AS
max_inventory_age, AVG(DATEDIFF(CURDATE(),purchase_date)) AS
average_inventory_age
FROM Vehicle AS V , InventoryVehicle AS I , P_Transaction AS P
WHERE V .VIN = I .VIN AND I .VIN = P .VIN
GROUP BY type_name;"   ; 
    $result = mysqli_query($db, $query);

    $query1 = "SELECT type_name FROM Vehicle WHERE type_name NOT IN (SELECT type_name
FROM InventoryVehicle) GROUP BY type_name  ;" ; 
    $result1 = mysqli_query($db, $query1);
 
if ( !is_bool($result) && (mysqli_num_rows($result) > 0) ) { 
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
         
	$a=$row['type_name']; 
	$b=$row['min_inventory_age'];
	$c=$row['max_inventory_age']; 
	$d=$row['average_inventory_age'];

echo "\t<tr><td>".$a."</td><td>".$b."</td><td>".$c."</td><td>".$d."</td></tr>\n";	  
} //end of while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
}  //end of if
 
while($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
         
	$e=$row1['type_name']; 
 

echo "\t<tr><td>".$e."</td><td>"."N/A"."</td><td>"."N/A"."</td><td>"."N/A"."</td></tr>\n";	  
} //end of while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))  
  
 
?>

</table>


<br><br>
<form action="report_menu.php"  > 
  <input type="submit" value="Go Back to Report Menu">
</form>
<form action="logout.php"  > 
  <input type="submit" value="Log out">
</form> 
			 
<br><br><br>

<?php include 'footer.php'; ?>
</body>
</html>
