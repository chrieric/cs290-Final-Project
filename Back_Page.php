<?php
session_start();
ob_start();
include 'Query_Functions.php';
error_reporting(E_ALL);
ini_set('display_errors',1);

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
	$failure++;
}
*/

if(isset($_POST['delete_row']))
{
	
}


if(isset($_POST['dropselect']))
{
	$_SESSION['dropdown']=$_POST['dropdown'];
	
	if($failure==0)
	{
		header("Location:Front_Page.php");
	}
	
}
?>