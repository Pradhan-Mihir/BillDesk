<?php
	require_once('../connection.php');
	$response = array();
	if(isset($_POST['delete']))
	{
		if(isset($_POST['id']))
		{
			$sql_select = "select * from manage_user_tbl where user_id = '".$_POST['id']."'";
			$resultView = mysqli_query($con,$sql_select);
			if(mysqli_num_rows($resultView) > 0)
			{
				while($rowView = mysqli_fetch_array($resultView))
				{
					$image1 = $rowView['user_image'];
					$path = $_SERVER['DOCUMENT_ROOT'].'/project/images/user_images/';
					if (file_exists($path.$image1)) 
					{
						unlink($path.$image1);
					}				
				}
			}
			
			$deleteSql = "CALL deleteManageUser('".$_POST['id']."')";
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
			$fetchSql = "CALL fetchManageUser('".$_POST['id']."')";
			$result = mysqli_query($con,$fetchSql);		
			while($row = mysqli_fetch_array($result))
			{
				$response["username"] = $row["username"];
				$response["full_name"] = $row["full_name"];
				$response["email"] = $row["email"];	
				$response["mobile"] = $row["mobile"];			
			}		
		}		
	}
	else if(isset($_POST['val']))
	{
		$fetchSql = "select * from manage_user_tbl where  ";
		
		if($_POST['which'] == 'txt_uname')
		{
			$fetchSql .= "  username = '".$_POST['txt']."'  ";
		}

		if($_POST['which'] == 'txt_email')
		{
			$fetchSql .= "  email = '".$_POST['txt']."'  ";
		}

		if($_POST['which'] == 'txt_mobile')
		{
			$fetchSql .= "  mobile = '".$_POST['txt']."'  ";
		}

		$result = mysqli_query($con, $fetchSql);
		
		if (mysqli_num_rows($result) < 1)
		{
			$response['exists'] = 0;
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