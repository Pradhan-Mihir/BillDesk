<?php
	require_once('../connection.php');
	$response = array();
	if(isset($_POST['delete']))
	{
		$sql_select = "select * from tbl_payment_in where payment_in_id = '".$_POST['id']."'";
		$resultView = mysqli_query($con,$sql_select);
		if(mysqli_num_rows($resultView) > 0)
		{
			while($rowView = mysqli_fetch_array($resultView))
			{
				$image1 = $rowView['image'];
				$path = $_SERVER['DOCUMENT_ROOT'].'/tryon_project_mbm/images/payment_in_images/';
				if (file_exists($path.$image1)) 
				{
					unlink($path.$image1);
				}				
			}
		}
		
		if(isset($_POST['id']))
		{
			$deleteSql = "CALL deletePayment_in('".$_POST['id']."')";
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