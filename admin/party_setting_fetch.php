<?php
	require_once('../connection.php');
	$response = array();
	
	if(isset($_POST['setting']))
	{	
		if(isset($_POST['id']))
		{
			$fetchSql = "select * from tbl_party_setting where party_setting_id='".$_POST['id']."' ";
			$result = mysqli_query($con,$fetchSql);		
			$row = mysqli_fetch_array($result);
			
				$is_party_grouping = $row["is_party_grouping"];
				$is_shipping_address = $row["is_shipping_address"];
				$is_print_shipping_address = $row["is_print_shipping_address"];
				$is_enable_payment_reminder = $row["is_enable_payment_reminder"];
				$reminder_in_days = $row["reminder_in_days"];
				$reminder_message = $row["reminder_message"];
				$is_additional_field_1 = $row["is_additional_field_1"];
				$additional_field_1_name = $row["additional_field_1_name"];
				$is_a_f_1_show_in_print = $row["is_a_f_1_show_in_print"];
				$is_additional_field_2 = $row["is_additional_field_2"];
				$additional_field_2_name = $row["additional_field_2_name"];
				$is_a_f_2_show_in_print = $row["is_a_f_2_show_in_print"];
				$is_additional_field_3 = $row["is_additional_field_3"];
				$additional_field_3_name = $row["additional_field_3_name"];
				$is_a_f_3_show_in_print = $row["is_a_f_3_show_in_print"];
				$is_additional_field_4 = $row["is_additional_field_4"];
				$additional_field_4_name = $row["additional_field_4_name"];
				$is_a_f_4_show_in_print = $row["is_a_f_4_show_in_print"];
				$date = $row["date"];
				
				$response = array("is_party_grouping" => $is_party_grouping ,"is_shipping_address" => $is_shipping_address,"is_print_shipping_address" => $is_print_shipping_address,"is_enable_payment_reminder" => $is_enable_payment_reminder,"reminder_in_days" => $reminder_in_days,"reminder_message" => $reminder_message,"is_additional_field_1" => $is_additional_field_1,"additional_field_1_name" => $additional_field_1_name,"is_a_f_1_show_in_print" => $is_a_f_1_show_in_print,"is_additional_field_2" =>$is_additional_field_2,"additional_field_2_name" => $additional_field_2_name,"is_a_f_2_show_in_print" => $is_a_f_2_show_in_print,"is_additional_field_3" =>$is_additional_field_3,"additional_field_3_name" => $additional_field_3_name,"is_a_f_3_show_in_print" => $is_a_f_3_show_in_print,"is_additional_field_4" =>$is_additional_field_4,"additional_field_4_name" => $additional_field_4_name,"is_a_f_4_show_in_print" => $is_a_f_4_show_in_print,"date" => $date);
				
		}
	}		
	else
	{
		$response["Fail"] = 1;
	}	
	echo json_encode($response);

?>