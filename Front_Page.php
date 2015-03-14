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
 
	if(!(isset($_SESSION['dropdown']))||$_SESSION['dropdown']=='Pilot')
	{
		//update for prep and binds?
		//$prepped = $connect->prepare("SELECT * FROM pilot WHERE id=1 AND id=:id");
		
		//$prepped->execute(array(':id'=>$_SESSION['username']));
		
		$prepped = $connect->prepare("SELECT * FROM pilot WHERE user_id=1");
		
		$prepped->execute();
	}
	else
	{
		$table_name=$_SESSION['dropdown'];
		//update for prep and binds?
		$prepped = $connect->prepare("SELECT * FROM $table_name WHERE id=1 AND id=:id");
		
		$prepped->execute(array(':id'=>$_SESSION['username']));
	}
	
	$_SESSION['dropdown']='Pilot';
 
 ?>
 
 <table border='1'>
	<thead>
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
		
		/*
		
		echo "<td>";
		echo "deleteButton($table_name,$row['id'])";
		echo "updateButton($table_name,$row['id'])";
		echo "</td>";
		*/
		
		echo "</tr>";
	}
	
	echo "</tbody>";
	$curr_table=array('Pilot','pilot_skill','skill','skill_req','ship_type','ship_req');
	
	echo "<form action='Query_Functions.php' method='post'>";
	echo dropDown('dropdown',$curr_table);
	echo "<input type='submit' name='dropselect' value='Select'>";
	echo "</form>";
	
	$connect = null;
?>	
	
 
</body>
</html>