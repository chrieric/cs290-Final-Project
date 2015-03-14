<?php
session_start();


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
 
$user;
$password;
$user_id;
 
if(isset($_POST['username']) && isset($_POST['password']))
{
	$user = $_POST['username'];
	$password = $_POST['password'];
	
	try{
		$prepped = $connect->prepare("SELECT id FROM user WHERE user_name= :user");
		
		$prepped->execute(array(':user'=>$_POST['username']));
	
		$rows=$prepped->fetchAll();
	}
	catch(PDOException $e)
	{
		print "Error!:".$e->getMessage()."<br/>";
		die();
	}
	
	if(!(count($rows) > 0))
	{
		$prepped = $connect->prepare("INSERT INTO user (user_name,password) VALUES(:user,:pass)");
		
		$prepped->execute(array(':user'=>$user,':pass'=>$password));
	}


	/*
	$rows=$prepped->fetchAll()
 
	if(count($rows)==1)
	{
		$_SESSION['logged_user']=$rows['id'];
		echo $rows['id'];
	}
	*/
	
	$connect = null;
}
?>