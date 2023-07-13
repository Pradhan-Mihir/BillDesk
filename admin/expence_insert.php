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
	
	if($_POST['expence_id'] == '')
	{
		//INSERT CODE
		$sql_expence_iu = "insert into tbl_expence(company_id,financial_id,expense_id,date,payment_type_id,cheque_ref_no,is_round_off,round_off,total,description) values('".$row_company_id['company_id']."','".$row_financial_id['financial_id']."','".$_POST['txt_expense_type']."','".$_POST['txt_date']."','".$_POST['cmb_payment_type']."','".$_POST['txt_cheque_ref']."','".$_POST['chk_is_round_off']."','".$_POST['txt_round_off']."','".$_POST['txt_total']."','".$_POST['txt_description']."')";
		
		$rs_expence_iu =  mysqli_query($con , $sql_expence_iu);
		
		$sql_inv_id = "select max(expence_id) 'inv_id' from tbl_expence";
		$rs_inv_id = mysqli_query($con , $sql_inv_id);
		$inv_id = mysqli_fetch_array($rs_inv_id);
		
		//company_ledger
		$objname = "expence";
		$credit=0.00;
		$party_id = "0";
		
		$sql_company_ledger="insert into tbl_company_ledger(company_id , related_id , related_obj_name,party_id, date, details, credit, debit, financial_id, new_invoice_no) values('".$row_company_id['company_id']."' , '".$inv_id["inv_id"]."' ,'".$objname."','".$party_id."' , '".$_POST['txt_date']."' , '".$_POST['txt_description']."' , '".$credit."','".$_POST['txt_total']."','".$row_financial_id['financial_id']."','".$_POST['txt_new_invoice_no']."')";
		$rs_company_ledger = mysqli_query($con,$sql_company_ledger);
	}
	
	//total no of product find
	if(isset($_POST["txt_price"][1]))
		$number = count($_POST["txt_price"]);
	else
		$number = 1;
	//inserting into detail tbls
	
	if($number > 0)  
	{  
	  for($i=0; $i<$number; $i++)  
	    {  
		   if(trim($_POST["txt_price"][$i] != ''))		   
		    { 
				$sql_expence_detail = "insert into tbl_expence_detail(expence_id,item_name,price,quantity,total) values('".$inv_id["inv_id"]."','".mysqli_real_escape_string($con, $_POST["txt_item"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_price"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_quantity"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_amount"][$i])."')";
				
				mysqli_query($con,$sql_expence_detail);
			}
		}
	}	
?>