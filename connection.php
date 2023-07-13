<?php
	$con = mysqli_connect('localhost','root','');
	
	if(!$con)
	{
		die('Not connected.'.mysqli_error($con));
	}
	/*else
	{
		echo "Connection succesfull.";
	}*/
	
	$db = mysqli_select_db($con,'tryon_project');
	
	if(!$db)
	{
		die('Not connected with database.'.mysqli_error($con));
	}
	/*else
	{
		echo "Succesfully connected with database.";
	}*/
?>