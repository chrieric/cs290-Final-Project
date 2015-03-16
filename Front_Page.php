<?php
ob_start();
session_start();
include 'Query_Functions.php';
error_reporting(E_ALL);
ini_set('display_errors',1);

$un = 'chrieric-db';
$pass = 'KpqdL049GgphILrs';

//connect to database, if unsuccessful throws error
try{
	$connect = new PDO("mysql:host=oniddb.cws.oregonstate.edu;dbname=chrieric-db",$un,$pass);
	$connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
	print "Error!:".$e->getMessage()."<br/>";
	die();
	
}
	//creates div to display the user that is currently logged in to the page
	echo"<div class='user_info'>";
	$user;
	
	//checks to see if user_name session variable is set
	//if so displays it at the top of the page, otherwise gives generic message
	if(isset($_SESSION['user_name']))
	{
		$user = $_SESSION['user_name'];
		echo "You are currently logged in as $user";
	
		echo "<form action='Back_Page.php' method='post'>";
		echo "<input type='submit' name='log_out' value='Log Out'>";
		echo "</form>";
		
	}
	else
	{
		echo "You are currently not logged in and can only see shared content";
	}
	echo"</div>";
?>
 

<!DOCTYPE html>
<html lang='en'>
<head>
<link rel="stylesheet" type="text/css" href="stylish.css">
<script type="text/javascript" src='Requests.js'></script>
<title>Eve Database</title>
<header>
<h1>Eve Database</h1>
</header>
</head>
<body>
<div class='add_button_div'>
<div class='drop_text'>
Use the drop down menu to select a table.
</div>
 
<?php
	
	$table_fields;
	$table_name;
	
	//checks to see if a user_id session variable is set, if not sets the user_session variable
	//to a default value, mainly for testing purposes
	if(isset($_SESSION['user_id']))
	{
		$user_session = $_SESSION['user_id'];
	}
	else
	{
		$user_session = 1;
	}
	
	//checks to see if a dropdown session variable is set or if it is equal to pilot
	//if so it displays the pilot table
	//if not it displays the table associated with the dropdown session variable
	if(!(isset($_SESSION['dropdown']))||$_SESSION['dropdown']=='Pilot')
	{
		$table_name = 'pilot';
		//query string for pilot (default) table to display
		$query_string = "SELECT * FROM pilot WHERE user_id=1";
		
			//if a user session is in place add that user's id to query as well
			if(isset($_SESSION['user_id']))
			{
				$query_string.=" OR user_id=:id";
			}
		
		//prepare and execute sql query
		$prepped = $connect->prepare($query_string);
		
		$prepped->execute(array(":id" => $user_session));
		
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
				$query_string.=" OR user_id=$user_session";
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
	
	
	//echo "<div class='add_button_div'>";
	//the below code creates a drop down menu to allow the user to specify which table they want to view
	echo "<div class='drop_select'>";
	echo "<form action='Back_Page.php' method='post'>";
	echo dropDown('dropdown',$curr_table);
	echo "<input class='select_button' type='submit' name='dropselect' value='Select'>";
	echo "</form>";
	echo "</div>";
	echo "<br>";
	echo "<br>";
	echo "<br>";
	
	echo "<div class='add_text'>";
	echo "<b>Add Row</b>";
	echo "</div>";
	//variable dependent on currently selected table
	$add_row = 'add_'.$table_name;
	
	//form to add values to the current table via POST
	echo"<form action='Back_Page.php' method='post'>";
	
	//loops through column names
	foreach($table_fields as $field => $keyf)
	{	
		//creates a text field for each column
		if($keyf != 'id' && $keyf != 'user_id')
		{		
			echo "<label>".$keyf."</label>";
			echo "<input type='text' name=\"".$keyf."\">";
		}
	}
	//creates rest of input and button to send data
	echo "<input type='hidden' name=user_id value=\"".$user_session."\">";
	echo "<input type='submit' name=$add_row id = 'Add' value='Add'>";
	echo "</form>";
	echo "</div>";
 ?>
 
<div class='table_div'>
<table border='1'>

<thead>
<?php	

	//displays column heads
	//echo '<th>Update</th>';
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
	//array holding the table names available
	$curr_table=array('pilot','pilot_skill','skill','skill_req','ship_type','ship_req');
	$row;
	
	//loops over data returned by SQL query and creates a table row
	while($row = $prepped->fetch(PDO::FETCH_ASSOC))
	{
		echo "<tr>";
		
		/*
		echo "<td>";
		echo "<form action='QueryFunctions.php' method='post'>";
		echo "<input type='hidden' name='id' value=\"".$row['id']."\">";
		echo "<input type='submit' name='update_row' value='Update'>";
		echo "</form>";
		echo "</td>";
		*/
		
		//creates button to delete a table row via post
		echo "<td>";
		echo "<form action='Back_Page.php' method='post'>";
		echo "<input type='hidden' name='id' id='del_id' value=\"".$row['id']."\">";
		echo "<input type='hidden' name='t_name' id='del_t_name' value=\"".$table_name."\">";
		echo "<input type='hidden' name='user' id='del_user' value=\"".$user_session."\">";
		echo "<input type='submit' name='delete_row' value='Delete'>";
		
		//echo "<input type='button' value ='Delete' onclick='deleteRequest(id.value,t_name.value,user.value)'>";
		echo "</form>";
		echo "</td>";
		
		//creates data for table row
		foreach($row as $array => $key)
		{
			if($array != 'id' && $array != 'user_id')
			{
				echo '<td>' . $key . '</td>';
			}
			
		}
		
		echo "</tr>";
	}
	echo "<div id='delete_message'></div>";
	echo "</tbody>";
	echo "</div>";

	$connect = null;
?>	
	
 
</body>
</html>