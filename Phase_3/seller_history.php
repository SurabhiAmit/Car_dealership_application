<!DOCTYPE html>
<html>  
 

<title>Burdell's Ramblin's Wrecks Search for Vehicles</title>
<head>
<style>
 
</style>
  <meta charset="UTF-8">
  <meta name="description" content="seller histort">
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
			  
<h1> Seller History Report </h1>

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
        <th>b_name</th>
        <th>number_of_vehicle</th>
        <th>average_purchase_price</th>
        <th>average_number_repairs_per_vehicle</th>

    </tr>

<?php
 
    $query = "SELECT b_name, COUNT(DISTINCT P .VIN) AS number_of_vehicle, AVG(kbb_price) AS
average_purchase_price, (COUNT(repairID) / COUNT(DISTINCT P .VIN)) AS
average_number_repairs_per_vehicle
FROM P_Transaction AS P , Determine AS D , Customer AS C , Business AS B
WHERE P .VIN = D .VIN AND P .customerID = C .customerID AND C .customerID = B .customerID
GROUP BY b_name
HAVING   (COUNT(repairID) / COUNT(DISTINCT P .VIN)  < 5.0)
ORDER BY COUNT(DISTINCT P .VIN) DESC, AVG(kbb_price) ASC;
 "  ;
 
    $result = mysqli_query($db, $query);

 echo "Business Seller";
if ( !is_bool($result) && (mysqli_num_rows($result) > 0) ) { 
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
         
	$a=$row['b_name']; 
	$b=$row['number_of_vehicle'];
	$c=$row['average_purchase_price']; 
	$d=$row['average_number_repairs_per_vehicle'];
	echo "\t<tr ><td>".$a."</td><td>".$b."</td><td>".$c."</td><td>".$d."</td></tr>\n";

}
          
    } //end of if
else {echo "\t<tr><td>".$a."</td><td>" ."N/A"."</td><td>" ."N/A"."</td><td>" ."N/A"."</td></tr>\n"; }      
 
?>
</table>


<div style="background-color:#FF6347;color:black; ">
<table>
 
    <tr>
        <th>b_name</th>
        <th>number_of_vehicle</th>
        <th>average_purchase_price</th>
        <th>average_number_repairs_per_vehicle</th>

    </tr>

<?php
 
    $query = "SELECT b_name, COUNT(DISTINCT P .VIN) AS number_of_vehicle, AVG(kbb_price) AS
average_purchase_price, (COUNT(repairID) / COUNT(DISTINCT P .VIN)) AS
average_number_repairs_per_vehicle
FROM P_Transaction AS P , Determine AS D , Customer AS C , Business AS B
WHERE P .VIN = D .VIN AND P .customerID = C .customerID AND C .customerID = B .customerID
GROUP BY b_name
HAVING   (COUNT(repairID) / COUNT(DISTINCT P .VIN)   >= 5.0)  
ORDER BY COUNT(DISTINCT P .VIN) DESC, AVG(kbb_price) ASC;
 "  ;
 
    $result = mysqli_query($db, $query);

 
if ( !is_bool($result) && (mysqli_num_rows($result) > 0) ) { 
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
         
	$a=$row['b_name']; 
	$b=$row['number_of_vehicle'];
	$c=$row['average_purchase_price']; 
	$d=$row['average_number_repairs_per_vehicle'];
	echo "\t<tr ><td>".$a."</td><td>".$b."</td><td>".$c."</td><td>".$d."</td></tr>\n";

}
          
    } //end of if
else {echo "\t<tr><td>".$a."</td><td>" ."N/A"."</td><td>" ."N/A"."</td><td>" ."N/A"."</td></tr>\n"; }      
 
?>
</table>

</div>


<table>
    <tr>
        <th>first_name</th>
        <th>last_name</th>
        <th>number_of_vehicle</th>
        <th>average_purchase_price</th>
        <th>average_number_repairs_per_vehicle</th>

    </tr>

<?php
echo " <br><br>"; 
    $query = "SELECT first_name, last_name, COUNT(*) AS number_of_vehicle, AVG(kbb_price)
AS average_purchase_price, COUNT(repairID) / COUNT(*) AS
average_number_repairs_per_vehicle
FROM P_Transaction AS P , Determine AS D , Customer AS C , Individual AS I
WHERE P .VIN = D .VIN AND P .customerID = C .customerID AND P .customerID =
I .customerID
GROUP BY first_name, last_name
HAVING   (COUNT(repairID) / COUNT(DISTINCT P .VIN)  < 5.0)
ORDER BY COUNT( P .VIN) DESC, AVG(kbb_price) ASC;"  ;
 
    $result = mysqli_query($db, $query);

 echo "Individual Seller";
if ( !is_bool($result) && (mysqli_num_rows($result) > 0) ) { 
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
         
	$a=$row['first_name']; 
	$b=$row['last_name'];
	$c=$row['number_of_vehicle'];
	$d=$row['average_purchase_price']; 
	$e=$row['average_number_repairs_per_vehicle'];
echo "\t<tr><td>".$a."</td><td>".$b."</td><td>".$c."</td><td>".$d."</td><td>".$e."</td></tr>\n";	 
 
}
          
    } //end of if
else {echo "\t<tr><td>"."N/A"."</td><td>" ."N/A"."</td><td>" ."N/A"."</td><td>"."N/A"."</td><td>" ."N/A"."</td></tr>\n"; }      
 
?>
</table>
 


<div style="background-color:#FF6347;color:black; ">
<table>
    <tr>
        <th>first_name</th>
        <th>last_name</th>
        <th>number_of_vehicle</th>
        <th>average_purchase_price</th>
        <th>average_number_repairs_per_vehicle</th>

    </tr>

<?php
 
    $query = "SELECT first_name, last_name, COUNT(*) AS number_of_vehicle, AVG(kbb_price)
AS average_purchase_price, COUNT(repairID) / COUNT(*) AS
average_number_repairs_per_vehicle
FROM P_Transaction AS P , Determine AS D , Customer AS C , Individual AS I
WHERE P .VIN = D .VIN AND P .customerID = C .customerID AND P .customerID =
I .customerID
GROUP BY first_name, last_name
HAVING   (COUNT(repairID) / COUNT(DISTINCT P .VIN)  < 5.0)
ORDER BY COUNT( P .VIN) DESC, AVG(kbb_price) ASC;"  ;
 
    $result = mysqli_query($db, $query);

 
if ( !is_bool($result) && (mysqli_num_rows($result) > 0) ) { 
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
         
	$a=$row['first_name']; 
	$b=$row['last_name'];
	$c=$row['number_of_vehicle'];
	$d=$row['average_purchase_price']; 
	$e=$row['average_number_repairs_per_vehicle'];
echo "\t<tr><td>".$a."</td><td>".$b."</td><td>".$c."</td><td>".$d."</td><td>".$e."</td></tr>\n";	 
 
}
          
    } //end of if
else {echo "\t<tr><td>"."N/A"."</td><td>" ."N/A"."</td><td>" ."N/A"."</td><td>"."N/A"."</td><td>" ."N/A"."</td></tr>\n"; }      
 
?>
</table>
</div>
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
