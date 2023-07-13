<?php
include_once('../connection.php');

	//company id sql
	$company_id="SELECT * FROM tbl_company WHERE is_default=1";
	$rs_company_id=mysqli_query($con,$company_id);
	$row_company_id=mysqli_fetch_array($rs_company_id);
	
	//current financial year
	$sql_financial_id="SELECT * FROM tbl_financial_master WHERE is_default=1";
	$rs_financial_id=mysqli_query($con,$sql_financial_id);
	$row_financial_id=mysqli_fetch_array($rs_financial_id);

	//update tbl_sales_invoice
			
	$sql_sales_invoice_iu = "UPDATE tbl_sales_invoice SET party_id = '".$_POST['cmb_party']."', state_of_supply ='".$_POST['cmb_state_of_supply']."' , payment_type_id = '".$_POST['cmb_payment_type']."', narration= '".$_POST['txt_narration']."', sub_total = '".$_POST['txt_sub_total']."', shipping_packing_amount= '".$_POST['txt_shipping_amt']."' , is_round_off = '".$_POST['chk_is_round_off']."', round_off = '".$_POST['txt_round_off']."' , total = '".$_POST['txt_total_inv']."', pay = '".$_POST['txt_pay']."' , new_invoice_no ='".$_POST['txt_new_invoice_no']."' WHERE sales_invoice_id = '".$_POST['sales_invoice_id']."'";
	$rs_sales_invoice_iu = mysqli_query($con , $sql_sales_invoice_iu);
		
	$number = count($_POST["txt_rate"]); 
	if($number > 0)  
	{  
	  for($i=0; $i<$number; $i++)  
	  {  
	   if(trim($_POST["sales_invoice_detail_id"][$i] == '')) 		   
	   {  
			$sql_invoice_detail = "INSERT INTO tbl_sales_invoice_detail(company_id , sales_invoice_id,product_id,unit_id,unit,rate,qty,gross_total,disc_per,disc_amt,gstslab_id,financial_id, new_invoice_no) VALUES('".$row_company_id['company_id']."' ,'".$_POST['sales_invoice_id']."','".mysqli_real_escape_string($con, $_POST["txt_product"][$i])."', '".mysqli_real_escape_string($con, $_POST["txt_unit_id"][$i])."' , '".mysqli_real_escape_string($con, $_POST["txt_unit"][$i])."' , '".mysqli_real_escape_string($con, $_POST["txt_rate"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_quantity"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_total"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_discount"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_discount_amt"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_gst"][$i])."' , '".$row_financial_id['financial_id']."' , '".$_POST['txt_new_invoice_no']."')";
			//$sql_invoice_detail = "INSERT INTO tbl_sales_invoice_detail(company_id,sales_invoice_id,product_id,unit_id,unit,rate,qty,gross_total,disc_per,disc_amt,sub_total,gstslab_id,gst,gst_per,igst,igst_per,total,financial_id,new_invoice_no) VALUES('".$row_company_id['company_id']."', '".$_POST['sales_invoice_id']."' , '".mysqli_real_escape_string($con, $_POST["txt_product"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_unit_id"][$i])."' ,'".mysqli_real_escape_string($con, $_POST["txt_unit"][$i])."' , '".mysqli_real_escape_string($con, $_POST["txt_rate"][$i])."' , '".mysqli_real_escape_string($con, $_POST["txt_quantity"][$i])."' , '".$gtot."' , '".mysqli_real_escape_string($con, $_POST["txt_discount"][$i])."' , '".$dsc_amt."' , '".$stot."' , '".mysqli_real_escape_string($con, $_POST["txt_gst"][$i])."' , '".mysqli_real_escape_string($con, $_POST["txt_gst"][$i])."' , '".mysqli_real_escape_string($con, $_POST["txt_gst"][$i])."' , '".mysqli_real_escape_string($con, $_POST["txt_gst"][$i])."' , '".mysqli_real_escape_string($con, $_POST["txt_gst"][$i])."' , '".$row_financial_id['financial_id']."' , '".$_POST['txt_new_invoice_no']."')";
			mysqli_query($con, $sql_invoice_detail);  
	   }
		else
		{
			$sql_invoice_detail = "UPDATE tbl_sales_invoice_detail SET product_id = '".mysqli_real_escape_string($con, $_POST["txt_product"][$i])."' , unit_id = '".mysqli_real_escape_string($con, $_POST["txt_unit_id"][$i])."' , unit = '".mysqli_real_escape_string($con, $_POST["txt_unit"][$i])."' , rate = '".mysqli_real_escape_string($con, $_POST["txt_rate"][$i])."' , qty= '".mysqli_real_escape_string($con, $_POST["txt_quantity"][$i])."' , gross_total = '".mysqli_real_escape_string($con, $_POST["txt_total"][$i])."' , disc_per = '".mysqli_real_escape_string($con, $_POST["txt_discount"][$i])."' , disc_amt = '".mysqli_real_escape_string($con, $_POST["txt_discount_amt"][$i])."' , gstslab_id = '".mysqli_real_escape_string($con, $_POST["txt_gst"][$i])."' , new_invoice_no = '".$_POST['txt_new_invoice_no']."' WHERE `sales_invoice_detail_id`= '".mysqli_real_escape_string($con, $_POST["sales_invoice_detail_id"][$i])."'";
			mysqli_query($con, $sql_invoice_detail);  
		}			
	  }
	  echo "Updated";
	}  
	else  
	{  
	  echo "Please Enter Name";  
	}		  
?> 