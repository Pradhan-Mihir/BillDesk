<?php
	include_once('../connection.php');
	
	$type = 0;
	if(isset($_POST['type'])){
	   $type = $_POST['type'];
	}

	// Search result
	if($type == 1){
		$searchText = mysqli_real_escape_string($con,$_POST['search']);

		$sql = "SELECT product_id,product_name FROM tbl_product_master where product_name like '%".$searchText."%' order by product_name asc limit 5";

		$result = mysqli_query($con,$sql);

		$search_arr = array();

		while($fetch = mysqli_fetch_assoc($result)){
			$id = $fetch['product_id'];
			$name = $fetch['product_name'];

			$search_arr[] = array("product_id" => $id, "product_name" => $name);
		}

		echo json_encode($search_arr);
	}

	// get User data
	if($type == 2){
		$productid = mysqli_real_escape_string($con,$_POST['product_id']);

		$sql = "SELECT pm.* FROM tbl_product_master pm left join tbl_company tc on tc.company_id = pm.company_id where tc.is_default = 1".$productid;

		$result = mysqli_query($con,$sql);

		$return_arr = array();
		while($fetch = mysqli_fetch_assoc($result))
		{
			$productid = $fetch['product_id'];
			$productname = $fetch['product_name'];

			$return_arr[] = array("product_id"=>$productid, "product_name"=> $productname);
		}

		echo json_encode($return_arr);
	}
?>