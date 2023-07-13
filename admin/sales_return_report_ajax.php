<?php
	require_once('../connection.php');
	$response = "";
	
	$date = date("Y/m/d");
	$limit = 10;
	
	$sql1 = "select * from tbl_product_master";
	$result1 = mysqli_query($con,$sql1) or die("query faild".mysqli_error($con));
	$total_record = mysqli_num_rows($result1);
	$total_page = ceil($total_record/$limit);
	
	
	if(isset($_POST['pagging']))
	{
			$response = array();
			$stat = $_POST['status'];
			
			if($_POST['start_date'] != '' && $_POST['end_date'] != '')
			{
				if($_POST['party'] != 0)
				{
					if($_POST['status'] != 0)
					{
						//party yes status yes date yea
						$sql = "select si.sales_return_date,si.invoice_no,si.pay,si.total,par.party_name from tbl_sales_return si
								LEFT JOIN tbl_party_master par ON par.party_id = si.party_id 
								where sales_return_date between '".$_POST['start_date']."' and '".$_POST['end_date']."' and si.party_id = '".$_POST['party']."' ";
								
						if($stat == 'Paid')
						{
							$sql .= " and si.pay >= si.total ";
						}	
						else if($stat == 'Unpaid')
						{
							$sql .= " and si.pay = 0 ";
						}	
						else 
						{
							$sql .= " and si.pay <= si.total ";
						}
						$sql_count = $sql;
					}
					else
					{
						//party yes status no date yes
						$sql = "select si.sales_return_date,si.invoice_no,si.pay,si.total,par.party_name from tbl_sales_return si LEFT JOIN tbl_party_master par ON par.party_id = si.party_id where sales_return_date between '".$_POST['start_date']."' and '".$_POST['end_date']."' and si.party_id = '".$_POST['party']."' ";
						
						$sql_count = "select si.sales_return_date,si.invoice_no,si.pay,si.total,par.party_name from tbl_sales_return si LEFT JOIN tbl_party_master par ON par.party_id = si.party_id where si.sales_return_date between '".$_POST['start_date']."' and '".$_POST['end_date']."' and si.party_id = '".$_POST['party']."'";
					}
				}
				else
				{
					if($_POST['status'] != 0)
					{
						//party no status yes date yes
						$sql = "select si.sales_return_date , si.invoice_no , si.pay , si.total ,par.party_name from tbl_sales_return si LEFT JOIN tbl_party_master par ON par.party_id = si.party_id 
								where si.sales_return_date between '".$_POST['start_date']."' and '".$_POST['end_date']."'   ";
								
						if($stat == 'Paid')
						{
							$sql .= " and si.pay >= total ";
						}	
						else if($stat == 'Unpaid')
						{
							$sql .= " and si.pay = 0 ";
						}	
						else 
						{
							$sql .= " and si.pay <= si.total ";
						}
						$sql_count = $sql;

					}
					else
					{
						//party no status no date yes 
						$sql = "select si.sales_return_date , si.invoice_no , si.pay , si.total , par.party_name from tbl_sales_return si LEFT JOIN tbl_party_master par ON par.party_id = si.party_id where si.sales_return_date between '".$_POST['start_date']."' and '".$_POST['end_date']."'  ";
						
						$sql_count ="select si.sales_return_date , si.invoice_no , si.pay , si.total from tbl_sales_return si LEFT JOIN tbl_party_master par ON par.party_id = si.party_id where si.sales_return_date between '".$_POST['start_date']."' and '".$_POST['end_date']."' ";
					}
				}
			}
			else
			{
				if($_POST['party'] != 0)
				{
					if($_POST['status'] != 0)
					{
						//party yes status yes date no
						$sql = "select si.sales_return_date,si.invoice_no,si.pay,si.total,par.party_name from tbl_sales_return si
								LEFT JOIN tbl_party_master par ON par.party_id = si.party_id 
								where  si.party_id = '".$_POST['party']."' and";
								
						if($stat == 'Paid')
						{
							$sql .= "  si.pay >= si.total ";
						}	
						else if($stat == 'Unpaid')
						{
							$sql .= "  si.pay = 0 ";
						}	
						else 
						{
							$sql .= "  si.pay <= si.total ";
						}
						$sql_count = $sql;

					}
					else
					{
						//party yes status no date no
						$sql = "select si.sales_return_date,si.invoice_no,si.pay,si.total,par.party_name from tbl_sales_return si LEFT JOIN tbl_party_master par ON par.party_id = si.party_id  where  si.party_id = '".$_POST['party']."' ";
						
						$sql_count = "select si.sales_return_date,si.invoice_no,si.pay,si.total,par.party_name from tbl_sales_return si LEFT JOIN tbl_party_master par ON par.party_id = si.party_id  where  si.party_id = '".$_POST['party']."'";
					}
				}
				else
				{
					if($_POST['status'] != 0)
					{
						//party no status yes date no
						$sql = "select si.sales_return_date , si.invoice_no , si.pay , si.total ,par.party_name from tbl_sales_return si LEFT JOIN tbl_party_master par ON par.party_id = si.party_id 
								where  ";
								
						if($stat == 'Paid')
						{
							$sql .= "  si.pay >= si.total ";
						}	
						else if($stat == 'Unpaid')
						{
							$sql .= "  si.pay = 0 ";
						}	
						else 
						{
							$sql .= "  si.pay < si.total and si.pay != 0 ";
						}
						$sql_count = $sql;
						
					}
					else
					{
						//party no status no date no 
						$sql = "select si.sales_return_date , si.invoice_no , si.pay , si.total ,par.party_name  from tbl_sales_return si  LEFT JOIN tbl_party_master par ON par.party_id = si.party_id  ";
						$sql_count = "select si.sales_return_date , si.invoice_no , si.pay , si.total from tbl_sales_return si  LEFT JOIN tbl_party_master par ON par.party_id = si.party_id ";
					}
				}
			}
			//echo $sql;
			$result = mysqli_query($con,$sql);
			
			$total_records = mysqli_num_rows(mysqli_query($con,$sql_count));
			$counter = 0;
			if($total_records != 0)
				while($row = mysqli_fetch_array($result))
				{
					$sales_return_date = $row['sales_return_date'];
					$invoice_no = $row['invoice_no'];
					$party_name = $row['party_name'];
					$total = $row['total'];
					$pay = $row['pay'];
					if($total > $pay)
					{
						$left = $total - $pay;
						$color = 'red';
						$status = 'Unpaid';
					}
					
					else
					{
						$left = 0;
						$color = "#25e90d";
						$status = 'Paid';
					}
					
					if(isset($_POST['export_table']) && $_POST['export_table'] == 1)
					{
						$response[] = array("sr_no" => ++$counter  ,"sales_return_date" => $sales_return_date,"party_name" => $party_name,"total" => $total,"pay" => $pay, "left" => $left , "status" => $status );
					}
					else
					{
						$response[] = array("sales_return_date" => $sales_return_date,"invoice_no" => $invoice_no,"party_name" => $party_name,"total" => $total,"pay" => $pay,"total_records" => $total_records , "left" => $left , "status" => $status , "color" => $color);
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