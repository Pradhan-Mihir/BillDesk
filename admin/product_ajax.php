<?php
	require_once('../connection.php');
	$response = array();
	
	if(isset($_POST['edit']))
	{	
        if(isset($_POST['id']))
        {
            $fetchSql = "SELECT * FROM tbl_product_master where product_id = '".$_POST['id']."' ";
            $result = mysqli_query($con,$fetchSql);
			
			//data in unit_conversion regarding current product , can't write together due to having 1 unit can be troublesome
			$sql_conversion = "select * from tbl_unit_conversion where product_id = '".$_POST['id']."' and is_default = 1";
			$rs_conversion = mysqli_query($con , $sql_conversion);
			$num = mysqli_num_rows($rs_conversion);
			$row_conversion = mysqli_fetch_array($rs_conversion);
			
            while($row = mysqli_fetch_array($result))
            {
                $response["category_id"] = $row["category_id"];
                $response["barcode"] = $row["barcode"];
                $response["product_code"] = $row["product_code"];
                $response["product_name"] = $row["product_name"];
                $response["gstslab_id"] = $row["gstslab_id"];
                $response["hsn_code"] = $row["hsn_code"];
                $response["unit_id"] = $row["unit_id"];
				$response["primary_unit_id"] = $row["primary_unit_id"];
				$response["secondary_unit_id"] = $row["secondary_unit_id"];
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
				$response["discount_on_sale"] = $row["discount_on_sale"];
				$response["tax_rate"] = $row["tax_rate"];
				$response["additional_cess_per_unit"] = $row["additional_cess_per_unit"];
				$response["discount_type"] = $row["discount_type"];
                $response["product_image"] = $row["product_image"];
				$response["is_batch"] = $row["is_batch"];
				$response["is_serial"] = $row["is_serial"];
				
				if($num > 0 )
					$response["conversion_id"] = $row_conversion["conversion_id"];
				$response["num"] = $num;
            }
        }
	}
	// to fetch data of batch while edit
	else if(isset($_POST['batch_fetch']))
	{
		if(isset($_POST['id']))
		{
			$sql_batch = "select * from tbl_batch_tracking where product_id = '".$_POST['id']."' ";
			$rs_batch = mysqli_query($con , $sql_batch);
			
			$count = mysqli_num_rows($rs_batch);
			$response = '';
			while ($row_batch = mysqli_fetch_array($rs_batch))
				$response .= "<tr id='row-batch'><td><div class='form-group'><input type='number' id='txt_mrp' name='txt_mrp[]' class='form-control' placeholder='MRP.' value = '".$row_batch['mrp_price']."'></div></td><td><div class='form-group'><input type='text' id='txt_batch_no' name='txt_batch_no[]'  class='form-control' placeholder='Enter Batch no' value = '".$row_batch['batch_no']."'></div></td><td><div class='form-group'><input type='date' id='txt_mfg_date' name='txt_mfg_date[]'  class='form-control'  value = '".$row_batch['mfg_date']."'></div></td><td><div class='form-group'><input type='date' id='txt_exp_date' name='txt_exp_date[]'  class='form-control'  value = '".$row_batch['exp_date']."'></div></td><td><div class='form-group'><input type='text' id='txt_model_no' name='txt_model_no[]'  class='form-control' placeholder='Enter Model No' value = '".$row_batch['model_no']."'>	</div></td><td><div class='form-group'><input type='text' id='txt_size' name='txt_size[]'  class='form-control' placeholder='Enter size' value = '".$row_batch['size']."'></div></td><td><div class='form-group'><input type='text' id='txt_batch_qty' name='txt_batch_qty[]'  class='form-control' placeholder='Enter quantity' value = '".$row_batch['quantity']."'></div></td><td><button type='button' name='btn_remove_batch[]' id='btn_remove_batch' class='btn btn-danger btn_remove'>X</button><input type='hidden' id='txt_batch_tracking_id' name='txt_batch_tracking_id[]' value = '".$row_batch['batch_tracking_id']."'></td></tr>";
		}
	}
	//to delete data of natch while edit
	else if(isset($_POST['batch_delete']))
	{
		if(isset($_POST['id']))
		{
			$sql_batch = "delete from tbl_batch_tracking where batch_tracking_id = '".$_POST['id']."' ";
			$rs_batch = mysqli_query($con , $sql_batch);
			if($rs_batch)
				$response = 'done';
			else
				$response["Fail"] = 1;
		}
	}
	//to delete the data of serial while edit
	else if(isset($_POST['serial_delete']))
	{
		if(isset($_POST['id']))
		{
			$sql_serial = "delete from tbl_serial_no where serial_no_id = '".$_POST['id']."' ";
			$rs_serial = mysqli_query($con , $sql_serial);
			if($rs_serial)
				$response = 'done';
			else
				$response["Fail"] = 1;
		}
	}
	//to fetch data for serial while edit
	else if(isset($_POST['serial_fetch']))
	{
		if(isset($_POST['id']))
		{
			$sql_serial = "select * from tbl_serial_no where product_id = '".$_POST['id']."' ";
			$rs_serial = mysqli_query($con , $sql_serial);
			
			$count = mysqli_num_rows($rs_serial);
			$response = '';
			while ($row_serial = mysqli_fetch_array($rs_serial))
				$response .= "<tr id='row_serial'><td align='center'><div class='col-md-16'><div class='form-group'><input type='text' class='form-control' id='txt_serial_no' name='txt_serial_no[]' placeholder='Enter Serial No' value = '".$row_serial['serial_no']."'></div></div></td><td align='center'><div class='col-md-3'><div class='form-group'><button type='button' id='btn_remove_serial' name='btn_remove_serial' class='btn btn-danger'>X</button><input type='hidden' id='serial_no_id' name='serial_no_id[]' value = '".$row_serial['serial_no_id']."'></div></div></td></tr>";
		}
	}
	else if(isset($_POST['delete']))
	{
		if(isset($_POST['id']))
		{
			$sql_select = "select * from tbl_product_master where product_id = '".$_POST['id']."'";
			$resultView = mysqli_query($con,$sql_select);
			if(mysqli_num_rows($resultView) > 0)
			{
				while($rowView = mysqli_fetch_array($resultView))
				{
					$image1 = $rowView['product_image'];
					$path = $_SERVER['DOCUMENT_ROOT'].'/tryon_project_mbm/images/product_images/';
					if (file_exists($path.$image1)) 
					{
						unlink($path.$image1);
					}				
				}
			}
			
			$sql_batch_delete = "delete from tbl_batch_tracking where product_id = '".$_POST['id']."' ";
			mysqli_query($con , $sql_batch_delete);
			
			$sql_unit_delete = "DELETE FROM tbl_unit_conversion WHERE product_id = '".$_POST['id']."' ";
			mysqli_query($con , $sql_unit_delete);
			
			$sql_serial_delete = "delete from tbl_serial_no where product_id = '".$_POST['id']."' ";
			mysqli_query($con , $sql_serial_delete);
			
			$deleteSql = "CALL deleteProduct_master('".$_POST['id']."')";
			
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
	else if( isset($_POST['primary_secondary_unit']))
	{
		if(isset($_POST['Sid']) && isset($_POST['Pid']))
		{
			$counter = 0;
			$rate = '';
			$prd_id = $_POST['product_id'];
			$c = '';
			$is_chk ;

			if($prd_id != '')
			{
				$sql_selected = "select * from tbl_unit_conversion where product_id = '".$prd_id."' and is_default = 1";
				$rs_selected = mysqli_query($con , $sql_selected);
				$row_selected = mysqli_fetch_array($rs_selected);
				
				$num_selected = mysqli_num_rows($rs_selected);
				if($num_selected > 0 )
				{
					$c = $row_selected['conversion_id'];
				}
			}

			$sql_unit_list = "select * from tbl_unit_conversion WHERE primary_unit_id = '".$_POST['Pid']."' and secondary_unit_id = '".$_POST['Sid']."' group by rate";
			$result = mysqli_query($con,$sql_unit_list);
			while($row = mysqli_fetch_array($result))
			{
				++$counter;
				if($row['conversion_id'] == $c)
				{
					$rate = $row['rate'];
					$primary_unit = $row['primary_unit'];
					$secondary_unit = $row['secondary_unit'];
					$is_chk = 1;

				}
				else
				{
					$rate = $row['rate'];
					$primary_unit = $row['primary_unit'];
					$secondary_unit = $row['secondary_unit'];
					$is_chk = 0;
				}
				$response[] = array("rate" => $rate , "primary_unit" => $primary_unit , "secondary_unit" => $secondary_unit , "is_chk" => $is_chk);
			}
			
		}
		if($counter == 0)
			$response["Fail"] = 1;
	}
	else
		{
			$response = '';
		}
		
		echo json_encode($response);
?>	
