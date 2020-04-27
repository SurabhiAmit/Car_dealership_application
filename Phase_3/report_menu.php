<!DOCTYPE html>
<html>
<head>
	<style>  
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #808080;
}

li {
  float: left;
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 16px;
  text-decoration: none;
}

li a:hover {
  background-color: #111111;
}
	</style>
</head>

<body style="background-color:powderblue;">
 
			
			<div class="nav_bar">
				<ul>    
                    <li><a href="seller_history.php" <?php if($current_filename=='Seller History.php') echo "class='active'"; ?>><b>View Seller History Report</b></a></li>                       
					<li><a href="inventory_age.php" <?php if(strpos($current_filename, 'inventory_age.php') !== false) echo "class='active'"; ?>><b>View Inventory Age Report</b></a></li>  
                    <li><a href="average_time_in_inventory.php" <?php if($current_filename=='average_time_in_inventory.php') echo "class='active'"; ?>><b>View Average Time in Inventory Report</b></a></li>  
                    <li><a href="price_per_condition.php" <?php if($current_filename=='price_per_condition.php') echo "class='active'"; ?>><b>View Price Per Condition Report</b></a></li>  
                    <li><a href="repair_statistics.php" <?php if($current_filename=='repair_statistics.php') echo "class='active'"; ?>><b>View Repair Statistics Report</b></a></li>  
                    <li><a href="monthly_sales_report.php" <?php if($current_filename=='monthly_sales.php') echo "class='active'"; ?>><b>View Monthly Sales Report</b></a></li>  
                    <li><a href="logout.php"  <b>Log Out</b></a></li>              
				</ul>
			</div>
<br><br> 

 
</body>
</html>
