<?php
	require_once('../connection.php');
	$response = array();
	if(isset($_POST['delete']))
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
	else
	{
		$response["Fail"] = 1;
	}
	echo json_encode($response);
?>