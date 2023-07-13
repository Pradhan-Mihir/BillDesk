<?php
    include_once('../connection.php');
    global $con;
    $response = array();

	$is_party = ' != ';
	$party_id = 0 ;
	$is_date = ' NOT ';
	$start_date = '0';
	$end_date = '0';
	
    if(isset($_POST['pagging']))
	{
		$response = array();

		if($_POST['from_date'] != '' && $_POST['to_date'] != '')
		{
			$is_date = ' ';
			$start_date = $_POST['from_date'];
			$end_date = $_POST['to_date'];
		}
		if($_POST['party_id'] != 0)
		{
			$is_party = ' = ';
			$party_id = $_POST['party_id'] ;
		}
		
		$sql = "with id as (select product_id , product_name from tbl_product_master 
		left join tbl_company on tbl_product_master.company_id = tbl_company.company_id),
		
		pur as (select sum(tbl_purchase_invoice_detail.total) as 'purchase_amt' ,
		sum(tbl_purchase_invoice_detail.qty) as 'purchase_qty' ,  tbl_purchase_invoice.party_id as 'purchase_party' ,
		tbl_purchase_invoice_detail.product_id  from tbl_purchase_invoice_detail 
		left join tbl_purchase_invoice on tbl_purchase_invoice_detail.purchase_invoice_id = tbl_purchase_invoice.purchase_invoice_id 
		where tbl_purchase_invoice.party_id ".$is_party." ".$party_id."  and tbl_purchase_invoice.purchase_invoice_date ".$is_date." between
		'".$start_date."' and '".$end_date."' 
		group by tbl_purchase_invoice_detail.product_id),

		sal as (select sum(tbl_sales_invoice_detail.total) as 'sales_amt',  sum(tbl_sales_invoice_detail.qty) as 'sales_qty' ,
		tbl_sales_invoice.party_id as 'sales_party' ,  tbl_sales_invoice_detail.product_id  from tbl_sales_invoice_detail 
		left join tbl_sales_invoice on tbl_sales_invoice_detail.sales_invoice_id = tbl_sales_invoice.sales_invoice_id 
		where tbl_sales_invoice.party_id ".$is_party." ".$party_id." and tbl_sales_invoice.sales_invoice_date ".$is_date." between  
		'".$start_date."' and '".$end_date."'  
		group by tbl_sales_invoice_detail.product_id )

		select id.product_name ,pur.purchase_qty , pur.purchase_amt , sal.sales_qty, sal.sales_amt from id
		left join pur on id.product_id = pur.product_id
		left join sal on id.product_id = sal.product_id where ( pur.purchase_amt != '' or sal.sales_amt != '' ) ";

		

		//echo $sql;
		$result = mysqli_query($con,$sql);
		$counter = 0;
		
		while($row = mysqli_fetch_array($result))
		{
			$product_name = $row['product_name'];
			$amt_pur = $row['purchase_amt'];
			$amt_sal = $row['sales_amt'];
			$qty_pur = $row['purchase_qty'];
			$qty_sal = $row['sales_qty'];

			if($row['sales_qty'] == '')
				$qty_sal = 0;

			if($row['purchase_qty'] == '')
				$qty_pur = 0;
			
			if($row['sales_amt'] == '')
				$amt_sal = 0;

			if($row['purchase_amt'] == '')
				$amt_pur = 0;
			
			if(isset($_POST['export_table']) && $_POST['export_table'] == 1)
			{
				$response[] = array("sr_no" => ++$counter ,"product_name" => $product_name ,"qty_sal" => $qty_sal,"amt_sal" => $amt_sal,"qty_pur" => $qty_pur , "amt_pur" => $amt_pur);
			}
			else
			{
				$response[] = array("product_name" => $product_name , "amt_pur" => $amt_pur , "amt_sal" => $amt_sal , "qty_pur" => $qty_pur , "qty_sal" => $qty_sal );
			}
		}
	}
	else
	{
		$response = 'no data';
	}
	echo json_encode($response);



?>