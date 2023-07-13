<?php
    include_once('../connection.php');
    global $con;
    $response = array();
    $limit = 10;
	$counter = 0;

    $query = "select bat.* , pro.product_name  from tbl_batch_tracking bat 
    left join tbl_company com on  com.company_id = bat.company_id 
    left join tbl_product_master pro on  pro.product_id = bat.product_id 
    where com.is_default = 1 ";

    if(isset($_POST['pagging']))
	{
			
		$response = array();
		

		if($_POST['mfg_start_date'] != '' && $_POST['mfg_end_date'] != '')
		{
			$query .= "  and  bat.mfg_date between '".$_POST['mfg_start_date']."' and '".$_POST['mfg_end_date']."'    ";
		}
		if($_POST['exp_start_date'] != '' && $_POST['exp_end_date'] != '')
		{
			$query .= "  and  bat.exp_date between '".$_POST['exp_start_date']."' and '".$_POST['exp_end_date']."'    ";
		}
		if($_POST['size'] != 0)
		{
			$query .= "    and bat.size = '".$_POST['size']."'      ";
		}
		if($_POST['batch_no'] != 0)
		{
			$query .= "    and bat.batch_no = '".$_POST['batch_no']."'      ";
		}
		if($_POST['model_no'] != 0)
		{
			$query .= "    and bat.model_no = '".$_POST['model_no']."'      ";
		}
		if($_POST['stock'] != 0)
		{
			$query .= "    and bat.quantity > 0      ";
		}
		if($_POST['product_id'] != 0)
		{
			$query .= "    and bat.product_id = '".$_POST['product_id']."'      ";
		}

		$sql = $query;
		
		//echo $sql;
		$result = mysqli_query($con,$sql);
		
		$total_records = mysqli_num_rows($result);
		if($total_records != 0)
			while($row = mysqli_fetch_array($result))
			{
				$product_name = $row['product_name'];
				$mrp_price = $row['mrp_price'];
				$batch_no = $row['batch_no'];
				$model_no = $row['model_no'];
				$mfg_date = $row['mfg_date'];
				$exp_date = $row['exp_date'];
				$size = $row['size'];
				$quantity = $row['quantity'];
				$color = '#000000';
				
				if(isset($_POST['export_table']) && $_POST['export_table'] == 1)
				{
					$response[] = array( "sr_no"=> ++$counter , "product_name" => $product_name , "batch_no" => $batch_no , "mrp_price" => $mrp_price  , "model_no" => $model_no , "mfg_date" => $mfg_date , "exp_date" => $exp_date , "size" => $size , "quantity" => $quantity);
				}
				else
				{
					$response[] = array("product_name" => $product_name , "mrp_price" => $mrp_price , "batch_no" => $batch_no , "model_no" => $model_no , "mfg_date" => $mfg_date , "exp_date" => $exp_date , "size" => $size , "quantity" => $quantity ,"total_records" => $total_records);
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
		$response[] = array("Fail" => 'no data');
	}
	echo json_encode($response);



?>