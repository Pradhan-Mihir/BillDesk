<?php
	include_once('header.php');
	
	$curr_ip =  gethostbyname(getHostName());
	$qr_path = 'http://'.$curr_ip.':80/tryon_project_mbm/invoice/';
	$detail = '<table class="table table-hover"><thead><tr><th class="text-center">Sr No.</th><th class="text-center">Item</th><th class="text-center">Price</th><th class="text-center">Quantity</th>';
	
	$fetchSql = "select * from tbl_invoice_setting";
    $result = mysqli_query($con,$fetchSql);
	$row_inv_setting = mysqli_fetch_array($result);
	
	$detail_email = '';
	$counter = 0;
	
	//fetch active company id
	$company_id="SELECT * FROM tbl_company WHERE is_default=1";
	$rs_company_id=mysqli_query($con,$company_id);
	$row_company_id=mysqli_fetch_array($rs_company_id);
	
	$company_name = $row_company_id['company_name'];
	$mobile_no = $row_company_id['mobile_no'];
	$alter_mobile = $row_company_id['alter_mobile_no'];
	$gst_in = $row_company_id['gst_in_no'];
	$image = $row_company_id["company_logo"];
	$company_add = $row_company_id["address"];
	$company_city = $row_company_id["city"];
	$company_pincode = $row_company_id["pincode"];
	$company_state = $row_company_id["state"];
	$company_mail = $row_company_id['email'];
	
	//for income invoice
	if(isset($_GET['income_id']))
	{
		$detail .= '<th class="text-center">Amount</th></tr></thead><tbody id="detail_show">';
		$last_id = $_GET['income_id'];
		//echo $last_id;
		
		$sql_income = "SELECT inc.*,pay.payment_type  FROM tbl_income inc 
		LEFT JOIN tbl_payment_type pay ON pay.payment_type_id = inc.payment_type_id
		where income_id = '".$last_id."' ";
		$rs_income = mysqli_query($con,$sql_income);
		$row = mysqli_fetch_array($rs_income);
		
		$date= $row['date'];
		$invoice_no = $last_id;
		$invoice = "Income receipt";
		$address = '';
		$party = '';
		$gst = 0.00;
		$gst_final = 0.0;
		$igst = 0.00;
		$discount = 0.00;
		$sub_total = $row['total'];
		$total = $row['total'];
		$pay = $row['total'];
		$qty = "-";
		$shipping = 0.00;
		$payment_type = $row['payment_type'];
		$filename = "Income-".$invoice_no."-".$last_id."";
		$qr_path .= $filename.'.png';   


		$sql_detail = "select * from tbl_income_detail where income_id='".$last_id."' ";
		$rs_detail = mysqli_query($con,$sql_detail);
		
		while($row_income = mysqli_fetch_array($rs_detail))
		{
			++$counter;
			
			$detail .="<tr class='text-center'><td >".$counter."</td><td>".$row_income['item_name']."</td><td>".$row_income['price']."</td><td>".$row_income['quantity']."</td><td>".$row_income['total']."</td></tr>";
			
			$detail_email .= '<tr>
					<td class="item-col item">
					  <table cellspacing="0" cellpadding="0" width="100%">
						<tr >
						  <td class="product">
							<span style="color: #4d4d4d; font-weight:bold;">'.$row_income['item_name'].'</span>
						  </td>
						</tr>
					  </table>
					</td>
					<td class="item-col quantity">
					  &#8377;'.$row_income['price'].'
					</td>
					<td class="item-col">
					  '.$row_income['quantity'].'
					</td>
					<td class="item-col quantity">
					  '.$gst.'
					</td>
					<td class="item-col">
					  '.$discount.'
					</td>
					<td class="item-col">
					  &#8377;'.$row_income['total'].'
					</td>
				  </tr>';
		} 
		$detail .= "</tbody></table>";
		
	}
	//for expence invoice
	else if(isset($_GET['expence_id']))
	{
		$detail .= '<th class="text-center">Amount</th></tr></thead><tbody id="detail_show">';
	
		$last_id = $_GET['expence_id'];
		
		$sql_expence = "SELECT exp.*,pay.payment_type FROM tbl_expence exp 
		LEFT JOIN tbl_payment_type pay ON pay.payment_type_id = exp.payment_type_id
		where expence_id = '".$last_id."' ";
		$rs_expence = mysqli_query($con,$sql_expence);
		$row = mysqli_fetch_array($rs_expence);
		
		$date= $row['date'];
		$invoice_no = $last_id;
		$invoice = "Expence receipt";
		$address = '';
		$party = '';
		$gst = 0.00;
		$gst_final = 0.0;
		$igst = 0.00;
		$discount = 0.00;
		$sub_total = $row['total'];
		$total = $row['total'];
		$pay = $row['total'];
		$qty = "-";
		$shipping = 0.00;
		$payment_type = $row['payment_type'];
		$filename = "Expense-".$invoice_no."-".$last_id."";
		$qr_path .= $filename.'.png'; 

		$sql_detail = "select * from tbl_expence_detail where expence_id='".$last_id."' ";
		$rs_detail = mysqli_query($con,$sql_detail);
		
		while($row_expence = mysqli_fetch_array($rs_detail))
		{
			++$counter;
			$detail .="<tr class='text-center'><td >".$counter."</td><td>".$row_expence['item_name']."</td><td>".$row_expence['price']."</td><td>".$row_expence['quantity']."</td><td>".$row_expence['total']."</td></tr>";
			
			$detail_email = '<tr>
					<td class="item-col item">
					  <table cellspacing="0" cellpadding="0" width="100%">
						<tr >
						  <td class="product">
							<span style="color: #4d4d4d; font-weight:bold;">'.$row_expence['item_name'].'</span>
						  </td>
						</tr>
					  </table>
					</td>
					<td class="item-col quantity">
					  &#8377;'.$row_expence['price'].'
					</td>
					<td class="item-col">
					  '.$row_expence['quantity'].'
					</td>
					<td class="item-col quantity">
					  '.$gst.'
					</td>
					<td class="item-col">
					  '.$discount.'
					</td>
					<td class="item-col">
					  &#8377;'.$row_expence['total'].'
					</td>
				  </tr>';
		} 
		$detail .= "</tbody></table>";
	}
	//for payment_in invoice
	else if(isset($_GET['payment_in_id'])) 
	{
		$invoice = "Payment In Receipt";
		$last_id = $_GET['payment_in_id'];
		//echo $last_id;
		$detail .= '<th class="text-center">Amount</th></tr></thead><tbody id="detail_show">';
		
			
		$sql_payment_in = "SELECT payin.*,par.billing_address,par.party_name,par.mobile_no,par.state,par.gst_in,par.email,pay.payment_type FROM tbl_payment_in payin
		LEFT JOIN tbl_party_master par ON par.party_id = payin.party_id 
		LEFT JOIN tbl_payment_type pay ON pay.payment_type_id = payin.payment_type_id
		where payin.payment_in_id = '".$last_id."' ";
		$rs_payment_in = mysqli_query($con,$sql_payment_in);
		$row = mysqli_fetch_array($rs_payment_in);
		
		$date= $row['date'];
		$invoice_no = $row['receipt_no'];
		$address = $row['billing_address'];
		$party = $row['party_name'];
		$party_email = $row['email'];
		$party_gst_in = $row['gst_in'];
		$party_mobile = $row['mobile_no'];
		$party_state = $row['state'];
		$gst = 0.00	;
		$gst_final = 0.0;
		$igst = 0.00;
		$discount = 0.00;
		$sub_total = $row['received'];
		$total = $row['received'];
		$pay = $row['received'];
		$qty = "-";
		$shipping = 0.00;
		$payment_type = $row['payment_type'];
		$filename = "Payment-In-".$invoice_no."-".$last_id."";
		$qr_path .= $filename.'.png'; 
		
		++$counter;
		$detail .="<tr class='text-center'><td >".$counter."</td><td>".$row['description']."</td><td>".$row['received']."</td><td>".$qty."</td><td>".$row['received']."</td></tr>";
		
		$detail_email = '<tr>
					<td class="item-col item">
					  <table cellspacing="0" cellpadding="0" width="100%">
						<tr >
						  <td class="product">
							<span style="color: #4d4d4d; font-weight:bold;">'.$row['description'].'</span>
						  </td>
						</tr>
					  </table>
					</td>
					<td class="item-col quantity">
					  &#8377;'.$row['received'].'
					</td>
					<td class="item-col">
					  '.$qty.'
					</td>
					<td class="item-col quantity">
					  '.$gst.'
					</td>
					<td class="item-col">
					  '.$discount.'
					</td>
					<td class="item-col">
					  &#8377;'.$row['received'].'
					</td>
				  </tr>';
		
		$detail .= "</tbody></table>";
	}
	//for payment_out invoice
	else if(isset($_GET['payment_out_id']))
	{
		$invoice = "Payment Out Receipt";
		$detail .= '<th class="text-center">Amount</th></tr></thead><tbody id="detail_show">';
		$last_id = $_GET['payment_out_id'];
		
		$sql_payment_out = "SELECT payout.*,par.billing_address,par.party_name,par.mobile_no,par.state,par.gst_in,par.email,pay.payment_type FROM tbl_payment_out payout
		LEFT JOIN tbl_party_master par ON par.party_id = payout.party_id 
		LEFT JOIN tbl_payment_type pay ON pay.payment_type_id = payout.payment_type_id
		where payout.payment_out_id = '".$last_id."' ";
		$rs_payment_out = mysqli_query($con,$sql_payment_out);
		$row = mysqli_fetch_array($rs_payment_out);
		
		$date= $row['date'];
		$invoice_no = $row['receipt_no'];
		$address = $row['billing_address'];
		$party = $row['party_name'];
		$party_email = $row['email'];
		$party_gst_in = $row['gst_in'];
		$party_mobile = $row['mobile_no'];
		$party_state = $row['state'];
		$gst = 0.00	;
		$gst_final = 0.0;
		$igst = 0.00;
		$discount = 0.00;
		$sub_total = $row['paid'];
		$total = $row['paid'];
		$pay = $row['paid'];
		$qty = "-";
		$shipping = 0.00;
		$payment_type = $row['payment_type'];
		$filename = "Payment-Out-".$invoice_no."-".$last_id."";
		$qr_path .= $filename.'.png'; 

		++$counter;
		$detail .="<tr class='text-center'><td >".$counter."</td><td>".$row['description']."</td><td>".$row['paid']."</td><td>".$qty."</td><td>".$row['paid']."</td></tr>";
		
		
		$detail_email = '<tr>
						<td class="item-col item">
						  <table cellspacing="0" cellpadding="0" width="100%">
							<tr >
							  <td class="product">
								<span style="color: #4d4d4d; font-weight:bold;">'.$row['description'].'</span>
							  </td>
							</tr>
						  </table>
						</td>
						<td class="item-col quantity">
						  &#8377;'.$row['paid'].'
						</td>
						<td class="item-col">
						  '.$qty.'
						</td>
						<td class="item-col quantity">
						  '.$gst.'
						</td>
						<td class="item-col">
						  '.$discount.'
						</td>
						<td class="item-col">
						  &#8377;'.$row['paid'].'
						</td>
					  </tr>';
		
		$detail .= "</tbody></table>";
	}
	//for purchase invoice
	else if(isset($_GET['purchase_id']))
	{
		$invoice = "Purchase Invoice";
		$detail .= '<th class="text-center">Gst</th><th class="text-center">Discount</th><th class="text-center">Amount</th></tr></thead><tbody id="detail_show">';
		
		$last_id = $_GET['purchase_id'];
		
		$sql_purchase = "SELECT pi.* , par.party_name,par.billing_address,par.mobile_no,par.state,par.gst_in,par.email,pay.payment_type FROM tbl_purchase_invoice pi
		LEFT JOIN tbl_party_master par ON par.party_id = pi.party_id
		LEFT JOIN tbl_payment_type pay ON pay.payment_type_id = pi.payment_type_id
		WHERE pi.purchase_invoice_id = '".$last_id."' ";
		$rs_purchase = mysqli_query($con,$sql_purchase);
		$row = mysqli_fetch_array($rs_purchase);
		
		
		$date= $row['purchase_invoice_date'];
		$invoice_no = $row['new_invoice_no'].'-'.$row['invoice_no'];
		$address = $row['billing_address'];
		$party = $row['party_name'];
		$party_email =$row['email'];
		$party_gst_in = $row['gst_in'];
		$party_mobile = $row['mobile_no'];
		$party_state = $row['state_of_supply'] ;
		$gst = 0.00	;
		$gst_final = 0.0;
		$igst = 0.00;
		$discount = 0.00;
		$sub_total =$row['sub_total'];
		$total = $row['total'];
		$pay = $row['pay'];
		$shipping = $row['shipping_packing_ammount'];
		$payment_type = $row['payment_type'];
		$filename = "Purchase-".$invoice_no."";
		$qr_path .= $filename.'.png'; 

		$sql_detail = "select pid.*,pro.product_name,pro.purchase_tax_type from tbl_purchase_invoice_detail pid 
		LEFT JOIN tbl_product_master pro ON pro.product_id = pid.product_id
		where pid.purchase_invoice_id='".$last_id."' ";
		$rs_detail = mysqli_query($con,$sql_detail);
		
		while($row_purchase = mysqli_fetch_array($rs_detail))
		{
			$serial_no = $row_purchase['serial_no'];
			$serial = '';
			$batch = "";
			$batch_no = $row_purchase['batch_no'];
			
			if($serial_no != '')
			{
				$serial = "Serial No :";
				$serial_no = explode("|",$serial_no);
				$sr_no = count($serial_no);
				
				for($i=0;$i<$sr_no;$i++)
				{
					if($serial_no[$i] != '')
					{
						$sql = "select serial_no from tbl_serial_no where serial_no_id = '".$serial_no[$i]."' ";
						$rs_sql = mysqli_query($con , $sql);
						
						while($row_sr = mysqli_fetch_array($rs_sql))
						{
							$serial .= $row_sr['serial_no'].',';
						}
					}
				}
			}
			if($batch_no!= '')
			{
				$sql = "select batch_no from tbl_batch_tracking where batch_tracking_id = '".$batch_no."' ";
				$rs_sql = mysqli_query($con , $sql);
				$batch = "Batch No :";
				$row_sr = mysqli_fetch_array($rs_sql);
				
				$batch .= $row_sr['batch_no'];
			}
			
			if($row_inv_setting['is_show_serial']  != 1)
				$serial = '';
			if($row_inv_setting['is_show_batch']  != 1)
				$batch = '';

			++$counter;
			$detail .="<tr class='text-center'><td >".$counter."</td><td>".$row_purchase['product_name']."<br/>&nbsp;".$serial.$batch."</td>";
			
			//for gst
			if($row_purchase['gst'] == "" || $row_purchase['gst'] == 0 )
			{
				$gst = $row_purchase['igst'];
				$gst_per = $row_purchase['igst_per'];
			}
			else
			{
				$gst = $row_purchase['gst'];
				$gst_per = $row_purchase['gst_per'];
			}
			//for igst
			if($row_purchase['igst'] == "" || $row_purchase['igst'] == 0 )
			{
				$gst = $row_purchase['gst'];
				$gst_per = $row_purchase['gst_per'];
			}
			else
			{
				$gst = $row_purchase['igst'];
				$gst_per = $row_purchase['igst_per'];
			}
			
			$detail .= "<td>".$row_purchase['rate']."</td><td>".$row_purchase['qty']."</td>";
			
				
			$detail .= "<td>".$gst."</td><td>".$row_purchase['disc_amt']."</td><td>".$row_purchase['total']."</td></tr>";
				
			
			$detail_email .= '<tr>
						<td class="item-col item">
						  <table cellspacing="0" cellpadding="0" width="100%">
							<tr >
							  <td class="product">
								<span style="color: #4d4d4d; font-weight:bold;">'.$row_purchase['product_name'].'<br/>
									'.$serial.$batch.'
								</span>
							  </td>
							</tr>
						  </table>
						</td>
						<td class="item-col quantity">
						  &#8377;'.$row_purchase['rate'].'
						</td>
						<td class="item-col">
						  '.$row_purchase['qty'].'
						</td>
						<td class="item-col quantity">
						  '.$gst.'
						</td>
						<td class="item-col">
						  '.$row_purchase['disc_amt'].'
						</td>
						<td class="item-col">
						  &#8377;'.$row_purchase['total'].'
						</td>
					  </tr>';
			
		} 
		$detail .= "</tbody></table>";
	}
	//for purchase return invoice
	else if(isset($_GET['purchase_return_id']))
	{
		$invoice = "Purchase Return Invoice";
		$detail .= '<th class="text-center">Gst</th><th class="text-center">Discount</th><th class="text-center">Amount</th></tr></thead><tbody id="detail_show">';
		
		$last_id = $_GET['purchase_return_id'];
		
		$sql_purchase_return = "SELECT pri.* , par.party_name,par.billing_address,par.mobile_no,par.state,par.gst_in,par.email,pay.payment_type FROM tbl_purchase_return_invoice pri
		LEFT JOIN tbl_party_master par ON par.party_id = pri.party_id
		LEFT JOIN tbl_payment_type pay ON pay.payment_type_id = pri.payment_type_id
		WHERE pri.purchase_return_invoice_id = '".$last_id."' ";
		$rs_purchase_return = mysqli_query($con,$sql_purchase_return);
		$row = mysqli_fetch_array($rs_purchase_return);
		
		$date= $row['purchase_return_invoice_date'];
		$invoice_no = $row['new_invoice_no'].'-'.$row['invoice_no'];
		$address = $row['billing_address'];
		$party = $row['party_name'];
		$party_email =$row['email'];
		$party_gst_in = $row['gst_in'];
		$party_mobile = $row['mobile_no'];
		$party_state = $row['state_of_supply'] ;
		$gst = 0.00	;
		$gst_final = 0.0;
		$igst = 0.00;
		$discount = 0.00;
		$sub_total =$row['sub_total'];
		$total = $row['total'];
		$pay = $row['pay'];
		$shipping = $row['shipping_packing_amount'];
		$payment_type = $row['payment_type'];
		$filename = "Purchase-Return-".$invoice_no."";
		$qr_path .= $filename.'.png'; 

		$sql_detail = "select prid.*,pro.product_name,pro.purchase_tax_type from tbl_purchase_return_invoice_detail prid 
		LEFT JOIN tbl_product_master pro ON pro.product_id = prid.product_id
		where prid.purchase_return_invoice_id ='".$last_id."' ";
		$rs_detail = mysqli_query($con,$sql_detail);
		
		while($row_purchase_return = mysqli_fetch_array($rs_detail))
		{
			$serial_no = $row_purchase_return['serial_no'];
			$serial = '';
			$batch = "";
			$batch_no = $row_purchase_return['batch_no'];
			
			if($serial_no != '')
			{
				$serial = "Serial No :";
				$serial_no = explode("|",$serial_no);
				$sr_no = count($serial_no);
				
				for($i=0;$i<$sr_no;$i++)
				{
					if($serial_no[$i] != '')
					{
						$sql = "select serial_no from tbl_serial_no where serial_no_id = '".$serial_no[$i]."' ";
						$rs_sql = mysqli_query($con , $sql);
						
						while($row_sr = mysqli_fetch_array($rs_sql))
						{
							$serial .= $row_sr['serial_no'].',';
						}
					}
				}
			}
			if($batch_no!= '')
			{
				$sql = "select batch_no from tbl_batch_tracking where batch_tracking_id = '".$batch_no."' ";
				$rs_sql = mysqli_query($con , $sql);
				$batch = "Batch No :";
				$row_sr = mysqli_fetch_array($rs_sql);
				
				$batch .= $row_sr['batch_no'];
			}
			
			if($row_inv_setting['is_show_serial']  != 1)
				$serial = '';
			if($row_inv_setting['is_show_batch']  != 1)
				$batch = '';

			++$counter;
			$detail .="<tr class='text-center'><td >".$counter."</td><td>".$row_purchase_return['product_name']."<br/>&nbsp;".$serial.$batch."</td>";
			
			//for gst
			if($row_purchase_return['gst'] == "" || $row_purchase_return['gst'] == 0 )
			{
				$gst = $row_purchase_return['igst'];
				$gst_per = $row_purchase_return['igst_per'];
			}
			else
			{
				$gst = $row_purchase_return['gst'];
				$gst_per = $row_purchase_return['gst_per'];
			}
			//for igst
			if($row_purchase_return['igst'] == "" || $row_purchase_return['igst'] == 0 )
			{
				$gst = $row_purchase_return['gst'];
				$gst_per = $row_purchase_return['gst_per'];
			}
			else
			{
				$gst = $row_purchase_return['igst'];
				$gst_per = $row_purchase_return['igst_per'];
			}
			
			$detail .="<td>".$row_purchase_return['rate']."</td><td>".$row_purchase_return['qty']."</td>";
			
			$detail .="<td>".$gst."</td><td>".$row_purchase_return['disc_amt']."</td><td>".$row_purchase_return['total']."</td></tr>";
			
			$detail_email .= '<tr>
						<td class="item-col item">
						  <table cellspacing="0" cellpadding="0" width="100%">
							<tr >
							  <td class="product">
								<span style="color: #4d4d4d; font-weight:bold;">'.$row_purchase_return['product_name'].'<br/>
									'.$serial.$batch.'</span>
							  </td>
							</tr>
						  </table>
						</td>
						<td class="item-col quantity">
						  &#8377;'.$row_purchase_return['rate'].'
						</td>
						<td class="item-col">
						  '.$row_purchase_return['qty'].'
						</td>
						<td class="item-col quantity">
						  '.$gst.'
						</td>
						<td class="item-col">
						  '.$row_purchase_return['disc_amt'].'
						</td>
						<td class="item-col">
						  &#8377;'.$row_purchase_return['total'].'
						</td>
					  </tr>';
					
		} 
		$detail .= "</tbody></table>";
		
	}
	//for sales invoice
	else if(isset($_GET['sales_id']))
	{
		$invoice = "Sales Invoice";
		$detail .= '<th class="text-center">Gst</th><th class="text-center">Discount</th><th class="text-center">Amount</th></tr></thead><tbody id="detail_show">';
		
		$last_id = $_GET['sales_id'];
		
		$sql_sales = "SELECT si.* , par.party_name,par.billing_address,par.mobile_no,par.state,par.gst_in,par.email,pay.payment_type FROM tbl_sales_invoice si
		LEFT JOIN tbl_party_master par ON par.party_id = si.party_id
		LEFT JOIN tbl_payment_type pay ON pay.payment_type_id = si.payment_type_id
		WHERE si.sales_invoice_id = '".$last_id."' ";
		$rs_sales = mysqli_query($con,$sql_sales);
		$row = mysqli_fetch_array($rs_sales);
		
		$date= $row['sales_invoice_date'];
		$invoice_no = $row['new_invoice_no'].'-'.$row['invoice_no'];
		$address = $row['billing_address'];
		$party = $row['party_name'];
		$party_email =$row['email'];
		$party_gst_in = $row['gst_in'];
		$party_mobile = $row['mobile_no'];
		$party_state = $row['state_of_supply'] ;
		$gst = 0;
		$gst_final = 0;
		$igst = 0;
		$discount = 0.00;
		$sub_total =$row['sub_total'];
		$total = $row['total'];
		$pay = $row['pay'];
		$shipping = $row['shipping_packing_amount'];
		$payment_type = $row['payment_type'];
		$filename = "Sales-".$invoice_no."";
		$qr_path .= $filename.'.png'; 

		$sql_detail = "select sid.*,pro.product_name,pro.sales_tax_type from tbl_sales_invoice_detail sid 
		LEFT JOIN tbl_product_master pro ON pro.product_id = sid.product_id
		where sid.sales_invoice_id='".$last_id."' ";
		$rs_detail = mysqli_query($con,$sql_detail);
		
		
		
		
		while($row_sales = mysqli_fetch_array($rs_detail))
		{
			$serial_no = $row_sales['serial_no'];
			$serial = '';
			$batch = "";
			$batch_no = $row_sales['batch_no'];
			
			if($serial_no != '')
			{
				$serial = "Serial No :";
				$serial_no = explode("|",$serial_no);
				$sr_no = count($serial_no);
				
				for($i=0;$i<$sr_no;$i++)
				{
					if($serial_no[$i] != '')
					{
						$sql = "select serial_no from tbl_serial_no where serial_no_id = '".$serial_no[$i]."' ";
						$rs_sql = mysqli_query($con , $sql);
						
						while($row_sr = mysqli_fetch_array($rs_sql))
						{
							$serial .= $row_sr['serial_no'].',';
						}
					}
				}
			}
			if($batch_no!= '')
			{
				$sql = "select batch_no from tbl_batch_tracking where batch_tracking_id = '".$batch_no."' ";
				$rs_sql = mysqli_query($con , $sql);
				$batch = "Batch No :";
				$row_sr = mysqli_fetch_array($rs_sql);
				
				$batch .= $row_sr['batch_no'];
			}
			
			if($row_inv_setting['is_show_serial']  != 1)
				$serial = '';
			if($row_inv_setting['is_show_batch']  != 1)
				$batch = '';

			++$counter;
			$detail .="<tr class='text-center'><td >".$counter."</td><td>".$row_sales['product_name']."<br/>&nbsp;".$serial.$batch."</td>";
			
			//for gst
			if($row_sales['gst'] == "" || $row_sales['gst'] == 0 )
			{
				$gst = $row_sales['igst'];
				$gst_per = $row_sales['igst_per'];
			}
			else
			{
				$gst = $row_sales['gst'];
				$gst_per = $row_sales['gst_per'];
			}
			//for igst
			if($row_sales['igst'] == "" || $row_sales['igst'] == 0 )
			{
				$gst = $row_sales['gst'];
				$gst_per = $row_sales['gst_per'];
			}
			else
			{
				$gst = $row_sales['igst'];
				$gst_per = $row_sales['igst_per'];
			}
			
			$detail .="<td>".$row_sales['rate']."</td><td>".$row_sales['qty']."</td>";
			
			$detail .="<td>".$gst."</td><td>".$row_sales['disc_amt']."</td><td>".$row_sales['total']."</td></tr>";
			
			$detail_email .= '<tr>
						<td class="item-col item">
						  <table cellspacing="0" cellpadding="0" width="100%">
							<tr >
							  <td class="product">
								<span style="color: #4d4d4d; font-weight:bold;">'.$row_sales['product_name'].'<br/>
									'.$serial.$batch.'
								</span>
							  </td>
							</tr>
						  </table>
						</td>
						<td class="item-col quantity">
						  &#8377;'.$row_sales['rate'].'
						</td>
						<td class="item-col">
						  '.$row_sales['qty'].'
						</td>
						<td class="item-col quantity">
						  '.$gst.'
						</td>
						<td class="item-col">
						  '.$row_sales['disc_amt'].'
						</td>
						<td class="item-col">
						  &#8377;'.$row_sales['total'].'
						</td>
					  </tr>';
			
		} 
		$detail .= "</tbody></table>";
	}
	//for sales return invoice
	else if(isset($_GET['sales_return_id']))
	{
		$invoice = "Sales Return Invoice";
		$detail .= '<th class="text-center">Gst</th><th class="text-center">Discount</th><th class="text-center">Amount</th></tr></thead><tbody id="detail_show">';
		
		$last_id = $_GET['sales_return_id'];
		
		$sql_sales_return = "SELECT sri.* , par.party_name,par.billing_address,par.mobile_no,par.state,par.gst_in,par.email,pay.payment_type FROM tbl_sales_return sri
		LEFT JOIN tbl_party_master par ON par.party_id = sri.party_id
		LEFT JOIN tbl_payment_type pay ON pay.payment_type_id = sri.payment_type_id
		WHERE sri.sales_return_id = '".$last_id."' ";
		$rs_sales_return = mysqli_query($con,$sql_sales_return);
		$row = mysqli_fetch_array($rs_sales_return);
		
		$date= $row['sales_return_date'];
		$invoice_no = $row['new_invoice_no'].'-'.$row['invoice_no'];
		$address = $row['billing_address'];
		$party = $row['party_name'];
		$party_email =$row['email'];
		$party_gst_in = $row['gst_in'];
		$party_mobile = $row['mobile_no'];
		$party_state = $row['state_of_supply'] ;
		$gst = 0;
		$gst_final = 0;
		$igst = 0;
		$discount = 0.00;
		$sub_total =$row['sub_total'];
		$total = $row['total'];
		$pay = $row['pay'];
		$shipping = $row['shipping_packing_amount'];
		$payment_type = $row['payment_type'];
		$filename = "Sales-Return-".$invoice_no."";
		$qr_path .= $filename.'.png'; 

		$sql_detail = "select srid.*,pro.product_name,pro.sales_tax_type from tbl_sales_return_detail srid 
		LEFT JOIN tbl_product_master pro ON pro.product_id = srid.product_id
		where srid.sales_return_id='".$last_id."' ";
		$rs_detail = mysqli_query($con,$sql_detail);
		
		while($row_sales_return = mysqli_fetch_array($rs_detail))
		{
			$serial_no = $row_sales_return['serial_no'];
			$serial = '';
			$batch = "";
			$batch_no = $row_sales_return['batch_no'];
			
			if($serial_no != '')
			{
				$serial = "Serial No :";
				$serial_no = explode("|",$serial_no);
				$sr_no = count($serial_no);
				
				for($i=0;$i<$sr_no;$i++)
				{
					if($serial_no[$i] != '')
					{
						$sql = "select serial_no from tbl_serial_no where serial_no_id = '".$serial_no[$i]."' ";
						$rs_sql = mysqli_query($con , $sql);
						
						while($row_sr = mysqli_fetch_array($rs_sql))
						{
							$serial .= $row_sr['serial_no'].',';
						}
					}
				}
			}
			if($batch_no!= '')
			{
				$sql = "select batch_no from tbl_batch_tracking where batch_tracking_id = '".$batch_no."' ";
				$rs_sql = mysqli_query($con , $sql);
				$batch = "Batch No :";
				$row_sr = mysqli_fetch_array($rs_sql);
				
				$batch .= $row_sr['batch_no'];
			}

			if($row_inv_setting['is_show_serial']  != 1)
				$serial = '';
			if($row_inv_setting['is_show_batch']  != 1)
				$batch = '';

			++$counter;
			$detail .="<tr class='text-center'><td >".$counter."</td><td>".$row_sales_return['product_name']."<br/>&nbsp;".$serial.$batch."</td>";
			
			//for gst
			if($row_sales_return['gst'] == "" || $row_sales_return['gst'] == 0 )
			{
				$gst = $row_sales_return['igst'];
				$gst_per = $row_sales_return['igst_per'];
			}
			else
			{
				$gst = $row_sales_return['gst'];
				$gst_per = $row_sales_return['gst_per'];
			}
			//for igst
			if($row_sales_return['igst'] == "" || $row_sales_return['igst'] == 0 )
			{
				$gst = $row_sales_return['gst'];
				$gst_per = $row_sales_return['gst_per'];
			}
			else
			{
				$gst = $row_sales_return['igst'];
				$gst_per = $row_sales_return['igst_per'];
			}
			
			$detail .="<td>".$row_sales_return['rate']."</td><td>".$row_sales_return['qty']."</td>";
			
			$detail .="<td>".$gst."</td><td>".$row_sales_return['disc_amt']."</td><td>".$row_sales_return['total']."</td></tr>";
			
			$detail_email .= '<tr>
						<td class="item-col item">
						  <table cellspacing="0" cellpadding="0" width="100%">
							<tr >
							  <td class="product">
								<span style="color: #4d4d4d; font-weight:bold;">'.$row_sales_return['product_name'].'<br/>
									'.$serial.$batch.'
							  </td>
							</tr>
						  </table>
						</td>
						<td class="item-col quantity">
						  &#8377;'.$row_sales_return['rate'].'
						</td>
						<td class="item-col">
						  '.$row_sales_return['qty'].'
						</td>
						<td class="item-col quantity">
						  '.$gst.'
						</td>
						<td class="item-col">
						  '.$row_sales_return['disc_amt'].'
						</td>
						<td class="item-col">
						  &#8377;'.$row_sales_return['total'].'
						</td>
					  </tr>';
		} 
		$detail .= "</tbody></table>";
	}
	//for cashmemo
	else if(isset($_GET['cashmemo_id']))
	{
		$invoice = "Cashmemo Invoice";
		$detail .= '<th class="text-center">Gst</th><th class="text-center">Discount</th><th class="text-center">Amount</th></tr></thead><tbody id="detail_show">';
		
		$last_id = $_GET['cashmemo_id'];
		
		$sql_cashmemo = "SELECT cm.*,pay.payment_type  FROM tbl_cashmemo cm
		LEFT JOIN tbl_payment_type pay ON pay.payment_type_id = cm.payment_type_id
		WHERE cm.cashmemo_id = '".$last_id."' ";
		$rs_cashmemo= mysqli_query($con,$sql_cashmemo);
		$row = mysqli_fetch_array($rs_cashmemo);
		
		$date= $row['cashmemo_date'];
		$invoice_no = $row['new_invoice_no'].'-'.$row['invoice_no'];
		$address = "";
		$party = "";
		$gst = 0;
		$gst_final = 0;
		$igst = 0;
		$discount = 0.00;
		$sub_total =$row['sub_total'];
		$total = $row['total'];
		$pay = $row['pay'];
		$shipping = $row['shipping_packing_amount'];
		$payment_type = $row['payment_type'];
		$filename = "Cashmemo-".$invoice_no."";
		$qr_path .= $filename.'.png'; 

		$sql_detail = "select cad.*,pro.product_name,pro.sales_tax_type from tbl_cashmemo_detail cad 
		LEFT JOIN tbl_product_master pro ON pro.product_id = cad.product_id
		where cad.cashmemo_id='".$last_id."' ";
		$rs_detail = mysqli_query($con,$sql_detail);
		
		while($row_cashmemo = mysqli_fetch_array($rs_detail))
		{
			$serial_no = $row_cashmemo['serial_no'];
			$serial = '';
			$batch = "";
			$batch_no = $row_cashmemo['batch_no'];
			
			if($serial_no != '')
			{
				$serial = "Serial No :";
				$serial_no = explode("|",$serial_no);
				$sr_no = count($serial_no);
				
				for($i=0;$i<$sr_no;$i++)
				{
					if($serial_no[$i] != '')
					{
						$sql = "select serial_no from tbl_serial_no where serial_no_id = '".$serial_no[$i]."' ";
						$rs_sql = mysqli_query($con , $sql);
						
						while($row_sr = mysqli_fetch_array($rs_sql))
						{
							$serial .= $row_sr['serial_no'].',';
						}
					}
				}
			}
			if($batch_no!= '')
			{
				$sql = "select batch_no from tbl_batch_tracking where batch_tracking_id = '".$batch_no."' ";
				$rs_sql = mysqli_query($con , $sql);
				$batch = "Batch No :";
				$row_sr = mysqli_fetch_array($rs_sql);
				
				$batch .= $row_sr['batch_no'];
			}
			
			if($row_inv_setting['is_show_serial']  != 1)
				$serial = '';
			if($row_inv_setting['is_show_batch']  != 1)
				$batch = '';

			++$counter;
			$detail .="<tr class='text-center'><td >".$counter."</td><td>".$row_cashmemo['product_name']."<br/>&nbsp;".$serial.$batch."</td>";
			
			//for gst
			if($row_cashmemo['gst'] == "" || $row_cashmemo['gst'] == 0 )
			{
				$gst = $row_cashmemo['igst'];
				$gst_per = $row_cashmemo['igst_per'];
			}
			else
			{
				$gst = $row_cashmemo['gst'];
				$gst_per = $row_cashmemo['gst_per'];
			}
			//for igst
			if($row_cashmemo['igst'] == "" || $row_cashmemo['igst'] == 0 )
			{
				$gst = $row_cashmemo['gst'];
				$gst_per = $row_cashmemo['gst_per'];
			}
			else
			{
				$gst = $row_cashmemo['igst'];
				$gst_per = $row_cashmemo['igst_per'];
			}
			
			$detail .="<td>".$row_cashmemo['rate']."</td><td>".$row_cashmemo['qty']."</td>";
			
			$detail .="<td>".$gst."</td><td>".$row_cashmemo['disc_amt']."</td><td>".$row_cashmemo['total']."</td></tr>";
			
			$detail_email .= '<tr>
						<td class="item-col item">
						  <table cellspacing="0" cellpadding="0" width="100%">
							<tr >
							  <td class="product">
								<span style="color: #4d4d4d; font-weight:bold;">'.$row_cashmemo['product_name'].'<br/>
									'.$serial.$batch.'</span>
							  </td>
							</tr>
						  </table>
						</td>
						<td class="item-col quantity">
						  &#8377;'.$row_cashmemo['rate'].'
						</td>
						<td class="item-col">
						  '.$row_cashmemo['qty'].'
						</td>
						<td class="item-col quantity">
						  '.$gst.'
						</td>
						<td class="item-col">
						  '.$row_cashmemo['disc_amt'].'
						</td>
						<td class="item-col">
						  &#8377;'.$row_cashmemo['total'].'
						</td>
					  </tr>';
		} 
		$detail .= "</tbody></table>";
	}
	//for cashmemo return
	else if(isset($_GET['cashmemo_return_id']))
	{
		$invoice = "Cashmemo Return Invoice";
		$detail .= '<th class="text-center">Gst</th><th class="text-center">Discount</th><th class="text-center">Amount</th></tr></thead><tbody id="detail_show">';
		
		$last_id = $_GET['cashmemo_return_id'];
		
		$sql_cashmemo_return = "SELECT cm.*,pay.payment_type  FROM tbl_cashmemo_return cm
		LEFT JOIN tbl_payment_type pay ON pay.payment_type_id = cm.payment_type_id
		WHERE cm.cashmemo_return_id = '".$last_id."' ";
		$rs_cashmemo_return= mysqli_query($con,$sql_cashmemo_return);
		$row = mysqli_fetch_array($rs_cashmemo_return);
		
		$date= $row['cashmemo_return_date'];
		$invoice_no = $row['new_invoice_no'].'-'.$row['invoice_no'];
		$address = "";
		$party = "";
		$gst = 0;
		$gst_final = 0;
		$igst = 0;
		$discount = 0.00;
		$sub_total =$row['sub_total'];
		$total = $row['total'];
		$pay = $row['pay'];
		$shipping = $row['shipping_packing_amount'];
		$payment_type = $row['payment_type'];
		$filename = "Cashmemo-Return-".$invoice_no."";
		$qr_path .= $filename.'.png'; 

		$sql_detail = "select card.*,pro.product_name,pro.sales_tax_type from tbl_cashmemo_return_detail card 
		LEFT JOIN tbl_product_master pro ON pro.product_id = card.product_id
		where card.cashmemo_return_id = '".$last_id."' ";
		$rs_detail = mysqli_query($con,$sql_detail);
		
		while($row_cashmemo_return = mysqli_fetch_array($rs_detail))
		{
			$serial_no = $row_cashmemo_return['serial_no'];
			$serial = '';
			$batch = "";
			$batch_no = $row_cashmemo_return['batch_no'];
			
			if($serial_no != '')
			{
				$serial = "Serial No :";
				$serial_no = explode("|",$serial_no);
				$sr_no = count($serial_no);
				
				for($i=0;$i<$sr_no;$i++)
				{
					if($serial_no[$i] != '')
					{
						$sql = "select serial_no from tbl_serial_no where serial_no_id = '".$serial_no[$i]."' ";
						$rs_sql = mysqli_query($con , $sql);
						
						while($row_sr = mysqli_fetch_array($rs_sql))
						{
							$serial .= $row_sr['serial_no'].',';
						}
					}
				}
			}
			if($batch_no!= '')
			{
				$sql = "select batch_no from tbl_batch_tracking where batch_tracking_id = '".$batch_no."' ";
				$rs_sql = mysqli_query($con , $sql);
				$batch = "Batch No :";
				$row_sr = mysqli_fetch_array($rs_sql);
				
				$batch .= $row_sr['batch_no'];
			}
			
			if($row_inv_setting['is_show_serial']  != 1)
				$serial = '';
			if($row_inv_setting['is_show_batch']  != 1)
				$batch = '';

			++$counter;
			$detail .="<tr class='text-center'><td >".$counter."</td><td>".$row_cashmemo_return['product_name']."<br/>&nbsp;".$serial.$batch."</td>";
			
			//for gst
			if($row_cashmemo_return['gst'] == "" || $row_cashmemo_return['gst'] == 0 )
			{
				$gst = $row_cashmemo_return['igst'];
				$gst_per = $row_cashmemo_return['igst_per'];
			}
			else
			{
				$gst = $row_cashmemo_return['gst'];
				$gst_per = $row_cashmemo_return['gst_per'];
			}
			//for igst
			if($row_cashmemo_return['igst'] == "" || $row_cashmemo_return['igst'] == 0 )
			{
				$gst = $row_cashmemo_return['gst'];
				$gst_per = $row_cashmemo_return['gst_per'];
			}
			else
			{
				$gst = $row_cashmemo_return['igst'];
				$gst_per = $row_cashmemo_return['igst_per'];
			}
			
			$detail .="<td>".$row_cashmemo_return['rate']."</td><td>".$row_cashmemo_return['qty']."</td>";
			
			$detail .="<td>".$gst."</td><td>".$row_cashmemo_return['disc_amt']."</td><td>".$row_cashmemo_return['total']."</td></tr>";
			
			$detail_email .= '<tr>
						<td class="item-col item">
						  <table cellspacing="0" cellpadding="0" width="100%">
							<tr >
							  <td class="product">
								<span style="color: #4d4d4d; font-weight:bold;">'.$row_cashmemo_return['product_name'].'<br/>
									'.$serial.$batch.'</span>
							  </td>
							</tr>
						  </table>
						</td>
						<td class="item-col quantity">
						  &#8377;'.$row_cashmemo_return['rate'].'
						</td>
						<td class="item-col">
						  '.$row_cashmemo_return['qty'].'
						</td>
						<td class="item-col quantity">
						  '.$gst.'
						</td>
						<td class="item-col">
						  '.$row_cashmemo_return['disc_amt'].'
						</td>
						<td class="item-col">
						  &#8377;'.$row_cashmemo_return['total'].'
						</td>
					  </tr>';
		} 
		$detail .= "</tbody></table>";
	}
	else
	{
		die("Opps... Something Went Wrong..!".mysqli_error($con));
	}
?>
		<!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="white-box printableArea" id="capture">
    	<div class="row">
            <div class=""> 
              <img src="../images/company_images/<?php echo $row_company_id['company_logo']; ?>" alt="image" class="img-circle" width="100px" />
            </div>
            <div class="col-md-2 text-right">
              <h1><b class="text-info"><?php echo $company_name; ?></b></h1>
              <h4><b><i class="fa fa-phone"></i><?php echo $row_company_id['mobile_no']; ?></b></h4>
            </div>
        </div>
		<div class="row">
		  	<div class="col-md-12">
         		<hr>
				<h3><b><?php echo $invoice; ?></b> <span class="pull-right"><?php echo $invoice_no; ?></span></h3>
				<hr>
				<!---row--->
				<div class="row">
					<div class="col-md-12">
						<div class="pull-left">
							<address>
							<h2> &nbsp;<b class="text-danger">Bill Desk</b></h2>
							<p class="text-muted m-l-5"><?php echo $company_add;?>
								<br/> <?php echo $company_city.'-'.$company_pincode;?>
								<br/> <?php echo $company_state; ?></p>
							</address>
						</div>
					
						<div class="pull-right text-right">
							<?php if($address != '' && $row_inv_setting['is_show_party'] == 1)
							{?>
								<address>
								<h3>To,</h3>
								<h4 class="font-bold"><?php echo $party;?></h4>
								<h5 class="font-bold"><i class="fa fa-phone"></i><?php echo $party_mobile;?></h5>
								<p class="text-muted m-l-30"><?php echo $address;?>
									<br/> <?php echo $party_state;?>
								</p>
								
								</address>
							<?php
							}
							?>
							<p class="m-t-30"><b>Invoice Date :</b><i class="fa fa-calendar"></i>&nbsp;<?php echo $date;?></p>
						</div>
				
					</div>
					<div class="col-md-12">
						<div class="table-responsive m-t-40" style="clear: both;">
							<?php echo $detail; ?>
						</div>
					</div>
					<div class="col-md-12">
						<div class="pull-right m-t-30 text-right">
							<p>Sub - Total: <?php echo "&#8377; ".$sub_total;?></p>
							<p>Shipping/Packing Amount: <?php echo "&#8377; ".$shipping;?></p>
							<p>Total: <?php echo "&#8377; ".$total;?></p>
							<h3><b>Pay :</b><?php echo "&#8377; ".$pay;?></h3>
						</div>
						<div class="clearfix"></div>
						<hr>
					</div>
          		</div>
				<div class="row">
					<div class="col-md-6">
						<div class="pull-left m-t-30 text-left">
							<h2><b>Terms & Conditions</b></h2>
							<h5>This is a Computer Generated Invoice.</h5>
							<?php 
								$counter = 1;
								$terms = "";
								for($i = 3 ; $i < 9 ; $i++)
								{
									if(trim($row_inv_setting[$i]) != '')
									{
										$terms .=  '<h5>'.$counter .". ". $row_inv_setting[$i].'</h5>';
										$counter++;
									}	
								}
								echo $terms;
							?>
							
						</div>	
					</div>	
					<div class="col-md-6">
						<div class="pull-right m-t-30 text-right">
							<img src="https://chart.googleapis.com/chart?chs=250x250&amp;cht=qr&amp;chl=<?php echo $qr_path;?>&amp;choe=UTF-8" alt="QR code">
						</div>	
					</div>
				</div>  
       		</div>
     	</div>
    </div>
    <!-- .row -->
    <div class="text-right">
      <button id="print" class="btn btn-default btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
      <button id="back" onclick="window.location.href='<?php echo $back_path; ?>'" class="btn btn-default btn-outline" type="button"> <span><i class="fa fa-print"></i> Back</span> </button>
	  <!---<button type="button" id="shot" name="shot" onclick="docapture();">Capture</button>--->
    </div>
    
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
<script src="html2canvas.min.js"></script>
<script>
	function docapture()
	{
		window.scrollTo(0,0);
		
		html2canvas(document.getElementById('capture')).then(function(canvas){
			console.log(canvas.toDataURL("image/png",0.9));
		
			var filename = "<?php echo $filename;?>";
			$.ajax({  
				url:"save_capture.php",
				type:"POST",
				data:{'image': canvas.toDataURL("image/png",0.9),'filename': filename},
				success:function(data)  
				{  
					console.log("done");
				}
			});	
		});

	}
</script>
<?php 
	$invoice_mail = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Invoice</title>

  <style type="text/css">
    /* Take care of image borders and formatting, client hacks */
    img { max-width: 600px; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;}
    a img { border: none; }
    table { border-collapse: collapse !important;}
    #outlook a { padding:0; }
    .ReadMsgBody { width: 100%; }
    .ExternalClass { width: 100%; }
    .backgroundTable { margin: 0 auto; padding: 0; width: 100% !important; }
    table td { border-collapse: collapse; }
    .ExternalClass * { line-height: 115%; }
    .container-for-gmail-android { min-width: 600px; }


    /* General styling */
    * {
      font-family: DejaVu Sans, sans-serif;
    }

    body {
      -webkit-font-smoothing: antialiased;
      -webkit-text-size-adjust: none;
      width: 100% !important;
      margin: 0 !important;
      height: 100%;
      color: #676767;
    }

    td {
      font-family:  DejaVu Sans, Arial, sans-serif;
      font-size: 14px;
      color: #777777;
      text-align: center;
      line-height: 21px;
    }

    a {
      color: #676767;
      text-decoration: none !important;
    }

    .pull-left {
      text-align: left;
    }

    .pull-right {
      text-align: right;
    }

    .header-lg,
    .header-md,
    .header-sm {
      font-size: 32px;
      font-weight: 700;
      line-height: normal;
      padding: 35px 0 0;
      color: #4d4d4d;
    }

    .header-md {
      font-size: 24px;
    }

    .header-sm {
      padding: 5px 0;
      font-size: 18px;
      line-height: 1.3;
    }

    .content-padding {
      padding: 20px 0 5px;
    }

    .mobile-header-padding-right {
      width: 290px;
      text-align: right;
      padding-left: 10px;
    }

    .mobile-header-padding-left {
      width: 290px;
      text-align: left;
      padding-left: 10px;
    }

    .free-text {
      width: 100% !important;
      padding: 10px 60px 0px;
    }

    .button {
      padding: 30px 0;
    }

    .mini-block {
      border: 1px solid #e5e5e5;
      border-radius: 5px;
      background-color: #ffffff;
      padding: 12px 15px 15px;
      text-align: left;
      width: 253px;
    }

    .mini-container-left {
      width: 278px;
      padding: 10px 0 10px 15px;
    }

    .mini-container-right {
      width: 278px;
      padding: 10px 14px 10px 15px;
    }

    .product {
      text-align: left;
      vertical-align: top;
      width: 175px;
    }

    .total-space {
      padding-bottom: 8px;
      display: inline-block;
    }

    .item-table {
      padding: 50px 20px;
      width: 560px;
    }

    .item {
      width: 300px;
    }

    .mobile-hide-img {
      text-align: left;
      width: 125px;
    }

    .mobile-hide-img img {
      border: 1px solid #e6e6e6;
      border-radius: 4px;
    }

    .title-dark {
      text-align: left;
      border-bottom: 1px solid #cccccc;
      color: #4d4d4d;
      font-weight: 700;
      padding-bottom: 5px;
    }

    .item-col {
      padding-top: 20px;
      text-align: left;
      vertical-align: top;
    }

    .force-width-gmail {
      min-width:600px;
      height: 0px !important;
      line-height: 1px !important;
      font-size: 1px !important;
    }

  </style>

  <style type="text/css" media="screen">
    @import url(http://fonts.googleapis.com/css?family=Oxygen:400,700);
  </style>

  <style type="text/css" media="screen">
    @media screen {
      /* Thanks Outlook 2013! */
      * {
        font-family: "Oxygen", " DejaVu Sans", "Arial", "sans-serif" !important;
      }
    }
  </style>

  <style type="text/css" media="only screen and (max-width: 480px)">
    /* Mobile styles */
    @media only screen and (max-width: 480px) {

      table[class*="container-for-gmail-android"] {
        min-width: 290px !important;
        width: 100% !important;
      }

      img[class="force-width-gmail"] {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
      }

      table[class="w320"] {
        width: 320px !important;
      }

      td[class*="mobile-header-padding-left"] {
        width: 160px !important;
        padding-left: 0 !important;
      }

      td[class*="mobile-header-padding-right"] {
        width: 160px !important;
        padding-right: 0 !important;
      }

      td[class="header-lg"] {
        font-size: 24px !important;
        padding-bottom: 5px !important;
      }

      td[class="content-padding"] {
        padding: 5px 0 5px !important;
      }

       td[class="button"] {
        padding: 5px 5px 30px !important;
      }

      td[class*="free-text"] {
        padding: 10px 18px 30px !important;
      }

      td[class~="mobile-hide-img"] {
        display: none !important;
        height: 0 !important;
        width: 0 !important;
        line-height: 0 !important;
      }

      td[class~="item"] {
        width: 140px !important;
        vertical-align: top !important;
      }

      td[class~="quantity"] {
        width: 50px !important;
      }

      td[class~="price"] {
        width: 90px !important;
      }

      td[class="item-table"] {
        padding: 30px 20px !important;
      }

      td[class="mini-container-left"],
      td[class="mini-container-right"] {
        padding: 0 15px 15px !important;
        display: block !important;
        width: 290px !important;
      }

    }
  </style>
</head>

<body bgcolor="#f7f7f7">
<table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%">
  <tr>
    <td align="left" valign="top" width="100%" style="background:repeat-x url(http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg) #ffffff;">
      <center>
        <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff" background="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" style="background-color:transparent">
          <tr>
            <td width="100%" height="80" valign="top" style="text-align: center; vertical-align:middle;">
            <!--[if gte mso 9]>
            <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:1000;height:80px; v-text-anchor:middle;">
              <v:fill type="tile" src="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" color="#ffffff" />
              <v:textbox inset="0,0,0,0">
            <![endif]-->
              <center>
                <table cellpadding="0" cellspacing="0" width="600" class="w320">
                  <tr>
                    <td class="pull-left mobile-header-padding-left" style="vertical-align: middle;">
                      <p><h1>Bill Desk</h1></p>
                    </td>
                  </tr>
                </table>
              </center>
              <!--[if gte mso 9]>
              </v:textbox>
            </v:rect>
            <![endif]-->
            </td>
          </tr>
        </table>
      </center>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
      <center>
        <table cellspacing="0" cellpadding="0" width="600" class="w320">
          <tr>
            <td class="header-lg">
              '.$company_name.'
            </td></br>
          </tr>
          <tr>
            <td class="free-text">
              '.$mobile_no.'<br />'.$company_mail.'
            </td>
          </tr>
          <tr>
            <td class="free-text">
              '.$gst_in.'<br />
            </td>
          </tr>
          <tr>
            <td class="w320">
              <table cellpadding="0" cellspacing="0" width="100%">
                <tr>';
					if($party != '' && $row_inv_setting == 1)
					{
					  $invoice_mail .='<td class="mini-container-left">
						<table cellpadding="0" cellspacing="0" width="100%">
						  <tr>
							<td class="mini-block-padding">
							  <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
								<tr>
								  <td class="mini-block">
									<span class="header-sm">'.$party.'</span><br />
									'.$address.'<br />
									'.$party_gst_in.'<br />
									'.$party_mobile.'<br />
									Bill No.'.$invoice_no.'
								  </td>
								</tr>
							  </table>
							</td>
						  </tr>
						</table>
					  </td>';
					}
					$invoice_mail .='
                  <td class="mini-container-right">
                    <table cellpadding="0" cellspacing="0" width="100%">
                      <tr>
                        <td class="mini-block-padding">
                          <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
                            <tr>
                              <td class="mini-block">
                                <span class="header-sm">Date Of Invoice</span><br />
                                '.$date.'<br />
                                <br />
                                <span class="header-sm">Invoice No</span> <br />
                                '.$invoice_no.'
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </center>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top" width="100%" style="background-color: #ffffff;  border-top: 1px solid #e5e5e5; border-bottom: 1px solid #e5e5e5;">
      <center>
        <table cellpadding="0" cellspacing="0" width="600" class="w320">
            <tr>
              <td class="item-table">
                <table cellspacing="0" cellpadding="0" width="100%">
                  <tr>
                    <td class="title-dark" width="300">
                       Description
                    </td>
                    <td class="title-dark" width="163">
                      Price
                    </td>
                    <td class="title-dark" width="97">
                      Qty
                    </td>
					<td class="title-dark" width="97">
                      Gst
                    </td>
					<td class="title-dark" width="97">
                      Discount
                    </td>
					<td class="title-dark" width="97">
                      Amount
                    </td>
                  </tr>
				  
				  '.$detail_email.'

                  <tr>
                    <td class="item-col item mobile-row-padding"></td>
                    <td class="item-col quantity"></td>
                    <td class="item-col price"></td>
                  </tr>


                  <tr>
					<td style="text-align:left">
						<img src="https://chart.googleapis.com/chart?chs=150x150&amp;cht=qr&amp;chl='.$qr_path.'&amp;choe=UTF-8" alt="QR code">
					</td>
					<td></td>
					<td></td>
					<td></td>
                    <td class="item-col quantity" style="text-align:right; padding-right: 10px; border-top: 1px solid #cccccc;">
                      <span class="total-space">Subtotal</span> <br />
                      <span class="total-space">Shipping</span> <br />
                      <span class="total-space">Total</span> <br />
					  <span class="total-space" style="font-weight: bold; color: #4d4d4d">Pay</span>
					  
                    </td>
                    <td class="item-col price" style="text-align: right; border-top: 1px solid #cccccc;">
                      <span class="total-space">'.$sub_total.'</span>  <br />
                      <span class="total-space">'.$shipping.'</span>  <br />
					  <span class="total-space">'.$total.'</span>  <br />
                      <span class="total-space" style="font-weight:bold; color: #4d4d4d">'.$pay.'</span>
                    </td>
                  </tr>  
                </table>
              </td>
            </tr>
        </table>
      </center>
    </td>
  </tr>
	<tr>
		<td  valign="top" width="100%" style="background-color: #f7f7f7; height: 100px; align:center;">
			<h2 style="text-align:center;">Terms & Conditions</h2>
			'.$terms.'
		</td>
	</tr>					
</table>
</div>
</body>
</html>';
	

	if(isset($_GET['income_id']))
	{
		$to = $row_login_select['email'];
		$subject = "Income Invoice";
		
		$message = $invoice_mail;
		$header  = "MIME-Version: 1.0\r\n";
		$header .= "Content-type: text/html; charset: iso-8859-1"."\r\n";
		$header .= "From:billdesk675@gmail.com";
		
		if(mail($to,$subject,$message,$header))
		{
			echo '<script>window.location="invoice.php?income_id="'.$_GET['income_id'].';</script>';
		}
		else
		{
			die('Mail Not Sent'.mysqli_error($con));
		}
	}	
	else if(isset($_GET['expence_id']))
	{
		$to = $row_login_select['email'];
		$subject = "Expense Invoice";
		
		$message = $invoice_mail;
		$header  = "MIME-Version: 1.0\r\n";
		$header .= "Content-type: text/html; charset: iso-8859-1"."\r\n";
		$header .= "From:billdesk675@gmail.com";
		
		if(mail($to,$subject,$message,$header))
		{
			echo '<script>window.location="invoice.php?expence_id="'.$_GET['expence_id'].';</script>';
		}
		else
		{
			die('Mail Not Sent'.mysqli_error($con));
		}
	}
	else if(isset($_GET['payment_in_id']))
	{
		$to = $party_email .','. $row_login_select['email'];
		$subject = "Payment In Invoice";
		
		$message = $invoice_mail;
		
		$header  = "MIME-Version: 1.0\r\n";
		$header .= "Content-type: text/html; charset: iso-8859-1"."\r\n";
		$header .= "From:billdesk675@gmail.com";
		
		if(mail($to,$subject,$message,$header))
		{
			echo '<script>window.location="invoice.php?payment_in_id="'.$_GET['payment_in_id'].';</script>';
		}
		else
		{
			die('Mail Not Sent'.mysqli_error($con));
		}
	}
	else if(isset($_GET['payment_out_id']))
	{
		$to = $party_email .','. $row_login_select['email'];
		$subject = "Payment Out Invoice";
		
		$message = $invoice_mail;
		
		$header  = "MIME-Version: 1.0\r\n";
		$header .= "Content-type: text/html; charset: iso-8859-1"."\r\n";
		$header .= "From:billdesk675@gmail.com";
		
		if(mail($to,$subject,$message,$header))
		{
			echo '<script>window.location="invoice.php?payment_out_id="'.$_GET['payment_out_id'].';</script>';
		}
		else
		{
			die('Mail Not Sent'.mysqli_error($con));
		}
	}
	else if(isset($_GET['purchase_id']))
	{
		$to = $party_email .','. $row_login_select['email'];
		$subject = "Purchase Invoice";
		
		$message = $invoice_mail;
		
		$header  = "MIME-Version: 1.0\r\n";
		$header .= "Content-type: text/html; charset: iso-8859-1"."\r\n";
		$header .= "From:billdesk675@gmail.com";
		
		if(mail($to,$subject,$message,$header))
		{
			echo '<script>window.location="invoice.php?purchase_id="'.$_GET['purchase_id'].';</script>';
		}
		else
		{
			die('Mail Not Sent'.mysqli_error($con));
		}
	}
	else if(isset($_GET['purchase_return_id']))
	{
		$to = $party_email .','. $row_login_select['email'];
		$subject = "Purchase Return Invoice";
		
		$message = $invoice_mail;
		
		$header  = "MIME-Version: 1.0\r\n";
		$header .= "Content-type: text/html; charset: iso-8859-1"."\r\n";
		$header .= "From:billdesk675@gmail.com";
		
		if(mail($to,$subject,$message,$header))
		{
			echo '<script>window.location="invoice.php?purchase_return_id="'.$_GET['purchase_return_id'].';</script>';
		}
		else
		{
			die('Mail Not Sent'.mysqli_error($con));
		}
	}
	else if(isset($_GET['sales_id']))
	{
		$to = $party_email .','. $row_login_select['email'];
		$subject = "Sales Invoice";
		
		$message = $invoice_mail ;
		
		$header  = "MIME-Version: 1.0\r\n";
		$header .= "Content-type: text/html; charset: iso-8859-1"."\r\n";
		$header .= "From:billdesk675@gmail.com";
		
		if(mail($to,$subject,$message,$header))
		{
			echo '<script>window.location="invoice.php?sales_id="'.$_GET['sales_id'].';</script>';
		}
		else
		{
			die('Mail Not Sent'.mysqli_error($con));
		}
	}
	else if(isset($_GET['sales_return_id']))
	{
		$to = $party_email .','. $row_login_select['email'];
		$subject = "Sales Return Invoice";
		
		$message = $invoice_mail;
		
		$header  = "MIME-Version: 1.0\r\n";
		$header .= "Content-type: text/html; charset: iso-8859-1"."\r\n";
		$header .= "From:billdesk675@gmail.com";
		
		if(mail($to,$subject,$message,$header))
		{
			echo '<script>window.location="invoice.php?sales_return_id="'.$_GET['sales_return_id'].';</script>';
		}
		else
		{
			die('Mail Not Sent'.mysqli_error($con));
		}
	}
	else if(isset($_GET['cashmemo_id']))
	{
		$to = $row_login_select['email'];
		$subject = "Cashmemo Invoice";
		
		$message = $invoice_mail;
		
		$header  = "MIME-Version: 1.0\r\n";
		$header .= "Content-type: text/html; charset: iso-8859-1"."\r\n";
		$header .= "From:billdesk675@gmail.com";
		
		if(mail($to,$subject,$message,$header))
		{
			echo '<script>window.location="invoice.php?cashmemo_id="'.$_GET['cashmemo_id'].';</script>';
		}
		else
		{
			die('Mail Not Sent'.mysqli_error($con));
		}
	}
	else if(isset($_GET['cashmemo_return_id']))
	{
		$to = $row_login_select['email'];
		$subject = "Cashmemo Return Invoice";
		
		$message = $invoice_mail;
		
		$header  = "MIME-Version: 1.0\r\n";
		$header .= "Content-type: text/html; charset: iso-8859-1"."\r\n";
		$header .= "From:billdesk675@gmail.com";
		
		if(mail($to,$subject,$message,$header))
		{
			echo '<script>window.location="invoice.php?cashmemo_return_id="'.$_GET['cashmemo_return_id'].';</script>';
		}
		else
		{
			die('Mail Not Sent'.mysqli_error($con));
		}
	}
	include_once('footer.php');
	
?>	

<script src="eliteadmin-ecommerce/js/jquery.PrintArea.js" type="text/JavaScript"></script>

<script>
	$(document).ready(function() {
		docapture();

		$("#print").click(function() {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
            $("div.printableArea").printArea(options);
        });
    });
</script>