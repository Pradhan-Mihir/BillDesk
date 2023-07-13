<?php  
include_once('../connection.php');
$response = array();
function checknull($x)
{
	if($x == '')
		$x = 0;
	
	return($x);
}
	if(isset($_POST['report']))
	{
		if($_POST['start_date'] != '' && $_POST['end_date'] != '')
		{
			$query = "With p as(select sum(tbl_purchase_invoice.pay) as 'purchase' from tbl_purchase_invoice 
			where tbl_purchase_invoice.company_id = (select company_id from tbl_company where is_default = 1) 
			and tbl_purchase_invoice.purchase_invoice_date between '".$_POST['start_date']."' and '".$_POST['end_date']."'),
			
			pd as(select sum(tbl_purchase_invoice_detail.disc_amt) as 'purchase_discount' from tbl_purchase_invoice_detail
			left join tbl_purchase_invoice on tbl_purchase_invoice_detail.purchase_invoice_id = tbl_purchase_invoice.purchase_invoice_id
			where tbl_purchase_invoice_detail.company_id = (select company_id from tbl_company where is_default = 1)
			and tbl_purchase_invoice.purchase_invoice_date between '".$_POST['start_date']."' and '".$_POST['end_date']."'),
			
			pgst as(select sum(tbl_purchase_invoice_detail.gst + tbl_purchase_invoice_detail.igst) as 'purchase_tax' from tbl_purchase_invoice_detail
			left join tbl_purchase_invoice on tbl_purchase_invoice_detail.purchase_invoice_id = tbl_purchase_invoice.purchase_invoice_id
			where tbl_purchase_invoice_detail.company_id = (select company_id from tbl_company where is_default = 1)
			and tbl_purchase_invoice.purchase_invoice_date between '".$_POST['start_date']."' and '".$_POST['end_date']."'),
			
			s as(select sum(tbl_sales_invoice.pay) as 'sales' from tbl_sales_invoice 
			where tbl_sales_invoice.company_id = (select company_id from tbl_company where is_default = 1)
			and tbl_sales_invoice.sales_invoice_date between '".$_POST['start_date']."' and '".$_POST['end_date']."'),
			
			sd as(select sum(tbl_sales_invoice_detail.disc_amt) as 'sales_discount' from tbl_sales_invoice_detail
			left join tbl_sales_invoice on tbl_sales_invoice_detail.sales_invoice_id = tbl_sales_invoice.sales_invoice_id
			where tbl_sales_invoice_detail.company_id = (select company_id from tbl_company where is_default = 1)
			and tbl_sales_invoice.sales_invoice_date between '".$_POST['start_date']."' and '".$_POST['end_date']."'),
			 
			sgst as(select sum(tbl_sales_invoice_detail.gst  + tbl_sales_invoice_detail.igst) as 'sales_tax' from tbl_sales_invoice_detail
			left join tbl_sales_invoice on tbl_sales_invoice_detail.sales_invoice_id = tbl_sales_invoice.sales_invoice_id
			where tbl_sales_invoice_detail.company_id = (select company_id from tbl_company where is_default = 1)
			and tbl_sales_invoice.sales_invoice_date between '".$_POST['start_date']."' and '".$_POST['end_date']."'),
			 
			c as(select sum(tbl_cashmemo.pay) as 'cashmemo' from tbl_cashmemo
			where tbl_cashmemo.company_id = (select company_id from tbl_company where is_default = 1)
			and tbl_cashmemo.cashmemo_date between '".$_POST['start_date']."' and '".$_POST['end_date']."'),
			
			cd as(select sum(tbl_cashmemo_detail.disc_amt) as 'cashmemo_discount' from tbl_cashmemo_detail
			left join tbl_cashmemo on tbl_cashmemo_detail.cashmemo_id  = tbl_cashmemo.cashmemo_id
			where tbl_cashmemo_detail.company_id = (select company_id from tbl_company where is_default = 1)
			and tbl_cashmemo.cashmemo_date between '".$_POST['start_date']."' and '".$_POST['end_date']."'),
			
			cgst as(select sum(tbl_cashmemo_detail.gst + tbl_cashmemo_detail.igst) as 'cashmemo_tax' from tbl_cashmemo_detail
			left join tbl_cashmemo on tbl_cashmemo_detail.cashmemo_id  = tbl_cashmemo.cashmemo_id
			where tbl_cashmemo_detail.company_id = (select company_id from tbl_company where is_default = 1)
			and tbl_cashmemo.cashmemo_date between '".$_POST['start_date']."' and '".$_POST['end_date']."'),
			
			pr as(select sum(tbl_purchase_return_invoice.pay) as 'purchase_return' from tbl_purchase_return_invoice 
			where tbl_purchase_return_invoice.company_id = (select company_id from tbl_company where is_default = 1)
			and tbl_purchase_return_invoice.purchase_return_invoice_date between '".$_POST['start_date']."' and '".$_POST['end_date']."'),
			
			prd as(select sum(tbl_purchase_return_invoice_detail.disc_amt) as 'purchase_return_discount' from tbl_purchase_return_invoice_detail
			left join tbl_purchase_return_invoice on tbl_purchase_return_invoice_detail.purchase_return_invoice_id = tbl_purchase_return_invoice.purchase_return_invoice_id
			where tbl_purchase_return_invoice_detail.company_id = (select company_id from tbl_company where is_default = 1)
			and tbl_purchase_return_invoice.purchase_return_invoice_date between '".$_POST['start_date']."' and '".$_POST['end_date']."'),
			
			prgst as(select sum(tbl_purchase_return_invoice_detail.gst + tbl_purchase_return_invoice_detail.igst) as 'purchase_return_tax' from tbl_purchase_return_invoice_detail
			left join tbl_purchase_return_invoice on tbl_purchase_return_invoice_detail.purchase_return_invoice_id = tbl_purchase_return_invoice.purchase_return_invoice_id
			where tbl_purchase_return_invoice_detail.company_id = (select company_id from tbl_company where is_default = 1)
			and tbl_purchase_return_invoice.purchase_return_invoice_date between '".$_POST['start_date']."' and '".$_POST['end_date']."'),
			
			sr as(select sum(tbl_sales_return.pay) as 'sales_return' from tbl_sales_return
			where tbl_sales_return.company_id = (select company_id from tbl_company where is_default = 1)
			and tbl_sales_return.sales_return_date between '".$_POST['start_date']."' and '".$_POST['end_date']."'),
			
			srd as(select sum(tbl_sales_return_detail.disc_amt) as 'sales_return_discount' from tbl_sales_return_detail
			left join tbl_sales_return on tbl_sales_return_detail.sales_return_id = tbl_sales_return.sales_return_id
			where tbl_sales_return_detail.company_id = (select company_id from tbl_company where is_default = 1)
			and tbl_sales_return.sales_return_date between '".$_POST['start_date']."' and '".$_POST['end_date']."'),
			
			srgst as(select sum(tbl_sales_return_detail.gst + tbl_sales_return_detail.igst) as 'sales_return_tax' from tbl_sales_return_detail
			left join tbl_sales_return on tbl_sales_return_detail.sales_return_id = tbl_sales_return.sales_return_id
			where tbl_sales_return_detail.company_id = (select company_id from tbl_company where is_default = 1)
			and tbl_sales_return.sales_return_date between '".$_POST['start_date']."' and '".$_POST['end_date']."'),
			
			cr as(select sum(tbl_cashmemo_return.pay) as 'cashmemo_return' from tbl_cashmemo_return
			where tbl_cashmemo_return.company_id = (select company_id from tbl_company where is_default = 1)
			and tbl_cashmemo_return.cashmemo_return_date between '".$_POST['start_date']."' and '".$_POST['end_date']."'),
			
			crd as(select sum(tbl_cashmemo_return_detail.disc_amt) as 'cashmemo_return_discount' from tbl_cashmemo_return_detail 
			left join tbl_cashmemo_return on tbl_cashmemo_return_detail.cashmemo_return_id = tbl_cashmemo_return.cashmemo_return_id
			where tbl_cashmemo_return_detail.company_id = (select company_id from tbl_company where is_default = 1)
			and tbl_cashmemo_return.cashmemo_return_date between '".$_POST['start_date']."' and '".$_POST['end_date']."'),
			
			crgst as(select sum(tbl_cashmemo_return_detail.gst + tbl_cashmemo_return_detail.igst) as 'cashmemo_return_tax' from tbl_cashmemo_return_detail 
			left join tbl_cashmemo_return on tbl_cashmemo_return_detail.cashmemo_return_id = tbl_cashmemo_return.cashmemo_return_id
			where tbl_cashmemo_return_detail.company_id = (select company_id from tbl_company where is_default = 1)
			and tbl_cashmemo_return.cashmemo_return_date between '".$_POST['start_date']."' and '".$_POST['end_date']."'),
			
			i as(select sum(tbl_income.total) as 'income' from tbl_income 
			where tbl_income.company_id = (select company_id from tbl_company where is_default = 1)
			and tbl_income.date between '".$_POST['start_date']."' and '".$_POST['end_date']."'),
			
			e as(select sum(tbl_expence.total) as 'expence' from tbl_expence 
			where tbl_expence.company_id = (select company_id from tbl_company where is_default = 1)
			and tbl_expence.date between '".$_POST['start_date']."' and '".$_POST['end_date']."'),
			
			pro as(select sum(tbl_product_master.opening_stock * tbl_product_master.sales_rate) as 'opening_stock' , 
			sum(tbl_product_master.closing_stock * tbl_product_master.sales_rate) as 'closing_stock' from tbl_product_master 
			where tbl_product_master.company_id = (select company_id from tbl_company where is_default = 1))
			 
			select p.purchase , pd.purchase_discount , pgst.purchase_tax , pr.purchase_return , prd.purchase_return_discount , prgst.purchase_return_tax ,
			s.sales , sd.sales_discount , sgst.sales_tax , sr.sales_return , srd.sales_return_discount , srgst.sales_return_tax ,
			c.cashmemo , cd.cashmemo_discount , cgst.cashmemo_tax , cr.cashmemo_return , crd.cashmemo_return_discount , crgst.cashmemo_return_tax ,
			i.income , e.expence,   pro.opening_stock , pro.closing_stock 
			from p , pd , pgst , pr , prd , prgst , s , sd , sgst , sr , srd , srgst , c , cd , cgst , cr , crd , crgst , i , e , pro  ";

		}
		else
		{
			$query = "With p as(select sum(tbl_purchase_invoice.pay) as 'purchase' from tbl_purchase_invoice 
			where tbl_purchase_invoice.company_id = (select company_id from tbl_company where is_default = 1)),
			
			pd as(select sum(tbl_purchase_invoice_detail.disc_amt) as 'purchase_discount' from tbl_purchase_invoice_detail
			left join tbl_purchase_invoice on tbl_purchase_invoice_detail.purchase_invoice_id = tbl_purchase_invoice.purchase_invoice_id
			where tbl_purchase_invoice_detail.company_id = (select company_id from tbl_company where is_default = 1)),
			
			pgst as(select sum(tbl_purchase_invoice_detail.gst + tbl_purchase_invoice_detail.igst) as 'purchase_tax' from tbl_purchase_invoice_detail
			left join tbl_purchase_invoice on tbl_purchase_invoice_detail.purchase_invoice_id = tbl_purchase_invoice.purchase_invoice_id
			where tbl_purchase_invoice_detail.company_id = (select company_id from tbl_company where is_default = 1)),
			
			s as(select sum(tbl_sales_invoice.pay) as 'sales' from tbl_sales_invoice 
			where tbl_sales_invoice.company_id = (select company_id from tbl_company where is_default = 1)),
			
			sd as(select sum(tbl_sales_invoice_detail.disc_amt) as 'sales_discount' from tbl_sales_invoice_detail
			left join tbl_sales_invoice on tbl_sales_invoice_detail.sales_invoice_id = tbl_sales_invoice.sales_invoice_id
			where tbl_sales_invoice_detail.company_id = (select company_id from tbl_company where is_default = 1)),
			 
			sgst as(select sum(tbl_sales_invoice_detail.gst  + tbl_sales_invoice_detail.igst) as 'sales_tax' from tbl_sales_invoice_detail
			left join tbl_sales_invoice on tbl_sales_invoice_detail.sales_invoice_id = tbl_sales_invoice.sales_invoice_id
			where tbl_sales_invoice_detail.company_id = (select company_id from tbl_company where is_default = 1)),
			 
			c as(select sum(tbl_cashmemo.pay) as 'cashmemo' from tbl_cashmemo
			where tbl_cashmemo.company_id = (select company_id from tbl_company where is_default = 1)),
			
			cd as(select sum(tbl_cashmemo_detail.disc_amt) as 'cashmemo_discount' from tbl_cashmemo_detail
			left join tbl_cashmemo on tbl_cashmemo_detail.cashmemo_id  = tbl_cashmemo.cashmemo_id
			where tbl_cashmemo_detail.company_id = (select company_id from tbl_company where is_default = 1)),
			
			cgst as(select sum(tbl_cashmemo_detail.gst + tbl_cashmemo_detail.igst) as 'cashmemo_tax' from tbl_cashmemo_detail
			left join tbl_cashmemo on tbl_cashmemo_detail.cashmemo_id  = tbl_cashmemo.cashmemo_id
			where tbl_cashmemo_detail.company_id = (select company_id from tbl_company where is_default = 1)),
			
			pr as(select sum(tbl_purchase_return_invoice.pay) as 'purchase_return' from tbl_purchase_return_invoice 
			where tbl_purchase_return_invoice.company_id = (select company_id from tbl_company where is_default = 1)),
			
			prd as(select sum(tbl_purchase_return_invoice_detail.disc_amt) as 'purchase_return_discount' from tbl_purchase_return_invoice_detail
			left join tbl_purchase_return_invoice on tbl_purchase_return_invoice_detail.purchase_return_invoice_id = tbl_purchase_return_invoice.purchase_return_invoice_id
			where tbl_purchase_return_invoice_detail.company_id = (select company_id from tbl_company where is_default = 1)),
			
			prgst as(select sum(tbl_purchase_return_invoice_detail.gst + tbl_purchase_return_invoice_detail.igst) as 'purchase_return_tax' from tbl_purchase_return_invoice_detail
			left join tbl_purchase_return_invoice on tbl_purchase_return_invoice_detail.purchase_return_invoice_id = tbl_purchase_return_invoice.purchase_return_invoice_id
			where tbl_purchase_return_invoice_detail.company_id = (select company_id from tbl_company where is_default = 1)),
			
			sr as(select sum(tbl_sales_return.pay) as 'sales_return' from tbl_sales_return
			where tbl_sales_return.company_id = (select company_id from tbl_company where is_default = 1)),
			
			srd as(select sum(tbl_sales_return_detail.disc_amt) as 'sales_return_discount' from tbl_sales_return_detail
			left join tbl_sales_return on tbl_sales_return_detail.sales_return_id = tbl_sales_return.sales_return_id
			where tbl_sales_return_detail.company_id = (select company_id from tbl_company where is_default = 1)),
			
			srgst as(select sum(tbl_sales_return_detail.gst + tbl_sales_return_detail.igst) as 'sales_return_tax' from tbl_sales_return_detail
			left join tbl_sales_return on tbl_sales_return_detail.sales_return_id = tbl_sales_return.sales_return_id
			where tbl_sales_return_detail.company_id = (select company_id from tbl_company where is_default = 1)),
			
			cr as(select sum(tbl_cashmemo_return.pay) as 'cashmemo_return' from tbl_cashmemo_return
			where tbl_cashmemo_return.company_id = (select company_id from tbl_company where is_default = 1)),
			
			crd as(select sum(tbl_cashmemo_return_detail.disc_amt) as 'cashmemo_return_discount' from tbl_cashmemo_return_detail 
			left join tbl_cashmemo_return on tbl_cashmemo_return_detail.cashmemo_return_id = tbl_cashmemo_return.cashmemo_return_id
			where tbl_cashmemo_return_detail.company_id = (select company_id from tbl_company where is_default = 1)),
			
			crgst as(select sum(tbl_cashmemo_return_detail.gst + tbl_cashmemo_return_detail.igst) as 'cashmemo_return_tax' from tbl_cashmemo_return_detail 
			left join tbl_cashmemo_return on tbl_cashmemo_return_detail.cashmemo_return_id = tbl_cashmemo_return.cashmemo_return_id
			where tbl_cashmemo_return_detail.company_id = (select company_id from tbl_company where is_default = 1)),
			
			i as(select sum(tbl_income.total) as 'income' from tbl_income 
			where tbl_income.company_id = (select company_id from tbl_company where is_default = 1)),
			
			e as(select sum(tbl_expence.total) as 'expence' from tbl_expence 
			where tbl_expence.company_id = (select company_id from tbl_company where is_default = 1)),
			
			pro as(select sum(tbl_product_master.opening_stock * tbl_product_master.sales_rate) as 'opening_stock' , 
			sum(tbl_product_master.closing_stock * tbl_product_master.sales_rate) as 'closing_stock' from tbl_product_master 
			where tbl_product_master.company_id = (select company_id from tbl_company where is_default = 1))
			 
			select p.purchase , pd.purchase_discount , pgst.purchase_tax , pr.purchase_return , prd.purchase_return_discount , prgst.purchase_return_tax ,
			s.sales , sd.sales_discount , sgst.sales_tax , sr.sales_return , srd.sales_return_discount , srgst.sales_return_tax ,
			c.cashmemo , cd.cashmemo_discount , cgst.cashmemo_tax , cr.cashmemo_return , crd.cashmemo_return_discount , crgst.cashmemo_return_tax ,
			i.income , e.expence,   pro.opening_stock , pro.closing_stock 
			from p , pd , pgst , pr , prd , prgst , s , sd , sgst , sr , srd , srgst , c , cd , cgst , cr , crd , crgst , i , e , pro ";
		}
		$rs_query = mysqli_query($con , $query);
		$row = mysqli_fetch_array($rs_query);
		
		$closing_stock = checknull($row['closing_stock']);
		$opening_stock = checknull($row['opening_stock']);
		$expence = checknull($row['expence']);
		$income = checknull($row['income']);
		$cashmemo_return_tax = checknull($row['cashmemo_return_tax']);
		$cashmemo_return_discount = checknull($row['cashmemo_return_discount']);
		$cashmemo_return = checknull($row['cashmemo_return']);
		$cashmemo_tax = checknull($row['cashmemo_tax']);
		$cashmemo_discount = checknull($row['cashmemo_discount']);
		$cashmemo = checknull($row['cashmemo']);
		$sales_return_tax = checknull($row['sales_return_tax']);
		$sales_return_discount = checknull($row['sales_return_discount']);
		$sales_return = checknull($row['sales_return']);
		$sales_tax = checknull($row['sales_tax']);
		$sales_discount = checknull($row['sales_discount']);
		$sales = checknull($row['sales']);
		$purchase_return_tax = checknull($row['purchase_return_tax']);
		$purchase_return_discount = checknull($row['purchase_return_discount']);
		$purchase_return = checknull($row['purchase_return']);
		$purchase_tax = checknull($row['purchase_tax']);
		$purchase_discount = checknull($row['purchase_discount']);
		$purchase = checknull($row['purchase']);
		
		$tax_payable = $purchase_tax + $sales_return_tax + $cashmemo_return_tax;
		$tax_receivable = $purchase_return_tax + $sales_tax + $cashmemo_tax;
		
		if($rs_query)
		{
		  $response = array("purchase" => $purchase , "purchase_discount" => $purchase_discount , "purchase_return" => $purchase_return, "purchase_return_discount" => $purchase_return_discount, "sales" => $sales , "sales_discount" => $sales_discount, "sales_return" => $sales_return , "sales_return_discount" => $sales_return_discount  , "cashmemo" => $cashmemo , "cashmemo_discount" => $cashmemo_discount ,  "cashmemo_return" => $cashmemo_return , "cashmemo_return_discount" => $cashmemo_return_discount ,  "income" => $income , "expence" => $expence , "opening_stock" => $opening_stock , "closing_stock" => $closing_stock , "tax_payable" => $tax_payable , "tax_receivable" => $tax_receivable );
		}
		else
		{
			die("data not Found".mysqli_error($con));
			$response = array("fail" => 1);
		}
	}


	echo json_encode($response);

?>