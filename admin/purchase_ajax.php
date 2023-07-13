<?php
	require_once('../connection.php');
	$response = array();
	$no_of_unit_list = 0;
	//purchase_fetch.php fetch_while_edit
	if(isset($_POST['edit_fetch']))
	{
		if(isset($_POST['id']))
		{
			$fetchSql = "select pi.* , pm.purchase_tax_type from tbl_purchase_invoice_detail pi left join tbl_product_master pm on pm.product_id = pi.product_id where pi.purchase_invoice_id = '".$_POST['id']."'";
			$result_sql = mysqli_query($con,$fetchSql);
            $batch_no= null;
            $serial_no = null;
            $serial_no_id = null;
            $batch_no_id = null;

            while($row = mysqli_fetch_array($result_sql))
			{
				$purchase_invoice_detail_id = $row["purchase_invoice_detail_id"];
				$product_id = $row["product_id"];
				$unit_id = $row["unit_id"];
				$rate = $row["rate"];
				$qty= $row["qty"];
				$disc_per = $row["disc_per"];
				$gstslab_id = $row["gstslab_id"];
				$disc_amt = $row["disc_amt"];
                $batch_no= '';
                $serial_no = '';
                $serial_no_id = '';
                $batch_no_id = '';
				if($row["batch_no"] != '')
				{
					$batch_no= '';
					$serial_no = '';
                    $serial_no_id = '';
                    $batch_no_id = $row['batch_no'];

                    $sql_batch = "select * from tbl_batch_tracking where batch_tracking_id = '".$batch_no_id."'";
                    $rs_batch = mysqli_query($con , $sql_batch);
                    $row_batch = mysqli_fetch_array($rs_batch);
                    if(mysqli_num_rows($rs_batch)>0)
                    $batch_no = "|".$row_batch['batch_no']."|".$row_batch['mfg_date']."|".$row_batch['exp_date']."|".$row_batch['model_no']."|".$row_batch['size']."|".$row_batch['quantity']."|".$row_batch['mrp_price'];

				}
				
                if($row['gst_per'] == 0)
                    $gst = $row['igst_per']/2;

                if($row['igst_per'] == 0)
                    $gst = $row['gst_per'];

                if($row['purchase_tax_type'] == 'Including Gst')
                    $gst = 0;

				if ($row["serial_no"] != '')
				{
                    $serial_no_id = $row['serial_no'];
                    $batch_no_id = '';
					$serial_no = '';
					$batch_no = '';
                    $temp = explode('|',$serial_no_id);
                    for($i=1;$i<count($temp);$i++)
                    {
                        $sql_serial = "select serial_no from tbl_serial_no where serial_no_id = '".$temp[$i]."'";
                        $row_serial = mysqli_fetch_array(mysqli_query($con , $sql_serial));
                        if(mysqli_num_rows(mysqli_query($con , $sql_serial)) > 0)
                            $serial_no .= '|'.$row_serial['serial_no'];
                    }
				}
				$response[] = array ("purchase_invoice_detail_id" => $purchase_invoice_detail_id , "product_id" => $product_id , "unit_id" => $unit_id , "rate" => $rate , "qty" => $qty ,"disc_per" => $disc_per ,"gstslab_id" => $gstslab_id ,"disc_amt" => $disc_amt , "serial_no" => $serial_no , "batch_no" => $batch_no , "serial_no_id" => $serial_no_id , "batch_no_id" => $batch_no_id , "gst" => $gst);
			}		
		}
		else
		{
			$response["Fail"] = 1;
		}
	}
	//purchase_detail_delete.php delete_product_while_edit
	else if(isset($_POST['edit_delete_detail']))
	{
		if(isset($_POST['id']))
		{
			$sql_inv_fetch = "select product_id , qty from tbl_purchase_invoice_detail where purchase_invoice_detail_id = '".$_POST['id']."'";
			$rs_inv_fetch = mysqli_query($con , $sql_inv_fetch);
			$row_inv = mysqli_fetch_array($rs_inv_fetch);
			
			$sql_inv_main = "UPDATE tbl_product_master SET closing_stock = (select closing_stock from tbl_product_master where product_id = '".$row_inv['product_id']."') - '".$row_inv['qty']."' WHERE  product_id = '".$row_inv['product_id']."' ";
			$rs_inv_main = mysqli_query($con , $sql_inv_main);
			
			
			$deleteSql = "delete from tbl_purchase_invoice_detail where purchase_invoice_detail_id = '".$_POST['id']."' ";
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
	//purchase_party_search.php fnc_state_change() , fnc_party()
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
	//purchase_product_fetch.php fnc_unit()
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
				$fetchSql = "select uc.rate As 'rate' , un.unit_id , un.unit_name  , pr.* , gst.cgst , uc.primary_unit , uc.primary_unit_id , uc.secondary_unit , uc.secondary_unit_id  from tbl_product_master pr left join tbl_unit un on un.unit_id = pr.unit_id left join tbl_unit_conversion uc on uc.product_id = pr.product_id left join tbl_gstslab_master gst on gst.gstslab_id = pr.gstslab_id where pr.product_id = '".$_POST['id']."' and uc.is_default = 1";
			}
			else
			{
				$fetchSql = "select 0 AS 'rate'  , uc.unit_name 'secondary_unit' , gst.cgst , un.unit_name 'primary_unit' , pr.* from tbl_product_master pr left join tbl_unit un on un.unit_id = pr.primary_unit_id left join tbl_unit uc on uc.unit_id = pr.secondary_unit_id left join tbl_gstslab_master gst on pr.gstslab_id = gst.gstslab_id where pr.product_id = '".$_POST['id']."'";
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
				
				$response = array("product_id" => $product_id , "rate" => $rate , "purchase_rate" => $purchase_rate , "gstslab_id" => $gstslab_id , "primary_unit" => $primary_unit , "primary_unit_id" => $primary_unit_id , "secondary_unit" => $secondary_unit , "secondary_unit_id" => $secondary_unit_id  , "is_batch" => $is_batch , "is_serial" => $is_serial ,  "cgst" => $cgst);
			}		
		}
		else
		{
			$response["Fail"] = 1;
		}
	}
	//purchase_delete.php 
	else if(isset($_POST['inv_delete']))
	{
		if(isset($_POST['id']))
		{
			$sql_inv_delete = "SELECT product_id , qty from tbl_purchase_invoice_detail where purchase_invoice_id = '".$_POST['id']."'" ;
			$rs_inv_delete = mysqli_query($con , $sql_inv_delete);
			
			while ($row = mysqli_fetch_array($rs_inv_delete))
			{
				$sql_inv_update_delete = "update tbl_product_master set closing_stock = (select closing_stock from tbl_product_master where product_id = '".$row['product_id']."') - '".$row['qty']."' where product_id = '".$row['product_id']."'";
				$rs_inv_update_delete = mysqli_query($con , $sql_inv_update_delete);
			}
			
			$deleteSql = "CALL deletePurchase_invoice('".$_POST['id']."')";
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
			$fetchSql = "select * from tbl_purchase_invoice_detail where purchase_invoice_detail_id = '".$_POST['id']."'";
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
	
	
	else if(isset($_POST['gst_val']))
	{
		if(isset($_POST['id']))
		{
			$sql_gst= "SELECT  gst.cgst  FROM  tbl_product_master pro , tbl_gstslab_master gst where pro.product_id = '".$_POST['prd_id']."' and gst.gstslab_id = '".$_POST['id']."' ";
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
    else if(isset($_POST['serial_detail_delete']))
    {
        if(isset($_POST['id']))
        {

            $sql_inv_fetch = "delete from tbl_serial_no where serial_no_id = '".$_POST['id']."'";

            if(mysqli_query($con , $sql_inv_fetch))
                $response["Success"] = 1;
            else
                $response["Fail"] = 1;
        }
    }
    else if(isset($_POST['batch_detail_delete']))
    {
        if(isset($_POST['id']))
        {
            $sql_inv_fetch = "delete from tbl_batch_tracking where batch_tracking_id = '".$_POST['id']."'";

            if(mysqli_query($con , $sql_inv_fetch))
                $response["Success"] = 1;
            else
                $response["Fail"] = 1;
        }
    }
	else
	{
		$response["Fail"] = 1;
	}
	echo json_encode($response);

?>