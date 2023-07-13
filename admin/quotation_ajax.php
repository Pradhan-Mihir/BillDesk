<?php
	require_once('../connection.php');
	$response = array();
	$no_of_unit_list = 0;
	//quotation_fetch.php fetch_while_edit
	if(isset($_POST['edit_fetch']))
	{
		if(isset($_POST['id']))
		{
			$fetchSql = "select * from tbl_quotation_detail where quotation_id = '".$_POST['id']."'";
			$result_sql = mysqli_query($con,$fetchSql);			
			
			while($row = mysqli_fetch_array($result_sql))
			{
				$quotation_detail_id = $row["quotation_detail_id"];
				$product_id = $row["product_id"];
				$unit_id = $row["unit_id"];
				$rate = $row["rate"];
				$qty= $row["qty"];
				$disc_per = $row["disc_per"];
				$gstslab_id = $row["gstslab_id"];
				$disc_amt = $row["disc_amt"];
				if($row["serial_no"] == '')
				{
					$batch_no= $row["batch_no"];
					$serial_no = '';
				}
				else
				{
					$serial_no = $row["serial_no"];
					$batch_no = '';
				}
			
				$response[] = array ("quotation_detail_id" => $quotation_detail_id , "product_id" => $product_id , "unit_id" => $unit_id , "rate" => $rate , "qty" => $qty ,"disc_per" => $disc_per ,"gstslab_id" => $gstslab_id ,"disc_amt" => $disc_amt , "serial_no" => $serial_no , "batch_no" => $batch_no);
			}		
		}
		else
		{
			$response["Fail"] = 1;
		}
	}
	//quotation_detail_delete.php delete_product_while_edit
	else if(isset($_POST['edit_delete_detail']))
	{
		if(isset($_POST['id']))
		{
			$deleteSql = "delete from tbl_quotation_detail where quotation_detail_id = '".$_POST['id']."' ";
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