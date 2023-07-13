<?php
	require_once('../connection.php');
	$response = array();
    global $con;
	if(isset($_POST['edit']))
	{
		if(isset($_POST['id']))
		{
			$fetchSql = "select * from tbl_payment_out where payment_out_id = '".$_POST['id']."' ";
			$result = mysqli_query($con,$fetchSql);		
			while($row = mysqli_fetch_array($result))
			{
				$response["party_id"] = $row["party_id"];
				$response["receipt_no"] = $row["receipt_no"];
				$response["payment_type_id"] = $row["payment_type_id"];
				$response["cheque_ref_no"] = $row["cheque_ref_no"];
				$response["date"] = $row["date"];
				$response["description"] = $row["description"];
				$response["image"] = $row["image"];
				$response["paid"] = $row["paid"];
			}		
		}		
	}
    else if(isset($_POST['tabs']))
    {
        $sql = "select party_type from tbl_party_master where party_id =  '".$_POST['party_id']."' ";
        $row1  = mysqli_fetch_array(mysqli_query($con, $sql));

        if($row1['party_type'] != 1 )
            $fetchSql = "select purchase_invoice_date AS date , purchase_invoice_id AS id , total - pay AS due , invoice_no , total , 'purchase' AS table_name  from tbl_purchase_invoice where party_id = '" . $_POST['party_id'] . "' and total > pay";

        else
            $fetchSql = "select sales_return_date AS date , sales_return_id AS id  , total - pay AS due , invoice_no , total , 'sales_return' AS table_name  from tbl_sales_return where party_id = '" . $_POST['party_id'] . "' and total > pay ";

        $result = mysqli_query($con,$fetchSql);

        while($row = mysqli_fetch_array($result))
        {

            $date = $row["date"];
            $due = $row["due"];
            $invoice_no = $row["invoice_no"];
            $total = $row["total"];
            $id = $row['id'];
            $type =  $row['table_name'];

            $response[] = array('date' => $date , 'inv_no' => $invoice_no , 'total' => $total , 'due' => $due , 'id' =>$id , 'type' => $type);
        }
    }
	else
	{
		$response["Fail"] = 1;
	}
	echo json_encode($response);

?>