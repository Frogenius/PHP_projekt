<?php
require '../../../../vendor/autoload.php';

require_once '../dispatcher.php';
require_once '../routing.php';
require_once '../controllers.php';

//aspekty globalne
session_start();
	if (isset($_COOKIE['youname']) && isset($_COOKIE['userid'])&& empty( $_GET["add"])&&($_COOKIE['youname']!='Guest') ) {  
		$_SESSION['youname'] = $_COOKIE['youname'];
		$_SESSION['userid'] = $_COOKIE['userid'];	
		if (isset($_COOKIE['cartp']) )
			$_SESSION['cartp'] = unserialize($_COOKIE['cartp']);			
	}else if (!empty( $_GET["add"]) ){
		setcookie("youname", $_SESSION['youname'], time() + 60 * 60 * 24 * 5, "/"); //5 days
		setcookie("userid", $_SESSION['userid'] , time() + 60 * 60 * 24 * 5, "/"); //5 days	
		if (isset($_COOKIE['cartp']))
			$_SESSION['cartp'] = unserialize($_COOKIE['cartp']);
	}else{
		$_SESSION['youname'] = 'Guest';
		$_SESSION['userid'] = '000';
		$_SESSION['cartp'] = [];		
	}	
	if (!empty( $_GET["exit"]) ){
		$_SESSION = array();
		setcookie("youname", '', time() - 60 * 60 * 24 * 5, '/');
		setcookie("userid", '', time() - 60 * 60 * 24 * 5, '/');
		$_SESSION['youname'] = 'Guest';
		$_SESSION['userid'] = '000';	
		$_SESSION['cartp'] = [];
	}
//wybór kontrolera do wywołania:
$action_url = $_GET['action'];
dispatch($routing, $action_url);

