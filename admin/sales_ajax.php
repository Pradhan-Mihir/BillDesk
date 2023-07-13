<?php
	require_once('../connection.php');
	$response = array();
	$no_of_unit_list = 0;
	//sales_fetch.php fetch_while_edit
	if(isset($_POST['edit_fetch']))
	{
		if(isset($_POST['id']))
		{
			$fetchSql = "select * from tbl_sales_invoice_detail where sales_invoice_id = '".$_POST['id']."'";
			$result_sql = mysqli_query($con,$fetchSql);			
			
			while($row = mysqli_fetch_array($result_sql))
			{
				$sales_invoice_detail_id = $row["sales_invoice_detail_id"];
				$product_id = $row["product_id"];
				$unit_id = $row["unit_id"];
				$rate = $row["rate"];
				$qty= $row["qty"];
				$disc_per = $row["disc_per"];
				$gstslab_id = $row["gstslab_id"];
				$disc_amt = $row["disc_amt"];
				$serial_no = '';
				$batch_no = '';

				if($row["serial_no"] == '')
					$batch_no= $row["batch_no"];

				if($row["batch_no"] == '')
					$serial_no = $row["serial_no"];
			
				$response[] = array ("sales_invoice_detail_id" => $sales_invoice_detail_id , "product_id" => $product_id , "unit_id" => $unit_id , "rate" => $rate , "qty" => $qty ,"disc_per" => $disc_per ,"gstslab_id" => $gstslab_id ,"disc_amt" => $disc_amt , "serial_no" => $serial_no , "batch_no" => $batch_no);
			}
		}
		else
		{
			$response["Fail"] = 1;
		}
	}
	//sales_detail_delete.php delete_product_while_edit
	else if(isset($_POST['edit_delete_detail']))
	{
		if(isset($_POST['id']))
		{
			$sql_inv_fetch = "select product_id , qty from tbl_sales_invoice_detail where sales_invoice_detail_id = '".$_POST['id']."'";
			$rs_inv_fetch = mysqli_query($con , $sql_inv_fetch);
			$row_inv = mysqli_fetch_array($rs_inv_fetch);
			
			$sql_inv_main = "UPDATE tbl_product_master SET closing_stock = (select closing_stock from tbl_product_master where product_id = '".$row_inv['product_id']."') - '".$row_inv['qty']."' WHERE  product_id = '".$row_inv['product_id']."' ";
			$rs_inv_main = mysqli_query($con , $sql_inv_main);
			
			
			$deleteSql = "delete from tbl_sales_invoice_detail where sales_invoice_detail_id = '".$_POST['id']."' ";
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
	//sales_party_search.php fnc_state_change() , fnc_party()
	else if(isset($_POST['party_search']))
	{
		if(isset($_POST['id']))
		{
		  $party = "select state from tbl_party_master WHERE party_id = '".$_POST['id']."'";
		  $result = mysqli_query($con,$party);        
		  while($row = mysqli_fetch_array($result))
		  {
			$response["state"] = $row["state"];
		  }
		}
		else
		{
			$response["Fail"] = 1;
		}
	}
	//sales_product_fetch.php fnc_unit()
	else if(isset($_POST['product_fetch']))
	{
		if(isset($_POST['id']))
		{
			$sql_unit_conversion = "select * from tbl_unit_conversion where product_id = '".$_POST['id']."' and is_default = 1";
			$rs_unit_conversion = mysqli_query($con , $sql_unit_conversion);
			$num = mysqli_num_rows($rs_unit_conversion);

            $sql_product_setting = "select is_gst_bill from tbl_product_setting";
            $rs_product_setting = mysqli_query($con,$sql_product_setting);
            $row_product_setting = mysqli_fetch_array($rs_product_setting);

			if($num > 0)
			{
				$fetchSql = "select uc.rate As 'rate' , un.unit_id , un.unit_name , pr.* , gst.cgst , uc.primary_unit , uc.primary_unit_id , uc.secondary_unit , uc.secondary_unit_id  from tbl_product_master pr left join tbl_unit un on un.unit_id = pr.unit_id left join tbl_unit_conversion uc on uc.product_id = pr.product_id left join tbl_gstslab_master gst on gst.gstslab_id = pr.gstslab_id where pr.product_id = '".$_POST['id']."' and uc.is_default = 1";
			}
			else
			{
				$fetchSql = "select 0 AS 'rate'  , uc.unit_name 'secondary_unit' , gst.cgst , un.unit_name 'primary_unit' , pr.* from tbl_product_master pr left join tbl_unit un on un.unit_id = pr.primary_unit_id left join tbl_unit uc on uc.unit_id = pr.secondary_unit_id left join tbl_gstslab_master gst on gst.gstslab_id = pr.gstslab_id where pr.product_id = '".$_POST['id']."'";
			}
			$result_sql = mysqli_query($con,$fetchSql);		
			while($row = mysqli_fetch_array($result_sql))
			{
				$product_id = $row["product_id"];
				$sales_rate = $row['sales_rate'];
				$gstslab_id = $row['gstslab_id'];
				$primary_unit = $row['primary_unit'];
				$primary_unit_id = $row['primary_unit_id'];
				$secondary_unit = $row['secondary_unit'];
				$secondary_unit_id = $row['secondary_unit_id'];
				$is_serial = $row['is_serial'];
				$is_batch = $row['is_batch'];
                $rate = $row['rate'];
				$cgst = 0 ;
				if($row_product_setting['is_gst_bill'] == 1)
                {
                    $cgst = $row['cgst'];
                    if($row['sales_tax_type'] == 'Including Gst')
                    {
                        $gst = $cgst / 100;
                        $sales_rate = $sales_rate - ($sales_rate * $gst );
                    }
                }
				if($row['rate'] == 0)
					$rate = 1;
								
				if($row['is_batch'] == 0)
				$is_batch = '';

				if($row['is_serial'] == 0)
					$is_serial = '';
				
				if($row['primary_unit'] == '')
				{
					$primary_unit = '';
					$primary_unit_id = '';
				}
				if($num < 1)
				{
					$secondary_unit_id = ''; 
					$secondary_unit = ''; 
				}
				
				$response = array("product_id" => $product_id , "rate" => $rate , "sales_rate" => $sales_rate , "gstslab_id" => $gstslab_id , "primary_unit" => $primary_unit , "primary_unit_id" => $primary_unit_id , "secondary_unit" => $secondary_unit , "secondary_unit_id" => $secondary_unit_id  , "is_batch" => $is_batch , "is_serial" => $is_serial , "cgst" => $cgst);
			}		
		}
		else
		{
			$response["Fail"] = 1;
		}
	}
	//sales_delete.php 
	else if(isset($_POST['inv_delete']))
	{
		if(isset($_POST['id']))
		{
			$sql_inv_delete = "SELECT product_id , qty from tbl_sales_invoice_detail where sales_invoice_id = '".$_POST['id']."'" ;
			$rs_inv_delete = mysqli_query($con , $sql_inv_delete);
			
			while ($row = mysqli_fetch_array($rs_inv_delete))
			{
				$sql_inv_update_delete = "update tbl_product_master set closing_stock = (select closing_stock from tbl_product_master where product_id = '".$row['product_id']."') - '".$row['qty']."' where product_id = '".$row['product_id']."'";
				$rs_inv_update_delete = mysqli_query($con , $sql_inv_update_delete);
			}
			
			$deleteSql = "CALL deletesales_invoice('".$_POST['id']."')";
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
	else if(isset($_POST['edit_unit_fetch']))
	{
		if(isset($_POST['id']))
		{
			$fetchSql = "select * from tbl_sales_invoice_detail where sales_invoice_detail_id = '".$_POST['id']."'";
			$result_sql = mysqli_query($con , $fetchSql);
			while($row = mysqli_fetch_array($result_sql))
			{
				$unit_id = $row['unit_id'];
				$unit = $row['unit'];
				$product_id = $row['product_id'];
				
				$response = array("unit_id" => $unit_id , "unit" => $unit , "product_id" => $product_id);
			}
		}
		else
		{
			$response["Fail"] = 1;
		}
	}
	else if(isset($_POST['batch_fill']))
	{
		if(isset($_POST['id']))
		{
			$fetch_serial = "select * from tbl_batch_tracking where product_id = '".$_POST['id']."' and is_sold = 0 ";
			if(isset($_POST['edit_time']))
			{
				$fetch_serial = "select * from tbl_batch_tracking where batch_tracking_id = (select batch_no from tbl_sales_invoice_detail where sales_invoice_detail_id  = '".$_POST['edit_time']."' )";
			}

			$result_serial = mysqli_query($con , $fetch_serial);
			
			while($row = mysqli_fetch_array($result_serial))
			{
				$batch_tracking_id  = $row["batch_tracking_id"];
				$mrp_price  = $row["mrp_price"];
				$batch_no  = $row["batch_no"];
				$exp_date  = $row["exp_date"];
				$mfg_date  = $row["mfg_date"];
				$model_no  = $row["model_no"];
				$size = $row["size"];
				$quantity = $row["quantity"];
				
				$response[] = array("batch_tracking_id" => $batch_tracking_id , "mrp_price" => $mrp_price , "batch_no" => $batch_no , "exp_date" => $exp_date , "mfg_date" => $mfg_date , "model_no" => $model_no , "size" => $size , "quantity" => $quantity );
			}
		}
		else
		{
			$response["Fail"] = 1;
		}
	}
	else if(isset($_POST['serial_fill']))
	{
		if(isset($_POST['id']))
		{

			$fetch_serial = "select * from tbl_serial_no where product_id = '".$_POST['id']."' and is_sold = 0";
			if(isset($_POST['edit_time']))
			{
				$fetch_serial = "select serial_no from tbl_sales_invoice_detail where sales_invoice_detail_id  = '".$_POST['edit_time']."'";
				$result_serial = mysqli_query($con , $fetch_serial);
				$row = mysqli_fetch_array($result_serial);
				if($row['serial_no'] != '')
				{
					$sr = explode ('|' , $row['serial_no']);
					for($pp = 0 ; $pp < count($sr) - 1 ; $pp ++)
					{
						$sql = " select * from tbl_serial_no where serial_no_id = '".$sr[$pp]."' ";
						$rs_for_serial = mysqli_query($con , $sql);
						while($row_for_serial= mysqli_fetch_array($rs_for_serial))
						{
							$serial_no_id = $row_for_serial['serial_no_id'];
							$serial_no = $row_for_serial['serial_no'];
							$response[] = array("serial_no_id" => $serial_no_id , "serial_no" => $serial_no );
						}
					}

				}
			}
			else{
				$result_serial = mysqli_query($con , $fetch_serial);
				while($row = mysqli_fetch_array($result_serial))
				{
					$serial_no_id = $row['serial_no_id'];
					$serial_no = $row['serial_no'];
					$response[] = array("serial_no_id" => $serial_no_id , "serial_no" => $serial_no );
				}
			}
		}
		else
		{
			$response["Fail"] = 1;
		}
	}
	else if(isset($_POST['gst_val']))
	{
		if(isset($_POST['id']))
		{
			$sql_gst= "SELECT  gst.cgst FROM  tbl_product_master pro , tbl_gstslab_master gst where pro.product_id = '".$_POST['prd_id']."' and gst.gstslab_id = '".$_POST['id']."' ";
			$rs_gst= mysqli_query($con , $sql_gst);
		  
			$row = mysqli_fetch_array($rs_gst);
			$cgst = $row['cgst'];

			$response[] = array("cgst" => $cgst );
		}
		else
		{
		  $response["Fail"] = 1;
		}
	}
	else if(isset($_POST['barcode']))
	{
		if(isset($_POST['id']))
		{
			$sql_gst= "select product_name,gstslab_id,sales_rate  from tbl_barcode_master where barcode = '".$_POST['id']."' 
			UNION all
			select product_id as 'product_name',gstslab_id,sales_rate   from tbl_product_master where barcode = '".$_POST['id']."'
			";
			$rs_gst= mysqli_query($con , $sql_gst);
			$row = mysqli_fetch_array($rs_gst);
			if($row)
			{

				$response['product_name'] = $row['product_name'];
				$response['gstslab_id'] = $row['gstslab_id'];
				$response['sales_rate'] = $row['sales_rate'];
				$response['Fail'] = 0;
			}
			else
			{
				$response['Fail'] = 1;
			}
		}
		else
		{
		  $response["Fail"] = 1;
		}
	}
	else
	{
		$response["Fail"] = 1;
	}
	echo json_encode($response);

?>