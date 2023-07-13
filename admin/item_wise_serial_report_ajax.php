<?php
    include_once('../connection.php');
    global $con;
    $response = array();
    $limit = 10;

    if(isset($_POST['pagging']))
	{
		if(isset($_POST['id']))
		{
			$page = $_POST['id'];
			$offset = ($page -1 ) * 10;
			$response = array();

			$query = "WITH temporaryTable(product_id) as
					(select product_id  from tbl_serial_no group by product_id limit $offset , $limit)
					select tbl_serial_no.* , tbl_product_master.product_name from tbl_serial_no , temporaryTable , tbl_product_master
					where tbl_serial_no.product_id =  temporaryTable.product_id
					and tbl_serial_no.product_id =  tbl_product_master.product_id    ";

            if($_POST['product_id'] != 0)
            {
				$query .= "  and tbl_serial_no.product_id =     ".$_POST['product_id']."      ";
            }

			$query .= "  order by  tbl_serial_no.product_id        ";
            $sql = $query;
            $sql_count = 'select product_id from tbl_serial_no group by product_id';

			//echo $sql;
			$result = mysqli_query($con,$sql);
			
			$total_records = mysqli_num_rows(mysqli_query($con,$sql_count));
			$key = 0;
			$counter = 0;
			if($total_records != 0)
				while($row = mysqli_fetch_array($result))
				{
					$product_name = $row['product_name'];
					$product_id = $row['product_id'];
					$serial_no = $row['serial_no'];
					$is_sold = $row['is_sold'];
					
					$response[] = array("product_name" => $product_name ,  "product_id" => $product_id , "serial_no" => $serial_no , "is_sold" => $is_sold , "total_records" => $total_records);
				}
				else
					$response[] = array("total_records" => $total_records);
			
		}
	}
	else
	{
		$response = 'no data';
	}
	echo json_encode($response);



?>