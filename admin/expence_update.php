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
	
	//select maximum company ledger id
	$sql_company_ledger_id = "select *  from tbl_company_ledger where related_id = '".$_POST['expence_id']."' ";
	$rs_company_ledger_id = mysqli_query($con,$sql_company_ledger_id);
	$row_company_ledger_id = mysqli_fetch_array($rs_company_ledger_id);
	
	//update tbl_expence
	$sql_expence_iu = "update tbl_expence set company_id = '".$row_company_id['company_id']."',financial_id = '".$row_financial_id['financial_id']."',expense_id = '".$_POST['txt_expense_type']."',date = '".$_POST['txt_date']."',payment_type_id = '".$_POST['cmb_payment_type']."',cheque_ref_no='".$_POST['txt_cheque_ref']."',is_round_off = '".$_POST['chk_is_round_off']."',round_off = '".$_POST['txt_round_off']."',total = '".$_POST['txt_total']."' ,description = '".$_POST['txt_description']."' where expence_id = '".$_POST['expence_id']."' "; 
	$rs_expence_iu = mysqli_query($con,$sql_expence_iu);
	
	//company ledger update...
	$objname = "expence";
	$credit=0.00;
	$party_id = 0;
	
	$sql_update_company_ledger = "update tbl_company_ledger set company_id = '".$row_company_id['company_id']."',related_id = '".$_POST['expence_id']."',related_obj_name='".$objname."',party_id='".$party_id."',date = '".$_POST['txt_date']."' ,details = '".$_POST['txt_description']."' , credit = '".$credit."' , debit = '".$_POST['txt_total']."',financial_id = '".$row_financial_id['financial_id']."' where related_id = '".$_POST['expence_id']."' and related_obj_name = '".$objname."' ";
	$rs_update_company_ledger = mysqli_query($con,$sql_update_company_ledger);
	
	if(isset($_POST["txt_price"][1]))
		$number = count($_POST["txt_price"]);
	else
		$number = 1;
	
	if($number > 0)  
	{  
		for($i=0; $i<$number; $i++)  
		{
			if(trim($_POST["expence_detail_id"][$i] == ''))		   
			{
				$sql_expence_detail = "insert into tbl_expence_detail(expence_id,item_name,price,quantity,total) values('".$_POST['expence_id']."','".mysqli_real_escape_string($con, $_POST["txt_item"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_price"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_quantity"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_amount"][$i])."')";
				
				mysqli_query($con,$sql_expence_detail);
			}
			else
			{
				$sql_expence_detail = "update tbl_expence_detail set expence_id = '".$_POST['expence_id']."',item_name = '".mysqli_real_escape_string($con, $_POST["txt_item"][$i])."',price = '".mysqli_real_escape_string($con, $_POST["txt_price"][$i])."',quantity = '".mysqli_real_escape_string($con, $_POST["txt_quantity"][$i])."',total = '".mysqli_real_escape_string($con, $_POST["txt_price"][$i])."' where expence_detail_id = '".mysqli_real_escape_string($con, $_POST["expence_detail_id"][$i])."'  ";
				echo $sql_expence_detail;
				
				mysqli_query($con,$sql_expence_detail);
			}
		}
		echo "updated";
	}
?>