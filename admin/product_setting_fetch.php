<?php
	require_once('../connection.php');
	$response = array();
	
	if(isset($_POST['setting']))
	{	
		if(isset($_POST['id']))
		{
			$fetchSql = "select * from tbl_product_setting where product_setting_id='".$_POST['id']."' ";
			$result = mysqli_query($con,$fetchSql);		
			$row = mysqli_fetch_array($result);
			
				$is_enable_item = $row["is_enable_item"];
				$what_do_you_sell = $row["what_do_you_sell"];
				$is_barcode_scan = $row["is_barcode_scan"];
				$is_stock_maintenance = $row["is_stock_maintenance"];
				$is_show_low_stock_dialog = $row["is_show_low_stock_dialog"];
				$is_item_unit = $row["is_item_unit"];
				$is_default_unit = $row["is_default_unit"];
				$is_item_category = $row["is_item_category"];
				$is_party_wise_rate = $row["is_party_wise_rate"];
				$is_description = $row["is_description"];
				$is_item_wise_tax = $row["is_item_wise_tax"];
				$is_item_wise_discount = $row["is_item_wise_discount"];
				$is_update_sale_price = $row["is_update_sale_price"];
				$quantity_upto_decimal = $row["quantity_upto_decimal"];
				$is_serial_no = $row["is_serial_no"];
				$is_mrp_price = $row["is_mrp_price"];
				$is_batch_no = $row["is_batch_no"];
				$is_exp_date = $row["is_exp_date"];
				$is_mfg_date = $row["is_mfg_date"];
				$is_model_no = $row["is_model_no"];
				$is_size = $row["is_size"];
				$serial_no = $row["serial_no"];
				$mrp_price = $row["mrp_price"];
				$batch_no = $row["batch_no"];
				$exp_date = $row["exp_date"];
				$mfg_date = $row["mfg_date"];
				$model_no = $row["model_no"];
				$size = $row["size"];
				
				$response = array("is_enable_item" => $is_enable_item ,"what_do_you_sell" => $what_do_you_sell,"is_barcode_scan" => $is_barcode_scan,"is_stock_maintenance" => $is_stock_maintenance,"is_show_low_stock_dialog" => $is_show_low_stock_dialog,"is_item_unit" => $is_item_unit,"is_default_unit" => $is_default_unit,"is_item_category" => $is_item_category,"is_party_wise_rate" => $is_party_wise_rate,"is_description" =>$is_description,"is_item_wise_tax" => $is_item_wise_tax,"is_item_wise_discount" => $is_item_wise_discount,"is_update_sale_price" =>$is_update_sale_price,"quantity_upto_decimal" => $quantity_upto_decimal,"is_serial_no" => $is_serial_no,"is_mrp_price" =>$is_mrp_price,"is_batch_no" => $is_batch_no,"is_exp_date" => $is_exp_date,"is_mfg_date" => $is_mfg_date,"is_model_no" => $is_model_no ,$is_size => "is_size"
				,"serial_no" => $serial_no,"mrp_price" =>$mrp_price,"batch_no" => $batch_no,"exp_date" => $exp_date,"mfg_date" => $mfg_date,"model_no" => $model_no ,$size => "size"
				);
				
		}
	}		
	else
	{
		$response["Fail"] = 1;
	}	
	echo json_encode($response);

?>