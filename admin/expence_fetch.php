<?php
	require_once('../connection.php');
	$response = array();
	if(isset($_POST['edit']))
	{
		if(isset($_POST['id']))
		{
			$fetchSql = "select * from tbl_expence where expence_id = '".$_POST['id']."' ";
			$result = mysqli_query($con,$fetchSql);		
			while($row = mysqli_fetch_array($result))
			{
				$response["expense_id"] = $row["expense_id"];
				$response["date"] = $row["date"];
				$response["payment_type_id"] = $row["payment_type_id"];
				$response["cheque_ref_no"] = $row["cheque_ref_no"];
				$response["is_round_off"] = $row["is_round_off"];
				$response["round_off"] = $row["round_off"];
				$response["total"] = $row["total"];
				$response["description"] = $row["description"];
			}		
		}		
	}
	else
	{
		$response["Fail"] = 1;
	}
	echo json_encode($response);

?>