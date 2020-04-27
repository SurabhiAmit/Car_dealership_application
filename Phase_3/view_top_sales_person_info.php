<?php
// written by team023 Meng Li
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
//echo "Database Connected successfully <br> ";
 
?> 

<html>  
<title>Top Performing Sales Person</title>
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
<h2>Top Performing Sales Person</h2>
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
        <th>First Name</th>
        <th>Last Name</th>
        <th>Number of Vehicles Sold</th>
        <th>Total Sales</th>
    </tr>
	 

<?php 

   $YEAR=$_GET['y'];
   $MONTH=$_GET['m'];
   
   //$sql="SELECT COUNT(salestransaction.VIN) AS NumofVeh FROM salestransaction WHERE YEAR(salestransaction.sales_date) = 2019 AND MONTH(salestransaction.sales_date) = $MONTH";
   
   $sql= "SELECT first_name, last_name, COUNT(S.VIN) AS NumofVeh, SUM(salesPrice) AS TotalSale FROM salestransaction AS S INNER JOIN users AS U
   ON U.username= S.salespeople_username  where YEAR(S.sales_date)=$YEAR AND MONTH(S.sales_date)=$MONTH group by first_name,last_name ORDER BY NumofVeh DESC, TotalSale DESC
   LIMIT 1";
    //!!!!!!!!!!!get rid of inventory vehcile when salestransaction get price!!!!!!!!!
   $result2 = $db->query($sql);
    // output data of each row
   if (  !is_bool($result2) && (mysqli_num_rows($result2) > 0) ) {
   while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC) ) { 
     echo "\t<tr><td>".$row2['first_name']."</td><td>".$row2['last_name']."</td><td>".$row2['NumofVeh']."</td><td>".$row2['TotalSale'];  
    } //END of while  
    }
    else {
    echo "\t<tr><td>"."N/A"."</td><td>"."N/A"."</td><td>"."N/A"."</td><td>"."N/A"."\n"; 
    }  

?>



</table>
   
</form>  
 
<?php include 'footer.php'; ?>
 
</body>
</html>
