<?php
	require_once('../connection.php');
	$response = array();
	if(isset($_POST['edit']))
	{
		if(isset($_POST['id']))
		{
			$fetchSql = "CALL fetchColor('".$_POST['id']."')";
			$result = mysqli_query($con,$fetchSql);		
			while($row = mysqli_fetch_array($result))
			{
				$response["color_name"] = $row["color_name"];
			}		
		}		
	}
	else
	{
		$response["Fail"] = 1;
	}
	echo json_encode($response);

?>