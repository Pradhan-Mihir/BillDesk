<?php
	require_once('../connection.php');
	$response = array();

	if(isset($_POST['state']))
	{
		if(isset($_POST['id']))
		{
		  $party = "select state_title,place_of_supply_id from tbl_place_of_supply_master WHERE gst_state_code = '". preg_replace('/[^0-9.]+/', '', substr($_POST['id'], 0, 2))."'";  
		  $result = mysqli_query($con,$party);        
		  while($row = mysqli_fetch_array($result))
		  {
			$state = $row["state_title"];
			$state_id = $row["place_of_supply_id"];
			$response = array("state_title" => $state ,"place_of_supply_id" => $state_id);
		  }
		} 
		else
		{
			$response["Fail"] = 1;
		}
		echo json_encode($response);
	}	
?>	