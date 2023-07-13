<?php
	require_once('../connection.php');
    global $con;
	$response = array();
	$counter = 0;
	
	$limit = 10;
	
	$sql = "select * from tbl_product_master where 1= 1   ";
	
	if(isset($_POST['pagging']))
	{
			
		if($_POST['stock'] == 1 )
		{
			$sql .= "    and opening_stock > 0   ";
		}
		if($_POST['category'] != 0)
		{
			$sql .= "    and category_id = '".$_POST['category']."'   ";
		}
		if($_POST['start_date'] != '' && $_POST['end_date'] != '')
		{
			$sql .= "   and  product_date between '".$_POST['start_date']."' and '".$_POST['end_date']."'   ";
		}
		
		$sql_count = $sql ;
		$result = mysqli_query($con,$sql);
		
		$total_records = mysqli_num_rows(mysqli_query($con,$sql_count));
		if($total_records != 0)
			while($row = mysqli_fetch_array($result))
			{
				
				$product_name =$row['product_name'];
				$sales_rate = $row['sales_rate'];
				$purchase_rate = $row['purchase_rate'];
				$opening_stock = $row['opening_stock'];
				$total = $row['purchase_rate'] * $row['opening_stock'];

				if(isset($_POST['export_table']) && $_POST['export_table'] == 1)
				{
					$response[] = array("sr_no" => ++$counter, "product_name" => $product_name,"sales_rate" => $sales_rate,"purchase_rate" => $purchase_rate,"opening_stock" => $opening_stock,"total" => $total);
				}
				else
				{
					$response[] = array("product_name" => $product_name,"sales_rate" => $sales_rate,"purchase_rate" => $purchase_rate,"opening_stock" => $opening_stock,"total" => $total,"total_records" => $total_records);
				}
			}
		else
		{
			if(!isset($_POST['export_table']) && $_POST['export_table'] != 1)
			{
				$response[] = array("total_records" => $total_records);
			}
			
		}
		
	}
	
	else
	{
		$response = '';
	}
	echo json_encode($response); 
?>