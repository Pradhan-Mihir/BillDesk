<?php
	require_once('../connection.php');
	$response = array();
	if(isset($_POST['delete']))
	{
		if(isset($_POST['id']))
		{
			$deleteSql ="delete from tbl_income_type where income_type_id = '".$_POST['id']."' ";
			if(mysqli_query($con,$deleteSql))
			{
				$response["Success"] = 1;
			}
			else
			{
				$response["Fail"] = 1;
			}
		}		
	}
	else
	{
		$response["Fail"] = 1;
	}
	echo json_encode($response);
?>