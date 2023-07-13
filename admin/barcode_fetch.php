<?php
	require_once('../connection.php');
	$response = array();
	if(isset($_POST['edit']))
	{
		if(isset($_POST['id']))
		{
			$fetchSql = "CALL fetchBarcode_master('".$_POST['id']."')";
			$result = mysqli_query($con,$fetchSql);		
			while($row = mysqli_fetch_array($result))
			{
				$response["barcode"] = $row["barcode"];
				$response["product_name"] = $row["product_name"];
				$response["product_code"] = $row["product_code"];
				$response["gstslab_id"] = $row["gstslab_id"];
				$response["sales_rate"] = $row["sales_rate"];
				$response["mfg_date"] = $row["mfg_date"];
				$response["exp_date"] = $row["exp_date"];
				$response["print_barcode_at"] = $row["print_barcode_at"];
				$response["is_show_barcode"] = $row["is_show_barcode"];
			}		
		}		
	}
	else
	{
		$response["Fail"] = 1;
	}
	echo json_encode($response);

?>