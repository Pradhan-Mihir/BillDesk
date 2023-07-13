<?php
$title = "BILL DESK-CashMemo";
	include_once('header.php');
	
	$detail_row_num = 0;
	$cashmemo_id = 0;
	
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
		$cashmemo_id=base64_decode($_GET['id']);
		$sql_cashmemo_select="SELECT * FROM tbl_cashmemo WHERE cashmemo_id ='".$cashmemo_id."'";
		$rs_cashmemo_select=mysqli_query($con,$sql_cashmemo_select);
		$row_cashmemo_select=mysqli_fetch_array($rs_cashmemo_select);
		
		//fetch data for invoice detail
		$sql_cashmemo_detail_select = "select * from tbl_cashmemo_detail where cashmemo_id = '".$cashmemo_id."'";
		$rs_cashmemo_detail_select = mysqli_query($con , $sql_cashmemo_detail_select);
		$detail_row_num = mysqli_num_rows($rs_cashmemo_detail_select);
		
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
	$sql_invoice = "select max(pr.invoice_no) 'invoice_no' from tbl_cashmemo pr join tbl_financial_master fy on fy.financial_id = pr.financial_id where fy.is_default = 1";
	$rs_invoice = mysqli_query($con , $sql_invoice);
	$row_invoice = mysqli_fetch_array($rs_invoice);
	$invoice_no = $row_invoice['invoice_no'];
	if($invoice_no != '')
		$invoice_no = $invoice_no + 1;
	else
		$invoice_no = 1;
	
	
	function fnc_state($name)
	{
		global $row_cashmemo_select;
		
		if(isset($_GET['id']))
		{
			if($row_cashmemo_select['state_of_supply'] == $name)
			{echo "selected";}
		}
	}
	
	$new_inv_no = $setting->get_name('sales_return') . $row_financial_id['financial_year'];
	//`````````````````````````````````````````````````````````````INSERT CODE``````````````````````````````````````````````````````//
	if(isset($_POST['btn_save']) || isset($_POST['btn_save_n_print']))
	{
		if(isset($_POST['chk_is_round_off']))
            $chk_round_off =1;
        else
            $chk_round_off=0;
		//INSERT CODE
		$sql_cashmemo_invoice_iu = "insert into tbl_cashmemo (company_id,customer_name,customer_mobile,invoice_no,out_of_state,state_of_supply,cashmemo_date,payment_type_id,narration,sub_total,shipping_packing_amount,is_round_off,round_off,total,pay,financial_id,new_invoice_no,is_gst_bill) values('".$row_company_id['company_id']."' ,'".$_POST['txt_customer_name']."' ,'".$_POST['txt_customer_mobile']."' ,'".$_POST['txt_invoice_no']."','".$_POST['is_out_off_state']."' ,'".$_POST['cmb_state_of_supply']."' ,'".$_POST['txt_invoice_date']."' ,'".$_POST['cmb_payment_type']."' ,'".$_POST['txt_narration']."' ,'".$_POST['txt_sub_total']."' ,'".$_POST['txt_shipping_amt']."' ,'".$chk_round_off."' ,'".$_POST['txt_round_off']."' ,'".$_POST['txt_total_inv']."' ,'".$_POST['txt_pay']."' ,'".$row_financial_id['financial_id']."', '".$new_inv_no."' ,'".$row_product_setting['is_gst_bill']."') ";
		
		$rs_cashmemo_invoice_iu = mysqli_query($con , $sql_cashmemo_invoice_iu);
		
		if(! $rs_cashmemo_invoice_iu )
			die("data not inserted".mysqli_error($con));
			
		$inv_id =  mysqli_insert_id($con);
		//echo $inv_id;
		
		//payment_in 
		$objname = "cashmemo";
		$image="";
		
		if(!isset($_POST['txt_cheque_ref']))
			$txt_che = '';
		else
			$txt_che = $_POST['txt_cheque_ref'];
			
		$sql_payment_in = "insert into tbl_payment_in(company_id,financial_id,party_id,receipt_no,payment_type_id,cheque_ref_no,date,description,image,received,obj_name,obj_id) values('".$row_company_id['company_id']."','".$row_financial_id['financial_id']."','".$_POST['txt_customer_name']."','".$_POST['txt_invoice_no']."','".$_POST['cmb_payment_type']."','".$txt_che."','".$_POST['txt_invoice_date']."','".$_POST['txt_narration']."','".$image."','".$_POST['txt_pay']."','".$objname."','".$inv_id."')";
		$rs_payment_in = mysqli_query($con,$sql_payment_in);
		
		//company_ledger
		$debit=0.00;
		
		$sql_company_ledger="insert into tbl_company_ledger(company_id , related_id , related_obj_name,party_id ,date, details, credit, debit, financial_id, new_invoice_no) values('".$row_company_id['company_id']."' , '".$inv_id."' ,'".$objname."','".$_POST['txt_customer_name']."' , '".$_POST['txt_invoice_date']."' , '".$_POST['txt_narration']."' , '".$_POST['txt_pay']."','".$debit."','".$row_financial_id['financial_id']."','".$new_inv_no."')";
		$rs_company_ledger = mysqli_query($con,$sql_company_ledger);
		
		
		//total no of product find
		if(isset($_POST["txt_rate"][1]))
			$number = count($_POST["txt_rate"]);
		else
			$number = 1;
			$num = intval($number);
		echo " number ".$number;
		//exit;
		//inserting into detail tbl
		if($num > 0)  
		{  
			for($i=0; $i<$num; $i++) 
			{		
				if(trim($_POST["txt_rate"][$i] != '')) 		   
				{   echo "if for ka ";
					$sql_gst = "select igst from tbl_gstslab_master where gstslab_id = '".mysqli_real_escape_string($con, $_POST["txt_gst"][$i])."'";
					$rs_gst = mysqli_query($con ,$sql_gst);
					
					if(!$rs_gst)
						die("get fucked up".mysqli_error($con));
					
					$row_gst=mysqli_fetch_array($rs_gst);
					
					$igst_per = $row_gst['igst'];
					//echo $igst_per;
					
					$gst_per = $igst_per/2;
					//echo $gst_per;
					
					$gst = ((mysqli_real_escape_string($con, $_POST["txt_rate"][$i]) * mysqli_real_escape_string($con, $_POST["txt_quantity"][$i])) - mysqli_real_escape_string($con, $_POST["txt_discount_amt"][$i]) ) * ($gst_per/100);
					$igst = ((mysqli_real_escape_string($con, $_POST["txt_rate"][$i]) * mysqli_real_escape_string($con, $_POST["txt_quantity"][$i])) - mysqli_real_escape_string($con, $_POST["txt_discount_amt"][$i]) ) * ($igst_per/100);
					
					if($_POST['is_out_off_state'] == 1)
					{
						$gst_per = 0.00;
						$gst = 0.00;
					}
					else
					{
						$igst_per = 0.00;
						$igst = 0.00;
					}
					
					$sql_unit_select = "select unit_name from tbl_unit where unit_id = '".mysqli_real_escape_string($con, $_POST["product_unit"][$i])."'";
					$rs_unit_select = mysqli_query($con , $sql_unit_select);
					
					if(!$rs_unit_select)
						die("unit fucked up ".mysqli_error($con));
					
					$row_unit_select = mysqli_fetch_array($rs_unit_select);
					
					$sql_invoice_detail = "INSERT INTO tbl_cashmemo_detail(company_id , cashmemo_id,product_id,unit_id,unit,rate,qty,gross_total,disc_per,disc_amt,sub_total,gstslab_id,gst,gst_per,igst,igst_per,total,financial_id, new_invoice_no,serial_no,batch_no) VALUES('".$row_company_id['company_id']."' ,'".$inv_id."','".mysqli_real_escape_string($con, $_POST["txt_product"][$i])."', '".mysqli_real_escape_string($con, $_POST["product_unit"][$i])."' , '".$row_unit_select['unit_name']."' , '".mysqli_real_escape_string($con, $_POST["txt_rate"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_quantity"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_rate"][$i])."' * '".mysqli_real_escape_string($con, $_POST["txt_quantity"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_discount"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_discount_amt"][$i])."',('".mysqli_real_escape_string($con, $_POST["txt_rate"][$i])."' * '".mysqli_real_escape_string($con, $_POST["txt_quantity"][$i])."') - '".mysqli_real_escape_string($con, $_POST["txt_discount_amt"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_gst"][$i])."' ,'".$gst."','".$gst_per."' ,'".$igst."','".$igst_per."' , '".mysqli_real_escape_string($con, $_POST["txt_total"][$i])."' + '".$gst."' + '".$igst."' , '".$row_financial_id['financial_id']."' , '".$new_inv_no."','".mysqli_real_escape_string($con, $_POST["txt_serial_no"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_batch_no"][$i])."')";
					
					$rs_detail = mysqli_query($con, $sql_invoice_detail);  
					
					if(!$rs_detail)
						die("detail fucked up ".mysqli_error($con));
					
					
					echo "update in serial";
					if($_POST['txt_serial_no'] != '')
					{
						$var = explode("|",$_POST["txt_serial_no"][$i]);
						$len_var = sizeof($var);
						for($j = 0 ; $j< $len_var - 1 ; $j++)
						{
							$sql_serial = "UPDATE tbl_serial_no SET is_sold = 1 WHERE serial_no_id = '".$var[$j]."' ";
							$rs_serial = mysqli_query($con,$sql_serial);
							
							if(!$rs_serial)
							die("serial fucked up ".mysqli_error($con));
						}
					}
					
					if($_POST['txt_batch_no'] != '')
					{
						$sql_batch = "UPDATE tbl_batch_tracking SET qty = qty - ".$_POST['txt_quantity'][$i]." WHERE batch_tracking_id  = '".$_POST['txt_batch_no'][$i]."' ";
						$rs_batch = mysqli_query($con,$sql_batch);
					} 
					
					$sql_current_unit = "select * from tbl_unit_conversion where product_id = '".mysqli_real_escape_string($con, $_POST["txt_product"][$i])."' and secondary_unit_id = '".mysqli_real_escape_string($con, $_POST["product_unit"][$i])."' and is_default = 1";
					$rs_current_unit = mysqli_query($con , $sql_current_unit);
					
					if(!$rs_current_unit)
						die("cur unit fucked up ".mysqli_error($con));
					
					$num_current_unit = mysqli_num_rows($rs_current_unit);
					
					//just so when it doesnt go into if...i dont have to repeat the query....hehe
					$qty_for_stock = mysqli_real_escape_string($con, $_POST["txt_quantity"][$i]);
					
					if($num_current_unit > 0 )
					{
						$row_current_unit = mysqli_fetch_array($rs_current_unit);
						$qty_for_stock= mysqli_real_escape_string($con, $_POST["txt_quantity"][$i]) / $row_current_unit['rate'];
					}
					
					$sql_stock_cashmemo = "update tbl_product_master set closing_stock = (select closing_stock from tbl_product_master where product_id ='".mysqli_real_escape_string($con, $_POST["txt_product"][$i])."' ) - '".mysqli_real_escape_string($con, $_POST["txt_quantity"][$i])."' where product_id = '".mysqli_real_escape_string($con, $_POST["txt_product"][$i])."' ";
					$rs_stock_cashmemo = mysqli_query($con,$sql_stock_cashmemo);
					
					if(!$rs_stock_cashmemo)
						die("stock fucked up ".mysqli_error($con));
				}
			}
			if(!$rs_cashmemo_invoice_iu)
			{
			  die("data not inserted".mysqli_error($con));
			}
			else
			{
				if(isset($_POST['btn_save_n_print']))
					echo "<script>window.location.href='invoice.php?cashmemo_id=$inv_id';</script>";
				else
					echo "<script>window.location.href='cashmemo.php';</script>";
			}
		}	
	}
	//update code
	if(isset($_POST['btn_edit']) || isset($_POST['btn_update_n_print']))
	{
		//update tbl_cashmemo
		$objname = "cashmemo";	
		$img3 = "";		
		$sql_cashmemo_invoice_iu = "UPDATE tbl_cashmemo SET customer_name = '".mysqli_real_escape_string($con,$_POST['txt_customer_name'])."', customer_mobile = '".mysqli_real_escape_string($con,$_POST['txt_customer_mobile'])."',state_of_supply ='".$_POST['cmb_state_of_supply']."',cashmemo_date = '".$_POST['txt_invoice_date']."' , payment_type_id = '".$_POST['cmb_payment_type']."', narration= '".$_POST['txt_narration']."', sub_total = '".$_POST['txt_sub_total']."', shipping_packing_amount= '".$_POST['txt_shipping_amt']."' , is_round_off = '".$_POST['chk_is_round_off']."', round_off = '".$_POST['txt_round_off']."' , total = '".$_POST['txt_total_inv']."', pay = '".$_POST['txt_pay']."' , new_invoice_no ='".$new_inv_no."', is_gst_bill = '".$row_product_setting['is_gst_bill']."' WHERE cashmemo_id = '".$cashmemo_id."'";
		
		$rs_cashmemo_invoice_update = mysqli_query($con , $sql_cashmemo_invoice_iu);

		$inv_id = $cashmemo_id;
		
		$sql_payment_in_update = "update tbl_payment_in set company_id ='".$row_company_id['company_id']."',financial_id='".$row_financial_id['financial_id']."',party_id='".$_POST['txt_customer_name']."',payment_type_id='".$_POST['cmb_payment_type']."',date='".$_POST['txt_invoice_date']."',description='".$_POST['txt_narration']."',image='".$img3."',received='".$_POST['txt_pay']."',obj_name='".$objname."',obj_id = '".$cashmemo_id."' where party_id ='".$_POST['txt_customer_name']."' and obj_name = '".$objname."' and obj_id = '".$cashmemo_id."' ";
		$rs_payment_in_update = mysqli_query($con,$sql_payment_in_update);		
				
		//company_ledger
		
		$objname = "cashmemo";
		$debit=0.00;
		
		$sql_company_ledger="update tbl_company_ledger set company_id = '".$row_company_id['company_id']."',related_id = '".$_POST['cashmemo_id']."',related_obj_name='".$objname."',party_id = '".$_POST['txt_customer_name']."',date = '".$_POST['txt_invoice_date']."' ,details = '".$_POST['txt_narration']."' , credit = '".$_POST['txt_pay']."' , debit = '".$debit."',financial_id = '".$row_financial_id['financial_id']."' where related_id = '".$_POST['cashmemo_id']."' and related_obj_name = '".$objname."' ";
		$rs_company_ledger = mysqli_query($con,$sql_company_ledger);
			
		if(isset($_POST["txt_rate"][1]))
			$number = count($_POST["txt_rate"]);
		else
			$number = 1;
		
		if($number > 0)  
		{  
		  for($i=0; $i<$number; $i++)  
		  {  
				$sql_unit_select = "select * from tbl_unit where unit_id = '".mysqli_real_escape_string($con, $_POST["product_unit"][$i])."'";
				$rs_unit_select = mysqli_query($con , $sql_unit_select);
				$row_unit_select = mysqli_fetch_array($rs_unit_select);
				
				$sql_gst = "select igst from tbl_gstslab_master where gstslab_id = '".mysqli_real_escape_string($con, $_POST["txt_gst"][$i])."'";
				$rs_gst = mysqli_query($con ,$sql_gst);
				$row_gst=mysqli_fetch_array($rs_gst);
				
				$igst_per = $row_gst['igst'];
				$gst_per = $igst_per/2;
				$igst = ((mysqli_real_escape_string($con, $_POST["txt_rate"][$i]) * mysqli_real_escape_string($con, $_POST["txt_quantity"][$i])) - mysqli_real_escape_string($con, $_POST["txt_discount_amt"][$i]) ) * ($igst_per/100);
				$gst = ((mysqli_real_escape_string($con, $_POST["txt_rate"][$i]) * mysqli_real_escape_string($con, $_POST["txt_quantity"][$i])) - mysqli_real_escape_string($con, $_POST["txt_discount_amt"][$i]) ) * ($gst_per/100);
				
				if($_POST['is_out_off_state'] == 1){
					$gst_per = 0.00;
					$gst = 0.00;
				}
				else{
					$igst_per = 0.00;
					$igst = 0.00;
				}
				
			$sql_current_unit = "select * from tbl_unit_conversion where product_id = '".mysqli_real_escape_string($con, $_POST["txt_product"][$i])."' and secondary_unit_id = '".mysqli_real_escape_string($con, $_POST["product_unit"][$i])."' and is_default = 1";
			$rs_current_unit = mysqli_query($con , $sql_current_unit);
			$num_current_unit = mysqli_num_rows($rs_current_unit);
			
			//just so when it doesnt go into if...i dont have to repeat the query....hehe
			$qty_for_stock = mysqli_real_escape_string($con, $_POST["txt_quantity"][$i]);
			
			if($num_current_unit > 0 )
			{
				$row_current_unit = mysqli_fetch_array($rs_current_unit);
				$qty_for_stock= mysqli_real_escape_string($con, $_POST["txt_quantity"][$i]) / $row_current_unit['rate'];
			}
			
		   if(trim($_POST["cashmemo_detail_id"][$i] == '')) 		   
		   {  
				$sql_invoice_detail = "INSERT INTO tbl_cashmemo_detail(company_id , cashmemo_id,product_id,unit_id,unit,rate,qty,gross_total,disc_per,disc_amt,sub_total,gstslab_id,gst,gst_per,igst,igst_per,total,financial_id,new_invoice_no,serial_no,batch_no) VALUES('".$row_company_id['company_id']."' ,'".$_POST['cashmemo_id']."','".mysqli_real_escape_string($con, $_POST["txt_product"][$i])."', '".mysqli_real_escape_string($con, $_POST["product_unit"][$i])."' , '".$row_unit_select['unit_name']."' , '".mysqli_real_escape_string($con, $_POST["txt_rate"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_quantity"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_rate"][$i])."' * '".mysqli_real_escape_string($con, $_POST["txt_quantity"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_discount"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_discount_amt"][$i])."',('".mysqli_real_escape_string($con, $_POST["txt_rate"][$i])."' * '".mysqli_real_escape_string($con, $_POST["txt_quantity"][$i])."') - '".mysqli_real_escape_string($con, $_POST["txt_discount_amt"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_gst"][$i])."' , '".$gst."' , '".$gst_per."' , '".$igst."' , '".$igst_per."' , '".mysqli_real_escape_string($con, $_POST["txt_total"][$i])."' + '".$gst."' + '".$igst."' , '".$row_financial_id['financial_id']."' , '".$new_inv_no."' , '".mysqli_real_escape_string($con, $_POST["txt_serial_no"][$i])."' , '".mysqli_real_escape_string($con, $_POST["txt_batch_no"][$i])."')";
				
				mysqli_query($con, $sql_invoice_detail);  
				
				$sql_stock_cashmemo = "update tbl_product_master set closing_stock = (select closing_stock from tbl_product_master where product_id ='".mysqli_real_escape_string($con, $_POST["txt_product"][$i])."' ) - '".$qty_for_stock."' where product_id = '".mysqli_real_escape_string($con, $_POST["txt_product"][$i])."' ";
				
				//echo $sql_stock_cashmemo;
				//echo "<br>";
				$rs_stock_cashmemo = mysqli_query($con,$sql_stock_cashmemo);
		   }
			else
			{
				$sql_invoice_detail = "UPDATE tbl_cashmemo_detail SET unit_id = '".mysqli_real_escape_string($con, $_POST["product_unit"][$i])."' , unit = '".$row_unit_select['unit_name']."' , rate = '".mysqli_real_escape_string($con, $_POST["txt_rate"][$i])."' , qty= '".mysqli_real_escape_string($con, $_POST["txt_quantity"][$i])."' , gross_total = '".mysqli_real_escape_string($con, $_POST["txt_rate"][$i])."' * '".mysqli_real_escape_string($con, $_POST["txt_quantity"][$i])."' , disc_per = '".mysqli_real_escape_string($con, $_POST["txt_discount"][$i])."' , disc_amt = '".mysqli_real_escape_string($con, $_POST["txt_discount_amt"][$i])."' , sub_total = ('".mysqli_real_escape_string($con, $_POST["txt_rate"][$i])."' * '".mysqli_real_escape_string($con, $_POST["txt_quantity"][$i])."') - '".mysqli_real_escape_string($con, $_POST["txt_discount_amt"][$i])."' , gstslab_id = '".mysqli_real_escape_string($con, $_POST["txt_gst"][$i])."' , gst = '".$gst."' , gst_per = '".$gst_per."' , igst = '".$igst."' , igst_per = '".$igst_per."' , total = '".mysqli_real_escape_string($con, $_POST["txt_total"][$i])."' + '".$gst."' + '".$igst."' , new_invoice_no = '".$new_inv_no."' , batch_no = '".mysqli_real_escape_string($con, $_POST["txt_batch_no"][$i])."', serial_no = '".mysqli_real_escape_string($con, $_POST["txt_serial_no"][$i])."' WHERE cashmemo_detail_id= '".mysqli_real_escape_string($con, $_POST["cashmemo_detail_id"][$i])."' ";
				//echo $sql_invoice_detail;
			
				//to fetch old unit for secondary unit ......really sucks
				$sql_stock_update = "select * from tbl_cashmemo_detail where cashmemo_detail_id = '".mysqli_real_escape_string($con, $_POST["cashmemo_detail_id"][$i])."'";
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
				
				$sql_update_stock_for_old = "update tbl_product_master set closing_stock = (select closing_stock from tbl_product_master where product_id = '".$row_stock_update['product_id']."') + '".$qty_update_fetch."' - '".$qty_for_stock."'where product_id = '".$row_stock_update['product_id']."'";
				//echo $sql_update_stock_for_old;
				//echo "<br>";
				
				mysqli_query($con , $sql_update_stock_for_old);
				
				mysqli_query($con, $sql_invoice_detail); 
			}			
		  }
			if(!$rs_cashmemo_invoice_update)
			{
			  die("data not Updated".mysqli_error($con));
			}
			else
			{
				if(isset($_POST['btn_update_n_print']))
					echo "<script>window.location.href='invoice.php?cashmemo_id=$cashmemo_id';</script>";
				else
					echo "<script>window.location.href='cashmemo.php';</script>";
			}
		}  
		else  
		{  
		  echo "Please Enter Name";  
		}		  
		
	}
?>

<script>
var no_of_detail_row = "<?php echo $detail_row_num; ?>";
var serial_key;
var batch_key;
var swit = 0 ;
	
	function tot()
	{
		let prd_qty = document.getElementsByName("txt_quantity[]");
		let prd_disc = document.getElementsByName("txt_discount[]");
		let prd_rate = document.getElementsByName("txt_rate[]");
        let total_val = 0;
		let qty_val = 1;
		let rate_val = 0;
		let disc_amt = 0;
		let disc_ratio = 0;
		let sub_total = 0.00;
		
		
		for(let i=0; i<prd_qty.length ; i++)
		{	
			if(prd_rate.value == 0 || prd_qty.value == 0 )
			{
				return;
			}
			
			total_val = prd_qty[i].valueAsNumber * prd_rate[i].valueAsNumber ;
			
			if(prd_disc[i].value != '' || prd_disc[i].value != 0)
			{
				disc_ratio = prd_disc[i].valueAsNumber / 100 ;
				disc_amt = total_val * disc_ratio;
				document.getElementsByName("txt_discount_amt[]")[i].value = disc_amt.toFixed(2);
				total_val = total_val - disc_amt;
			}
			if(document.getElementById('is_out_off_state').value == 1)
			{
				document.getElementsByName("txt_total[]")[i].value = parseFloat(total_val.toFixed(2)) + (parseFloat(document.getElementsByName('txt_cgst[]')[i].value) * parseFloat(2) * parseFloat(total_val.toFixed(2)) / parseFloat(100));
			}
			else
			{
				document.getElementsByName("txt_total[]")[i].value = parseFloat(total_val.toFixed(2)) + (parseFloat(document.getElementsByName('txt_cgst[]')[i].value) * parseFloat(total_val.toFixed(2)) / parseFloat(100));
			}
			sub_total += total_val;
			document.getElementsByName("txt_total[]")[i].valueAsNumber = total_val.toFixed(2);
			
		}
		document.getElementById("txt_sub_total").value = sub_total.toFixed(2);
		//console.log(sub_total);
		fnc_calculate_total();
	}
	
	function fnc_calculate_total()
	{
		var txt_round = document.getElementById("txt_round_off");
		var gtotal = document.getElementById("txt_gtotal");
		var total_inv = document.getElementById("txt_total_inv");
		var chk = document.getElementById("chk_is_round_off");
		var sub_total = document.getElementById("txt_sub_total").valueAsNumber ;
		var shipping_amt = document.getElementById("txt_shipping_amt").valueAsNumber;
		var round_total = 0;
		var r_off =0;
		var temp = 0.00;
		
		temp  = sub_total + shipping_amt ;
		gtotal.value = temp.toFixed(2);
		round_total = Math.ceil(gtotal.value);
		r_off = round_total - gtotal.value;
		//console.log(round_total);
		txt_round.readOnly = true;
		
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
		var prd_len = document.getElementsByName("txt_product[]").length;
		var prd_detail_id = document.getElementsByName("cashmemo_detail_id[]");
		var prd = document.getElementsByName("txt_product[]");
		let is_batc = <?php echo $setting->get_name('is_show_batch'); ?>;
        let is_seria = <?php echo $setting->get_name('is_show_serial'); ?>;
		
		//console.log(prd_len);
		var id = e.value;
		//console.log(id);
	 if(id != '')
	  {
		//e.closest('#product_unit').remove();
		
		$.ajax({  
			url:"cashmemo_ajax.php",
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
						var un = document.getElementsByName("product_unit[]")[i];
						document.getElementsByName('txt_serial_no[]')[i].value = '';
						un.options.length=0;
						
						//console.log(data);
						//checkin if both unit are absent
						document.getElementsByName('share_rate[]')[i].value = 0;
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
						
						//un.options[un.options.length]= new Option(data.secondary_unit, data.secondary_unit_id);
						//un.append('<option value = "'+data.primary_unit_id+'">'+data.primary_unit+'</option>');
						//un.append('<option value = "'+data.secondary_unit_id+'">'+data.secondary_unit+'</option>');
						// to prevent over write the rate of product while edit
						
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
						if(prd_detail_id[i].value == '')
						{
							document.getElementsByName("txt_gst[]")[i].value = data.gstslab_id;
							document.getElementsByName("txt_rate[]")[i].value = data.sales_rate;
						}
						//console.log(data.sales_rate);
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
		var e = document.getElementById("txt_customer_name");
		var temp = $('#cmb_state_of_supply').val();
		var state = "<?php echo $row_company_id['state']; ?>";
  
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
		var e = document.getElementById("txt_customer_name");
		var state = "<?php echo $row_company_id['state']; ?>";
		//console.log("hello");
		//console.log(e.value);
		
		if(e.value != '')
		{
			$.ajax({ 
				url: 'cashmemo_ajax.php',
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
	
	function fnc_unit_change(e)
	{
		var prd_len = document.getElementsByName("txt_product[]").length;
		var prd = document.getElementsByName("txt_product[]") ;
		var id = e.value;
		  
		$.ajax({  
			url:"cashmemo_ajax.php",
			type:"POST",  
			data:{ 'id' : id , 'edit_unit_fetch' : 1 },
			dataType :'json',
			success:function(data)  
			{  
				//console.log("inside success");
				for(i=0;i<prd_len;i++)
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
  
	function fnc_chk_serial(e)
	{
		if(e.checked == 1)
		{
			//console.log('checked');
			//console.log(e.value);
			//console.log(document.getElementsByName('txt_product[]')[serial_key].value);
			
			var val_of_current_checked_serial = e.value;
			
			document.getElementsByName('txt_serial_no[]')[serial_key].value = val_of_current_checked_serial.concat('|',document.getElementsByName('txt_serial_no[]')[serial_key].value);
			
			var my_arr_of_serial = document.getElementsByName('txt_serial_no[]')[serial_key].value.split('|');
			//console.log(my_arr_of_serial.length - 1);
			
			if(document.getElementsByName("txt_quantity[]")[serial_key].value == '')
				document.getElementsByName("txt_quantity[]")[serial_key].value =  1; 
			else
			document.getElementsByName("txt_quantity[]")[serial_key].value = parseInt(document.getElementsByName("txt_quantity[]")[serial_key].value) + 1; 
		}
		else
		{
			//console.log('unchecked');
			document.getElementsByName('txt_serial_no[]')[serial_key].value = document.getElementsByName('txt_serial_no[]')[serial_key].value.replace(e.value+'|','');
			document.getElementsByName("txt_quantity[]")[serial_key].value = parseInt(document.getElementsByName("txt_quantity[]")[serial_key].value) - 1; 
		}
	}
	
	function fnc_chk_batch(e)
	{
		if(e.checked == 1)
		{
			for(i=0;i<document.getElementsByName('txt_batch_tracking_id[]').length;i++)
			{
				if(e==document.getElementsByName('txt_batch_tracking_id[]')[i])
				{
					document.getElementsByName('alloted_qty[]')[i].disabled = false;
				}
			}
			if(document.getElementsByName('txt_batch_no[]')[batch_key].value == '')
			{
				document.getElementsByName('txt_batch_no[]')[batch_key].value = e.value;
			}
			else
			{
				$('#dynamic_field').append('<tr id="row"><td><div class="form-group"><input type="number" oninput="barcode_data(this)" name="barcode_id[]" id="barcode_id" class = "form-control" value = ""/></div>	</td><td><div class="form-group"><select class="form-control"  id="txt_product" name="txt_product[]" onchange="fnc_unit(this);fnc_style_remove(this);" placeholder = "select Product"><option value = "">--select--</option><?php $sql_autocomplete = "SELECT pm.*,ut.unit_name FROM tbl_product_master pm left join tbl_company tc on tc.company_id = pm.company_id left join tbl_unit ut on ut.unit_id= pm.unit_id where tc.is_default = 1";$rs_autocomplete = mysqli_query($con , $sql_autocomplete);while($row_autocomplete = mysqli_fetch_array($rs_autocomplete)){?><option value="<?php echo $row_autocomplete["product_id"];?>"><?php echo $row_autocomplete["product_name"];?>(<?php echo $row_autocomplete["unit_name"];?>)</option> <?php } ?></select></div></td><?php if($setting->get_name('is_show_serial') == 1) { ?><td><div class="form-group"><a id="link_serial" onclick="fnc_serial_find(this);" name = "link_serial[]" class="form-control" data-toggle="modal" data-target="#serial">Serial</a></div></td> <?php } ?><?php if($setting->get_name('is_show_batch') == 1) { ?><td><div class="form-group"><a href = "#" id="link_batch" name="link_batch[]" onclick="fnc_batch_find(this);" class="form-control"  data-toggle="modal" data-target="#batch">Batch</a></div></td> <?php } ?><td><div class="form-group"><select class="form-control" id="product_unit" name="product_unit[]" onchange="fnc_rate_update(this);"></select></div></td><td><div class="form-group"><input type="number" id="txt_quantity" name="txt_quantity[]" step="0.001" oninput = "fnc_qty_serial_count(this)" value = "" onchange = "tot();fnc_style_remove(this)" class="form-control" placeholder="Enter QUANTITY" ><input type="hidden" id="share_rate" name="share_rate[]"></div></td><td><div class="form-group"><input type="number" id="txt_rate" name="txt_rate[]" step="0.01" onchange = "tot();fnc_style_remove(this);" class="form-control" placeholder="Enter rate" ></div></td><td><div class="form-group"><input type="number" id="txt_discount[]" name="txt_discount[]" step="0.01" onchange = "tot();fnc_style_remove(this);" class="form-control" placeholder="Enter discount" value = 0 ></div></td><td><div class="form-group"><select id="txt_gst" name="txt_gst[]" class="form-control" onchange="fnc_style_remove(this);"><option value = "">--select--</option><?php $sql_gst="SELECT gst.* FROM tbl_gstslab_master gst LEFT JOIN tbl_company com ON com.company_id  = gst.company_id  WHERE com.is_default = 1 "; $rs_gst = mysqli_query($con,$sql_gst); while($row_gst=mysqli_fetch_array($rs_gst)){ ?><option value="<?php echo $row_gst["gstslab_id"]; ?>"><?php echo $row_gst["gstslab_name"]; ?></option><?php } ?></select></div></td>	<td><div class="form-group"><input type="number" id="txt_total[]" name="txt_total[]" step="0.01" readonly = "true" class="form-control" placeholder="Enter TOTAL" ></div></td><td><input type="hidden" name="txt_discount_amt[]" id="txt_discount_amt"/><input type="hidden" name="txt_serial_no[]" id="txt_serial_no" value = "" > <input type="hidden" name="txt_batch_no[]" id="txt_batch_no" value="" ><input type="hidden" name="cashmemo_detail_id[]" id="cashmemo_detail_id" value="" /> <button type="button" name="btn_remove" id="btn_remove" class="btn btn-danger btn_remove">X</button></td></tr>');
				
				document.getElementsByName('txt_product[]')[document.getElementsByName('txt_product[]').length - 1].value = document.getElementsByName('txt_product[]')[batch_key].value;
				document.getElementsByName('txt_batch_no[]')[document.getElementsByName('txt_batch_no[]').length - 1].value = e.value;
				fnc_unit(document.getElementsByName('txt_product[]')[document.getElementsByName('txt_product[]').length - 1]);
			}
		}
		else
		{
			for(i=0;i<document.getElementsByName('txt_batch_tracking_id[]').length;i++)
			{
				if(e==document.getElementsByName('txt_batch_tracking_id[]')[i])
				{
					document.getElementsByName('alloted_qty[]')[i].value = '';
					document.getElementsByName('alloted_qty[]')[i].disabled = true;
				}
			}
			//console.log('unchecked');
			var bat = document.getElementsByName('txt_batch_no[]');
			if(bat.length < 2)
			{
				$('#dynamic_field').append('<tr id="row"><td><div class="form-group"><input type="number" oninput="barcode_data(this)" name="barcode_id[]" id="barcode_id" class = "form-control" value = ""/></div>	</td><td><div class="form-group"><select class="form-control"  id="txt_product" name="txt_product[]" onchange="fnc_unit(this);fnc_style_remove(this);" placeholder = "select Product"><option value = "">--select--</option><?php $sql_autocomplete = "SELECT pm.*,ut.unit_name FROM tbl_product_master pm left join tbl_company tc on tc.company_id = pm.company_id left join tbl_unit ut on ut.unit_id= pm.unit_id where tc.is_default = 1";$rs_autocomplete = mysqli_query($con , $sql_autocomplete);while($row_autocomplete = mysqli_fetch_array($rs_autocomplete)){?><option value="<?php echo $row_autocomplete["product_id"];?>"><?php echo $row_autocomplete["product_name"];?>(<?php echo $row_autocomplete["unit_name"];?>)</option> <?php } ?></select></div></td><?php if($setting->get_name('is_show_serial') == 1) { ?><td><div class="form-group"><a id="link_serial" onclick="fnc_serial_find(this);" name = "link_serial[]" class="form-control" data-toggle="modal" data-target="#serial" style="pointer-events: none;">Serial</a></div></td> <?php } ?><?php if($setting->get_name('is_show_batch') == 1) { ?><td><div class="form-group"><a id="link_batch" name="link_batch[]" onclick="fnc_batch_find(this);" class="form-control"  data-toggle="modal" data-target="#batch" style="pointer-events: none;" >Batch</a></div></td> <?php } ?><td><div class="form-group"><select class="form-control" id="product_unit" name="product_unit[]" onchange="fnc_rate_update(this);"></select></div></td><td><div class="form-group"><input type="number" id="txt_quantity" name="txt_quantity[]" step="0.001" value = "" oninput = "fnc_qty_serial_count(this)" onchange = "tot();fnc_style_remove(this);" class="form-control" placeholder="Enter QUANTITY" ><input type="hidden" id="share_rate" name="share_rate[]"></div></td><td><div class="form-group"><input type="number" id="txt_rate" name="txt_rate[]" step="0.01" onchange = "tot();fnc_style_remove(this);" class="form-control" placeholder="Enter rate" ></div></td><td><div class="form-group"><input type="number" id="txt_discount[]" name="txt_discount[]" step="0.01" onchange = "tot();fnc_style_remove(this);" class="form-control" placeholder="Enter discount" value = 0 ></div></td><td><div class="form-group"><select id="txt_gst" name="txt_gst[]" class="form-control" onchange="fnc_style_remove(this);"><option value = "">--select--</option><?php $sql_gst="SELECT gst.* FROM tbl_gstslab_master gst LEFT JOIN tbl_company com ON com.company_id  = gst.company_id  WHERE com.is_default = 1 "; $rs_gst = mysqli_query($con,$sql_gst); while($row_gst=mysqli_fetch_array($rs_gst)){ ?><option value="<?php echo $row_gst["gstslab_id"]; ?>"><?php echo $row_gst["gstslab_name"]; ?></option><?php } ?></select></div></td>	<td><div class="form-group"><input type="number" id="txt_total[]" name="txt_total[]" step="0.01" readonly = "true" class="form-control" placeholder="Enter TOTAL" ></div></td><td><input type="hidden" name="txt_discount_amt[]" id="txt_discount_amt"/><input type="hidden" name="txt_serial_no[]" id="txt_serial_no" value = "" > <input type="hidden" name="txt_batch_no[]" id="txt_batch_no" value="" ><input type="hidden" name="cashmemo_detail_id[]" id="cashmemo_detail_id" value="" /> <button type="button" name="btn_remove" id="btn_remove" class="btn btn-danger btn_remove">X</button></td></tr>');
				
				
			}
			for(i=0;i<bat.length;i++)
			{
				if(e.value == bat[i].value)
				{
					bat[i].closest('tr').remove();
					break;
				}
			}
			
		}
	}
	
	function fnc_batch_find(e)
	{
		//console.log('batch clicked');
		var bat = document.getElementsByName('link_batch[]');
		var prd = document.getElementsByName('txt_product[]');
		var prd_batch = 0;
		
		for(i=0;i<bat.length;i++)
		{
			if(e == bat[i])
			{
				//console.log(prd[i].value);
				//console.log(i+"th batch");
				
				batch_key = i;
				prd_batch = document.getElementsByName('txt_product[]')[batch_key].value;
				//console.log(prd_batch);
				//alert(batch_key);
				//console.log(i+"th batch");
				$.ajax({  
					url:"cashmemo_ajax.php",
					type:"POST", 
					/* dataType:'json', */  
					data:{ 'id' : prd[i].value , 'batch_fill' : 1 },
					success:function(data)  
					{  
						const obj = JSON.parse(data);
						$('#batch_body').html('');
						//console.log(data);
					
						for(i=0 ; i < obj.length ; i++)
						{
							$('#batch_body').append("<tr id='row_batch'><td align='center'><input type='checkbox' id='txt_batch_tracking_id'name='txt_batch_tracking_id[]' onchange = 'fnc_chk_batch(this);' value='"+obj[i].batch_tracking_id+"'> </td> <td align='center'><input type = 'number' class='form-control' id='txt_mrp' name='txt_mrp[]' value = '"+obj[i].mrp_price+"' readonly style='background-color:white; color:black; border:0px;' ></td><td align='center'><label class='control-label' id='batch_no' name='batch_no[]' >"+obj[i].batch_no+"</label></td><td align='center'><label class='control-label' id='txt_mfg_date' name='txt_mfg_date[]' >"+obj[i].mfg_date+"</label></td><td align='center'><label class='control-label' id='txt_exp_date' name='txt_exp_date[]'>"+obj[i].exp_date+"</label></td><td align='center'><label class='control-label' id='txt_model_no' name='txt_model_no[]' >"+obj[i].model_no+"</label></td><td align='center'>	<label class='control-label' id='txt_size' name='txt_size[]' >"+obj[i].size+"</label></td><td align='center'><input type = 'number'  id='txt_batch_qty' name='txt_batch_qty[]' class = 'form-control' readonly style='background-color:white; color:black; border:0px;' value = '"+obj[i].quantity+"'></td>	<td align='center'><input type='number' id='alloted_qty' class = 'form-control' name='alloted_qty[]' placeholder='Enter quantity' value='' disabled oninput='batch_qty(this);' ></td></tr>");
						}
						
						//check for batch...if the product is same and has a batchtracking id...which is same  as the id from the modal chkbox chk that damn thing
						
						for(i=0;i<document.getElementsByName('txt_product[]').length;i++)
						{
							if(document.getElementsByName('txt_product[]')[i].value == prd_batch && document.getElementsByName('txt_batch_no[]')[i] != '')
							{
								for(k=0;k<document.getElementsByName('txt_batch_tracking_id[]').length;k++)
								{
									if(document.getElementsByName('txt_batch_no[]')[i].value == document.getElementsByName('txt_batch_tracking_id[]')[k].value)
									{
										document.getElementsByName('txt_batch_tracking_id[]')[k].checked = true;
										document.getElementsByName('alloted_qty[]')[k].value = document.getElementsByName('txt_quantity[]')[i].value ;
										document.getElementsByName('alloted_qty[]')[k].disabled = false;
										break;
									}
								}
							}
						}
					}
				});
				break;
			}
			//if end
		}
		//for end
	}
	
	function batch_qty(e)
	{
		var pop_bat = document.getElementsByName('txt_batch_tracking_id[]');
		var prd = document.getElementsByName('txt_product[]');
		var bat_id = document.getElementsByName('txt_batch_no[]');
		
		for(i = 0 ; i < pop_bat.length ; i++)
		{
			if(e == document.getElementsByName('alloted_qty[]')[i])
			{
				var qty = document.getElementsByName('txt_batch_qty[]')[i].value;
				//console.log(parseInt(qty));
				
					for(j=0;j<prd.length;j++)
					{
						if(bat_id[j].value == pop_bat[i].value)
						{
							if(parseInt(qty) < document.getElementsByName('alloted_qty[]')[i].value)
							{
								document.getElementsByName('txt_quantity[]')[j].value = parseInt(qty);
								document.getElementsByName('alloted_qty[]')[i].value = parseInt(qty); 
							}
							else
							{
								document.getElementsByName('txt_quantity[]')[j].value = e.value;
							}
								document.getElementsByName('txt_rate[]')[j].value  = document.getElementsByName('txt_mrp[]')[i].value;
							break;
						}
					}
			}
			
		}
	}
	
	function fnc_serial_find(e)
	{
		var sr = document.getElementsByName('link_serial[]');
		var prd = document.getElementsByName('txt_product[]');
		
		for(i=0;i<sr.length;i++)
		{
			if(e == sr[i])
			{
				serial_key = i;
				
				//alert(serial_key);
				//console.log(i+"th serial");
				$.ajax({  
					url:"cashmemo_ajax.php",
					type:"POST", 
					/* dataType:'json', */  
					data:{ 'id' : prd[i].value , 'serial_fill' : 1 },
					success:function(data)  
					{  
						const obj = JSON.parse(data);
						$('#serial_body').html('');
						//console.log(data);
						
						//var my_arr_of_serial = document.getElementsByName('txt_serial_no[]')[serial_key].value.split('|');
						//var my_arr_len = my_arr_of_serial.length;
						for(i=0 ; i < obj.length ; i++)
						{
							if(document.getElementsByName('txt_serial_no[]')[serial_key].value.includes(obj[i].serial_no_id))
							{
								//console.log('yes');
								//if the checkbox was checked previously..then check it
								$('#serial_body').append("<tr id='row_serial'><td align='center'><input type='checkbox' id='serial_no_id' name='serial_no_id[]' onchange = 'fnc_chk_serial(this);' value = '"+obj[i].serial_no_id+"' checked></td><td align='center'><label class = 'control-label' id='txt_serial' name='txt_serial[]' value = '"+obj[i].serial_no+"' >"+obj[i].serial_no+"</label></td></tr>");
							}
							else
							{
								//otherwise from the cmt above...too lazy to write it again
								$('#serial_body').append("<tr id='row_serial'><td align='center'><input type='checkbox' id='serial_no_id' name='serial_no_id[]' onchange = 'fnc_chk_serial(this);' value = '"+obj[i].serial_no_id+"'></td><td align='center'><label class = 'control-label' id='txt_serial' name='txt_serial[]' value = '"+obj[i].serial_no+"' >"+obj[i].serial_no+"</label></td></tr>");
							}
							
						}
					}
				});
			}
		}
		
	}
	
	function fnc_qty_serial_count(e)
	{
		for(i=0;i<document.getElementsByName('txt_product[]').length;i++)
		{
			if(e == document.getElementsByName('txt_quantity[]')[i])
			{
				if(document.getElementsByName('txt_serial_no[]')[i] != '')
				{
					var a = document.getElementsByName('txt_serial_no[]')[i].value.split('|').length - 1;
					//console.log(a);
					
					if(a > document.getElementsByName('txt_quantity[]')[i].value)
					{
						var prd = document.getElementsByName("txt_product[]")[i];
						var prd_text = prd.options[prd.selectedIndex].text;
						
						alert('QUANTITY cant be less than SELECTED Serial in '+prd_text);
						document.getElementsByName('txt_quantity[]')[i].value = a;
					}
				}
			}
		}
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
			url:"cashmemo_ajax.php",  
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

	function fnc_payment_type_text()
{
  var val_payment = $("#cmb_payment_type option:selected").text();
  
  if(val_payment == 'cheque' )
    $("#dynamic_ref").show();
  else
    $("#dynamic_ref").hide();
}

	function barcode_data(e)
	{
		barcode_no = e.value;
		if(barcode_no == '' )
		{
			e.style ="none";
			return;
		}

		if(barcode_no.length < 13 || barcode_no.length > 13)
		{
			e.style.borderColor="#FF0000";
			return;
		}
		$.ajax({  
			url:"cashmemo_ajax.php",  
			type:"POST",  
			data:{ 'id' : barcode_no ,'barcode' :1 },
			datatype:'json',
			async:false,
			success:function(data)
				{
					const obj = JSON.parse(data);
					//document.getElementById('barcode_no').style ="none"
					let prd = document.getElementsByName('txt_product[]');
					let index = 0;

					for( let x = 0; x < prd.length ; x++)
						if(e == document.getElementsByName('barcode_id[]')[x])
						{
							index = x;
							break;
						}
					
					if(obj.Fail != 0)
					{
						document.getElementsByName('barcode_id[]')[index].style.borderColor="#FF0000";
						document.getElementsByName('btn_remove')[index].click();
						return true;
					}

					document.getElementsByName('txt_product[]')[index].value = obj.product_name;
					document.getElementsByName('barcode_id[]')[index].style = 'none';
					document.getElementsByName('txt_quantity[]')[index].value = 1;
					fnc_unit(prd[index]);
					$('#btn_add').click();
				}
		});
	}
	
//validation 
function fnc_validation()
{
	let txt_customer_name = document.getElementById('txt_customer_name').value;
	let txt_invoice_date = document.getElementById('txt_invoice_date').value;
	let txt_product = document.getElementsByName('txt_product[]');
    let txt_quantity = document.getElementsByName('txt_quantity[]');
    let txt_rate = document.getElementsByName('txt_rate[]');
    let txt_discount = document.getElementsByName('txt_discount[]');
    let txt_gst = document.getElementsByName('txt_gst[]');
	
	var name_valid = /^[A-Za-z ]+$/; 
	var mono_valid = /^\d{10}$/;
	var today = new Date();
	var given_date = new Date(txt_invoice_date);
	
	//validation for party type
	if(txt_customer_name == '')
	{
		$('#txt_customer_name').after('<span class="error_company" style="color:red; font-size:15px;">Please Enter Customer Name!</span>');
		document.getElementById("txt_customer_name").focus();
		return false;
	}
	if(!txt_customer_name.match(name_valid))
	{
		$('#txt_customer_name').after('<span class="error_company" style="color:red; font-size:12px;">Please Enter Valid Name!</span>');
		document.getElementById("txt_customer_name").focus();
		return false;
	}
	
	//validation of mobile no
	if(txt_customer_mobile =='')
	{
		$('#txt_customer_mobile').after('<span class="error_company" style="color:red; font-size:12px;">Mobile No Is Required!</span>');
		document.getElementById("txt_customer_mobile").focus();
		return false;
	}
	if(!txt_customer_mobile.match(mono_valid))
	{
		$('#txt_customer_mobile').after('<span class="error_company" style="color:red; font-size:12px;">Please Enter Valid Mobile No!</span>');
		document.getElementById("txt_customer_mobile").focus();
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

#barcode_id::-webkit-inner-spin-button{
    -webkit-appearance: none;    
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
			CASHMEMO
		</div>
			<div class="panel-wrapper collapse in" aria-expanded="true">
				<div class="panel-body">
					<form  method="post" name="add_name" id = "add_name" enctype="multipart/form-data">
						<div class="form-body">		
							<div class="row">
								<div class="col-md-3">
									<div class="form-group" id = "switch_party">
										<label class="control-label">Customer Name</label>
										<input type="text"id="txt_customer_name" name="txt_customer_name"  class="form-control" placeholder="Enter Customer Name" onchange="fnc_party();">							
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group" id = "switch_party">
										<label class="control-label">Customer Mobile</label>
										<input type="text"id="txt_customer_mobile" name="txt_customer_mobile"  class="form-control" placeholder="Enter Customer Mobile">							
									</div>
								</div>
								<!--/span-->
								<div class="col-md-2">
									<div class="form-group">
										<label class="control-label">Invoice No</label>
										<input type="text" id="txt_invoice_no" name="txt_invoice_no" class="form-control" placeholder="Enter Invoice No." readonly = "true"value="<?php if(isset($_GET['id'])){ echo $row_cashmemo_select['invoice_no']; }else { echo $invoice_no; } ?>">										
									</div>
								</div>
								<!--/span-->
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label">State Of Supply</label>
										<select id="cmb_state_of_supply" name="cmb_state_of_supply" class="form-control" onchange = "fnc_state_change();">
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
											<option value="LADAKH"<?php fnc_state("LADAKH");?>>LADAKH</option>
											<option value="MEGHALAYA"<?php fnc_state("MEGHALAYA");?>>MEGHALAYA</option>
											<option value="MAHARASHTRA"<?php fnc_state("MAHARASHTRA");?>>MAHARASHTRA</option>
											<option value="MANIPUR"<?php fnc_state("MANIPUR");?>>MANIPUR</option>
											<option value="MADHYA PRADESH"<?php fnc_state("MADHYA PRADESH");?>>MADHYA PRADESH</option>
											<option value="MIZORAM"<?php fnc_state("MIZORAM");?>>MIZORAM</option>
											<option value="NAGALAND"<?php fnc_state("NAGALAND");?>>NAGALAND</option>
											<option value="ODISHA"<?php fnc_state("ODISHA");?>>ODISHA</option>
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
										<input type="hidden" name="is_out_off_state" id="is_out_off_state" value="<?php if(isset($_GET['id'])){ echo $row_cashmemo_select['out_of_state']; }?>"/>
									</div>
								</div>
								<!--/span-->
								<div class="col-md-2">
									<div class="form-group">
										<label class="control-label">cashmemo Invoice Date</label>
										<input type="date" id="txt_invoice_date" name="txt_invoice_date" class="form-control" onclick="fnc_"  value="<?php if(isset($_GET['id'])){ echo $row_cashmemo_select['cashmemo_date']; }else { print(date("Y-m-d")); } ?>">		
									</div>
								</div>
								<!--/span-->
							</div>
							<!--row-->
							<div class="row">
								<div class="col-md-2">
									
									<!--- for serial popup --->
									<div class="modal fade" id="serial" role="dialog">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
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
																	</tbody>
																</table>	
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
													<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
													<h4>Batch</h4>
												</div>
												<div class="modal-body">
													<div class = "row">
														<table class="table-hover table-bordered table" data-tablesaw-mode="columntoggle" id = "dynamic_field_batch">
															<thead>
																<th style="text-align: center;">#</th>
																<th style="text-align: center;">Price</th>
																<th style="text-align: center;">Batch No.</th>
																<th style="text-align: center;">Exp. Date</th>
																<th style="text-align: center;">Mfg. Date</br>(%)</th>
																<th style="text-align: center;">Model No.</th>
																<th style="text-align: center;">Size</th>
																<th style="text-align: center;">Total Quantity</th>
																<th style="text-align: center;">Buy</th>
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
										<?php if($setting->get_name('is_show_barcode') == 1) { ?>
                                            <th style="width:15%;" class="text-center">Barcode</th>
                                        <?php } ?>

										<th style="width:13%;" class="text-center">Product</th>

                                        <?php if($setting->get_name('is_show_serial') == 1) { ?>
										<th style="width:5%;" class="text-center">Serial</th>
                                        <?php } ?>

                                        <?php if($setting->get_name('is_show_batch') == 1) { ?>
                                            <th style="width:5%;" class="text-center">Batch</th>
                                        <?php } ?>
										<th style="width:8%;" class="text-center">Unit</th>
										<th style="width:10%;" class="text-center">Qty</th>
										<th style="width:10%;" class="text-center">Rate</th>
										<th style="width:8%;" class="text-center">Discount</br>(%)</th>
										<th style="width:10%;" class="text-center">GST</th>
										<th style="width:10%;" class="text-center">Total</th>
										<th style="width:4%;" class="text-center">Action</th>
									</thead> 
									<tbody>
									
								<?php	if(!isset($_GET['id']))
									{ ?>
									<tr id='row0'>
										<?php if($setting->get_name('is_show_barcode') == 1) { ?>
										<td>
											<div class="form-group">
											<input type="number"  oninput="barcode_data(this)" name="barcode_id[]" id="barcode_id" class = "form-control" value = ""/>
											</div>	
										</td>
										<?php } ?>
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
												<option value="<?php echo $row_autocomplete['product_id'];?>"><?php echo $row_autocomplete['product_name'];?>(<?php echo $row_autocomplete['unit_name'];?>)</option>                    
												<?php
												  }
												?>
												</select>
											  </div>
										</td>
										<?php if($setting->get_name('is_show_serial') == 1) { ?>
										<td>
											<div class="form-group">
												<a id="link_serial" name="link_serial[]" onclick="fnc_serial_find(this);" class="form-control" data-toggle="modal" data-target="#serial" style="pointer-events: none;">Serial</a>
											</div>
										</td>
										<?php } ?>
										<?php if($setting->get_name('is_show_batch') == 1) { ?>
										<td>
											<div class="form-group">
												<a id="link_batch" name="link_batch[]" onclick="fnc_batch_find(this);" class="form-control"  data-toggle="modal" data-target="#batch" style="pointer-events: none;">Batch</a>
											</div>
										</td>
										<?php } ?>
										<td>
											<div class="form-group">
												<select class="form-control" id="product_unit" name="product_unit[]" onchange="fnc_rate_update(this);">
												</select>
											</div>
										</td>
										<td>
											<div class="form-group">
												<input type="number" id="txt_quantity" name="txt_quantity[]" step="0.001" value = "" onchange = "tot();fnc_style_remove(this);" oninput = "fnc_qty_serial_count(this)"  class="form-control" placeholder="Enter QUANTITY" >		
												<input type="hidden" id="share_rate" name="share_rate[]">
											</div>
										</td>
										<td>
											<div class="form-group">
												<input type="number" id="txt_rate" name="txt_rate[]" step="0.01" onchange = "tot();fnc_style_remove(this);"  class="form-control" placeholder="Enter rate" >				
											</div>
										</td>
										<td>
											<div class="form-group">
												<input type="number" id="txt_discount" name="txt_discount[]" step="0.01" onchange = "tot();fnc_style_remove(this);"  class="form-control" placeholder="Enter discount" value = 0>										
											</div>
										</td>
										<td>
											<div class="form-group">
                                                <select id="txt_gst" name="txt_gst[]" class="form-control" onchange="fnc_gst_cal(this);">
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
												<input type="number" id="txt_total" name="txt_total[]" step="0.01" readonly = "true" class="form-control" placeholder="Enter TOTAL" >										
											</div>
										</td>
										<td>
										
										<input type="hidden" name="txt_discount_amt[]" id="txt_discount_amt"/>
										<input type="hidden" name="txt_cgst[]" id="txt_cgst" value = "0"/>
										<input type="hidden" name="txt_serial_no[]" id="txt_serial_no" value="">
										<input type="hidden" name="txt_batch_no[]" id="txt_batch_no" >
										<input type="hidden" name="cashmemo_detail_id[]" id="cashmemo_detail_id" value = ''/> 
										<button type="button" name="btn_remove" id="btn_remove" class="btn btn-danger btn_remove">X</button></td>
									</tr> <?php }?>
									</tbody>
								</table>
							</div>
							<!--/row-->
								<!--/span-->
					
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
												<option value="<?php echo $row_payment['payment_type_id']; ?>" <?php if(isset($_GET['id'])){if($row_cashmemo_select['payment_type_id'] == $row_payment['payment_type_id']){echo "selected";}}?> ><?php echo $row_payment['payment_type'];?></option>
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
										<input type="number" id="txt_shipping_amt" name="txt_shipping_amt" class="form-control" value = "<?php if(isset($_GET['id'])){ echo $row_cashmemo_select['shipping_packing_amount']; }else {echo "0.00";}?>" onchange = "fnc_calculate_total()" placeholder="Enter Shipping/Packing Amount">																			
									</div>
								</div>
								<!--/span-->
							</div>	
							<div class="row">	
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Description</label>
										<textarea id="txt_narration" name="txt_narration" class="form-control" placeholder="Enter Narration"><?php if(isset($_GET['id'])){ echo $row_cashmemo_select['narration']; }?></textarea>
									</div>
								</div>
								<!--/span-->
								<div class="col-md-4">
									
								</div>
								<!--/span-->
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Gross Total</label>
										<input type="number" id="txt_gtotal" name="txt_gtotal" readonly = "true" class="form-control" placeholder="Enter Gross Total">									
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
										<input type="checkbox" id="chk_is_round_off" name="chk_is_round_off" onchange = "fnc_calculate_total()" <?php if(isset($_GET['id'])){  if($row_cashmemo_select['is_round_off'] == 1){ echo "checked";}}?>>	
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
										<input type="number" id="txt_pay" name="txt_pay" class="form-control"  placeholder="Enter Pay Amount" value="<?php if(isset($_GET['id'])){ echo $row_cashmemo_select['pay']; }?>" >	
									</div>
								</div>
								<!--/span-->
							</div>
						</div>
						<div class="form-actions">
						<div class = "row">
							<div  class = "col-md-8"> </div>
								<input type="hidden" name="cashmemo_id" id="cashmemo_id" value = "<?php if(isset($_GET['id'])){ echo $row_cashmemo_select['cashmemo_id']; }?>"/>
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

//ALT + A will add a new center
document.addEventListener ("keydown", function (zEvent) {
    if (zEvent.altKey  &&  zEvent.key === "a") {  
        $('#btn_add').click();
    }
} );

document.addEventListener ("keydown", function (Event) {
    if (Event.keyCode === 13) {  
        Event.preventDefault();
    }
} );
$(document).ready(function(){
	$("#dynamic_ref").hide();
	
	$('#txt_customer_name,#txt_customer_mobile,#txt_invoice_date').on('keyup , change', function () {
		$(".error_company").remove();
	});
	   
	$(document).on('click', '#btn_add', function() {
		  
		$('#dynamic_field').append('<tr id="row"><td><div class="form-group"><input type="number" oninput="barcode_data(this)" name="barcode_id[]" id="barcode_id" class = "form-control" value = ""/></div>	</td><td><div class="form-group"><select class="form-control"  id="txt_product" name="txt_product[]" onchange="fnc_unit(this);fnc_style_remove(this);" placeholder = "select Product"><option value = "">--select--</option><?php $sql_autocomplete = "SELECT pm.*,ut.unit_name FROM tbl_product_master pm left join tbl_company tc on tc.company_id = pm.company_id left join tbl_unit ut on ut.unit_id= pm.unit_id where tc.is_default = 1";$rs_autocomplete = mysqli_query($con , $sql_autocomplete);while($row_autocomplete = mysqli_fetch_array($rs_autocomplete)){?><option value="<?php echo $row_autocomplete["product_id"];?>"><?php echo $row_autocomplete["product_name"];?>(<?php echo $row_autocomplete["unit_name"];?>)</option> <?php } ?></select></div></td><?php if($setting->get_name('is_show_serial') == 1) { ?><td><div class="form-group"><a id="link_serial" onclick="fnc_serial_find(this);" name = "link_serial[]" class="form-control" data-toggle="modal" data-target="#serial" style="pointer-events: none;">Serial</a></div></td> <?php } ?><?php if($setting->get_name('is_show_batch') == 1) { ?><td><div class="form-group"><a id="link_batch" name="link_batch[]" onclick="fnc_batch_find(this);" class="form-control"  data-toggle="modal" data-target="#batch" style="pointer-events: none;" >Batch</a></div></td> <?php } ?><td><div class="form-group"><select class="form-control" id="product_unit" name="product_unit[]" onchange="fnc_rate_update(this);"></select></div></td><td><div class="form-group"><input type="number" id="txt_quantity" name="txt_quantity[]" step="0.001" value = "" onchange = "tot();fnc_style_remove(this);" class="form-control" placeholder="Enter QUANTITY" oninput = "fnc_qty_serial_count(this)" ><input type="hidden" id="share_rate" name="share_rate[]"></div></td><td><div class="form-group"><input type="number" id="txt_rate" name="txt_rate[]" step="0.01" onchange = "tot();fnc_style_remove(this);" class="form-control" placeholder="Enter rate" ></div></td><td><div class="form-group"><input type="number" id="txt_discount[]" name="txt_discount[]" step="0.01" onchange = "tot();fnc_style_remove(this);" class="form-control" placeholder="Enter discount" value = 0 ></div></td><td><div class="form-group"><select id="txt_gst" name="txt_gst[]" class="form-control" onchange="fnc_gst_cal(this);fnc_style_remove(this);"><option value = "">--select--</option><?php $sql_gst="SELECT gst.* FROM tbl_gstslab_master gst LEFT JOIN tbl_company com ON com.company_id  = gst.company_id  WHERE com.is_default = 1 "; $rs_gst = mysqli_query($con,$sql_gst); while($row_gst=mysqli_fetch_array($rs_gst)){ ?><option value="<?php echo $row_gst["gstslab_id"]; ?>"><?php echo $row_gst["gstslab_name"]; ?></option><?php } ?></select></div></td>	<td><div class="form-group"><input type="number" id="txt_total[]" name="txt_total[]" step="0.01" readonly = "true" class="form-control" placeholder="Enter TOTAL" ></div></td><td><input type="hidden" name="txt_discount_amt[]" id="txt_discount_amt"/><input type="hidden" name="txt_cgst[]" id="txt_cgst" value = "0"/><input type="hidden" name="txt_serial_no[]" id="txt_serial_no" value = ""> <input type="hidden" name="txt_batch_no[]" id="txt_batch_no" value = "" ><input type="hidden" name="cashmemo_detail_id[]" id="cashmemo_detail_id" value="" /> <button type="button" name="btn_remove" id="btn_remove" class="btn btn-danger btn_remove">X</button></td></tr>');
		//document.getElementsByName('link_batch[]')[document.getElementsByName('link_batch[]').length - 1].style.pointerEvents="none";
		//document.getElementsByName('link_serial[]')[document.getElementsByName('link_serial[]').length - 1].style.pointerEvents="none";
		let bar_avil = <?php echo $setting->get_name('is_show_barcode'); ?>;
        
        if(bar_avil ==  1){
            let bar_no = document.getElementsByName('barcode_id[]');
            bar_no[bar_no.length - 1].focus();
        }
	});  
	  
	//remove button code
	  $(document).on('click', '.btn_remove', function(){  
		 
		   	var detail_id = $(this).siblings("#cashmemo_detail_id").val();
			
			if(detail_id == '')
			{
				$(this).closest("tr").remove();
				return true;
			}
			
			if(confirm("Are you sure you want to delete this?"))
			{
				$.ajax({  
					url:"cashmemo_ajax.php",
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
				$('#dynamic_field').append('<tr id="unique"><td><div class="form-group"><input type="number" readonly oninput="barcode_data(this)" name="barcode_id[]" id="barcode_id" class = "form-control" value = ""/></div>	</td><td><div class="form-group"><select class="form-control"  id="txt_product" name="txt_product[]" onchange="fnc_unit(this);fnc_style_remove(this);" placeholder = "select Product"><option value = "">--select--</option></option><?php $sql_autocomplete = "SELECT pm.*,ut.unit_name FROM tbl_product_master pm left join tbl_company tc on tc.company_id = pm.company_id left join tbl_unit ut on ut.unit_id= pm.unit_id where tc.is_default = 1";$rs_autocomplete = mysqli_query($con , $sql_autocomplete);while($row_autocomplete = mysqli_fetch_array($rs_autocomplete)){?><option value="<?php echo $row_autocomplete["product_id"];?>"><?php echo $row_autocomplete["product_name"];?>(<?php echo $row_autocomplete["unit_name"];?>)</option> <?php } ?></select></div></td><?php if($setting->get_name('is_show_serial') == 1) { ?><td><div class="form-group"><a id="link_serial" name="link_serial[]" onclick="fnc_serial_find(this);" class="form-control" data-toggle="modal" data-target="#serial">Serial</a></div></td> <?php } ?><?php if($setting->get_name('is_show_batch') == 1) { ?><td><div class="form-group"><a id="link_batch"  name = "link_batch[]" class="form-control" onclick="fnc_batch_find(this);"  data-toggle="modal" data-target="#batch">Batch</a></div></td> <?php } ?><td><div class="form-group"><select class="form-control" id="product_unit" name="product_unit[]" onchange="fnc_rate_update(this);"></select></div></td><td><div class="form-group"><input type="number" id="txt_quantity" name="txt_quantity[]" step="0.001" oninput = "fnc_qty_serial_count(this)" value = "" onchange = "tot();fnc_style_remove(this);" class="form-control" placeholder="Enter QUANTITY" ><input type="hidden" id="share_rate" name="share_rate[]"></div></td><td><div class="form-group"><input type="number" id="txt_rate" name="txt_rate[]" step="0.01" onchange = "tot();fnc_style_remove(this);" class="form-control" placeholder="Enter rate" ></div></td><td><div class="form-group"><input type="number" id="txt_discount[]" step="0.01" name="txt_discount[]" onchange = "tot();fnc_style_remove(this);" class="form-control" placeholder="Enter discount" ></div></td><td><div class="form-group"><select id="txt_gst" name="txt_gst[]" class="form-control" onchange="fnc_gst_cal(this);fnc_style_remove(this);"><option value = "">--select--</option><?php $sql_gst="SELECT gst.* FROM tbl_gstslab_master gst LEFT JOIN tbl_company com ON com.company_id  = gst.company_id  WHERE com.is_default = 1 "; $rs_gst = mysqli_query($con,$sql_gst); while($row_gst=mysqli_fetch_array($rs_gst)){ ?><option value="<?php echo $row_gst["gstslab_id"]; ?>"><?php echo $row_gst["gstslab_name"]; ?></option><?php } ?></select></div></td>	<td><div class="form-group"><input type="number" id="txt_total[]" name="txt_total[]" step="0.01" readonly = "true" class="form-control" placeholder="Enter TOTAL" ></div></td><td><input type="hidden" name="txt_discount_amt[]" id="txt_discount_amt"/><input type="hidden" name="txt_cgst[]" id="txt_cgst" value = "0"/><input type="hidden" name="txt_serial_no[]" id="txt_serial_no" value = "" > <input type="hidden" name="txt_batch_no[]" id="txt_batch_no" value = "" ><input type="hidden" name="cashmemo_detail_id[]" id="cashmemo_detail_id" value="" /> <button type="button" name="btn_remove" id="btn_remove" class="btn btn-danger btn_remove">X</button></td></tr>');	
			}
		let is_batc = <?php echo $setting->get_name('is_show_batch'); ?>;
        let is_seria = <?php echo $setting->get_name('is_show_serial'); ?>;
		var inv_id = "<?php echo $cashmemo_id; ?>";
		$.ajax({ url: 'cashmemo_ajax.php',
		data: {'id': inv_id, 'edit_fetch': 1},
		type: 'post',
		dataType :'json',
		success: function(data) 
		{
			for(i=0;i<no_of_detail_row;i++)
			{
				var detail_id = $(this).siblings("#cashmemo_detail_id").val();
				
				var selID=document.getElementById("txt_quantity");
				var a = selID[i];
				
				document.getElementsByName("txt_product[]")[i].value =  data[i].product_id;
				document.getElementsByName("txt_gst[]")[i].value =  data[i].gstslab_id;
				document.getElementsByName("txt_quantity[]")[i].value = data[i].qty;
				document.getElementsByName("txt_rate[]")[i].value = data[i].rate;
				document.getElementsByName("txt_discount_amt[]")[i].value = data[i].disc_amt;
				document.getElementsByName("txt_discount[]")[i].value = data[i].disc_per;
				document.getElementsByName("cashmemo_detail_id[]")[i].value = data[i].cashmemo_detail_id;
				document.getElementsByName("product_unit[]")[i].value = data[i].unit_id;
				document.getElementsByName("txt_serial_no[]")[i].value = data[i].serial_no;
				document.getElementsByName("txt_batch_no[]")[i].value = data[i].batch_no;
				
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
				if(is_seria == 1)
                {
                    //to disable link_serial when is_serial is 0 in db
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
				fnc_unit_change(document.getElementsByName("cashmemo_detail_id[]")[i]);
				
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
	
	 });    
	 
</script>
<?php
	include_once('footer.php');
?>