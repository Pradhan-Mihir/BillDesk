<?php
	require_once('../connection.php');
	$response = array();
    global $con;
	
    if(isset($_POST['fetch']))
    {
        $fetchSql = "select * from tbl_product_setting ";
        $result = mysqli_query($con,$fetchSql);
        $row = mysqli_fetch_array($result);

        $is_show_serial = $row["is_show_serial"];
        $is_show_barcode = $row["is_show_barcode"];
        $purchase = $row["purchase"];
        $sales = $row["sales"];
        $sales_return = $row["sales_return"];
        $purchase_return = $row["purchase_return"];
        $cashmemo = $row["cashmemo"];
        $cashmemo_return = $row["cashmemo_return"];
        $is_show_low_stock = $row["is_show_low_stock"];
        $is_show_batch = $row["is_show_batch"];
        $is_gst_bill = $row["is_gst_bill"];

        $response = array("is_show_serial" => $is_show_serial ,"is_show_barcode" => $is_show_barcode , "purchase" => $purchase,"sales" => $sales , "sales_return" => $sales_return,"purchase_return" => $purchase_return , "cashmemo" => $cashmemo,"cashmemo_return" => $cashmemo_return , "is_show_low_stock" => $is_show_low_stock,"is_show_batch" =>$is_show_batch,"is_gst_bill" => $is_gst_bill );

    }
    else if(isset($_POST['update_chk']))
    {
        $sql = "UPDATE tbl_product_setting SET ".$_POST['id']." = ".$_POST['data']." ";
        $result = mysqli_query($con,$sql);
        if($result)
            $response['Fail'] = 0;
        else
            $response['Fail'] = 1;
    }
    else if(isset($_POST['update']))
    {
        $sql = "UPDATE tbl_product_setting SET ".$_POST['id']." = '".$_POST['data']."' ";
        $result = mysqli_query($con,$sql);
        if($result)
            $response['Fail'] = 0;
        else
            $response['Fail'] = 1;
    }
    else if(isset($_POST['check']))
    {
        $sql = "select ".$_POST['id']." from  tbl_product_setting ";
        $result = mysqli_query($con,$sql);
        $row = mysqli_fetch_array($result);

        if($row[$_POST['id']] == $_POST['data'] )
            $response['Fail'] = 0;
        else
            $response['Fail'] = 1;
    }
	else
	{
		$response["Fail"] = 1;
	}	
	echo json_encode($response);

?>