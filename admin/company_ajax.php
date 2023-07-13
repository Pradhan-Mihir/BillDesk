<?php
	require_once('../connection.php');
	$response = array();
	
	if(isset($_POST['delete']))
	{
		if(isset($_POST['id']))
		{
			$sql_select = "select * from tbl_company where company_id = '".$_POST['id']."'";
			$resultView = mysqli_query($con,$sql_select);
			if(mysqli_num_rows($resultView) > 0)
			{
				while($rowView = mysqli_fetch_array($resultView))
				{
					$image1 = $rowView['company_logo'];
					$path = $_SERVER['DOCUMENT_ROOT'].'/tryon_project_mbm/images/company_images/';
					if (file_exists($path.$image1)) 
					{
						unlink($path.$image1);
					}				
				}
			}
			
			$deleteSql = "CALL deleteCompany('".$_POST['id']."')";
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
			$fetchSql = "CALL fetchCompany('".$_POST['id']."')";
			$result = mysqli_query($con,$fetchSql);		
			while($row = mysqli_fetch_array($result))
			{
				$response["company_name"] = $row["company_name"];
				$response["mobile_no"] = $row["mobile_no"];
				$response["alter_mobile_no"] = $row["alter_mobile_no"];
				$response["email"] = $row["email"];
				$response["address"] = $row["address"];
				$response["city"] = $row["city"];
				$response["state"] = $row["state"];
				$response["pincode"] = $row["pincode"];
				$response["gst_in_no"] = $row["gst_in_no"];
				$response["bank_name"] = $row["bank_name"];
				$response["ac_no"] = $row["ac_no"];
				$response["ifsc"] = $row["ifsc"];
				$response["pan_no"] = $row["pan_no"];
				$response["tin_no"] = $row["tin_no"];
				$response["cst_no"] = $row["cst_no"];
				$response["stax_no"] = $row["stax_no"];
				$response["general_lic_no"] = $row["general_lic_no"];
				$response["company_logo"] = $row["company_logo"];
				$response["is_default"] = $row["is_default"];
			}		
		}		
	}
	else
	{
		$response["Fail"] = 1;
	}
	echo json_encode($response);

?>