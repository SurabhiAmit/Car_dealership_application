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
 

<body style="background-color:powderblue;">
 
			 
<?php
//  
$DB_HOST="localhost";
$DB_PORT ="3306";
$DB_USER="root";
$DB_PASS= "li196315";
$DB_SCHEMA= "cs6400_su19_team023";

// Create connection
$db = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_SCHEMA, $DB_PORT);

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
if (mysqli_connect_errno()) {
    echo "Failed to connect. Error:" . mysqli_connect_error();
}

else echo "Database Connected Successfully <br>";
//echo "Database Connected successfully";
?>			
			  
<h1> Monthly Sales Report </h1>

<table>
    <tr>
        <th>Sale Transaction Date</th>
        <th>Vehicle VIN</th>
    </tr>
 

<?php
//echo "Generating Repair Statistics Report...........<br><br>"; 

   $query = "SELECT sales_date, VIN FROM SalesTransaction ORDER BY sales_date DESC";
    $result = mysqli_query($db, $query);
 
echo "All Sales Transactions"; 
if ( !is_bool($result) && (mysqli_num_rows($result) > 0) ) { 
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
         
	$a=$row['sales_date'];
	$b=$row['VIN'];
	
echo "\t<tr><td>".$a."</td><td>".$b."\n";	 
 
}
 
         
    } //end of if
else {echo "\t<tr><td>"."N/A"."</td><td>"."N/A"."\n"; }

?>

</table>

<br><br><br>
<table>
  <tr>
    <th>Year</th>
    <th>Month</th>
    <th>Total Number of Vehicle Sold</th>
    <th>Monthly Total Sales Income</th>
    <th>Monthly Total net income</th>
    <th>Top Performing Salespeople</th>
  </tr>

<?php

$query1 = "
SELECT YEAR(S.sales_date) AS YEAR, MONTH(S.sales_date) as MONTH, COUNT(S.VIN) AS Total_Sold, SUM(S.salesPrice) AS Total_Sales_Income, sum(S.salesPrice-kbb_price-Total_R_Cost) as netincome FROM salestransaction AS S INNER JOIN P_Transaction AS P ON P .VIN=S .VIN LEFT OUTER JOIN (SELECT S.VIN, SUM(R.total_cost) AS Total_R_Cost FROM determine AS D INNER JOIN repairs AS R ON D.repairID = R.repairID inner join SalesTransaction as s on s.vin =d.vin GROUP BY s.VIN) AS RP ON RP.VIN=S.VIN GROUP BY YEAR, MONTH ORDER BY YEAR DESC, MONTH DESC" ; //!!!!!!!need to get rid of inventory vehcile when salestransaction have sales price!!!!!
$result1 = mysqli_query($db, $query1);



echo "Monthly Summary";
if ( !is_bool($result1) && (mysqli_num_rows($result1) > 0)) { 
while($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
  $a=$row['YEAR'];
  $b=$row['MONTH'];
  $c=$row['Total_Sold'];
  $d=$row['Total_Sales_Income'];
  //e=$row[''];
  $f=$row['netincome'];

echo "\t<tr><td>".$a."</td><td>".$b."</td><td>".$c."</td><td>".$d."</td><td>".$f."</td><td>" ."<a href='view_top_sales_person_info.php?y=$a&m=$b.'><button>View Sales Person Information</button></a>|"; 
}}
else {echo "\t<tr><td>"."N/A"."</td><td>"."N/A"."</td><td>"."N/A"."\n";}

?>
</table>
<br><br><br>

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
