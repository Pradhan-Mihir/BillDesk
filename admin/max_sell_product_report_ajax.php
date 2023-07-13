<?php
	require_once('../connection.php');
	$response = array();
	$counter = 0;
	
	$date = date("Y/m/d");
	$limit = 10;
	
	$sql = "SELECT pro.product_name,pro.opening_stock,sid.product_id,sid.unit_id,sid.qty,un.unit_name,sid.total FROM tbl_sales_invoice_detail sid
						LEFT JOIN tbl_product_master pro ON pro.product_id = sid.product_id
						LEFT JOIN tbl_unit un ON un.unit_id = sid.unit_id where 1=1     ";
	
	if(isset($_POST['pagging']))
	{
		$response = '';
		$response = array();
		
		
		if($_POST['stock'] == 1 )
		{
			$sql .= "    and  opening_stock > 0           ";
		}
		if($_POST['category'] != 0)
		{
			$sql .= "      and pro.category_id = '".$_POST['category']."'         ";
		}
		
		
		$sql .= "   GROUP BY pro.product_name,sid.unit_id ORDER BY sum(sid.qty) desc      ";
		$sql_count = $sql;
		
				
		$result = mysqli_query($con,$sql);
		
		$total_records = mysqli_num_rows($result);
		if($total_records != 0)
		{	
			while($row = mysqli_fetch_array($result))
			{
				
				$product_name =$row['product_name'];
				$opening_stock = $row['opening_stock'];
				$qty = $row['qty'];
				$unit_name = $row['unit_name'];
				
				if($unit_name == '')
					$unit_name = '-';

				$button = $row['product_id'].'|'.$row['unit_id'];
				
				if(isset($_POST['export_table']) && $_POST['export_table'] == 1)
				{
					$response[] = array("sr_no"=> ++$counter,"product_name" => $product_name,"unit_name" => $unit_name,"opening_stock" => $opening_stock,"qty" => $qty);
				}
				else
				{
					$response[] = array("product_name" => $product_name,"opening_stock" => $opening_stock,"qty" => $qty,"unit_name" => $unit_name,"button" => $button,"total_records" => $total_records);
				}
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
	else if(isset($_POST['tabs']))
	{
		if(isset($_POST['name']))
		{
			
			$sql = "SELECT pro.product_name,pid.unit_id,pid.qty,un.unit_name ";
					
					if($_POST['name']=='purchase')
					{
						$sql .= " FROM tbl_purchase_invoice_detail pid ";
					}
					else if($_POST['name']=='purchase_return')
					{
						$sql .= " FROM tbl_purchase_return_invoice_detail pid";
					}
					else if($_POST['name']=='sales')
					{
						$sql .= " FROM tbl_sales_invoice_detail pid ";
					}
					else if($_POST['name']=='sales_return')
					{
						$sql .= " FROM tbl_sales_return_detail pid ";
					}
					else if($_POST['name']=='cashmemo')
					{
						$sql .= " FROM tbl_cashmemo_detail pid ";
					}
					else if($_POST['name']=='cashmemo_return')
					{
						$sql .= " FROM tbl_cashmemo_return_detail pid ";
					}
					
					$sql .=" LEFT JOIN tbl_product_master pro ON pro.product_id = pid.product_id
					LEFT JOIN tbl_unit un ON un.unit_id = pid.unit_id where pid.product_id = '".$_POST['prd_key']."' and pid.unit_id = '".$_POST['unit_key']."'
					GROUP BY pro.product_name,pid.unit_id";
					
					$result = mysqli_query($con,$sql);	
		}
		while($row = mysqli_fetch_array($result))
		{
			$product_name = $row['product_name'];
			$unit_name = $row['unit_name'];
			$qty = $row['qty'];
			
			$response[] = array("product_name" => $product_name,"unit_name" => $unit_name , "qty" => $qty);
		}
	}
	else
	{
		$response = '';
	}
	echo json_encode($response);

?>