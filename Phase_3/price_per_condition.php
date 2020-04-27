<!DOCTYPE html>
<html>  
 

<title>Burdell's Ramblin's Wrecks Report</title>
<head>
<style>
table, th, td {
  border: 2px solid black;
  border-collapse: collapse;
  text-align: center; 
}
</style>
  <meta charset="UTF-8">
  <meta name="description" content="price per condition">
  <meta name="keywords" content="HTML,CSS,PHP,SQL">
 <meta name="author" content="Yougui Xiang">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="background-color:powderblue;">
 		 
<?php
// written by team023 Yougui Xiang
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
			  
<h1> Price per Condition Report </h1>

<table>
    <tr>
        <th>Vehicle type name</th>
        <th>Vehicle condition</th>
		<th>Price per condition ($) </th>
 
    </tr>


<?php
//echo "Generating Price per Condition Report............<br><br>"; 
$query = "SELECT type_condition.type_name, type_condition.vehicle_condition, COALESCE(a.condition_price,'0 (N/A)') AS condition_price
FROM 
(SELECT type_name, vehicle_condition FROM  Vehicle , P_Transaction GROUP BY type_name,vehicle_condition) type_condition
LEFT JOIN  
(SELECT type_name, vehicle_condition, SUM(kbb_price)/COUNT(*) AS condition_price 
FROM  Vehicle AS V , P_Transaction AS P
WHERE V .VIN= P .VIN  GROUP BY type_name,vehicle_condition) a
ON type_condition.type_name=a.type_name AND type_condition.vehicle_condition=a.vehicle_condition
;" ;
    $result = mysqli_query($db, $query);
 
/*$query1 = " SELECT  type_name, vehicle_condition FROM Vehicle JOIN P_Transaction WHERE type_name, vehicle_condition NOT IN (SELECT type_name, vehicle_condition FROM Vehicle AS V , P_Transaction AS P WHERE V.VIN= P.VIN ) GROUP BY type_name, vehicle_condition  ;" ; 

 
    $result1 = mysqli_query($db, $query1);
 
*/
 
if ( !is_bool($result) && (mysqli_num_rows($result) > 0) ) { 
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
         
	$a=$row['type_name'];
	$b=$row['vehicle_condition'];
	$c=$row['condition_price']; 
 
echo "\t<tr><td>".$a."</td><td>".$b."</td><td>".$c."</td></tr>\n";	 
 
}       
    } //end of if

 
/* 
while($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
 
	$d=$row1['type_name'];
	$e=$row1['vehicle_condition'];
	$f="$0";
 

echo "\t<tr><td>".$d."</td><td>".$e."</td><td>".$f."</td></tr>\n";	 
 
}  

//else {echo "\t<tr><td>"."N/A"."</td><td>"."N/A"."</td><td>"."N/A"."</td></tr>\n"; }
*/

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
