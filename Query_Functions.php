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
*/
//these functions are rewritten for the PDO object from a previous assignment, no testing yet


//Adds a pilot to the pilot table
function addPilot($data)
{
	$first = $data['first_name'];
	$last = $data['last_name'];
	$race = $data['race'];
	$user = $data['user_id'];
		
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
		
	try{
		$prep = $connect->prepare("INSERT INTO pilot (first_name,last_name,race,user_id) VALUES(:first_name,:last_name,:race,:user)");
		
		$prep->execute(array(":first_name" => $first, ":last_name" => $last, ":race" => $race,":user" =>$user));
	}
	catch(PDOException $e)
	{
		print "Error!:".$e->getMessage()."<br/>";
		die();
	}
	
	$connect = null;
	
};

//adds a skill to the skill table
function addSkill($data)
{
	$name = $data['name'];
	$user = $data['user_id'];
		
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
		
	try{
		$prep = $connect->prepare("INSERT INTO skill (name,user_id) VALUES(:name,:user)");
		
		$prep->execute(array(":name" => $name,":user" =>$user));
	}
	catch(PDOException $e)
	{
		print "Error!:".$e->getMessage()."<br/>";
		die();
	}
	
	$connect = null;
	
};

//adds a ship to the ship_type table
function addShip($data)
{
	$name = $data['name'];
	$class = $data['class'];
	$high = $data['high_slot_mods'];
	$med = $data['med_slot_mods'];
	$low = $data['low_slot_mods'];
	$shield = $data['shield_hp'];
	$armor = $data['armor_hp'];
	$hull = $data['hull_hp'];
	$speed = $data['max_speed'];
	$CPU = $data['CPU'];
	$PG = $data['PG'];
	$user = $data['user_id'];
		
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
		
	try{
		$prep = $connect->prepare("INSERT INTO ship_type (name,class,high_slot_mods,med_slot_mods,low_slot_mods,shield_hp,armor_hp,hull_hp,max_speed,CPU,PG,user_id) VALUES(:name,:class,:high,:med,:low,:shield,:armor,:hull,:speed,:CPU,:PG,:user)");
		
		$prep->execute(array(":name" => $name,":class" =>$class,":high" =>$high,":med" =>$med,":low" =>$low,":shield" =>$shield,":armor" =>$armor,":hull" =>$hull,":speed" =>$speed,":CPU" =>$CPU,":PG" =>$PG,":user" =>$user));
	}
	catch(PDOException $e)
	{
		print "Error!:".$e->getMessage()."<br/>";
		die();
	}
	
	$connect = null;
	
};

//attempt at a general function to delete a row given the row's identifier and the table's name


function deleteRow($data)
{
	$id = $data['id'];
	$user = $data['user'];
	$table = $data['t_name'];
	
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
	
	try{
		$prep = $connect->prepare("DELETE FROM $table WHERE id=:id AND user_id=:user");
			
		$prep->execute(array(":id" => $id, ":user" => $user));
	}
	catch(PDOException $e)
	{
		print "Error!:".$e->getMessage()."<br/>";
		die();
	}

	$connect = null;
};


/*
//will delete all values from a table of the given table name, use only for testing
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