<?php
ob_start();
session_start();
include 'QueryFunctions.php';
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
<title>Eve Database</title>
<header>
<h4>Database Collection</h4>
</header>
</head>
<body>
<p>Use the drop down menu to select the table name you wish to display</p>
 
<?php
	if(!(isset($_SESSION['dropdown']))||$_SESSION['dropdown']=='Pilot')
	{
		//update for prep and binds?
		if(!($stmt = connect->query("SELECT * FROM pilot")))
		{
			echo "Query failed: (" . $mysqli->errno . ") ". $mysqli->error;
		}
	}
	else
	{
		$table_name=$_SESSION['dropdown'];
		//update for prep and binds?
		if(!($stmt= connect->query("SELECT * FROM $table_name")))
		{
			echo "Query failed: (" . $mysqli->errno . ") ". $mysqli->error;
		}
	}
	
	$_SESSION['dropdown']='Pilot';
?>
 
	$curr_categories=array();
	$row;
	
	//need to figure out how to get this to work for a "generalized" table
	while($row = $stmt->fetchAll(PDO::FETCH_ASSOC))//stmt is current name of object, can be different
	{
		echo "<tr>"
		
		foreach($row as $array => $key)
		{
			echo "<td>" . "$array[$key]" . "</td>"
		}
		
		echo "<td>";
		echo "<form action='QueryFunctions.php' method='post'>";	//may need to alter this line
		echo "<input type='hidden' name='id' value=\"".$row['id']."\">";
		echo "<input type='submit' name='delete_movie' value='Delete'>";
		echo "</form>";
		echo "</td>";
		
		</tr>
	}
	
	
 
</body>
</html>