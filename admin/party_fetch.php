<?php
	require_once('../connection.php');
	$response = array();
	if(isset($_POST['edit']))
	{
		if(isset($_POST['id']))
		{
			$fetchSql = "CALL fetchParty_master('".$_POST['id']."')";
			$result = mysqli_query($con,$fetchSql);		
			while($row = mysqli_fetch_array($result))
			{
				$response["party_type"] = $row["party_type"];
				$response["party_group_id"] = $row["party_group_id"];
				$response["party_name"] = $row["party_name"];
				$response["mobile_no"] = $row["mobile_no"];
				$response["alter_mobile_no"] = $row["alter_mobile_no"];
				$response["email"] = $row["email"];
				$response["billing_address"] = $row["billing_address"];
				$response["shipping_address"] = $row["shipping_address"];
				$response["gst_type"] = $row["gst_type"];
				$response["gst_in"] = $row["gst_in"];
				$response["state"] = $row["state"];
				$response["additional_field_1_name"] = $row["additional_field_1_name"];
				$response["additional_field_2_name"] = $row["additional_field_2_name"];
				$response["additional_field_3_name"] = $row["additional_field_3_name"];
				$response["additional_field_4_name"] = $row["additional_field_4_name"];
				$response["opening_balance"] = $row["opening_balance"];
				$response["balance_status"] = $row["balance_status"];
				$response["as_of_date"] = $row["as_of_date"];
			}		
		}		
	}
	else
	{
		$response["Fail"] = 1;
	}
	echo json_encode($response);

?>