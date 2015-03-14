<?php
session_start();
ob_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

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


//$user_id;
if(isset($_POST['username']) && isset($_POST['password']))
{

	//would this be better to include a bind statement and get our username and password into the prepared statement
	//in that way? either way SHOULD work, bind is the way we were taught...
	$prepped = $connect->prepare("SELECT id FROM user WHERE user_name= :user AND password= :pass");
		
	$prepped->execute(array(':user'=>$_POST['username'],':pass'=>$_POST['password']));
	
	$rows=$prepped->fetchAll();
	
	if(count($rows)==1)
	{
		$_SESSION['logged_user']=$rows['id'];
		//echo $rows['id'];
	}
	$connect = null;
	
}

?>