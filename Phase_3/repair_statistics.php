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
  <meta name="description" content="repair statistics">
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
			  
<h1> Repair Statistics Report </h1>

<table>
    <tr>
        <th>vendor_name</th>
        <th>number_of_repairs</th>
        <th>grand_cost $</th>
        <th>number_of_repairs_per_vehicle</th>
        <th>average_length_of_time(days)</th>
    </tr>
 

<?php
//echo "Generating Repair Statistics Report...........<br><br>"; 

   $query = "SELECT vendor_name, COUNT(*) AS number_of_repairs,
sum(total_cost) AS grand_cost, (count(*)/(SELECT COUNT(DISTINCT VIN)
FROM Determine )) AS number_of_repairs_per_vehicle,
(AVG(DATEDIFF(end_date , start_date))) AS average_length_of_time
FROM Repairs
GROUP BY vendor_name;" ; 
    $result = mysqli_query($db, $query);
 
 
if ( !is_bool($result) && (mysqli_num_rows($result) > 0) ) { 
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
         
	$a=$row['vendor_name'];
	$b=$row['number_of_repairs'];
	$c=$row['grand_cost'];
	$d=$row['number_of_repairs_per_vehicle'];
	$e=$row['average_length_of_time'];
echo "\t<tr><td>".$a."</td><td>".$b."</td><td>".$c."</td><td>".$d."</td><td>".$e."</td></tr>\n";	 
 
}
 
         
    } //end of if
else {echo "\t<tr><td>"."N/A"."</td><td>"."N/A"."</td><td>"."N/A"."</td><td>"."N/A"."</td><td>"."N/A"."</td></tr>\n"; }

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
