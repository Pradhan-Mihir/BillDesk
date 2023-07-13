<?php
	require_once('../connection.php');
	$response = array();
	
	if (isset($_POST['loginDetails']))
	{
		$fetchSql = "select * from manage_user_tbl where username = '".$_POST['user_name']."' and passward = '".$_POST['password']."' ";
		$result = mysqli_query($con, $fetchSql);
		
		if (mysqli_num_rows($result) < 1)
		{
			$response['Not_exists'] = 1;
		}
		else
		{
			$response['exists'] = 1;
		}
	}
	else
	{
		$response["Fail"] = 1;
	}
	
	echo json_encode($response);

?>