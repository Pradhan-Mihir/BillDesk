<?php
	require_once('../connection.php');
	$response = array();
	$no_of_unit_list = 0;
	//purchase_return_delete.php 
	if(isset($_POST['inv_delete']))
	{
		if(isset($_POST['id']))
		{
			$sql_inv_delete = "SELECT product_id , qty from tbl_purchase_return_invoice_detail where purchase_return_invoice_id = '".$_POST['id']."'" ;
			$rs_inv_delete = mysqli_query($con , $sql_inv_delete);
			
			while ($row = mysqli_fetch_array($rs_inv_delete))
			{
				$sql_inv_update_delete = "update tbl_product_master set opening_stock = (select opening_stock from tbl_product_master where product_id = '".$row['product_id']."') + '".$row['qty']."' where product_id = '".$row['product_id']."'";
				$rs_inv_update_delete = mysqli_query($con , $sql_inv_update_delete);
			}
			
			$deleteSql = "CALL deletePurchase_return_invoice('".$_POST['id']."')";
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
	//purchase_return_product_fetch.php fnc_unit()
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
				$fetchSql = "select purchase_rate As 'rate' , un.unit_id , un.unit_name , pr.purchase_tax_type  , gst.cgst , pr.product_id , pr.gstslab_id, uc.primary_unit , pr.is_serial , pr.is_batch , uc.primary_unit_id , uc.secondary_unit , uc.secondary_unit_id , pr.purchase_rate from tbl_product_master pr left join tbl_unit un on un.unit_id = pr.unit_id left join tbl_gstslab_master gst on gst.gstslab_id = pr.gstslab_id left join tbl_unit_conversion uc on uc.product_id = pr.product_id where pr.product_id = '".$_POST['id']."' and uc.is_default = 1";
			}
			else
			{
				$fetchSql = "select 0 AS 'rate'  ,uc.unit_name 'secondary_unit' , gst.cgst , un.unit_name 'primary_unit' , pr.*  from tbl_product_master pr left join tbl_unit un on un.unit_id = pr.primary_unit_id left join tbl_unit uc on uc.unit_id = pr.secondary_unit_id left join tbl_gstslab_master gst on gst.gstslab_id = pr.gstslab_id where pr.product_id = '".$_POST['id']."'";
			}
			
			$result_sql = mysqli_query($con,$fetchSql);		
			while($row = mysqli_fetch_array($result_sql))
			{
				$product_id = $row["product_id"];
				$purchase_rate = $row['purchase_rate'];
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
                    if($row['purchase_tax_type'] == 'Including Gst')
                    {
                        $gst = $cgst / 100;
                        $purchase_rate = $purchase_rate - ($purchase_rate * $gst );
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
				
				$response = array("product_id" => $product_id , "rate" => $rate , "purchase_rate" => $purchase_rate , "gstslab_id" => $gstslab_id , "primary_unit" => $primary_unit , "primary_unit_id" => $primary_unit_id , "secondary_unit" => $secondary_unit , "secondary_unit_id" => $secondary_unit_id , "is_batch" => $is_batch , "is_serial" => $is_serial , "cgst" => $cgst);
			}		
		}
		else
		{
			$response["Fail"] = 1;
		}		
	}
	//purchase_return_party_fetch.php fnc_party_search() , fnc_state_change()
	else if(isset($_POST['party_search']))
	{
		if(isset($_POST['id']))
		{
		  
		  $party = "select pid.product_id  , un.unit_name  , pm.state , pro.product_name from tbl_purchase_invoice pi left join tbl_purchase_invoice_detail pid on pid.purchase_invoice_id = pi.purchase_invoice_id left join tbl_party_master pm on pm.party_id = pi.party_id left join tbl_unit un on un.unit_id = pid.unit_id left join tbl_product_master pro on pro.product_id = pid.product_id WHERE pi.party_id = '".$_POST['id']."' group by pid.product_id ";
		  $result = mysqli_query($con,$party);
		  while($row = mysqli_fetch_array($result))
		  {
			$state = $row["state"];
			$product_id = $row['product_id'];
			$product_name = $row['product_name'];
			
			if($row['product_id'] == '')
				{
					$product_id = '';
				}
			
			$response[] = array("state" => $state , "product_id" => $product_id , "product_name" => $product_name );
		  }
		}
		else
		{
			$response["Fail"] = 1;
		}
	}
	// purchase_return_detail_delete.php from remove button
	else if(isset($_POST['edit_delete_detail']))
	{
		if(isset($_POST['id']))
		{
			$sql_inv_fetch = "select product_id , qty from tbl_purchase_return_invoice_detail where purchase_return_invoice_detail_id = '".$_POST['id']."'";
			$rs_inv_fetch = mysqli_query($con , $sql_inv_fetch);
			$row_inv = mysqli_fetch_array($rs_inv_fetch);
			
			$sql_inv_main = "UPDATE tbl_product_master SET opening_stock = (select opening_stock from tbl_product_master where product_id = '".$row_inv['product_id']."') + '".$row_inv['qty']."' WHERE  product_id = '".$row_inv['product_id']."' ";
			$rs_inv_main = mysqli_query($con , $sql_inv_main);
			
			$deleteSql = "delete from tbl_purchase_return_invoice_detail where purchase_return_invoice_detail_id = '".$_POST['id']."' ";
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
	//purchase_return_fetch.php
	else if(isset($_POST['edit_fetch']))
	{
		if(isset($_POST['id']))
		{
			$fetchSql = "select * from tbl_purchase_return_invoice_detail where purchase_return_invoice_id = '".$_POST['id']."'";
			$result_sql = mysqli_query($con,$fetchSql);
			
			while($row = mysqli_fetch_array($result_sql))
			{
				$purchase_return_invoice_detail_id = $row["purchase_return_invoice_detail_id"];
				$product_id = $row["product_id"];
				$unit_id = $row["unit_id"];
				$rate = $row["rate"];
				$qty= $row["qty"];
				$disc_per = $row["disc_per"];
				$gstslab_id = $row["gstslab_id"];
				$disc_amt = $row["disc_amt"];
				$serial_no = $row["serial_no"];
				$batch_no = $row["batch_no"];
				
				if($row["batch_no"] == '')
					$batch_no = '';
					
				if($row["serial_no"] == '')
					$serial_no = '';
				
				$response[] = array ("purchase_return_invoice_detail_id" => $purchase_return_invoice_detail_id , "product_id" => $product_id , "unit_id" => $unit_id , "rate" => $rate , "qty" => $qty ,"disc_per" => $disc_per ,"gstslab_id" => $gstslab_id ,"disc_amt" => $disc_amt , "serial_no" => $serial_no , "batch_no" => $batch_no);
			}		
		}
		else
		{
			$response["Fail"] = 1;
		}
	}
	else if(isset($_POST['edit_unit_fetch']))
	{
		if(isset($_POST['id']))
		{
			$fetchSql = "select * from tbl_purchase_return_invoice_detail where purchase_return_invoice_detail_id = '".$_POST['id']."'";
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
	else if(isset($_POST['max_qty']))
	{
		if(isset($_POST['id']))
		{
			$rate = 1;
			$qty = 0;
			$qty_return = 0;
			$current_stock = 0;
			
			$sql_primary_unit = "select * from tbl_product_master where product_id = '".$_POST['id']."'";
			$rs_primary_unit = mysqli_query($con , $sql_primary_unit);
			$row_primary_unit = mysqli_fetch_array($rs_primary_unit);
			$current_stock = $row_primary_unit['opening_stock'];
			
			$sql_rate = "select * from tbl_unit_conversion where product_id = '".$_POST['id']."' and is_default = 1";
			$rs_rate = mysqli_query($con , $sql_rate);
			$num_rate_row = mysqli_num_rows($rs_rate);
			
			$primary_unit_id = $row_primary_unit['primary_unit_id'];
			
			if($num_rate_row > 0 )
			{
				$row_rate = mysqli_fetch_array($rs_rate);
				$rate = $row_rate['rate'];
				$secondary_unit_id = $row_rate['secondary_unit_id'];
				$primary_unit_id = $row_rate['primary_unit_id'];
			}
			
			$sql_prd_qty_primary = "select sum(pid.qty) 'qty' , un.unit_id from tbl_purchase_invoice pi left join tbl_purchase_invoice_detail pid on pid.purchase_invoice_id = pi.purchase_invoice_id left join tbl_party_master pm on pm.party_id = pi.party_id left join tbl_unit un on  un.unit_id = pid.unit_id left join tbl_company com on com.company_id = pi.company_id where com.is_default = 1 and pi.party_id = '".$_POST['party']."' and pid.product_id = '".$_POST['id']."' GROUP by un.unit_id";
			$rs_prd_qty_primary = mysqli_query($con , $sql_prd_qty_primary);
			while($row_prd_qty_primary = mysqli_fetch_array($rs_prd_qty_primary))
			{
				if($row_prd_qty_primary['unit_id'] == $primary_unit_id)
				{
					$qty_pur = $row_prd_qty_primary['qty'];
				}
				else
				{
					$qty_pur += $row_prd_qty_primary['qty']/$rate;
				}
			}
			
			//for counting already returned goods
			$sql_qty_return = "select sum(pid.qty) 'qty' , un.unit_id from tbl_purchase_return_invoice pi left join tbl_purchase_return_invoice_detail pid on pid.purchase_return_invoice_id = pi.purchase_return_invoice_id left join tbl_party_master pm on pm.party_id = pi.party_id left join tbl_unit un on  un.unit_id = pid.unit_id left join tbl_company com on com.company_id = pi.company_id where com.is_default = 1 and pi.party_id = '".$_POST['party']."' and pid.product_id = '".$_POST['id']."' GROUP by un.unit_id";
			$rs_qty_return = mysqli_query($con , $sql_qty_return);
			while($row_qty_return = mysqli_fetch_array($rs_qty_return))
			{
				if($row_qty_return['unit_id'] == $primary_unit_id)
				{
					$qty_return = $row_qty_return['qty'];
				}
				else
				{
					$qty_return += $row_qty_return['qty']/$rate;
				}
			}
			
			$qty = $qty_pur - $qty_return;
			if($qty > $current_stock)
			{
				$qty = $current_stock;
			}
			
			$prd_id = $_POST['id'];
			$response['rate'] = $rate;
			$response['qty'] = $qty;
			$response['product_id'] = $prd_id;
			
		}
	}
	else if(isset($_POST['batch_fill']))
	{
		if(isset($_POST['id']))
		{
			$fetch_serial = "select * from tbl_batch_tracking where product_id = '".$_POST['id']."' and is_sold = 0 ";
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
			$fetch_serial = "select serial_no , serial_no_id , is_sold from tbl_serial_no where product_id = '".$_POST['id']."' and is_sold != 1";
			$result_serial = mysqli_query($con , $fetch_serial);
			
			while($row = mysqli_fetch_array($result_serial))
			{
				$serial_no_id = $row['serial_no_id'];
				$serial_no = $row['serial_no'];
				$is_sold = $row['is_sold'];
				
				$response[] = array("serial_no_id" => $serial_no_id , "serial_no" => $serial_no , "is_sold" => $is_sold );
			}
		}
		else
		{
			$response["Fail"] = 1;
		}
	}
	else if(isset($_POST['serial_unchecked']))
	{
		if(isset($_POST['id']))
		{
			$fetchSql = "UPDATE tbl_serial_no SET is_sold = 0 WHERE serial_no_id = '".$_POST['id']."'";
			$result_sql = mysqli_query($con , $fetchSql);

			if($result_sql)
				$response["Success"] = 1;
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
	else
	{
		$response["Fail"] = 1;
	}
	echo json_encode($response);
?>