<?php
session_start();
try{
	$connect = new PDO('oniddb.cws.oregonstate.edu;dbname=chrieric-db',$user,$pass)
	$connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
	print "Error!:".$e->getMessage()."<br/>";
	die();
}
 
$user;
$password;
$user_id;
 
if(isset($_POST['username']) && isset($_POST['password'])
{
	$user = $_POST['username'];
	$password = $_POST['password'];
	
	//would this be better to include a bind statement and get our username and password into the prepared statement
	//in that way? either way SHOULD work, bind is the way we were taught...
	try{
		$prepped = $connect->prepare("INSERT INTO user (user_name,password) VALUES(:user,:pass)");
		
		$prepped->execute(array(':user'=>$user,':pass'=>$password));
	}
	catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}
	
	/*
	$rows=$prepped->fetchAll()
 
	if(count($rows)==1)
	{
		$_SESSION['logged_user']=$rows['id'];
		echo $rows['id'];
	}
	*/
}
?>