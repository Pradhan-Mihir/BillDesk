<?php
	require_once('../connection.php');
	$response = "";
	
	$date = date("Y/m/d");
	$limit = 10;
	
	$sql1 = "select * from tbl_product_master";
	$result1 = mysqli_query($con,$sql1) or die("query failed".mysqli_error($con));
	$total_record = mysqli_num_rows($result1);
	$total_page = ceil($total_record/$limit);

    $query = "With id as(
    SELECT p.party_id, p.party_name, si.purchase_invoice_id, si.invoice_no , si.purchase_invoice_date, si.new_invoice_no , si.total FROM tbl_purchase_invoice si
     LEFT JOIN tbl_party_master p ON si.party_id = p.party_id WHERE si.company_id = (SELECT company_id FROM tbl_company WHERE is_default= 1)
                                                                AND si.financial_id = (SELECT financial_id FROM tbl_financial_master WHERE is_default= 1)),

     td as(
     SELECT purchase_invoice_id, (SUM(ISNULL(`igst`))) as `Tax`
     FROM tbl_purchase_invoice_detail
     WHERE purchase_invoice_id IN (SELECT purchase_invoice_id FROM tbl_purchase_invoice WHERE company_id = (SELECT company_id FROM tbl_company WHERE is_default= 1)
     AND financial_id = (SELECT financial_id FROM tbl_financial_master WHERE is_default= 1))
     GROUP BY purchase_invoice_id),

 pld as(
     SELECT SUM(pl.debit) as PaidAmount, pl.invoice_no, si.purchase_invoice_id FROM tbl_party_ledger pl
     LEFT JOIN tbl_purchase_invoice si ON pl.invoice_no = si.purchase_invoice_id
     WHERE pl.party_type = 0 AND pl.invoice_type = 0
     AND pl.company_id = (SELECT tbl_company.company_id FROM tbl_company WHERE is_default= 1)
     AND pl.financial_id = (SELECT pl.financial_id FROM tbl_financial_master WHERE is_default= 1)
     GROUP BY pl.invoice_no,  si.purchase_invoice_id),

 st as (
     SELECT (CASE
                 WHEN pld.PaidAmount = id.Total THEN 'Paid'
                 WHEN pld.PaidAmount = 0 THEN 'Unpaid'
				 WHEN pld.PaidAmount > id.Total THEN 'Paid'
                 WHEN pld.PaidAmount < id.Total and pld.PaidAmount != 0 Then 'Partial'
         END  ) as Status, pld.purchase_invoice_id FROM pld
                                                       LEFT JOIN id on pld.purchase_invoice_id = id.purchase_invoice_id
 ),

 pldate as (SELECT * FROM tbl_party_ledger pl WHERE party_type = 0 AND Credit > 0 AND
         party_ladger_id = (SELECT MAX(pl.party_ladger_id) FROM tbl_party_ledger _pl WHERE _pl.company_id = (SELECT pl.company_id FROM tbl_company WHERE is_default = 1)
                                                                                       AND _pl.financial_id = (SELECT financial_id FROM tbl_financial_master WHERE is_default= 1)
                                                                                       AND _pl.party_type = 0 AND _pl.Credit > 0 AND _pl.invoice_no = pl.invoice_no))


SELECT ROW_NUMBER() OVER (ORDER BY  id.invoice_no DESC) AS SRNO, id.party_id, id.party_name,  id.invoice_no , id.purchase_invoice_date as PurchaseDate, id.Total as TotalAmt,
       pld.PaidAmount as TotalPaid, st.Status, (id.Total - pld.PaidAmount) as Balance,
       td.purchase_invoice_id as PurchaseId


FROM td
         LEFT JOIN id ON td.purchase_invoice_id = id.purchase_invoice_id
         LEFT JOIN pld ON td.purchase_invoice_id = pld.purchase_invoice_id
         LEFT JOIN pldate ON pld.invoice_no = pldate.invoice_no
         LEFT JOIN st ON td.purchase_invoice_id= st.purchase_invoice_id  where 1=1      ";

	
	if(isset($_POST['pagging']))
	{
		$response = array();
		$stat = $_POST['status'];

		if($_POST['start_date'] != '' && $_POST['end_date'] != '')
		{
			$query .= "  and  id.purchase_invoice_date between '".$_POST['start_date']."' and '".$_POST['end_date']."'    ";
		}
		if($_POST['party'] != 0)
		{
			$query .= "    and id.party_id = '".$_POST['party']."'      ";
		}
		if($_POST['status'] != 0)
		{
			$query .= "    and  st.Status = '".$stat."'      ";
		}

		$sql = $query;
		$sql_count = $sql;
		//echo $sql;
		$result = mysqli_query($con,$sql);
		
		$total_records = mysqli_num_rows($result);
		$counter = 0;
		if($total_records != 0)
			while($row = mysqli_fetch_array($result))
			{
				$purchase_invoice_date = $row['PurchaseDate'];
				$invoice_no = $row['invoice_no'];
				$party_name = $row['party_name'];
				$total = $row['TotalAmt'];
				$pay = $row['TotalPaid'];
				$status = $row['Status'];
				$left = $row['Balance'];
				$color = '#000000';
				if($status == 'Paid')
					$color = '#25e90d';
				else if($status == 'Unpaid')
					$color = "red";
				else if($status == 'Partial')
					$color = "#ffcf00";

				if($pay == '')
					$pay = 0.00;
				if($left == '')
					$left = 0.00;

				if(isset($_POST['export_table']) && $_POST['export_table'] == 1)
				{
					$response[] = array("sr_no" => ++$counter ,"purchase_invoice_date" => $purchase_invoice_date,"party_name" => $party_name,"total" => $total,"pay" => $pay, "left" => $left , "status" => $status);
				}
				else
				{
					$response[] = array("purchase_invoice_date" => $purchase_invoice_date,"invoice_no" => $invoice_no,"party_name" => $party_name,"total" => $total,"pay" => $pay,"total_records" => $total_records , "left" => $left , "status" => $status , "color" => $color);
				}
				
			}
			else
			{
				if(!isset($_POST['export_table']) && $_POST['export_table'] != 1)
				{
					$response[] = array("total_records" => $total_records);
				}
			}
				
		
	}
	else
	{
		$response = 'no data';
	}
	echo json_encode($response);

?>