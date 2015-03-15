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
	$table_name = 'Pilot';
	
	//$_SESSION['dropdown']='Pilot';
	
	if(!(isset($_SESSION['dropdown']))||$_SESSION['dropdown']=='Pilot')
	{
		//update for prep and binds?
		//$prepped = $connect->prepare("SELECT * FROM pilot WHERE id=1 AND id=:id");
		
		//$prepped->execute(array(':id'=>$_SESSION['username']));
		
		$prepped = $connect->prepare("SELECT * FROM pilot WHERE user_id=1");
		
		$prepped->execute();
		
		$prep2 = $connect->prepare("DESCRIBE pilot");
		$prep2->execute();
		
		$table_fields=$prep2->fetchAll(PDO::FETCH_COLUMN);
	}
	else
	{
		$table_name=$_SESSION['dropdown'];
		
		$query_string = "SELECT * FROM $table_name";
		
		//update for prep and binds?
		//$prepped = $connect->prepare("SELECT * FROM $table_name WHERE id=1 AND id=:id");
		
		//$prepped->execute(array(':id'=>$_SESSION['username']));
		
		if($table_name == 'skill' || $table_name == 'ship_type')
		{
			$query_string.=" WHERE user_id=1";
		}
		
		$prepped = $connect->prepare($query_string);
		
		$prepped->execute();
		
		$prep2 = $connect->prepare("DESCRIBE $table_name");
		$prep2->execute();
		
		$table_fields=$prep2->fetchAll(PDO::FETCH_COLUMN);
	}
	
	$_SESSION['dropdown']='Pilot';
	
	$curr_table=array('Pilot','pilot_skill','skill','skill_req','ship_type','ship_req');
	
	echo "<form action='Back_Page.php' method='post'>";
	echo dropDown('dropdown',$curr_table);
	echo "<input type='submit' name='dropselect' value='Select'>";
	echo "</form>";
 
	echo"<form action='Back_Page.php' method='post'>";
	echo "<input type='submit' name=add_row' value='Add'>";
	foreach($table_fields as $field => $keyf)
	{	
		echo $keyf;
		echo "<input type='text' id=\"".$keyf."\">";
	}
	
	echo "</form>";
 
 ?>
 
 <table border='1'>
	<thead>
<?php	
	//displays column heads
	foreach($table_fields as $step => $keys)
	{
		echo '<th>' .$keys.'</th>';
	}
?>	
	</thead>
	<tbody>
 
 <?php
 
	$curr_table=array('pilot','pilot_skill','skill','skill_req','ship_type','ship_req');
	$row;
	
	//need to figure out how to get this to work for a "generalized" table
	while($row = $prepped->fetch(PDO::FETCH_ASSOC))//stmt is current name of object, can be different
	{
		echo "<tr>";
		
		foreach($row as $array => $key)
		{
			echo '<td>' . $key . '</td>';
		}
		
		echo "<td>";
		echo "<form action='QueryFunctions.php' method='post'>";
		echo "<input type='hidden' name='id' value=\"".$row['id']."\">";
		echo "<input type='submit' name='update_row' value='Update'>";
		echo "</form>";
		echo "</td>";
		
		echo "<td>";
		echo "<form action='Back_Page.php' method='post'>";
		echo "<input type='hidden' name='id' value=\"".$row['id']."\">";
		echo "<input type='hidden' name='id' value=\"".$table_name."\">";
		echo "<input type='submit' name='delete_row' value='Delete'>";
		echo "</form>";
		echo "</td>";
		
		echo "</tr>";
	}
	
	echo "</tbody>";


	$connect = null;
?>	
	
 
</body>
</html>