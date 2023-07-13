<?php
	$title = "BILL DESK-Purchase Invoice";
	include_once('header.php');
	global $con;
	$inv_id = '';
	$detail_row_num = 0;
	$purchase_id = 0;
	
	$sql_product_setting = "select * from tbl_product_setting";
	$rs_product_setting = mysqli_query($con,$sql_product_setting);
	$row_product_setting = mysqli_fetch_array($rs_product_setting);

   class general_setting
   {
	   // Properties
	   private $is_show_serial;
	   private $is_show_barcode;
	   private $purchase;
	   private $sales;
	   private $sales_return;
	   private $purchase_return;
	   private $cashmemo;
	   private $cashmemo_return;
	   private $is_show_low_stock;
	   private $is_show_batch;
	   private $is_gst_bill;

	   // Methods
	   function set_name($a , $index)
	   {
		   $this->$index = $a;
	   }

	   function get_name($index)
	   {
		   return $this->$index;
	   }
   }

$setting= new general_setting();
foreach ($row_product_setting as $key => $value)
{
   $setting->set_name( $value , $key );
}

	//fetch data for update
	if(isset($_GET['id']))
	{
		//fetch data for invoice
		$purchase_id=base64_decode($_GET['id']);
		$sql_purchase_select="SELECT * FROM tbl_purchase_invoice WHERE purchase_invoice_id ='".$purchase_id."'";
		$rs_purchase_select=mysqli_query($con,$sql_purchase_select);
		$row_purchase_select=mysqli_fetch_array($rs_purchase_select);
		
		//fetch data for invoice detail
		$sql_purchase_detail_select = "select * from tbl_purchase_invoice_detail where purchase_invoice_id = '".$purchase_id."'";
		$rs_purchase_detail_select = mysqli_query($con , $sql_purchase_detail_select);
		$detail_row_num = mysqli_num_rows($rs_purchase_detail_select);
	}
	
	//company id sql
	$company_id="SELECT * FROM tbl_company WHERE is_default=1";
	$rs_company_id=mysqli_query($con,$company_id);
	$row_company_id=mysqli_fetch_array($rs_company_id);
	
	//current financial year
	$sql_financial_id="SELECT * FROM tbl_financial_master WHERE is_default=1";
	$rs_financial_id=mysqli_query($con,$sql_financial_id);
	$row_financial_id=mysqli_fetch_array($rs_financial_id);
	
	//invoice_no sql
	$sql_invoice = "select max(pr.invoice_no) 'invoice_no' from tbl_purchase_invoice pr join tbl_financial_master fy on fy.financial_id = pr.financial_id where fy.is_default = 1";
	$rs_invoice = mysqli_query($con , $sql_invoice);
	$row_invoice = mysqli_fetch_array($rs_invoice);
	$invoice_no = $row_invoice['invoice_no'];
	if($invoice_no != '')
		$invoice_no = $invoice_no + 1;
	else
		$invoice_no = 1;
	
	
	function fnc_state($name)
	{
		global $row_purchase_select;
		
		if(isset($_GET['id']))
		{
			if($row_purchase_select['state_of_supply'] == $name)
			{echo "selected";}
		}
	}

	$new_inv_no = $setting->get_name('sales_return') . $row_financial_id['financial_year'];
//``````````````````````````````````````````````````````INSERT```````````````````````````````````````````````````````````````````
	if(isset($_POST['btn_save']) || isset($_POST['btn_save_n_print']) )
	{
        if(isset($_POST['chk_is_round_off']))
            $chk_round_off =1;
        else
            $chk_round_off=0;

		//INSERT CODE_
		$sql_purchase_invoice_iu = "CALL insertPurchase_invoice('".$row_company_id['company_id']."' ,'".$_POST['cmb_party']."' ,'".$_POST['txt_ref_order_no']."' ,'".$_POST['txt_invoice_no']."' , '".$_POST['is_out_off_state']."' ,'".$_POST['cmb_state_of_supply']."' ,'".$_POST['txt_invoice_date']."' ,'".$_POST['cmb_payment_type']."' ,'".$_POST['txt_narration']."' ,'".$_POST['txt_sub_total']."' ,'".$_POST['txt_shipping_amt']."' ,$chk_round_off ,'".$_POST['txt_round_off']."' ,'".$_POST['txt_total_inv']."' ,'".$_POST['txt_pay']."' ,'".$row_financial_id['financial_id']."', '".$new_inv_no."' ,'".$row_product_setting['is_gst_bill']."') ";
		//echo $sql_purchase_invoice_iu;
		$rs_purchase_invoice_iu = mysqli_query($con , $sql_purchase_invoice_iu);
		
		if(! $rs_purchase_invoice_iu )
			die("data not inserted".mysqli_error($con));
		
		$sql_inv_id = "select max(purchase_invoice_id) 'inv' from tbl_purchase_invoice";
		//echo $sql_inv_id;
		$rs_inv_id = mysqli_query($con , $sql_inv_id);
		$inv = mysqli_fetch_array($rs_inv_id);
		
		$inv_id = $inv['inv'];
		
		//payment out 
		$objname = "purchase";
		
		$image="";
		$sql_payment_out = "insert into tbl_payment_out(company_id,financial_id,party_id,receipt_no,payment_type_id,cheque_ref_no,date,description,image,paid,obj_name,obj_id) values('".$row_company_id['company_id']."','".$row_financial_id['financial_id']."','".$_POST['cmb_party']."','".$_POST['txt_invoice_no']."','".$_POST['cmb_payment_type']."','".$_POST['txt_cheque_ref']."','".$_POST['txt_invoice_date']."','".$_POST['txt_narration']."','".$image."','".$_POST['txt_pay']."','".$objname."','".$inv_id."')";
		$rs_payment_out = mysqli_query($con,$sql_payment_out);
		
		//company_ledger
    
		$credit=0.00;
		
		$sql_company_ledger="insert into tbl_company_ledger(company_id , related_id , related_obj_name,party_id ,date, details, credit, debit, financial_id, new_invoice_no) values('".$row_company_id['company_id']."' , '".$inv_id."' ,'".$objname."','".$_POST['cmb_party']."' , '".$_POST['txt_invoice_date']."' , '".$_POST['txt_narration']."' , '".$credit."','".$_POST['txt_pay']."','".$row_financial_id['financial_id']."','".$new_inv_no."')";
		//echo $sql_company_ledger;
		$rs_company_ledger = mysqli_query($con,$sql_company_ledger);
		
		//party_ledger
		$party_typ = "0";
		$inv_typ = "purchase"; 
		$debit = 0.00;
		
		$sql_party_ledger = "insert into tbl_party_ledger (company_id , party_type , party_id , invoice_type , invoice_no , detail , credit , debit , date , financial_id , new_invoice_no) VALUES('".$row_company_id['company_id']."' , '".$party_typ."' , '".$_POST['cmb_party']."' , '".$inv_typ."', '".$inv_id."' , '".$_POST['txt_narration']."' ,'".$_POST['txt_total_inv']."' , '".$_POST['txt_pay']."' , '".$_POST['txt_invoice_date']."' ,'".$row_financial_id['financial_id']."','".$new_inv_no."' ) ";
		//echo $sql_party_ledger;
		$rs_party_ledger = mysqli_query($con , $sql_party_ledger);
		
		//fetch party balance
		$sql_fetch_bal = "select opening_balance from tbl_party_master where party_id = '".$_POST['cmb_party']."' ";
		$rs_fetch_bal = mysqli_query($con,$sql_fetch_bal);
		$row_fetch_party_bal=mysqli_fetch_array($rs_fetch_bal);
		
		$sql_party_bal = "update tbl_party_master set opening_balance = '".$row_fetch_party_bal['opening_balance']."' + '".$_POST['txt_pay']."' where party_id = '".$_POST['cmb_party']."' ";
		//echo $sql_party_bal;
		$rs_party_bal = mysqli_query($con,$sql_party_bal);
		
		//total no of product find
		if(isset($_POST["txt_rate"][1]))
			$number = count($_POST["txt_rate"]);
		else
			$number = 1;
		
		//echo $number;
		//inserting into detail tbl
		if($number > 0)  
		{  
		  for($i=0; $i<$number; $i++)  
			{  
			   if(trim($_POST["txt_rate"][$i] != ''))		   
				{  
					$sql_gst = "select igst from tbl_gstslab_master where gstslab_id = '". $_POST["txt_gst"][$i]."'";
					//echo $sql_gst;
					$rs_gst = mysqli_query($con ,$sql_gst);
					$row_gst=mysqli_fetch_array($rs_gst);
					
					$igst_per = $row_gst['igst'];
					$gst_per = $igst_per/2;
					$igst = (( $_POST["txt_rate"][$i] *  $_POST["txt_quantity"][$i]) -  intval($_POST["txt_discount_amt"][$i]) ) * ($igst_per/100);
					$gst = (( $_POST["txt_rate"][$i] *  $_POST["txt_quantity"][$i]) -  intval($_POST["txt_discount_amt"][$i]) ) * ($gst_per/100);
					
					if($_POST['is_out_off_state'] == 1){
						$gst_per = 0.00;
						$gst = 0.00;
					}
					else{
						$igst_per = 0.00;
						$igst = 0.00;
					}
					
					$sql_unit_select = "select * from tbl_unit where unit_id = '". $_POST["product_unit"][$i]."'";
					//echo $sql_unit_select;
					$rs_unit_select = mysqli_query($con , $sql_unit_select);
					$row_unit_select = mysqli_fetch_array($rs_unit_select);


					$sr = '';
					//serial_no is available or not. checking
					if($_POST['txt_serial_no'][$i] != '')
					{
						$temp =  explode( '|', $_POST['txt_serial_no'][$i] );
						for($k=0;$k<count($temp);$k++) {
							if ($temp[$k] != '') {
								$sql_serial_ins = "insert into tbl_serial_no (company_id,product_id,serial_no) values ('" . $row_company_id['company_id'] . "' ,'" . $_POST["txt_product"][$i] . "','" . $temp[$k] . "')";
								mysqli_query($con, $sql_serial_ins);
								$last_id = mysqli_insert_id($con);
								$sr .= '|';
								$sr .= $last_id;
							}
						}
					}
					$br='';
					//batch no. is available or not. checking
					if($_POST['txt_batch_no'][$i] != '')
					{
						$temp =  explode( '|', $_POST['txt_batch_no'][$i] );

						$sql_batch_ins = "insert into tbl_batch_tracking (company_id,product_id,mrp_price , batch_no , exp_date , mfg_date , model_no , size , quantity) values ('" . $row_company_id['company_id'] . "' ,'" .  $_POST["txt_product"][$i] . "','" . $temp[7] . "' ,'" . $temp[1] . "' ,'" . $temp[3] . "' ,'" . $temp[2] . "' ,'" . $temp[4] . "' ,'" . $temp[5] . "' ,'" . $temp[6] . "')";
						mysqli_query($con, $sql_batch_ins);
						$br = mysqli_insert_id($con);
					}

					$sql_invoice_detail = "INSERT INTO tbl_purchase_invoice_detail(company_id , purchase_invoice_id,product_id,unit_id,unit,rate,qty,gross_total,disc_per,disc_amt,sub_total,gstslab_id,gst,gst_per,igst,igst_per,total,financial_id,new_invoice_no,serial_no,batch_no) VALUES('".$row_company_id['company_id']."' ,'".$inv_id."','". $_POST["txt_product"][$i]."', '". $_POST["product_unit"][$i]."' , '".$row_unit_select['unit_name']."' , '". $_POST["txt_rate"][$i]."','". $_POST["txt_quantity"][$i]."','". $_POST["txt_rate"][$i]."' * '". $_POST["txt_quantity"][$i]."','". $_POST["txt_discount"][$i]."','". $_POST["txt_discount_amt"][$i]."',('". $_POST["txt_rate"][$i]."' * '". $_POST["txt_quantity"][$i]."') - '". $_POST["txt_discount_amt"][$i]."','". $_POST["txt_gst"][$i]."' , '".$gst."' , '".$gst_per."' , '".$igst."' , '".$igst_per."' , '". $_POST["txt_total"][$i]."' , '".$row_financial_id['financial_id']."' , '".$new_inv_no."','".$sr."','".$br."')";
					//echo $sql_invoice_detail;
					mysqli_query($con, $sql_invoice_detail);

					
					$sql_current_unit = "select * from tbl_unit_conversion where product_id = '". $_POST["txt_product"][$i]."' and secondary_unit_id = '". $_POST["product_unit"][$i]."' and is_default = 1";
					//echo $sql_current_unit;
					$rs_current_unit = mysqli_query($con , $sql_current_unit);
					$num_current_unit = mysqli_num_rows($rs_current_unit);
					
					//just so when it doesn't go into if...I don't have to repeat the query....abb bc has bhi nhi sakta kya?
					$qty_for_stock =  $_POST["txt_quantity"][$i];
					
					if($num_current_unit > 0 )
					{
						$row_current_unit = mysqli_fetch_array($rs_current_unit);
						$qty_for_stock=  $_POST["txt_quantity"][$i] / $row_current_unit['rate'];
					}

					$sql_stock_purchase = "update tbl_product_master set closing_stock = (select closing_stock from tbl_product_master where product_id ='". $_POST["txt_product"][$i]."' ) + '".$qty_for_stock."' where product_id = '". $_POST["txt_product"][$i]."' ";
					//echo $sql_stock_purchase;
					$rs_stock_purchase = mysqli_query($con,$sql_stock_purchase);
					
				}  
			}
			if(!$rs_purchase_invoice_iu)
			{
			  die("data not inserted".mysqli_error($con));
			}
			else
			{
				if(isset($_POST['btn_save_n_print']))
					echo "<script>window.location.href='invoice.php?purchase_id=$inv_id';</script>";
				else
					echo "<script>window.location.href='purchase.php';</script>";

			}
		}
	}
//``````````````````````````````````````````````````````UPDATE```````````````````````````````````````````````````````````````````
	if(isset($_POST['btn_edit'])  || isset($_POST['btn_update_n_print']))
	{
        if(isset($_POST['chk_is_round_off']))
            $chk_round_off =1;
        else
            $chk_round_off=0;


        $objname = "purchase";
		$img3 = '';
		$sql_purchase_invoice_iu = "UPDATE tbl_purchase_invoice SET party_id = '".$_POST['cmb_party']."', ref_order_id ='".$_POST['txt_ref_order_no']."', state_of_supply ='".$_POST['cmb_state_of_supply']."' , purchase_invoice_date = '".$_POST['txt_invoice_date']."' , payment_type_id = '".$_POST['cmb_payment_type']."', narration= '".$_POST['txt_narration']."', sub_total = '".$_POST['txt_sub_total']."', shipping_packing_ammount= '".$_POST['txt_shipping_amt']."' , is_round_off = '".$chk_round_off."', round_off = '".$_POST['txt_round_off']."' , total = '".$_POST['txt_total_inv']."', pay = '".$_POST['txt_pay']."' , new_invoice_no ='".$new_inv_no."' ,is_gst_bill = '".$row_product_setting['is_gst_bill']."' WHERE purchase_invoice_id = '".$_POST['purchase_invoice_id']."'";
		$rs_purchase_invoice_iu = mysqli_query($con , $sql_purchase_invoice_iu);
		
		$sql_payment_out_update = "update tbl_payment_out set company_id ='".$row_company_id['company_id']."',financial_id='".$row_financial_id['financial_id']."',party_id='".$_POST['cmb_party']."',payment_type_id='".$_POST['cmb_payment_type']."',cheque_ref_no='".$_POST['txt_cheque_ref']."',date='".$_POST['txt_invoice_date']."',description='".$_POST['txt_narration']."',image='".$img3."',received='".$_POST['txt_pay']."',obj_name='".$objname."',obj_id = '".$_POST['purchase_invoice_id']."' where party_id ='".$_POST['cmb_party']."' and obj_name = '".$objname."' and obj_id = '".$_POST['purchase_invoice_id']."'";
		$rs_payment_out_update = mysqli_query($con,$sql_payment_out_update);
		
		//company_ledger
	  
		  
		  $credit=0.00;
		  
		  $sql_company_ledger="update tbl_company_ledger set company_id = '".$row_company_id['company_id']."',related_id = '".$_POST['purchase_invoice_id']."',related_obj_name='".$objname."',party_id = '".$_POST['cmb_party']."',date = '".$_POST['txt_invoice_date']."' ,details = '".$_POST['txt_narration']."' , credit = '".$credit."' , debit = '".$_POST['txt_pay']."' ,financial_id = '".$row_financial_id['financial_id']."' where related_id = '".$_POST['purchase_invoice_id']."' and related_obj_name = '".$objname."' ";
		  $rs_company_ledger = mysqli_query($con,$sql_company_ledger);
		  
		  //party_ledger
	  
		  $party_typ = 0;
		  $inv_typ = "purchase"; 
		  
		  $sql_party_ledger = "update tbl_party_ledger set company_id='".$row_company_id['company_id']."',party_type='".$party_typ."',party_id='".$_POST['cmb_party']."',invoice_type='".$inv_typ."',invoice_no='".$_POST['purchase_invoice_id']."',detail='".$_POST['txt_narration']."',credit='".$_POST['txt_total_inv']."',debit='".$_POST['txt_pay']."',date='".$_POST['txt_invoice_date']."',financial_id='".$row_financial_id['financial_id']."',new_invoice_no='".$new_inv_no."' where invoice_no='".$_POST['purchase_invoice_id']."' ";
		  $rs_party_ledger = mysqli_query($con , $sql_party_ledger);
		  
		  //fetch party balance
		  $sql_fetch_bal = "select opening_balance from tbl_party_master where party_id = '".$_POST['cmb_party']."' ";
		  $rs_fetch_bal = mysqli_query($con,$sql_fetch_bal);
		  $row_fetch_party_bal=mysqli_fetch_array($rs_fetch_bal);
		  
		  //fetch party old  balance
		  $sql_fetch_bal_old = "select pay from tbl_purchase_invoice where purchase_invoice_id = '".$_POST['purchase_invoice_id']."' ";
		  $rs_fetch_bal_old = mysqli_query($con,$sql_fetch_bal_old);
		  $row_fetch_party_bal_old=mysqli_fetch_array($rs_fetch_bal_old);
		  
		  $sql_party_bal = "update tbl_party_master set opening_balance = '".$row_fetch_party_bal['opening_balance']."' - '".$row_fetch_party_bal_old['pay']."' + '".$_POST['txt_pay']."' where party_id = '".$_POST['cmb_party']."' ";
		  $rs_party_bal = mysqli_query($con,$sql_party_bal);

		if(isset($_POST["txt_rate"][1]))
			$number = count($_POST["txt_rate"]);
		else
			$number = 1;

		$curr = 0;

		if($number > 0)  
		{  
		  for($i=0; $i<$number; $i++)  
		  {
				$sql_unit_select = "select * from tbl_unit where unit_id = '". $_POST["product_unit"][$i]."'";
				$rs_unit_select = mysqli_query($con , $sql_unit_select);
				$row_unit_select = mysqli_fetch_array($rs_unit_select);
				
				$sql_gst = "select igst from tbl_gstslab_master where gstslab_id = '". $_POST["txt_gst"][$i]."'";
				$rs_gst = mysqli_query($con ,$sql_gst);
				$row_gst=mysqli_fetch_array($rs_gst);
				
				$igst_per = $row_gst['igst'];
				$gst_per = $igst_per/2;
				$igst = (( $_POST["txt_rate"][$i] *  $_POST["txt_quantity"][$i]) -  $_POST["txt_discount_amt"][$i] ) * ($igst_per/100);
				$gst = (( $_POST["txt_rate"][$i] *  $_POST["txt_quantity"][$i]) -  $_POST["txt_discount_amt"][$i] ) * ($gst_per/100);
				
				if($_POST['is_out_off_state'] == 1){
					$gst_per = 0.00;
					$gst = 0.00;
				}
				else{
					$igst_per = 0.00;
					$igst = 0.00;
				}
				
			$sql_current_unit = "select * from tbl_unit_conversion where product_id = '". $_POST["txt_product"][$i]."' and secondary_unit_id = '". $_POST["product_unit"][$i]."' and is_default = 1";
			$rs_current_unit = mysqli_query($con , $sql_current_unit);
			$num_current_unit = mysqli_num_rows($rs_current_unit);
			
			//just so when it doesn't go into if...i don't have to repeat the query....hehe
			$qty_for_stock =  $_POST["txt_quantity"][$i];
			
			if($num_current_unit > 0 )
			{
				$row_current_unit = mysqli_fetch_array($rs_current_unit);
				$qty_for_stock=  $_POST["txt_quantity"][$i] / $row_current_unit['rate'];
			}
			
		   if(trim($_POST["purchase_invoice_detail_id"][$i] == ''))		   
			{
				//serial_no is available or not. checking
				$sr = '';
				if($_POST['txt_serial_no'][$i] != '')
				{
					$temp =  explode( '|', $_POST['txt_serial_no'][$i] );

					for($k=0;$k<count($temp);$k++) {
						if ($temp[$k] != '') {
							$sql_serial_ins = "insert into tbl_serial_no (company_id,product_id,serial_no) values ('" . $row_company_id['company_id'] . "' ,'" .  $_POST["txt_product"][$i] . "','" . $temp[$k] . "')";
							mysqli_query($con, $sql_serial_ins);
							$last_id = mysqli_insert_id($con);
							$sr .= '|';
							$sr .= $last_id;
						}
					}
				}
				//batch no. is available or not. checking
				$br='';
				if($_POST['txt_batch_no'][$i] != '')
				{
					$temp =  explode( '|', $_POST['txt_batch_no'][$i] );
					$sql_batch_ins = "insert into tbl_batch_tracking (company_id,product_id,mrp_price , batch_no , exp_date , mfg_date , model_no , size , quantity) values ('" . $row_company_id['company_id'] . "' ,'" .  $_POST["txt_product"][$i] . "','" . $temp[7] . "' ,'" . $temp[1] . "' ,'" . $temp[3] . "' ,'" . $temp[2] . "' ,'" . $temp[4] . "' ,'" . $temp[5] . "' ,'" . $temp[6] . "')";
					mysqli_query($con, $sql_batch_ins);
					$br = mysqli_insert_id($con);
				}
				//insert into detail table
				$sql_invoice_detail = "INSERT INTO tbl_purchase_invoice_detail(company_id , purchase_invoice_id,product_id,unit_id,unit,rate,qty,gross_total,disc_per,disc_amt,sub_total,gstslab_id,gst,gst_per,igst,igst_per,total,financial_id,new_invoice_no,serial_no,batch_no) VALUES('".$row_company_id['company_id']."' ,'".$_POST['purchase_invoice_id']."','". $_POST["txt_product"][$curr]."', '". $_POST["product_unit"][$i]."' , '".$row_unit_select['unit_name']."' , '". $_POST["txt_rate"][$i]."','". $_POST["txt_quantity"][$i]."','". $_POST["txt_rate"][$i]."' * '". $_POST["txt_quantity"][$i]."','". $_POST["txt_discount"][$i]."','". $_POST["txt_discount_amt"][$i]."',('". $_POST["txt_rate"][$i]."' * '". $_POST["txt_quantity"][$i]."') - '". $_POST["txt_discount_amt"][$i]."','". $_POST["txt_gst"][$i]."' , '".$gst."' , '".$gst_per."' , '".$igst."' , '".$igst_per."' , '". $_POST["txt_total"][$i]."' + '".$gst."' + '".$igst."' , '".$row_financial_id['financial_id']."' , '".$new_inv_no."' , '".$sr."' , '".$br."')";
				//echo $sql_invoice_detail;
				$curr ++;
				mysqli_query($con, $sql_invoice_detail);  
				
				$sql_stock_purchase = "update tbl_product_master set closing_stock = (select closing_stock from tbl_product_master where product_id ='". $_POST["txt_product"][$i]."' ) + '".$qty_for_stock."' where product_id = '". $_POST["txt_product"][$i]."' ";
				
				//echo $sql_stock_purchase;
				//echo "<br>";
				$rs_stock_purchase = mysqli_query($con,$sql_stock_purchase);
				
			}
			else
			{
				//serial_no is available or not. checking
				$sr = '';
				if($_POST['txt_serial_no'][$i] != '')
				{

					$temp =  explode( '|', $_POST['txt_serial_no'][$i] );
					$temp_id = explode('|',$_POST['txt_serial_no_id'][$i]);

					for($k=0;$k<count($temp);$k++) {
						if ($temp[$k] != '' && $temp_id[$k] == 0) {
							$sql_serial_ins = "insert into tbl_serial_no (company_id,product_id,serial_no) values ('" . $row_company_id['company_id'] . "' ,'" .  $_POST["txt_product"][$i] . "','" . $temp[$k] . "')";
							mysqli_query($con, $sql_serial_ins);
							$last_id = mysqli_insert_id($con);
							$sr .= '|';
							$sr .= $last_id;
						}
					}
				}

				//update detail table
				$sql_invoice_detail = "UPDATE tbl_purchase_invoice_detail SET unit_id = '". $_POST["product_unit"][$i]."' , unit = '".$row_unit_select['unit_name']."' , rate = '". $_POST["txt_rate"][$i]."' , qty= '". $_POST["txt_quantity"][$i]."' , gross_total = '". $_POST["txt_rate"][$i]."' * '". $_POST["txt_quantity"][$i]."' , disc_per = '".$_POST["txt_discount"][$i]."' ,  disc_amt = '". $_POST["txt_discount_amt"][$i]."' , sub_total = ('". $_POST["txt_rate"][$i]."' * '". $_POST["txt_quantity"][$i]."') - '". $_POST["txt_discount_amt"][$i]."' , gstslab_id = '". $_POST["txt_gst"][$i]."' , gst = '".$gst."' , gst_per = '".$gst_per."' , igst = '".$igst."' , igst_per = '".$igst_per."' , total = '". $_POST["txt_total"][$i]."' , new_invoice_no = '".$new_inv_no."' , serial_no = CONCAT(serial_no , '".$sr."') WHERE purchase_invoice_detail_id= '". $_POST["purchase_invoice_detail_id"][$i]."' ";
				//echo $sql_invoice_detail;
				
				//to fetch old unit for secondary unit ......really sucks
				$sql_stock_update = "select * from tbl_purchase_invoice_detail where purchase_invoice_detail_id = '". $_POST["purchase_invoice_detail_id"][$i]."'";
				$rs_stock_update = mysqli_query($con, $sql_stock_update);
				$row_stock_update = mysqli_fetch_array($rs_stock_update);
				
				//to fetch rate of depending on unit of previous listed qty
				$sql_update_unit_fetch = "select * from tbl_unit_conversion where product_id = '".$row_stock_update['product_id']."' and secondary_unit_id = '".$row_stock_update['unit_id']."' and is_default = 1";
				//echo $sql_update_unit_fetch;
				//echo "<br>";
				
				$rs_update_unit_fetch = mysqli_query($con, $sql_update_unit_fetch);
				$num_update_unit_fetch = mysqli_num_rows($rs_update_unit_fetch);
				$row_update_unit_fetch = mysqli_fetch_array($rs_update_unit_fetch);
				$qty_update_fetch = $row_stock_update['qty'];
				
				if($num_update_unit_fetch > 0 )
				{
					
					$qty_update_fetch = $row_stock_update['qty'] / $row_update_unit_fetch['rate'];
				}
				
				$sql_update_stock_for_old = "update tbl_product_master set closing_stock = (select closing_stock from tbl_product_master where product_id = '".$row_stock_update['product_id']."') - '".$qty_update_fetch."' + '".$qty_for_stock."'where product_id = '".$row_stock_update['product_id']."'";
				//echo $sql_update_stock_for_old;
				//echo "<br>";
				
				mysqli_query($con , $sql_update_stock_for_old);
				
				mysqli_query($con, $sql_invoice_detail); 
			}			
		  }
			
			if(!$rs_purchase_invoice_iu)
			{
			  die("data not Updated".mysqli_error($con));
			}
			else
			{
				if(isset($_POST['btn_update_n_print']))
					echo "<script>window.location.href='invoice.php?purchase_id=$purchase_id';</script>";
				else
					echo "<script>window.location.href='purchase.php';</script>";
			}
		}
	}
?>

<script>
    let no_of_detail_row = "<?php echo $detail_row_num; ?>";
    let serial_key;
    let batch_key;
    let swit = 0;

    function tot()
	{
		let prd_qty = document.getElementsByName("txt_quantity[]");
		let prd_disc = document.getElementsByName("txt_discount[]");
		let prd_rate = document.getElementsByName("txt_rate[]");
        let total_val = 0;
		let qty_val = 0;
		let rate_val = 0;
		let disc_amt = 0;
		let disc_ratio = 0;
		let sub_total = 0.00;
		
		
		for(let i=0; i<prd_qty.length ; i++)
		{	if(prd_rate[i].value == 0 || prd_qty[i].value == 0  || prd_rate[i].value == '' || prd_qty[i].value == '' )
			{
				return true;
			}

			total_val = prd_qty[i].valueAsNumber * prd_rate[i].valueAsNumber ;
			//console.log(total_val);
			if(prd_disc[i].value != '' ||  prd_disc[i].value != 0)
			{
				disc_ratio = prd_disc[i].valueAsNumber / 100 ;
				disc_amt = total_val * disc_ratio;
				document.getElementsByName("txt_discount_amt[]")[i].value = disc_amt.toFixed(2);
				total_val = total_val - disc_amt;
			}
			//console.log(total_val);
			if(document.getElementById('is_out_off_state').value == 1)
			{
				total_val = parseFloat(total_val) + (parseFloat(document.getElementsByName('txt_cgst[]')[i].value) * parseFloat(2) * parseFloat(total_val) / parseInt(100));
			}
			else
			{
				total_val= parseFloat(total_val) + (parseFloat(document.getElementsByName('txt_cgst[]')[i].value / 100) * total_val );
			}
			sub_total += total_val;
			//console.log(total_val);
			document.getElementsByName("txt_total[]")[i].valueAsNumber = total_val.toFixed(2) ;
		}
		document.getElementById("txt_sub_total").value = sub_total.toFixed(2);
		//console.log(sub_total);
		fnc_calculate_total();
	}
	
	function fnc_calculate_total()
	{
		let txt_round = document.getElementById("txt_round_off");
		let gtotal = document.getElementById("txt_gtotal");
		let total_inv = document.getElementById("txt_total_inv");
		let chk = document.getElementById("chk_is_round_off");
        let sub_total = document.getElementById("txt_sub_total").valueAsNumber ;
        let shipping_amt = document.getElementById("txt_shipping_amt").valueAsNumber;
        let round_total = 0;
        let r_off =0;
        let temp;
		
		temp  = sub_total + shipping_amt ;
		gtotal.value = temp.toFixed(2);
		round_total = Math.ceil(gtotal.value);
		r_off = round_total - gtotal.value;
		//console.log(round_total);
		
		if (chk.checked == 1)
		{
			txt_round.value = r_off.toFixed(2);
			total_inv.value = round_total.toFixed(2);		
		}
		else
		{
			total_inv.value =  gtotal.value;
			txt_round.value = "0.00";
		}
		//console.log(shipping_data);
		//console.log(rtotal);
		//console.log(total_inv);
		
	}
	
	function fnc_unit(e) 
	{
		//console.log(e.value);
        let prd_len = document.getElementsByName("txt_product[]").length;
        let prd_detail_id = document.getElementsByName("purchase_invoice_detail_id[]");
        let prd = document.getElementsByName("txt_product[]");
		let is_batc = <?php echo $setting->get_name('is_show_batch'); ?>;
        let is_seria = <?php echo $setting->get_name('is_show_serial'); ?>;

		//console.log(prd_len);
        let id = e.value;
		//console.log(id);
		
		if(id != '' )
		{
		//e.closest('#product_unit').remove();
		
		$.ajax({  
			url:"purchase_ajax.php",
			type:"POST",  
			data:{ 'id' : id , 'product_fetch' : 1 },
			dataType :'json',
			success:function(data)  
			{  
				//console.log("inside success");
				for(i=0;i<prd_len;i++)
				{
					//checking if both the 'e' and prd are same <select> or not
					if(prd[i] == e)
					{
                        let un = document.getElementsByName("product_unit[]")[i];
						document.getElementsByName('txt_serial_no[]')[i].value = '';
						un.options.length=0;
						
						//console.log(data);
						//checkin if both unit are absent
						document.getElementsByName('share_rate[]')[i].value = 0;
                        //document.getElementsByName('txt_quantity[]')[i].value = 1;
						if(data.primary_unit_id == '' && data.secondary_unit_id == '')
						{
							un.options.length=0;
						}
						else
						{
							un.options[un.options.length]= new Option(data.primary_unit, data.primary_unit_id);
							//checking secondary_unit for unit dropdown second value visible or not
							if(data.secondary_unit != '')
								un.options[un.options.length]= new Option(data.secondary_unit, data.secondary_unit_id);
								document.getElementsByName('share_rate[]')[i].value = data.rate;
						}

						//to disable link_batch when is_batch is 0 in db
						if(is_batc == 1)
						{
							if(data.is_batch == '')
							{
								//console.log("vatch clr 1");
								document.getElementsByName('link_batch[]')[i].style.pointerEvents="none";
								document.getElementsByName('link_batch[]')[i].removeAttribute('href');
								document.getElementsByName('txt_batch_no[]')[i].value = '';
							}
							else
							{
								//console.log("vatch clr 2");
								document.getElementsByName('link_batch[]')[i].removeAttribute('style');
								document.getElementsByName('link_batch[]')[i].setAttribute("href", "#");
								//document.getElementsByName('txt_batch_no[]')[i].value = '';
							}
						}
						//to disable link_serial when is_serial is 0 in db
						if(is_seria == 1)
						{
							if(data.is_serial == '')
							{
								//console.log("serial clr 1");
								document.getElementsByName('link_serial[]')[i].style.pointerEvents="none";
								document.getElementsByName('link_serial[]')[i].removeAttribute("href");
								document.getElementsByName('txt_serial_no[]')[i].value = '';
							}
							else
							{
								//console.log("serial clr 2");
								document.getElementsByName('link_serial[]')[i].removeAttribute('style');
								document.getElementsByName('link_serial[]')[i].setAttribute("href", "#");
								//document.getElementsByName('txt_serial_no[]')[i].value = '';
							}
						}

						// to prevent overwrite the rate of product while edit
						if(prd_detail_id[i].value == '')
						{
							if(document.getElementsByName('txt_batch_no[]')[i].value == '')
							{
								document.getElementsByName("txt_rate[]")[i].value = data.purchase_rate;
							}
							document.getElementsByName("txt_gst[]")[i].value = data.gstslab_id;
							document.getElementsByName("txt_cgst[]")[i].value = data.cgst;
							
						}
						//console.log(data.purchase_rate);
					}
				}
				//console.log(data);
				tot();
			} 
		});
	  }
	  else
	  {
		  e.closest('tr').remove();
		  $('#btn_add').click();
	  }
	
	}
	
	//set igst if out of state - vice-versa
	function fnc_state_change()
	{
        let e = document.getElementById("cmb_party");
        let temp = $('#cmb_state_of_supply').val();
        let state = "<?php echo $row_company_id['state']; ?>";
  
		//console.log(state);
    
		if( temp == state)
		{
			$('#is_out_off_state').val('0');
		}
		else
		{	
		  $('#is_out_off_state').val('1');
		  //document.getElementById('#is_out_off_state').val() = 1 ;
		} 
	}
	
	//to auto select state and igst/gst
	function fnc_party()
	{
        let e = document.getElementById("cmb_party");
        let state = "<?php echo $row_company_id['state']; ?>";
		//console.log("hello");
		//console.log(e.value);
		
		if(e.value != '')
		{
			$.ajax({ 
				url: 'purchase_ajax.php',
				data: {'id': e.value, 'party_search': 1},
				datatype: 'json',
				type: 'post',
				success: function(out)
					{
						const obj = JSON.parse(out);
						//alert(obj.state);
						$("#cmb_state_of_supply").val(obj.state);
						if(obj.state == state)
						{
						  $('#is_out_off_state').val('0');
						}
						else
						{	
						  $('#is_out_off_state').val('1');
						}
					}
				});
		}
		else
		{
			$("#cmb_state_of_supply").val('');
		}	
	}
  
  function fnc_add_party_select(elm)
	{
		if(elm.value == 'party')
		{
			if(confirm("Are you sure you want to add new party?"))  
				window.location = elm.value+".php";
			else
				document.getElementById('cmb_party').value = '';
		}
	}
	
	function fnc_unit_change(e)
	{
        let prd_len = document.getElementsByName("txt_product[]").length;
        let prd = document.getElementsByName("txt_product[]") ;
        let id = e.value;
		  
		$.ajax({  
			url:"purchase_ajax.php",
			type:"POST",  
			data:{ 'id' : id , 'edit_unit_fetch' : 1 },
			dataType :'json',
			success:function(data)  
			{  
				//console.log("inside success");
				for(let i=0;i<prd_len;i++)
				{
					if(prd[i].value == data.product_id)
					{	
						//console.log(data.unit);
						document.getElementsByName("product_unit[]")[i].value = data.unit_id ;
						//console.log(document.getElementsByName("product_unit[]")[i].selectedIndex);
						
					}
				}
				
			} 
		});
	}
	
	function fnc_gst_cal(e)
	{
		let is_gs = <?php echo $setting->get_name('is_gst_bill'); ?>;
        if(is_gs != 1)
            return;
        let key = '' ;
		for(let i=0;i<document.getElementsByName('txt_product[]').length;i++)
		{
			if(e == document.getElementsByName('txt_gst[]')[i])
			{
				key = i;
			}
		}
		if(e.value != '' && document.getElementsByName('txt_product[]')[key].value != '')
		{
			$.ajax({  
			url:"purchase_ajax.php",  
			type:"POST",  
			data:{ 'id' : e.value , 'prd_id' : document.getElementsByName('txt_product[]')[key].value ,'gst_val' :1 },
			datatype:'json',
			success:function(data)  
				{
					const obj = JSON.parse(data);
					document.getElementsByName('txt_cgst[]')[key].value = obj[0].cgst;
					tot();
				}
			});
		}
	}
    function fnc_serial_key(e)
    {
        for(let i=0;i<document.getElementsByName('txt_product[]').length;i++)
            if (e == document.getElementsByName('link_serial[]')[i]) {
                serial_key = i;
                break;
            }
        if(document.getElementsByName('txt_batch_no[]')[serial_key].value != '')
        {
            document.getElementsByName("link_serial[]")[serial_key].removeAttribute("href");
            document.getElementsByName("link_serial[]")[serial_key].removeAttribute("data-toggle");
        }
        else
        {
            document.getElementsByName('link_serial[]')[serial_key].setAttribute("data-toggle", "modal");
            document.getElementsByName('link_serial[]')[serial_key].setAttribute("href", "#");
        }


        $('#serial_body').empty();
        $('#serial_body').append('<tr><td><input type="text" id="serial_input" name = "serial_input" class = "form-control" placeholder="Enter Serial No" value = ""></td><td><button type="button" name="btn_add_serial" id="btn_add_serial" class="btn btn-success">Add More</button></td></tr>');



        if(document.getElementsByName('txt_serial_no_id[]')[serial_key].value == '')
        {
            let temp = document.getElementsByName('txt_serial_no[]')[serial_key].value;
            let res = temp.split('|');
            for (let i = 1; i < res.length; i++) {
                $('#serial_body').append('<tr><td><label class="control-label">' + res[i] + '</label></td><td><input type="hidden" id="serial_id" name = "serial_id[]" value=""><input type="hidden" id="serial_name" name = "serial_name[]" value="' + res[i] + '"><button type="button" name="btn_remove_serial" id="btn_remove_serial" class="btn btn-danger btn_remove_serial">X</button></td></tr>');
            }
        }
        else
        {
            let temp = document.getElementsByName('txt_serial_no[]')[serial_key].value;
            let res = temp.split('|');
            let temp_id = document.getElementsByName('txt_serial_no_id[]')[serial_key].value;
            let res_id = temp_id.split('|');
            for (let i = 1; i < res.length; i++) {
                $('#serial_body').append('<tr><td><label class="control-label">' + res[i] + '</label></td><td><input type="hidden" id="serial_id" name = "serial_id[]" value="' + res_id[i] + '"><input type="hidden" id="serial_name" name = "serial_name[]" value="' + res[i] + '"><button type="button" name="btn_remove_serial" id="btn_remove_serial" class="btn btn-danger btn_remove_serial">X</button></td></tr>');
            }
        }

    }

function fnc_batch_key(e)
{
    for(i=0;i<document.getElementsByName('txt_product[]').length;i++)
        if(e == document.getElementsByName('link_batch[]')[i]){
            batch_key = i;
            break;
        }
    if(document.getElementsByName('txt_serial_no[]')[batch_key].value != '')
    {
        document.getElementsByName("link_batch[]")[batch_key].removeAttribute("href");
        document.getElementsByName("link_batch[]")[batch_key].removeAttribute("data-toggle");
    }
    else
    {
        document.getElementsByName('link_batch[]')[batch_key].setAttribute("data-toggle", "modal");
        document.getElementsByName('link_batch[]')[batch_key].setAttribute("href", "#");
    }
    $('#batch_body').empty();
    $('#batch_body').append('<tr id="row_batch"><td><div class="form-group"><input type="text" id="batch_input" name="batch_input"  class="form-control" placeholder="Batch no" ></div></td><td><div class="form-group"><input type="date" id="mfg_input" name="mfg_input"  class="form-control"  ></div></td><td><div class="form-group"><input type="date" id="exp_input" name="exp_input"  class="form-control"  ></div></td><td><div class="form-group"><input type="text" id="model_no_input" name="model_no_input"  class="form-control" placeholder="Model No" ></div></td><td><div class="form-group"><input type="text" id="size_input" name="size_input"  class="form-control" placeholder="Size" ></div></td><td><div class="form-group"><input type="text" id="qty_input" name="qty_input"  class="form-control" placeholder="Quantity" ></div></td><td><div class="form-group"><input type="number" id="mrp_input" name="mrp_input" class="form-control" placeholder="MRP."></div></td><td><button type="button" name="btn_batch_add" id="btn_batch_add" class="btn btn-success">Add More</button></td></tr>');
    if(document.getElementsByName('txt_batch_no[]')[batch_key].value != '')
    {
        let bat_id = document.getElementsByName('txt_batch_no_id[]')[batch_key].value;
        let bat = document.getElementsByName('txt_batch_no[]')[batch_key].value;
        let val = bat.split('|');
        //alert(val);
        $('#batch_body').append('<tr><td><label class = "form-control">'+ val[1] +'</label><input type = "hidden" id = "txt_batch_name" name = "txt_batch_name[]" value = "'+ val[1] +'"></td><td><label class = "form-control">'+ val[2] +'</label><input type = "hidden" id = "txt_mfg_date" name = "txt_mfg_date[]" value = "'+ val[2] +'"></td><td><label class = "form-control">'+ val[3] +'</label><input type = "hidden" id = "txt_exp_date" name = "txt_exp_date[]" value = "'+ val[3] +'"></td><td><label class = "form-control">'+ val[4] +'</label><input type = "hidden" id = "txt_model_no" name = "txt_model_no[]" value = "'+ val[4] +'"></td><td><label class = "form-control">'+ val[5] +'</label><input type = "hidden" id = "txt_size" name = "txt_size[]" value = "'+ val[5] +'"></td><td><label class = "form-control">'+ val[6] +'</label><input type = "hidden" id = "txt_batch_quantity" name = "txt_batch_quantity[]" value = "'+ val[6] +'"></td><td><label class = "form-control">'+ val[7] +'</label><input type = "hidden" id = "txt_price" name = "txt_price[]" value = "'+ val[7] +'"></td><td><button type="button" name="btn_remove_batch[]" id="btn_remove_batch" onclick="fnc_batch_remove(this)" class="btn btn-danger btn_remove_batch">X</button><input type = "hidden" id = "batch_id" name = "batch_id[]" value = "'+bat_id+'"></td></tr>');
    }

}

function fnc_qr_balance(e)
{
    console.log('hello');
    let index;
    for(let i=0;i<document.getElementsByName('txt_product[]').length;i++)
        if( e == document.getElementsByName('txt_quantity[]')[i] || e == document.getElementsByName('txt_rate[]')[i]) {
            index = i;
            break;
        }
    if(document.getElementsByName('txt_batch_no[]')[index] != '')
    {
        if(document.getElementsByName('txt_quantity[]')[index] == e)
        {
            // console.log('hello moto');
            let  val = document.getElementsByName('txt_batch_no[]')[index].value;
            let result = val.split('|');
            if( parseInt(document.getElementsByName('txt_quantity[]')[index].value) < parseInt(result[6]))
            {
                // console.log('hello moto 2');
                document.getElementsByName('txt_quantity[]')[index].value = result[6] ;
            }
        }
        else if(document.getElementsByName('txt_rate[]')[index] == e)
        {
            let  val = document.getElementsByName('txt_batch_no[]')[index].value;
            let result = val.split('|');
            result[7] = document.getElementsByName('txt_rate[]')[index].value;
            let finalResult = '';
            for(let i=1;i<8;i++)
                finalResult = finalResult.concat('|',result[i]);
            console.log(finalResult);
            document.getElementsByName('txt_batch_no[]')[index].value = finalResult;
        }
    }

    if(document.getElementsByName('txt_serial_no[]')[index] != '')
    {
        let val = document.getElementsByName('txt_serial_no[]')[index].value;
        let exploded_value = val.split('|');
        val = exploded_value.length;
        val--;
        if(document.getElementsByName('txt_quantity[]')[index] == e)
        {
            if(val > document.getElementsByName('txt_quantity[]')[index].value )
            {
                document.getElementsByName('txt_quantity[]')[index].value = val ;
            }
        }
    }
	
}

	function fnc_batch_remove(e)
	{
        let bat_len = parseInt(document.getElementsByName('batch_id[]').length);
		for(let i=0 ; i < document.getElementsByName('batch_id[]').length;i++)
			if(e == document.getElementsByName('btn_remove_batch[]')[i])
			{
				btn_done = i;
				// console.log(i);
			}
		let detail_id =document.getElementsByName('batch_id[]')[btn_done];
		let pur_det_id = document.getElementsByName('purchase_invoice_detail_id[]')[batch_key].value;
		
		if(detail_id.value != '')
		{
			if(confirm("Are you sure you want to delete this?"))
			{
				$.ajax({
					url:"purchase_ajax.php",
					type:"POST",
					data:{ 'id' : detail_id.value , 'batch_detail_delete' : 1 },
					success:function(data)
					{}
				});
				
				$.ajax({  
						url:"purchase_ajax.php",
						type:"POST",  
						data:{ 'id' : pur_det_id , 'edit_delete_detail' : 1 },
						success:function(data)  
						{}  
				   });
				e.closest("tr").remove();
			}
		}
		else if(bat_len == 1)
		{
			document.getElementsByName('txt_batch_no[]')[batch_key].closest('tr').remove();
			e.closest("tr").remove();
		}
		else if(bat_len > 1)
		{
			
			let batch_name = document.getElementsByName('txt_batch_name[]')[btn_done].value;
			let mfg_date = document.getElementsByName('txt_mfg_date[]')[btn_done].value;
			let exp_date = document.getElementsByName('txt_exp_date[]')[btn_done].value;
			let model_no = document.getElementsByName('txt_model_no[]')[btn_done].value;
			let size = document.getElementsByName('txt_size[]')[btn_done].value;
			let qty = document.getElementsByName('txt_batch_quantity[]')[btn_done].value;
			let price = document.getElementsByName('txt_price[]')[btn_done].value;
			let finalResult = '';
			
			finalResult = finalResult.concat('|',batch_name);
			finalResult = finalResult.concat('|',mfg_date);
			finalResult = finalResult.concat('|',exp_date);
			finalResult = finalResult.concat('|',model_no);
			finalResult = finalResult.concat('|',size);
			finalResult = finalResult.concat('|',qty);
			finalResult = finalResult.concat('|',price);
			
			for(let i=0;i<document.getElementsByName('txt_product[]').length;i++)
				if(finalResult == document.getElementsByName('txt_batch_no[]')[i].value)
				{
					document.getElementsByName('txt_batch_no[]')[i].closest('tr').remove();
					e.closest('tr').remove();
				}
			
		}
	}
	
//for check selected value is cheque or not
function fnc_payment_type_text()
{
  var val_payment = $("#cmb_payment_type option:selected").text();
  
  if(val_payment == 'cheque' )
    $("#dynamic_ref").show();
  else
    $("#dynamic_ref").hide();
}

function fnc_no_prd_change(e)
{
	for(let i=0;i<document.getElementsByName('txt_product[]').length;i++)
	{
		if(e == document.getElementsByName('txt_product[]')[i])
		{
			var x = document.getElementsByName('txt_quantity[]')[i];
			x.focus();
			break;
		}
	}
}

function fnc_validation()
{
	var txt_product = document.getElementsByName('txt_product[]');
	var txt_quantity = document.getElementsByName('txt_quantity[]');
	var cmb_party = document.getElementById('cmb_party');
	var txt_invoice_date = document.getElementById('txt_invoice_date').value;
	var txt_rate = document.getElementsByName('txt_rate[]');
	var txt_discount = document.getElementsByName('txt_discount[]');
	var txt_gst = document.getElementsByName('txt_gst[]');
	var txt_shipping_amt = document.getElementsByName('txt_shipping_amt');
	var txt_pay = document.getElementsByName('txt_pay');
	
	var today = new Date();
	var given_date = new Date(txt_invoice_date);
	
	//validation for party type
	if(cmb_party.selectedIndex == 0 || cmb_party.value == 'party')
	{
		$('#cmb_party').after('<span class="error_company" style="color:red; font-size:15px;">Please Select Party!</span>');
		document.getElementById("cmb_party").focus();
		return false;
	}
	
	//date validatio
	if(given_date > today)
	{
		$('#txt_invoice_date').after('<span class="error_company" style="color:red; font-size:15px;">Please Select Date Properly!</span>');
		document.getElementById("txt_invoice_date").focus();
		return false;
	}
	
	//validation for product
	for(let x = 0 ; x < txt_product.length ; x ++)
	{
		if(txt_product[x].selectedIndex == 0)
		{
			txt_product[x].style.borderColor="#FF0000";
			txt_product[x].focus();
			return false;
		}

		if(txt_quantity[x].value == 0 || txt_quantity[x].value == '' || txt_quantity[x].value < 0)
		{
			txt_quantity[x].style.borderColor="#FF0000";
			txt_quantity[x].focus();
			return false;
		}
		
		if(txt_rate[x].value == 0 || txt_rate[x].value == '' || txt_rate[x].value < 0)
		{
			txt_rate[x].style.borderColor="#FF0000";
			txt_rate[x].focus();
			return false;
		}
		
		if(txt_discount[x].value == '' || txt_discount[x].value < 0)
		{
			txt_discount[x].style.borderColor="#FF0000";
			txt_discount[x].focus();
			return false;
		}
		
		if(txt_gst[x].selectedIndex == 0)
		{
			txt_gst[x].style.borderColor="#FF0000";
			txt_gst[x].focus();
			return false;
		}
	}
	if(txt_shipping_amt.value < 0 || txt_shipping_amt.value == '')
	{
		$('#txt_shipping_amt').after('<span class="error_company" style="color:red; font-size:15px;">Please Enter valid Amount!</span>');
		document.getElementById("txt_shipping_amt").focus();
		return false;
	}
	if(txt_pay.value < 0 || txt_pay.value == '')
	{
		$('#txt_pay').after('<span class="error_company" style="color:red; font-size:15px;">Please Enter valid amount!</span>');
		document.getElementById("txt_pay").focus();
		return false;
	}

	return true;
}

function fnc_style_remove(e)
{
	let abc = e.getAttribute('name');
	let bc = document.getElementsByName(abc);
	for(let p = 0 ; p< bc.length ; p++)
	{
		if(e == bc[p])
		{
			if ( bc[p].hasAttribute("style"))
			{
				 bc[p].setAttribute("style", "");
			}
			break;
		}
	}
}

function fnc_rate_update(e)
{
	let rate = document.getElementsByName('txt_rate[]');
	let unit = document.getElementsByName('product_unit[]');
	let conversion = document.getElementsByName('share_rate[]');
	let index = 0;

	for(i=0 ; i< rate.length ; i++)
	{
		if(e == unit[i])
		{
			index = i;
			break;
		}
	}

	if(e.selectedIndex == 0)
	{
		rate[index].value = parseFloat(rate[index].value) * parseFloat(conversion[index].value);
	}
	if(e.selectedIndex == 1)
	{
		rate[index].value = parseFloat(rate[index].value) / parseFloat(conversion[index].value);
	}
	tot();
}
</script>

<style>
	.disabledAnchor a{
       pointer-events: none !important;
       cursor: default;
       color:white;
}

.modal-batch {
    max-width: 80%;
}


  #txt_rate::-webkit-inner-spin-button{
    -webkit-appearance: none;    
  }

  #txt_quantity::-webkit-inner-spin-button{
    -webkit-appearance: none;    
  }

  #txt_discount::-webkit-inner-spin-button{
    -webkit-appearance: none;    
  }
</style>
 
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info">
		<div class="panel-heading">
			<form>
				<div class = 'row'>
				<div class = "col-md-6">
					Purchase Invoice
					</div>
					<div class = "col-md-6" style="text-align: right;">
						<label class="control-label">Credit <label>
						<input type="checkbox" data-color="#13dafe" data-size="small" data-secondary-color="#6164c1" class="js-switch" id="swt_party">
						<label> Cash</label>
					</div>
				</div>
			</form>
		</div>
			
			<div class="panel-wrapper collapse in" aria-expanded="true">
				<div class="panel-body">
					<form method="post" name="add_name" id = "add_name" enctype="multipart/form-data">
						<div class="form-body">		
							<div class="row">
								<div class="col-md-3">
									<div class="form-group" id = "switch_party">
										<label class="control-label">Party Name</label>
										<select id="cmb_party" name="cmb_party"  class="form-control" onchange="fnc_party();javascript:fnc_add_party_select(this);">
											<option value="">------SELECT PARTY------</option>
											<option value="party">Add new</option>
											<?php 
												$party="SELECT * FROM tbl_party_master  WHERE party_type=0";
												$rs_party=mysqli_query($con,$party);
												while($row_party=mysqli_fetch_array($rs_party))
												{ 
											?>
												<option value="<?php echo $row_party['party_id']; ?>" <?php if(isset($_GET['id'])){if($row_purchase_select['party_id'] == $row_party['party_id']){echo "selected";}}?> ><?php echo $row_party['party_name'];?></option>
											<?php
												}
											?>
										</select>								
									</div>
								</div>
								<!--/span-->
								<div class="col-md-2">
									<div class="form-group">
										<label class="control-label">Ref.Order No</label>
										<input type="text" id="txt_ref_order_no" name="txt_ref_order_no" class="form-control" value="<?php if(isset($_GET['id'])){ echo $row_purchase_select['ref_order_id']; }?>" placeholder="Enter Ref.Order No.">										
									</div>
								</div>
								<!--/span-->
								<div class="col-md-2">
									<div class="form-group">
										<label class="control-label">Invoice No</label>
										<input type="text" id="txt_invoice_no" name="txt_invoice_no" class="form-control" placeholder="Enter Invoice No." readonly value="<?php if(isset($_GET['id'])){ echo $row_purchase_select['invoice_no']; }else { echo $invoice_no; } ?>">
									</div>
								</div>
								<!--/span-->
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label">State Of Supply</label>
										<select id="cmb_state_of_supply" name="cmb_state_of_supply" class="form-control" onchange = "fnc_state_change(); tot();">
											<option value="">SELECT STATE OF SUPPLY</option>
											<option value="ANDAMAN AND NICOBAR ISLANDS" <?php fnc_state("ANDAMAN AND NICOBAR ISLANDS");?>>ANDAMAN AND NICOBAR ISLANDS</option>
											<option value="ANDHRA PRADESH"<?php fnc_state("ANDHRA PRADESH");?>>ANDHRA PRADESH</option>
											<option value="ARUNACHAL PRADESH"<?php fnc_state("ARUNACHAL PRADESH");?>>ARUNACHAL PRADESH</option>
											<option value="ASSAM"<?php fnc_state("ASSAM");?>>ASSAM</option>
											<option value="BIHAR"<?php fnc_state("BIHAR");?>>BIHAR</option>
											<option value="CHATTISGARH"<?php fnc_state("CHATTISGARH");?>>CHATTISGARH</option>
											<option value="CHATTISGARH"<?php fnc_state("CHATTISGARH");?>>CHATTISGARH</option>
											<option value="DAMAN AND DIU"<?php fnc_state("DAMAN AND DIU");?>>DAMAN AND DIU</option>
											<option value="DELHI"<?php fnc_state("DELHI");?>>DELHI</option>
											<option value="DADRA AND NAGAR HAVELI<?php fnc_state("DADRA AND NAGAR HAVELI");?>">DADRA AND NAGAR HAVELI</option>
											<option value="GOA" <?php fnc_state("GOA");?>>GOA</option>
											<option value="GUJARAT" <?php fnc_state("GUJARAT");?>>GUJARAT</option>
											<option value="HIMACHAL PRADESH"<?php fnc_state("HIMACHAL PRADESH");?>>HIMACHAL PRADESH</option>
											<option value="HARYANA"<?php fnc_state("HARYANA");?>>HARYANA</option>
											<option value="JAMMU AND KASHMIR"<?php fnc_state("JAMMU AND KASHMIR");?>>JAMMU AND KASHMIR</option>
											<option value="JHARKHAND"<?php fnc_state("JHARKHAND");?>>JHARKHAND</option>
											<option value="KERALA"<?php fnc_state("KERALA");?>>KERALA</option>
											<option value="KARNATAKA"<?php fnc_state("KARNATAKA");?>>KARNATAKA</option>
											<option value="LAKSHADWEEP"<?php fnc_state("LAKSHADWEEP");?>>LAKSHADWEEP</option>
											<option value="MEGHALAYA"<?php fnc_state("MEGHALAYA");?>>MEGHALAYA</option>
											<option value="MAHARASHTRA"<?php fnc_state("MAHARASHTRA");?>>MAHARASHTRA</option>
											<option value="MANIPUR"<?php fnc_state("MANIPUR");?>>MANIPUR</option>
											<option value="MADHYA PRADESH"<?php fnc_state("MADHYA PRADESH");?>>MADHYA PRADESH</option>
											<option value="MIZORAM"<?php fnc_state("MIZORAM");?>>MIZORAM</option>
											<option value="NAGALAND"<?php fnc_state("NAGALAND");?>>NAGALAND</option>
											<option value="ORISSA"<?php fnc_state("ORISSA");?>>ORISSA</option>
											<option value="PUNJAB"<?php fnc_state("PUNJAB");?>>PUNJAB</option>
											<option value="PONDICHERRY"<?php fnc_state("PONDICHERRY");?>>PONDICHERRY</option>
											<option value="RAJASTHAN"<?php fnc_state("RAJASTHAN");?>>RAJASTHAN</option>
											<option value="SIKKIM"<?php fnc_state("SIKKIM");?>>SIKKIM</option>
											<option value="TAMIL NADU"<?php fnc_state("TAMIL NADU");?>>TAMIL NADU</option>
											<option value="TRIPURA"<?php fnc_state("TRIPURA");?>>TRIPURA</option>
											<option value="UTTARAKHAND"<?php fnc_state("UTTARAKHAND");?>>UTTARAKHAND</option>
											<option value="UTTAR PRADESH"<?php fnc_state("UTTAR PRADESH");?>>UTTAR PRADESH</option>
											<option value="WEST BENGAL"<?php fnc_state("WEST BENGAL");?>>WEST BENGAL</option>
											<option value="TELANGANA"<?php fnc_state("TELANGANA");?>>TELANGANA</option>
										</select>
										<input type="hidden"  name="is_out_off_state" id="is_out_off_state" value="<?php if(isset($_GET['id'])){ echo $row_purchase_select['out_of_state']; }?>"/>
									</div>
								</div>
								<!--/span-->
								<div class="col-md-2">
									<div class="form-group">
										<label class="control-label">Invoice Date</label>
										<input type="date" id="txt_invoice_date" name="txt_invoice_date" class="form-control" value="<?php if(isset($_GET['id'])){ echo $row_purchase_select['purchase_invoice_date']; }else { print(date("Y-m-d")); } ?>" >		
									</div>
								</div>
								<!--/span-->
							</div>
							<div class="row">
								<div class="col-md-2">
									
									<!--- for serial popup --->
									<div class="modal fade" id="serial" role="dialog">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" id="btn_modal_serial" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
													<h4>Serial</h4>
												</div>
												<div class="modal-body">
													<div class="row">
														<div class="col-md-12">
															<div class="form-group">
																<table class="table-hover table .color-bordered-table .info-bordered-table" data-tablesaw-mode="columntoggle" id = "dynamic_serial">
																	<thead>
																		<th style="text-align: center;">#</th>
																		<th style="text-align: center;">Serial No.</th>
																	</thead>
																	<tbody id = "serial_body">
																	<tr>
                                                                        <td><input type="text" id="serial_input" name = "serial_input" class = "form-control" placeholder="Enter Serial No" value = ""></td>
                                                                        <td>
																		<button type="button" name="btn_add_serial" id="btn_add_serial" class="btn btn-success">Add More</button>
																		</td>
                                                                    </tr>
																	</tbody>
																</table>
                                                                <div>
                                                                    
                                                                </div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!---for batch unit--->
									<div class="modal fade bs-example-modal-lg" id="batch" role="dialog">
										<div class="modal-dialog modal-lg modal-batch">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" id="btn_modal_batch" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
													<h4>Batch</h4>
												</div>
												<div class="modal-body">
													<div class = "row">
														<table class="table-hover table-bordered table" data-tablesaw-mode="columntoggle" id = "dynamic_field_batch">
															<thead>
																<th style="text-align: center;">Batch Name</th>
																<th style="text-align: center;">Mfg. Date</th>
																<th style="text-align: center;">Exp. Date</th>
																<th style="text-align: center;">Model No.</th>
																<th style="text-align: center;">Size</th>
																<th style="text-align: center;">Quantity</th>
																<th style="text-align: center;">Price</th>
																<th style="text-align: center;">#</th>

															</thead> 
															<tbody id = "batch_body">
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>	
							</div>
							<!--/row-->
							<div class = "row">
								<table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle" id = "dynamic_field">
								<thead>
										
									<th style="width:15%;" class="text-center">Product</th>

									<?php if($setting->get_name('is_show_serial') == 1) { ?>
									<th style="width:5%;" class="text-center">Serial</th>
									<?php } ?>

									<?php if($setting->get_name('is_show_batch') == 1) { ?>
										<th style="width:5%;" class="text-center">Batch</th>
									<?php } ?>

									<th style="text-align: center; width:10%;">Unit</th>
									<th style="text-align: center; width:10%;">Qty</th>
									<th style="text-align: center; width:10%;">Rate</th>
									<th style="text-align: center; width:7%;">Discount</br>(%)</th>
									<th style="text-align: center; width:9%;">GST</th>
									<th style="text-align: center; width:10%;">Total</th>
									<th style="text-align: center; width:5%;">Action</th>
								</thead> 
									<tbody>
									
								<?php	if(!isset($_GET['id']))
									{ ?>
									<tr id='row0'>
										<td>
											<div class="form-group">
												<select class="form-control"  id="txt_product" name="txt_product[]" onchange="fnc_unit(this);fnc_style_remove(this);" placeholder = "select Product" >
												<option value = "">--select--</option>
												<?php
												  $sql_autocomplete = "SELECT pm.*,ut.unit_name FROM tbl_product_master pm left join tbl_company tc on tc.company_id = pm.company_id left join tbl_unit ut on ut.unit_id= pm.unit_id where tc.is_default = 1";
												  $rs_autocomplete = mysqli_query($con , $sql_autocomplete);
												  while($row_autocomplete = mysqli_fetch_array($rs_autocomplete))
												  {
												?>
												<option value="<?php echo $row_autocomplete['product_id'];?>"><?php echo $row_autocomplete['product_name'];?></option>                    
												<?php
												  }
												?>
												</select>
											  </div>
										</td>
										<?php if($setting->get_name('is_show_serial') == 1) { ?>
											<td>
												<div class="form-group">
													<a href="#" id="link_serial" onclick="fnc_serial_key(this);" name="link_serial[]" class="form-control" data-toggle="modal" data-target="#serial">Serial</a>
												</div>
											</td>
										<?php } ?>
										<?php if($setting->get_name('is_show_batch') == 1) { ?>
											<td>
												<div class="form-group">
													<a href="#" id="link_batch" name="link_batch[]" onclick="fnc_batch_key(this);" class="form-control"  data-toggle="modal" data-target="#batch">Batch</a>
												</div>
											</td>
										<?php } ?>
										<td>
											<div class="form-group">
												<select class="form-control" onchange="fnc_rate_update(this)" id="product_unit" name="product_unit[]">
												</select>
											</div>
										</td>
										<td>
											<div class="form-group">
												<input type="number" id="txt_quantity" name="txt_quantity[]" step = "0.001" value = "0" onchange = "tot(); fnc_qr_balance(this); fnc_style_remove(this);"  class="form-control" placeholder="Enter QUANTITY" >
												<input type="hidden" id="share_rate" name="share_rate[]">
											</div>
										</td>
										<td>
											<div class="form-group">
												<input type="number" id="txt_rate" step = "0.01" name="txt_rate[]" onchange = "tot(); fnc_qr_balance(this); fnc_style_remove(this);"  class="form-control" placeholder="Enter rate" >
											</div>
										</td>
										<td>
											<div class="form-group">
												<input type="number" id="txt_discount" step = "0.01" name="txt_discount[]" onchange = "tot();fnc_style_remove(this);"  class="form-control" placeholder="Enter discount" value = 0>										
											</div>
										</td>
										<td>
											<div class="form-group">
                                                <select id="txt_gst" name="txt_gst[]" class="form-control" onchange = "fnc_gst_cal(this);fnc_style_remove(this); ">
												<option value = "">--select--</option>                                                                               
                                                <?php
                                                $sql_gst="SELECT gst.* FROM tbl_gstslab_master gst LEFT JOIN tbl_company com ON com.company_id  = gst.company_id  WHERE com.is_default = 1 ";
                                                $rs_gst = mysqli_query($con,$sql_gst);
                                                while($row_gst=mysqli_fetch_array($rs_gst))
                                                {
                                                ?>
                                                    <option value="<?php echo $row_gst['gstslab_id']; ?>"><?php echo $row_gst['gstslab_name'];?></option>
                                                <?php
                                                }
                                                ?>
                                                </select>
											</div>
										</td>
										<td>
											<div class="form-group">
												<input type="number" id="txt_total" step = "0.01" name="txt_total[]" readonly = "true" class="form-control" placeholder="Enter TOTAL" >
											</div>
										</td>
										<td>
										<input type="hidden" name="txt_cgst[]" id="txt_cgst" value = "0"/>
										<input type="hidden" name="txt_discount_amt[]" id="txt_discount_amt"/>
										<input type="hidden" name="txt_serial_no[]" id="txt_serial_no" value="">
										<input type="hidden" name="txt_batch_no[]" id="txt_batch_no" >
                                        <input type="hidden" name="txt_serial_no_id[]" id="txt_serial_no_id" value="">
                                        <input type="hidden" name="txt_batch_no_id[]" id="txt_batch_no_id" >

										<input type="hidden" name="purchase_invoice_detail_id[]" id="purchase_invoice_detail_id" value = ''/> 
										<button type="button" name="btn_remove" id="btn_remove" class="btn btn-danger btn_remove">X</button></td>
									</tr> <?php }?>
									</tbody>
								</table>
							</div>
							<!--/row-->
								<!--/span-->
					</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<button type="button" name="btn_add" id="btn_add" class="btn btn-success">Add More</button>
								</div>
							</div>
							<!--/span-->
							<div class="col-md-4">
								
							</div>
							<!--/span-->
							<div class="col-md-4">
								<div class="form-group">
									<label class="control-label">Sub Total</label>
									<input type="number" id="txt_sub_total" name="txt_sub_total" readonly = "true" class="form-control" placeholder="Enter Sub Total">									
								</div>
							</div>
							<!--/span-->
						</div>		
							<!--/row-->
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Payment Type</label>
										<select id="cmb_payment_type" name="cmb_payment_type" class="form-control" onchange="fnc_payment_type_text();">
											<?php 
												$sql_payment="SELECT * FROM tbl_payment_type";
												$rs_payment=mysqli_query($con,$sql_payment);
												while($row_payment=mysqli_fetch_array($rs_payment))
												{ 
											?>
												<option value="<?php echo $row_payment['payment_type_id']; ?>" <?php if(isset($_GET['id'])){if($row_purchase_select['payment_type_id'] == $row_payment['payment_type_id']){echo "selected";}}?> ><?php echo $row_payment['payment_type'];?></option>
											<?php
												}
											?>
										</select>										
									</div>
								</div>
								<!--/span-->
								<div class="col-md-4">
									<div class="form-group" id="dynamic_ref">
										<label class="control-label">Refrence No.</label>
										<input type="number" id="txt_cheque_ref" name="txt_cheque_ref" class="form-control">    
									</div>
								</div>
								<!--/span-->
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Shipping/Packing Amount</label>
										<input type="number" id="txt_shipping_amt" name="txt_shipping_amt" class="form-control" value = "<?php if(isset($_GET['id'])){ echo $row_purchase_select['shipping_packing_ammount']; }else {echo "0.00";}?>" onchange = "fnc_calculate_total()" placeholder="Enter Shipping/Packing Amount">
									</div>
								</div>
								<!--/span-->
							</div>	
							<div class="row">	
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Description</label>
										<textarea id="txt_narration" name="txt_narration" class="form-control" placeholder="Enter Narration"><?php if(isset($_GET['id'])){ echo $row_purchase_select['narration']; }?></textarea>
									</div>
								</div>
								<!--/span-->
								<div class="col-md-4">
									
								</div>
								<!--/span-->
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Gross Total</label>
										<input type="number" id="txt_gtotal" name="txt_gtotal" readonly = "true" class="form-control">							
									</div>
								</div>
								<!--/span-->
							</div>		
							<!--/row-->
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Round Off</label>
										<input type="number" id="txt_round_off" name="txt_round_off" class="form-control" onchange = "fnc_calculate_total()" value = "0.00" placeholder="">																			
									</div>
								</div>
								<!--/span-->
								<div class="col-md-4">
									<div class="form-group">
										<input type="checkbox" id="chk_is_round_off" name="chk_is_round_off" onchange = "fnc_calculate_total()" <?php if(isset($_GET['id'])){  if($row_purchase_select['is_round_off'] == 1){ echo "checked";}}?>>	
										<label class="control-label">Is Round Off</label>
									</div>
								</div>
								<!--/span-->
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Total</label>
										<input type="number" id="txt_total_inv" name="txt_total_inv" readonly = "true" class="form-control" placeholder="Enter Total" >									
									</div>
								</div>
								<!--/span-->
							</div>		
							<!--/row-->
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										
									</div>
								</div>
								<!--/span-->
								<div class="col-md-4">
									
								</div>
								<!--/span-->
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Pay</label>
										<input type="number" id="txt_pay" name="txt_pay" class="form-control" step="0.01"  placeholder="Enter Pay Amount" value="<?php if(isset($_GET['id'])){ echo $row_purchase_select['pay']; } else echo "0.00"; ?>" >	
									</div>
								</div>
								<!--/span-->
							</div>
						</div>
						<div class="form-actions">
							<div class = "row">
							<div  class = "col-md-8"> </div>
								<input type="hidden" name="purchase_invoice_id" id="purchase_invoice_id" value = "<?php if(isset($_GET['id'])){ echo $row_purchase_select['purchase_invoice_id']; }?>"/>
								<?php	if(isset($_GET['id']))
										{ ?>
								<button type="submit" id="btn_edit" name="btn_edit" class="btn btn-success" onclick="return fnc_validation();"> <i class="fa fa-check"></i> Update</button>&nbsp;
								<button type="submit" style = "background: #03a9f3;" id="btn_update_n_print" name="btn_update_n_print" class="btn btn-success" onclick="return fnc_validation();"> <i class="fa fa-check"></i>Update & Print</button>&nbsp;
										<?php }else{?>
								<button type="submit" id="btn_save" name="btn_save" class="btn btn-success" onclick="return fnc_validation();"> <i class="fa fa-check"></i> Save</button>&nbsp;
								<button type="submit" id="btn_save_n_print" style = "background: #03a9f3;" name="btn_save_n_print" class="btn btn-success" onclick="return fnc_validation();"> <i class="fa fa-check"></i>Save & Print</button>&nbsp;
										<?php }?>
								<button type="reset" name="btn_reset" style = "background: lightgrey;" id="btn_reset" class="btn btn-default">Cancel</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!--./row-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>	
<script>
	document.addEventListener ("keydown", function (zEvent) {
    if (zEvent.altKey  &&  zEvent.key === "a") {  
        $('#btn_add').click();
    }
} );
$(document).ready(function(){
	
	//validation span remove
	$('#cmb_party,#txt_invoice_date , #cmb_party').on('keyup , change', function () {
		$(".error_company").remove();
	});
	
	
		
	
	
	document.getElementById('txt_round_off').readOnly = true;
	$("#dynamic_ref").hide();
	$("#swt_party").on('click',function(){
		
		var x = $("#swt_party").val();
		swit++;
		
		if(swit % 2 == 1)
		{
			$("#switch_party").empty();
			$("#switch_party").append('<label class="control-label">Billing Name</label><input type="number" id="cmb_party" name="cmb_party" class="form-control"  placeholder="Enter Billing Name" value="<?php if(isset($_GET['id'])){ echo $row_purchase_select['pay']; }?>" >	');
		}	
		if(swit % 2 == 0)
		{
			$("#switch_party").empty();
			$("#switch_party").append('<label class="control-label">Party Name</label><select id="cmb_party" name="cmb_party"  class="form-control" onchange="fnc_party();javascript:fnc_add_party_select(this);"><option value="">------SELECT PARTY------</option><option value="party">Add new</option><?php $party="SELECT * FROM tbl_party_master  WHERE party_type=0";$rs_party=mysqli_query($con,$party);while($row_party=mysqli_fetch_array($rs_party)) {  ?><option value="<?php echo $row_party["party_id"]; ?>" <?php if(isset($_GET["id"])) { if($row_purchase_select["party_id"] == $row_party["party_id"]){echo "selected";}} ?> ><?php echo $row_party["party_name"]; ?></option><?php } ?></select>');
		}
	});
	
	   
	$(document).on('click', '#btn_add', function() {
		  
		$('#dynamic_field').append('<tr id="row"><td><div class="form-group"><select class="form-control"  id="txt_product" name="txt_product[]" onchange="fnc_unit(this);fnc_style_remove(this);" placeholder = "select Product"><option value = "">--select--</option><?php $sql_autocomplete = "SELECT pm.*,ut.unit_name FROM tbl_product_master pm left join tbl_company tc on tc.company_id = pm.company_id left join tbl_unit ut on ut.unit_id= pm.unit_id where tc.is_default = 1";$rs_autocomplete = mysqli_query($con , $sql_autocomplete);while($row_autocomplete = mysqli_fetch_array($rs_autocomplete)){?><option value="<?php echo $row_autocomplete["product_id"];?>"><?php echo $row_autocomplete["product_name"];?></option> <?php } ?></select></div></td><?php if($setting->get_name('is_show_serial') == 1) { ?><td><div class="form-group"><a href="#" id="link_serial" onclick="fnc_serial_key(this);"  name = "link_serial[]" class="form-control" data-toggle="modal" data-target="#serial" ">Serial</a></div></td><?php } ?><?php if($setting->get_name('is_show_batch') == 1) { ?><td><div class="form-group"><a href="#" id="link_batch" onclick="fnc_batch_key(this);" name="link_batch[]"  class="form-control"  data-toggle="modal" data-target="#batch" >Batch</a></div></td><?php } ?><td><div class="form-group"><select class="form-control" onchange="fnc_rate_update(this)" id="product_unit" name="product_unit[]"></select></div></td><td><div class="form-group"><input type="number" id="txt_quantity" name="txt_quantity[]" value = "0" onchange = "tot(); fnc_qr_balance(this);fnc_style_remove(this);" class="form-control" step = "0.01" placeholder="Enter QUANTITY" ><input type="hidden" id="share_rate" name="share_rate[]"></div></td><td><div class="form-group"><input type="number" step = "0.01" id="txt_rate" name="txt_rate[]" onchange = "tot(); fnc_qr_balance(this);fnc_style_remove(this);" class="form-control" placeholder="Enter rate" ></div></td><td><div class="form-group"><input type="number" step = "0.01" id="txt_discount[]" name="txt_discount[]" onchange = "tot();fnc_style_remove(this);" class="form-control" placeholder="Enter discount" value = 0 ></div></td><td><div class="form-group"><select id="txt_gst" name="txt_gst[]" class="form-control" onchange = "fnc_gst_cal(this);fnc_style_remove(this);"><option value = "">--select--</option><?php $sql_gst="SELECT gst.* FROM tbl_gstslab_master gst LEFT JOIN tbl_company com ON com.company_id  = gst.company_id  WHERE com.is_default = 1 "; $rs_gst = mysqli_query($con,$sql_gst); while($row_gst=mysqli_fetch_array($rs_gst)){ ?><option value="<?php echo $row_gst["gstslab_id"]; ?>"><?php echo $row_gst["gstslab_name"]; ?></option><?php } ?></select></div></td>	<td><div class="form-group"><input type="number" id="txt_total[]" name="txt_total[]" step = "0.01" readonly = "true" class="form-control" placeholder="Enter TOTAL" ></div></td><td><input type="hidden" name="txt_cgst[]" id="txt_cgst" value = "0"/><input type="hidden" name="txt_discount_amt[]" id="txt_discount_amt"/><input type="hidden" name="txt_serial_no[]" id="txt_serial_no" value = ""> <input type="hidden" name="txt_batch_no[]" id="txt_batch_no" value = "" ><input type="hidden" name="txt_serial_no_id[]" id="txt_serial_no_id" value=""><input type="hidden" name="txt_batch_no_id[]" id="txt_batch_no_id" ><input type="hidden" name="purchase_invoice_detail_id[]" id="purchase_invoice_detail_id" value="" /> <button type="button" name="btn_remove" id="btn_remove" class="btn btn-danger btn_remove">X</button></td></tr>');
		//document.getElementsByName('link_batch[]')[document.getElementsByName('link_batch[]').length - 1].style.pointerEvents="none";
		//document.getElementsByName('link_serial[]')[document.getElementsByName('link_serial[]').length - 1].style.pointerEvents="none";
		
		let bar_avil = <?php echo $setting->get_name('is_show_barcode'); ?>;
        
        if(bar_avil ==  1){
            let bar_no = document.getElementsByName('txt_product[]');
            bar_no[bar_no.length - 1].focus();
        }
	});  
	  
	//remove button code
	  $(document).on('click', '.btn_remove', function(){  
		 
		   var detail_id = $(this).siblings("#purchase_invoice_detail_id").val();
		   if(detail_id == '')
			{
				$(this).closest("tr").remove();
				return true;
			}
			
			if(confirm("Are you sure you want to delete this?"))
			{
				$.ajax({  
					url:"purchase_ajax.php",
					type:"POST",  
					data:{ 'id' : detail_id , 'edit_delete_detail' : 1 },
					success:function(data)  
					{  
						//$( this ).closest("tr").css( "color", "red" );
						//$(this).closest("tr").remove();
					}  
				});
				$(this).closest("tr").remove();	
			}
	  });

	if(no_of_detail_row>0)
	{
		$('#btn_reset').attr("disabled" , "disabled");
		
		for(i=0;i<no_of_detail_row;i++)
			{
				$('#dynamic_field').append('<tr id="unique"><td><div class="form-group"><select class="form-control"  id="txt_product" name="txt_product[]" onchange="fnc_unit(this);fnc_style_remove(this);" onfocus = "fnc_no_prd_change(this);" placeholder = "select Product"><option value = "">--select--</option></option><?php $sql_autocomplete = "SELECT pm.*,ut.unit_name FROM tbl_product_master pm left join tbl_company tc on tc.company_id = pm.company_id left join tbl_unit ut on ut.unit_id= pm.unit_id where tc.is_default = 1";$rs_autocomplete = mysqli_query($con , $sql_autocomplete);while($row_autocomplete = mysqli_fetch_array($rs_autocomplete)){?><option value="<?php echo $row_autocomplete["product_id"];?>"><?php echo $row_autocomplete["product_name"];?></option> <?php } ?></select></div></td><?php if($setting->get_name('is_show_serial') == 1) { ?><td><div class="form-group"><a href="#" id="link_serial" onclick="fnc_serial_key(this);" name="link_serial[]" class="form-control" data-toggle="modal" data-target="#serial">Serial</a></div></td><?php } ?><?php if($setting->get_name('is_show_batch') == 1) { ?><td><div class="form-group"><a href="#" id="link_batch" onclick="fnc_batch_key(this);" name = "link_batch[]" class="form-control"  data-toggle="modal" data-target="#batch">Batch</a></div></td><?php } ?><td><div class="form-group"><select class="form-control" onchange="fnc_rate_update(this)" id="product_unit" name="product_unit[]"></select></div></td><td><div class="form-group"><input type="number" id="txt_quantity" name="txt_quantity[]" step = "0.001" value = "0" onchange = "tot(); fnc_qr_balance(this);fnc_style_remove(this);" class="form-control" placeholder="Enter QUANTITY" ><input type="hidden" id="share_rate" name="share_rate[]"></div></td><td><div class="form-group"><input type="number" id="txt_rate" step = "0.01" name="txt_rate[]" onchange = "tot(); fnc_qr_balance(this);fnc_style_remove(this);" class="form-control" placeholder="Enter rate" ></div></td><td><div class="form-group"><input type="number" id="txt_discount[]" step = "0.01" name="txt_discount[]" onchange = "tot();fnc_style_remove(this);" class="form-control" placeholder="Enter discount" ></div></td><td><div class="form-group"><select id="txt_gst" name="txt_gst[]" class="form-control" onchange = "fnc_gst_cal(this);fnc_style_remove(this);"><option value = "">--select--</option><?php $sql_gst="SELECT gst.* FROM tbl_gstslab_master gst LEFT JOIN tbl_company com ON com.company_id  = gst.company_id  WHERE com.is_default = 1 "; $rs_gst = mysqli_query($con,$sql_gst); while($row_gst=mysqli_fetch_array($rs_gst)){ ?><option value="<?php echo $row_gst["gstslab_id"]; ?>"><?php echo $row_gst["gstslab_name"]; ?></option><?php } ?></select></div></td>	<td><div class="form-group"><input type="number" id="txt_total[]" step = "0.01" name="txt_total[]" readonly = "true" class="form-control" placeholder="Enter TOTAL" ></div></td><td><input type="hidden" name="txt_cgst[]" id="txt_cgst" value = "0"/><input type="hidden" name="txt_discount_amt[]" id="txt_discount_amt"/><input type="hidden" name="txt_serial_no[]" id="txt_serial_no" value = "" > <input type="hidden" name="txt_batch_no[]" id="txt_batch_no" value = "" ><input type="hidden" name="txt_serial_no_id[]" id="txt_serial_no_id" value=""><input type="hidden" name="txt_batch_no_id[]" id="txt_batch_no_id" ><input type="hidden" name="purchase_invoice_detail_id[]" id="purchase_invoice_detail_id" value="" /> <button type="button" name="btn_remove" id="btn_remove" class="btn btn-danger btn_remove">X</button></td></tr>');
			}
		let is_batc = <?php echo $setting->get_name('is_show_batch'); ?>;
        let is_seria = <?php echo $setting->get_name('is_show_serial'); ?>;

		var inv_id = "<?php echo $purchase_id; ?>";
		$.ajax({ url: 'purchase_ajax.php',
		data: {'id': inv_id, 'edit_fetch': 1},
		type: 'post',
		dataType :'json',
		success: function(data) 
		{
			for(i=0;i<no_of_detail_row;i++)
			{
				var detail_id = $(this).siblings("#purchase_invoice_detail_id").val();
				
				document.getElementsByName("txt_product[]")[i].value =  data[i].product_id;
				document.getElementsByName("txt_product[]")[i].style.pointerEvents="none";
				document.getElementsByName("txt_product[]")[i].style.background = "lightgray";
				document.getElementsByName("txt_gst[]")[i].value =  data[i].gstslab_id;
				document.getElementsByName("txt_quantity[]")[i].value = data[i].qty;
				document.getElementsByName("txt_rate[]")[i].value = data[i].rate;
				document.getElementsByName("txt_discount_amt[]")[i].value = data[i].disc_amt;
				document.getElementsByName("txt_discount[]")[i].value = data[i].disc_per;
				document.getElementsByName("purchase_invoice_detail_id[]")[i].value = data[i].purchase_invoice_detail_id;
				document.getElementsByName("product_unit[]")[i].value = data[i].unit_id;
				document.getElementsByName("txt_serial_no[]")[i].value = data[i].serial_no;
				document.getElementsByName("txt_batch_no[]")[i].value = data[i].batch_no;
                document.getElementsByName("txt_serial_no_id[]")[i].value = data[i].serial_no_id;
                document.getElementsByName("txt_batch_no_id[]")[i].value = data[i].batch_no_id;
                document.getElementsByName("txt_cgst[]")[i].value = data[i].gst;
				
				if(is_batc == 1)
				{
					if(data[i].batch_no == '')
					{
						//console.log("batch clr 1");
						document.getElementsByName('link_batch[]')[i].style.pointerEvents="none";
						document.getElementsByName('link_batch[]')[i].removeAttribute('href');
						document.getElementsByName('txt_batch_no[]')[i].value = '';
					}
					else
					{
						//console.log("batch clr 2");
						document.getElementsByName('link_batch[]')[i].removeAttribute('style');
						document.getElementsByName('link_batch[]')[i].setAttribute("href", "#");
					}
				}
				
				//to disable link_serial when is_serial is 0 in db
				if(is_seria == 1)
				{
					if(data[i].serial_no == '')
					{
						//console.log("serial clr 1");
						document.getElementsByName('link_serial[]')[i].style.pointerEvents="none";
						document.getElementsByName('link_serial[]')[i].removeAttribute("href");
						document.getElementsByName('txt_serial_no[]')[i].value = '';
					}
					else
					{
						//console.log("serial clr 2");
						document.getElementsByName('link_serial[]')[i].removeAttribute('style');
						document.getElementsByName('link_serial[]')[i].setAttribute("href", "#");
					}
				}
				//console.log(data[i].serial_no);
				//document.getElementsByName("txt_product[]")[i].event( 'change' );
				
				fnc_unit(document.getElementsByName("txt_product[]")[i]);
				fnc_unit_change(document.getElementsByName("purchase_invoice_detail_id[]")[i]);
			}
			tot();
			
		},
		error: function(data) {
			console.log('my ERROR' + data.d);								
		}
		});
	}
	else{
		fnc_party();
	}

    $(document).on('click', '#btn_add_serial', function() {
		var sar = document.getElementById('serial_input');
        $('#serial_body').append('<tr><td><label class="control-label">'+sar.value+'</label></td><td><input type="hidden" id="serial_id" name = "serial_id[]" value=""><input type="hidden" id="serial_name" name = "serial_name[]" value="'+sar.value+'"><button type="button" name="btn_remove_serial" id="btn_remove_serial" class="btn btn-danger btn_remove_serial">X</button></td></tr>');
        //document.getElementsByName('link_batch[]')[document.getElementsByName('link_batch[]').length - 1].style.pointerEvents="none";
        //document.getElementsByName('link_serial[]')[document.getElementsByName('link_serial[]').length - 1].style.pointerEvents="none";
        document.getElementsByName('serial_name[]')[document.getElementsByName('serial_name[]').length - 1].value = sar.value;
        sar.focus();
        let temp = document.getElementsByName('txt_serial_no[]')[serial_key].value;
        let result = temp.concat('|', sar.value);
        document.getElementsByName('txt_serial_no[]')[serial_key].value = result;
		
		//to update qty if batch is increased
		let val = result.split('|');
		document.getElementsByName('txt_quantity[]')[serial_key].value = val.length - 1;
        
		sar.value = '';
        if(document.getElementsByName('txt_serial_no_id[]')[serial_key].value != '')
        {
             let val = document.getElementsByName('txt_serial_no_id[]')[serial_key].value ;
             val = val.concat('|','0');
            document.getElementsByName('txt_serial_no_id[]')[serial_key].value = val;
        }

    });

    $(document).on('click', '.btn_remove_serial', function(){

        let detail_id = $(this).siblings("#serial_id").val();
        if(detail_id != '')
        {
            if(confirm("Are you sure you want to delete this?"))
            {
                let temp = document.getElementsByName('txt_serial_no[]')[serial_key].value;
                let temp_id = document.getElementsByName('txt_serial_no_id[]')[serial_key].value;
                let sr = $(this).siblings("#serial_name").val();
                if(temp.includes(sr) && temp_id.includes(detail_id))
                {
                    document.getElementsByName('txt_serial_no[]')[serial_key].value = temp.replace('|'+ sr,"");
                    document.getElementsByName('txt_serial_no_id[]')[serial_key].value = temp_id.replace('|' + detail_id, "");

                }

                $.ajax({
                    url:"purchase_ajax.php",
                    type:"POST",
                    data:{ 'id' : detail_id , 'serial_detail_delete' : 1 },
                    success:function(data)
                    {
                        //$( this ).closest("tr").css( "color", "red" );
                        //$(this).closest("tr").remove();
                    }
                });
                $(this).closest("tr").remove();
                document.getElementsByName('txt_quantity[]')[serial_key].value = parseInt(document.getElementsByName('txt_quantity[]')[serial_key].value) - 1;
            }
        }
        else
        {
            let temp = document.getElementsByName('txt_serial_no[]')[serial_key].value;
            let temp_id = document.getElementsByName('txt_serial_no_id[]')[serial_key].value
            let sr = $(this).siblings("#serial_name").val();
            //console.log(sr);
               if(temp.includes(sr))
               {
                   if(temp_id != '') {
                       temp_id = temp_id.replace('|0',"");
                   }
                   temp = temp.replace('|'+ sr,"");
                   document.getElementsByName('txt_serial_no[]')[serial_key].value = temp;
                   document.getElementsByName('txt_serial_no_id[]')[serial_key].value = temp_id;
                   $(this).closest("tr").remove();
               }
        }
    });

    $(document).on('click', '#btn_batch_add', function() {
        $('#batch_body').append('<tr><td><label class = "form-control">'+document.getElementById('batch_input').value +'</label><input type = "hidden" id = "txt_batch_name" name = "txt_batch_name[]" value = "'+document.getElementById('batch_input').value +'"></td><td><label class = "form-control">'+ document.getElementById('mfg_input').value +'</label><input type = "hidden" id = "txt_mfg_date" name = "txt_mfg_date[]" value = "'+ document.getElementById('mfg_input').value +'"></td><td><label class = "form-control">'+ document.getElementById('exp_input').value +'</label><input type = "hidden" id = "txt_exp_date" name = "txt_exp_date[]" value = "'+ document.getElementById('exp_input').value +'"></td><td><label class = "form-control">'+$('#model_no_input').val()+'</label><input type = "hidden" id = "txt_model_no" name = "txt_model_no[]" value = "'+$('#model_no_input').val()+'"></td><td><label class = "form-control">'+ document.getElementById('size_input').value +'</label><input type = "hidden" id = "txt_size" name = "txt_size[]" value = "'+ document.getElementById('size_input').value +'"></td><td><label class = "form-control">'+ document.getElementById('qty_input').value +'</label><input type = "hidden" id = "txt_batch_quantity" name = "txt_batch_quantity[]" value = "'+ document.getElementById('qty_input').value +'"></td><td><label class = "form-control">'+ document.getElementById('mrp_input').value +'</label><input type = "hidden" id = "txt_price" name = "txt_price[]" value = "'+ document.getElementById('mrp_input').value +'"></td><td><button type="button" name="btn_remove_batch[]" id="btn_remove_batch" onclick="fnc_batch_remove(this)" class="btn btn-danger btn_remove_batch">X</button><input type = "hidden" id = "batch_id" name = "batch_id[]" value = ""></td></tr>');
        //document.getElementsByName('link_batch[]')[document.getElementsByName('link_batch[]').length - 1].style.pointerEvents="none";
        //document.getElementsByName('link_serial[]')[document.getElementsByName('link_serial[]').length - 1].style.pointerEvents="none";
        let bat_len = document.getElementsByName('txt_batch_no[]').length - 1;
        let bat = document.getElementById('batch_input');

        document.getElementById('batch_input').focus();
        let result = '';
        result = result.concat('|', bat.value);
        result = result.concat('|',document.getElementById('mfg_input').value);
		result = result.concat('|',document.getElementById('exp_input').value);
		result = result.concat('|',document.getElementById('model_no_input').value);
		result = result.concat('|',document.getElementById('size_input').value);
		result = result.concat('|',document.getElementById('qty_input').value);
		result = result.concat('|',document.getElementById('mrp_input').value);
		
        if(document.getElementsByName('txt_batch_no[]')[batch_key].value != '')
        {
            $('#dynamic_field').append('<tr id="unique"><td><div class="form-group"><select class="form-control"  id="txt_product" name="txt_product[]" onchange="fnc_unit(this);fnc_style_remove(this);" placeholder = "select Product"><option value = "">--select--</option></option><?php $sql_autocomplete = "SELECT pm.*,ut.unit_name FROM tbl_product_master pm left join tbl_company tc on tc.company_id = pm.company_id left join tbl_unit ut on ut.unit_id= pm.unit_id where tc.is_default = 1";$rs_autocomplete = mysqli_query($con , $sql_autocomplete);while($row_autocomplete = mysqli_fetch_array($rs_autocomplete)){?><option value="<?php echo $row_autocomplete["product_id"];?>"><?php echo $row_autocomplete["product_name"];?></option> <?php } ?></select></div></td><?php if($setting->get_name('is_show_serial') == 1) { ?><td><div class="form-group"><a href="#" id="link_serial" onclick="fnc_serial_key(this);" name="link_serial[]" class="form-control" data-toggle="modal" data-target="#serial">Serial</a></div></td><?php } ?><?php if($setting->get_name('is_show_batch') == 1) { ?><td><div class="form-group"><a href="#" id="link_batch" onclick="fnc_batch_key(this);" name = "link_batch[]" class="form-control"  data-toggle="modal" data-target="#batch">Batch</a></div></td><?php } ?><td><div class="form-group"><select class="form-control" onchange="fnc_rate_update(this)" id="product_unit" name="product_unit[]"></select></div></td><td><div class="form-group"><input type="number" id="txt_quantity" name="txt_quantity[]" step = "0.001" value = "'+document.getElementById('qty_input').value+'" onchange = "tot(); fnc_qr_balance(this);fnc_style_remove(this);" class="form-control" placeholder="Enter QUANTITY" ><input type="hidden" id="share_rate" name="share_rate[]"></div></td><td><div class="form-group"><input type="number" id="txt_rate" step = "0.01" name="txt_rate[]" onchange = "tot(); fnc_qr_balance(this);fnc_style_remove(this);" class="form-control" placeholder="Enter rate" value = "'+document.getElementById("mrp_input").value+'" ></div></td><td><div class="form-group"><input type="number" step = "0.01" id="txt_discount[]" name="txt_discount[]" onchange = "tot();fnc_style_remove(this);" class="form-control" placeholder="Enter discount" ></div></td><td><div class="form-group"><select id="txt_gst" name="txt_gst[]" class="form-control" onchange = "fnc_gst_cal(this);fnc_style_remove(this);"><option value = "">--select--</option><?php $sql_gst="SELECT gst.* FROM tbl_gstslab_master gst LEFT JOIN tbl_company com ON com.company_id  = gst.company_id  WHERE com.is_default = 1 "; $rs_gst = mysqli_query($con,$sql_gst); while($row_gst=mysqli_fetch_array($rs_gst)){ ?><option value="<?php echo $row_gst["gstslab_id"]; ?>"><?php echo $row_gst["gstslab_name"]; ?></option><?php } ?></select></div></td>	<td><div class="form-group"><input type="number" id="txt_total[]" step = "0.01" name="txt_total[]" readonly = "true" class="form-control" placeholder="Enter TOTAL" ></div></td><td><input type="hidden" name="txt_cgst[]" id="txt_cgst" value = "0"/><input type="hidden" name="txt_discount_amt[]" id="txt_discount_amt"/><input type="hidden" name="txt_serial_no[]" id="txt_serial_no" value = "" > <input type="hidden" name="txt_batch_no[]" id="txt_batch_no" value = "'+result+'" ><input type="hidden" name="txt_serial_no_id[]" id="txt_serial_no_id" value=""><input type="hidden" name="txt_batch_no_id[]" id="txt_batch_no_id" ><input type="hidden" name="purchase_invoice_detail_id[]" id="purchase_invoice_detail_id" value="" /> <button type="button" name="btn_remove" id="btn_remove" class="btn btn-danger btn_remove">X</button></td></tr>');
            document.getElementsByName('txt_product[]')[document.getElementsByName('txt_product[]').length-1].value = document.getElementsByName('txt_product[]')[batch_key].value ;
            fnc_unit(document.getElementsByName("txt_product[]")[document.getElementsByName('txt_product[]').length-1]);
        }
        else
        {
            document.getElementsByName('txt_batch_no[]')[batch_key].value = result;
			document.getElementsByName('txt_rate[]')[batch_key].value = document.getElementById('mrp_input').value;
			document.getElementsByName('txt_quantity[]')[batch_key].value = document.getElementById('qty_input').value;
        }

        document.getElementById('batch_input'). value = '' ;
        document.getElementById('mfg_input'). value = '' ;
        document.getElementById('exp_input'). value = '' ;
        document.getElementById('model_no_input'). value = '' ;
        document.getElementById('size_input'). value = '' ;
        document.getElementById('qty_input'). value = '' ;
        document.getElementById('mrp_input'). value = '' ;
		
		tot();
    });

});
	
</script>
<?php
	include_once('footer.php');
?>