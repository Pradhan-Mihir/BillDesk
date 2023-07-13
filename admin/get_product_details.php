<?php
	require_once('../connection.php');
	$response = array();
	if(isset($_POST['edit']))
	{
		if(isset($_POST['id']))
		{
			$fetchSql = "CALL fetchProduct_master('".$_POST['id']."')";
			$result = mysqli_query($con,$fetchSql);		
			while($row = mysqli_fetch_array($result))
			{
				$response["category_id"] = $row["category_id"];
				$response["barcode"] = $row["barcode"];
				$response["product_code"] = $row["product_code"];
				$response["product_name"] = $row["product_name"];
				$response["gstslab_id"] = $row["gstslab_id"];
				$response["hsn_code"] = $row["hsn_code"];
				$response["unit_id"] = $row["unit_id"];
				$response["purchase_rate"] = $row["purchase_rate"];
				$response["purchase_tax_type"] = $row["purchase_tax_type"];
				$response["sales_rate"] = $row["sales_rate"];
				$response["sales_tax_type"] = $row["sales_tax_type"];
				$response["opening_stock"] = $row["opening_stock"];
				$response["unit_per_price"] = $row["unit_per_price"];
				$response["description"] = $row["description"];
				$response["min_stock_qty"] = $row["min_stock_qty"];
				$response["product_location"] = $row["product_location"];
				$response["product_date"] = $row["product_date"];
				$response["product_image"] = $row["product_image"];
			}		
		}		
	}
	else
	{
		$response["Fail"] = 1;
	}
	echo json_encode($response);

?>