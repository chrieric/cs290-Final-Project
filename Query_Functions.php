<?php
error_reporting(E_ALL);
ini_set('display_errors',1);


$failure=0;
 
 /*
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

//these functions are rewritten for the PDO object from a previous assignment, no testing yet


//Attempt at a general function to update any table if given the table name
function updateTable($array,$table_name)
{
	global $connect;
	global $e;
	$param_type = array();
	$r_param_type =array();
	$temp="";
	$query_string = "INSERT INTO $table_name ("
 
	//if the array passed is larger than 0 it will build a query
	//based on the values in the table
	if(count($array) > 0)
	{
		foreach($array as $value => $key)
		{
			$query_string.=$value[$key];
			$query_string.=", ";
			$temp = gettype($value[$key]);
			array_push($param_type,$temp[0]);
		}
		
		chop($query_string,",");
		
		$query_string.=" VALUES (";
		
		foreach($array as $value)
		{
			$query_string.="?,";
		}
		
		chop($query_string,",");
		
		$query_string.=")";
		
		$r_param_type=&$param_type;
	
		try{
			$prepped=$connect->prepare($query_string);
			
			$prepped->execute($param_type); //this is not complete, need to look at example
			//page again to better understand how they are carrying this out
		}
		catch
		{
			echo "Error!". $e->getMessage() . <br/>;
			die();
		}
		
		$prepped = null;
	
	}
	else
	{
		$failure=1;
		
		echo "Error occured while processing your request, click <a href='front_page.php'>here</a> to return to your inventory.";
	}
};

//attempt at a general function to delete a row given the row's identifier and the table's name
function deleteRow($array,$table_name,$identifier)
{
	global $connect;
	$id=$array[$identifier]; /*this is just to inform me what should be here, change later
	$query_string="DELETE FROM $table_name WHERE id= ?";
	
	if($id!=null)
	{
		try{
			$prepped=$connect->prepare($query_string);
			
			$prepped->bind('i',$id);
			
			$prepped->execute();
		}
		catch
		{
			echo "Error!". $e->getMessage() . <br/>;
			die();
		}
		
		$connect=null;
	}
	else
	{
		echo "Identifier not found click <a href='front_page.php'>here</a> to return to your tables.";
	}
};

//will delete all values from a table of the given table name
function deleteAll($array, $table_name)
{
	global $connect;
	
	try {
    		$stmt=$connect->prepare("DELETE FROM $table_name")
    		$stmt->execute();
    	}
    	catch (PDOException $e) {
    		print "Error!: " . $e->getMessage() . "<br/>";
    		die();
	}
	
	
	$stmt=null;
};
*/
//creates a drop down menu when passed an array of values, the values will be the drop down's options
function dropDown($id,array $options)
{
	//initial string with no selects
	$drop='<select name="'.$id.'">'."\n";
	
	//number of selectable options
	$len=count($options);
	
	//$drop.='<option value="Default">Default</option>'."\n";
	
	//adds each selectable option
	for($i=0;$i<$len;$i++)
	{
		$drop.= '<option value="'.$options[$i].'">'.$options[$i].'</option>'."\n";
	}
	
	//closes select tag and returns the html for the drop down menu
	$drop.='</select>'."\n";
	
	return $drop;
};

?>