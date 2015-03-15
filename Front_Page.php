<?php
ob_start();
session_start();
include 'Query_Functions.php';
error_reporting(E_ALL);
ini_set('display_errors',1);

$un = 'chrieric-db';
$pass = 'KpqdL049GgphILrs';

try{
	$connect = new PDO("mysql:host=oniddb.cws.oregonstate.edu;dbname=chrieric-db",$un,$pass);
	$connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
	print "Error!:".$e->getMessage()."<br/>";
	die();
}
?>
 

<!DOCTYPE html>
<html lang='en'>
<head>
<link rel="stylesheet" type="text/css" href="stylish.css">
<script src='buttons.js'></script>
<title>Eve Database</title>
<header>
<h4>Eve Database</h4>
</header>
</head>
<body>
<p>Use the drop down menu to select the table name you wish to display</p>
 
<?php
	$table_fields;
	$table_name;
	
	if(isset($_SESSION['user_id']))
	{
		$user_session = $_SESSION['user_id'];
	}
	else
	{
		$user_session = 1;
	}
	
	
	//$_SESSION['dropdown']='Pilot';
	
	if(!(isset($_SESSION['dropdown']))||$_SESSION['dropdown']=='Pilot')
	{
		$table_name = 'pilot';
		//query string for pilot (default) table to display
		$query_string = "SELECT * FROM pilot WHERE user_id=1";
		
			//if a user session is in place add that user's id to query as well
			if(isset($_SESSION['user_id']))
			{
				$query_string.=" AND user_id=$user_session";
			}
		
		//prepare and execute sql query
		$prepped = $connect->prepare($query_string);
		
		$prepped->execute();
		
		//prepare and execute query to get column names
		$prep2 = $connect->prepare("DESCRIBE pilot");
		$prep2->execute();
		
		//store column names in table_fields variable
		$table_fields=$prep2->fetchAll(PDO::FETCH_COLUMN);
	}
	else
	{
		//sets table name variable based on the item selected from drop down menu
		$table_name=$_SESSION['dropdown'];
		
		//query string to allow easy change for SQL query
		$query_string = "SELECT * FROM $table_name";
		
		//if table name is one of the following add user_id attribute to query
		if($table_name == 'skill' || $table_name == 'ship_type')
		{
			$query_string.=" WHERE user_id=1";
			
			//if a user session is in place add that user's id as well
			if(isset($_SESSION['user_id']))
			{
				$query_string.=" AND user_id=$user_session";
			}
		}
		
		//prepare and execute assembled SQL query
		$prepped = $connect->prepare($query_string);
		
		$prepped->execute();
		
		//prep and execute query to get column names of specified table
		$prep2 = $connect->prepare("DESCRIBE $table_name");
		$prep2->execute();
		
		//store in table_fields
		$table_fields=$prep2->fetchAll(PDO::FETCH_COLUMN);
	}
	
	$_SESSION['dropdown']='Pilot';
	
	//array of possible tables to select
	$curr_table=array('Pilot','skill','ship_type');
	//$curr_table=array('Pilot','pilot_skill','skill','skill_req','ship_type','ship_req');
	
	//the below code creates a drop down menu to allow the user to specify which table they want to view
	echo "<form action='Back_Page.php' method='post'>";
	echo dropDown('dropdown',$curr_table);
	echo "<input type='submit' name='dropselect' value='Select'>";
	echo "</form>";
 
 
	$add_row = 'add_'.$table_name;
	//form to add values to the current table
	echo"<form action='Back_Page.php' method='post'>";
	echo "<input type='submit' name=$add_row value='Add'>";
	foreach($table_fields as $field => $keyf)
	{	
		//loops over the current columns and creates an input for each
		if($keyf != 'id' && $keyf != 'user_id')
		{		
			echo $keyf;
			echo "<input type='text' name=\"".$keyf."\">";
		}
	}
	echo "<input type='hidden' name=user_id value=\"".$user_session."\">";
	echo "</form>";
 ?>

 <table border='1'>
	<thead>
<?php	

	//displays column heads
	echo '<th>Update</th>';
	echo '<th>Delete</th>';
	foreach($table_fields as $step => $keys)
	{
		if($keys != 'id' && $keys != 'user_id')
		{
			echo '<th>' .$keys.'</th>';
		}
		
	}
?>	
	</thead>
	<tbody>
 
 <?php
 
	$curr_table=array('pilot','pilot_skill','skill','skill_req','ship_type','ship_req');
	$row;
	
	while($row = $prepped->fetch(PDO::FETCH_ASSOC))//stmt is current name of object, can be different
	{
		echo "<tr>";
		
		echo "<td>";
		echo "<form action='QueryFunctions.php' method='post'>";
		echo "<input type='hidden' name='id' value=\"".$row['id']."\">";
		echo "<input type='submit' name='update_row' value='Update'>";
		echo "</form>";
		echo "</td>";
		
		echo "<td>";
		echo "<form action='Back_Page.php' method='post'>";
		echo "<input type='hidden' name='id' value=\"".$row['id']."\">";
		echo "<input type='hidden' name='t_name' value=\"".$table_name."\">";
		echo "<input type='hidden' name='user' value=\"".$user_session."\">";
		echo "<input type='submit' name='delete_row' value='Delete'>";
		echo "</form>";
		echo "</td>";
		
		
		foreach($row as $array => $key)
		{
			if($array != 'id' && $array != 'user_id')
			{
				echo '<td>' . $key . '</td>';
			}
			
		}
		
		echo "</tr>";
	}
	
	echo "</tbody>";


	$connect = null;
?>	
	
 
</body>
</html>