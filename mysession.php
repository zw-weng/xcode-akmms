<?php
	if(!session_id())
	{
		session_start();
	}
	if(isset($_SESSION['user_id']) != session_id())
	{
		header('Location:login.php');
	}
?>