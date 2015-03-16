<?php
session_start();
ob_start();
include 'Query_Functions.php';
//include 'Front_Page.php';
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

if(isset($_POST['log_out']))
{
	logOut();
	
	if($failure==0)
	{
		echo '<script type="text/javascript">window.location = "Login.html";</script>';
	}
}

if(isset($_POST['delete_row']))
{
	deleteRow($_POST);
	$_SESSION['dropdown']=$_POST['t_name'];
	if($failure==0)
	{	
		header("Location:Front_Page.php");
		$_POST = array();
	}
}

if(isset($_POST['add_skill']))
{
	addSkill($_POST);
	$_SESSION['dropdown']='skill';
	if($failure==0)
	{
		header("Location:Front_Page.php");
		$_POST = array();
	}
}

if(isset($_POST['add_ship_type']))
{
	addShip($_POST);
	$_SESSION['dropdown']='ship_type';
	if($failure==0)
	{
		header("Location:Front_Page.php");
		$_POST = array();
	}
}

if(isset($_POST['add_pilot']))
{
	addPilot($_POST);
	$_SESSION['dropdown']='pilot';
	if($failure==0)
	{
		header("Location:Front_Page.php");
		$_POST = array();
	}
}

if(isset($_POST['dropselect']))
{
	$_SESSION['dropdown']=$_POST['dropdown'];
	
	if($failure==0)
	{
		header("Location:Front_Page.php");
		$_POST = array();
	}
	
}
?>