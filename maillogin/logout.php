<?php
session_start();
require_once 'classes/User.php';
$user = new User();

//gibt true zurück wenn $_SESSION['userSession'] gesetzt
if(!$user->is_logged_in())
{
	$user->redirect('index.php');
}

if($user->is_logged_in()!="")
{	
	//beendet session
	$user->logout();	
	$user->redirect('index.php');
}
?>