<?php
	require_once('../connection.php');
	$response = array();
	if(isset($_POST['edit']))
	{
		if(isset($_POST['id']))
		{
			$fetchSql = "CALL fetchFinancial_master('".$_POST['id']."')";
			$result = mysqli_query($con,$fetchSql);		
			while($row = mysqli_fetch_array($result))
			{
				$response["financial_year"] = $row["financial_year"];
				$response["financial_name"] = $row["financial_name"];
				$response["start_date"] = $row["start_date"];
				$response["end_date"] = $row["end_date"];
				$response["is_default"] = $row["is_default"];
			}		
		}		
	}
	else
	{
		$response["Fail"] = 1;
	}
	echo json_encode($response);

?>