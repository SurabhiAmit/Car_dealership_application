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
  <meta name="description" content="average time in inventory">
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
//echo "Database Connected Successfully";
?>			
			  
<h1> Average Time in Inventory Report </h1>

<table>
    <tr>
        <th>type_name</th>
        <th>average_time_in_inventory(days)</th>
    </tr>
<?php
//echo "Generating Average Time in Inventory Report...........<br><br>"; 
    $query = "SELECT type_name FROM Vehicle WHERE type_name NOT IN (SELECT type_name 
FROM Vehicle AS V , P_Transaction AS P , SalesTransaction AS S
WHERE V .VIN = P .VIN AND S .VIN = P .VIN  ) GROUP BY type_name  ;" ;
 
    $result = mysqli_query($db, $query);

    $query1 = "SELECT type_name, SUM(DATEDIFF(sales_date , purchase_date)) / COUNT(*) AS
average_time_in_inventory
FROM Vehicle AS V , P_Transaction AS P , SalesTransaction AS S
WHERE V .VIN = P .VIN AND S .VIN = P .VIN
GROUP BY type_name;" ;
 
    $result1 = mysqli_query($db, $query1);

 
if ( !is_bool($result) && (mysqli_num_rows($result) > 0) ) { 

 while($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC) ) {
 
	$b=$row1['type_name'];
	$c=$row1['average_time_in_inventory'];
    echo "\t<tr><td>".$b."</td><td>".$c."</td></tr>\n";
         	
}// end of while($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC) ) 
    
} //end of if

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
 
	$a=$row['type_name']; 

echo "\t<tr><td>".$a."</td><td>"."N/A"."</td></tr>\n";	 
 
} //end of while
//else {echo "\t<tr><td>"."N/A"."</td><td>" ."N/A"."</td></tr>\n"; } 

 
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
