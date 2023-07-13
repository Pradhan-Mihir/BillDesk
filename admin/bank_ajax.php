<?php
	require_once('../connection.php');
	$response = array();
	if(isset($_POST['inv_delete']))
	{
		if(isset($_POST['id']))
		{
			$deleteSql = "delete from tbl_bank_account where bank_account_id = '".$_POST['id']."' ";
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