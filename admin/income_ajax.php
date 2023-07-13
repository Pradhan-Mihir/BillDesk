<?php
	require_once('../connection.php');
	$response = array();
	$no_of_unit_list = 0;
	//purchase_fetch.php fetch_while_edit
	if(isset($_POST['edit_fetch']))
	{
		if(isset($_POST['id']))
		{
			$fetchSql = "select * from tbl_income_detail where income_id = '".$_POST['id']."'";
			$result_sql = mysqli_query($con,$fetchSql);			
			
			while($row = mysqli_fetch_array($result_sql))
			{
				$income_detail_id = $row["income_detail_id"];
				$item_name = $row["item_name"];
				$price = $row["price"];
				$quantity = $row["quantity"];
				$total= $row["total"];
				
				
				$response[] = array ("income_detail_id" => $income_detail_id , "item_name" => $item_name , "price" => $price , "quantity" => $quantity , "total" => $total);
			}		
		}
		else
		{
			$response["Fail"] = 1;
		}
	}
	else if(isset($_POST['edit_delete_detail']))
	{
		if(isset($_POST['id']))
		{	
			$deleteSql = "delete from tbl_income_detail where income_detail_id = '".$_POST['id']."' ";
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
	else if(isset($_POST['inv_delete']))
	{
		if(isset($_POST['id']))
		{
			$deleteSql = "CALL deleteIncome('".$_POST['id']."')";
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
	else if(isset($_POST['edit']))
	{
		if(isset($_POST['id']))
		{
			$fetchSql = "select * from tbl_income where income_id = '".$_POST['id']."' ";
			$result = mysqli_query($con,$fetchSql);		
			while($row = mysqli_fetch_array($result))
			{
				$response["income_type_id"] = $row["income_type_id"];
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