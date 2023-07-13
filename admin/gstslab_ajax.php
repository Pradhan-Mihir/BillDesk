<?php
	require_once('../connection.php');
	$response = array();
	if(isset($_POST['edit']))
	{
		if(isset($_POST['id']))
		{
			$fetchSql = "CALL fetchGstslab('".$_POST['id']."')";
			$result = mysqli_query($con,$fetchSql);		
			while($row = mysqli_fetch_array($result))
			{
				$response["gstslab_name"] = $row["gstslab_name"];
				$response["cgst"] = $row["cgst"];
				$response["sgst"] = $row["sgst"];
				$response["igst"] = $row["igst"];
			}		
		}		
	}
    else if(isset($_POST['delete']))
	{
		if(isset($_POST['id']))
		{
			$deleteSql = "CALL deleteGstslab('".$_POST['id']."')";
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