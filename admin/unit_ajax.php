<?php
	require_once('../connection.php');
	$response = array();
	if(isset($_POST['edit']))
	{
		if(isset($_POST['id']))
		{
			$fetchSql = "CALL fetchUnit('".$_POST['id']."')";
			$result = mysqli_query($con,$fetchSql);		
			while($row = mysqli_fetch_array($result))
			{
				$response["unit_name"] = $row["unit_name"];
			}		
		}		
	}
    else if(isset($_POST['delete']))
	{
		if(isset($_POST['id']))
		{
			$deleteSql = "CALL deleteUnit('".$_POST['id']."')";
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