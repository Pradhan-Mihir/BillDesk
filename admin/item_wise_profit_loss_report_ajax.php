<?php
    include_once('../connection.php');
    global $con;
    $response = array();

	
	$is_date = ' NOT ';
	$start_date = '0';
	$end_date = '0';
	$item_having = "( pur.purchase_amt != '' or sal.sales_amt != '' )";
	
    if(isset($_POST['pagging']))
	{
		$response = array();

		if($_POST['from_date'] != '' && $_POST['to_date'] != '')
		{
			$is_date = ' ';
			$start_date = $_POST['from_date'];
			$end_date = $_POST['to_date'];
		}
		if($_POST['is_sale'] != 0)
		{
			
			$item_having = "(sal.sales_amt != '' )";
		}
		
		$sql = "with id as (select product_id , opening_stock * sales_rate AS 'opening_stock', closing_stock * sales_rate AS 'closing_stock', product_name  from tbl_product_master left join tbl_company on tbl_product_master.company_id = tbl_company.company_id),

				pur as (select sum(tbl_purchase_invoice_detail.total) as 'purchase_amt' ,  sum(tbl_purchase_invoice_detail.qty) as 'purchase_qty' ,  tbl_purchase_invoice.party_id as 'purchase_party' , sum(tbl_purchase_invoice_detail.gst) + sum(tbl_purchase_invoice_detail.igst) AS 'purchase_tax' ,  tbl_purchase_invoice_detail.product_id  from tbl_purchase_invoice_detail left join tbl_purchase_invoice on tbl_purchase_invoice_detail.purchase_invoice_id = tbl_purchase_invoice.purchase_invoice_id where tbl_purchase_invoice.purchase_invoice_date ".$is_date." between '".$start_date."' and '".$end_date."'  group by tbl_purchase_invoice_detail.product_id),

				sal as (select sum(tbl_sales_invoice_detail.total) as 'sales_amt',  sum(tbl_sales_invoice_detail.qty) as 'sales_qty' , tbl_sales_invoice.party_id as 'sales_party' , sum(tbl_sales_invoice_detail.gst) + sum(tbl_sales_invoice_detail.igst) AS 'sales_tax' ,  tbl_sales_invoice_detail.product_id  from tbl_sales_invoice_detail left join tbl_sales_invoice on tbl_sales_invoice_detail.sales_invoice_id = tbl_sales_invoice.sales_invoice_id  where tbl_sales_invoice.sales_invoice_date ".$is_date." between '".$start_date."' and '".$end_date."'  group by tbl_sales_invoice_detail.product_id ),

				pur_ret as (select sum(tbl_purchase_return_invoice_detail.total) as 'purchase_ret_amt' ,  sum(tbl_purchase_return_invoice_detail.qty) as 'purchase_ret_qty' ,  tbl_purchase_return_invoice.party_id as 'purchase_ret_party' , sum(tbl_purchase_return_invoice_detail.gst) + sum(tbl_purchase_return_invoice_detail.igst) AS 'purchase_ret_tax' ,  tbl_purchase_return_invoice_detail.product_id  from tbl_purchase_return_invoice_detail left join tbl_purchase_return_invoice on tbl_purchase_return_invoice_detail.purchase_return_invoice_id = tbl_purchase_return_invoice.purchase_return_invoice_id where tbl_purchase_return_invoice.purchase_return_invoice_date ".$is_date." between
					'".$start_date."' and '".$end_date."'  group by tbl_purchase_return_invoice_detail.product_id),

				sal_ret as (select sum(tbl_sales_return_detail.total) as 'sales_ret_amt',  sum(tbl_sales_return_detail.qty) as 'sales_ret_qty' , tbl_sales_return.party_id as 'sales_ret_party' , sum(tbl_sales_return_detail.gst) + sum(tbl_sales_return_detail.igst) AS 'sales_ret_tax' ,  tbl_sales_return_detail.product_id  from tbl_sales_return_detail left join tbl_sales_return on tbl_sales_return_detail.sales_return_id = tbl_sales_return.sales_return_id  where tbl_sales_return.sales_return_date ".$is_date." between '".$start_date."' and '".$end_date."'  group by tbl_sales_return_detail.product_id )

				select id.product_name , id.opening_stock , id.closing_stock ,pur_ret.purchase_ret_amt , pur_ret.purchase_ret_tax , pur.purchase_amt , pur.purchase_tax , sal_ret.sales_ret_amt , sal_ret.sales_ret_tax , sal.sales_amt , sal.sales_tax , id.product_id from id
				left join pur on id.product_id = pur.product_id
				left join sal on id.product_id = sal.product_id
				left join pur_ret on id.product_id = pur_ret.product_id
				left join sal_ret on id.product_id = sal_ret.product_id
				where ( ".$item_having.")";

		

		//echo $sql;
		$result = mysqli_query($con,$sql);
		$tax_receive = 0;
		$tax_pay = 0;
		$counter = 0;
		while($row = mysqli_fetch_array($result))
		{
			$product_name = $row['product_name'];
			$amt_sal = $row['sales_amt'];
			$amt_sal_ret = $row['sales_ret_amt'];
			$amt_pur = $row['purchase_amt'];
			$amt_pur_ret = $row['purchase_ret_amt'];
			$opening_stock = number_format($row['opening_stock'], 2);
			$closing_stock = number_format($row['closing_stock'], 2);
			
			$tax_receive = $row['sales_tax'] + $row['purchase_ret_tax'];
			$tax_pay = $row['sales_ret_tax'] + $row['purchase_tax'];
			
			if($row['sales_amt'] == '')
				$amt_sal = 0;

			if($row['sales_ret_amt'] == '')
				$amt_sal_ret = 0;
			
			if($row['purchase_amt'] == '')
				$amt_pur = 0;
			
			if($row['purchase_ret_amt'] == '')
				$amt_pur_ret = 0;
			
			if($row['opening_stock'] == '')
				$opening_stock = 0;
			
			if($row['closing_stock'] == '')
				$closing_stock = 0;
			
			$profit = $amt_sal - $amt_pur + $amt_pur_ret - $amt_sal_ret;
			
			if(isset($_POST['export_table']) && $_POST['export_table'] == 1)
			{
				$response[] = array("sr_no" => ++$counter ,"product_name" => $product_name , "amt_sal" => $amt_sal , "amt_sal_ret" => $amt_sal_ret , "amt_pur" => $amt_pur , "amt_pur_ret" => $amt_pur_ret , "opening_stock" => $opening_stock , "closing_stock" => $closing_stock , "tax_receive" => $tax_receive , "tax_pay" => $tax_pay , "profit" => $profit);
			}
			else
			{
				$response[] = array("product_name" => $product_name , "amt_sal" => $amt_sal , "amt_sal_ret" => $amt_sal_ret , "amt_pur" => $amt_pur , "amt_pur_ret" => $amt_pur_ret , "opening_stock" => $opening_stock , "closing_stock" => $closing_stock , "tax_receive" => $tax_receive , "tax_pay" => $tax_pay , "profit" => $profit);
			}
		}
	}
	else
	{
		$response = 'no data';
	}
	echo json_encode($response);



?>