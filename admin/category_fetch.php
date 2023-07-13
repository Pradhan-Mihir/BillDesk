<?php
	require_once('../connection.php');
	$response = array();
	if(isset($_POST['edit']))
	{
		if(isset($_POST['id']))
		{
			$fetchSql = "CALL fetchCategory('".$_POST['id']."')";
			$result = mysqli_query($con,$fetchSql);		
			while($row = mysqli_fetch_array($result))
			{
				$response["category_code"] = $row["category_code"];
				$response["category_name"] = $row["category_name"];
			}		
		}		
	}
	else
	{
		$response["Fail"] = 1;
	}
	echo json_encode($response);

?>