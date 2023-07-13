<?php
$title = "BILL DESK-Bank Account";
	include_once('header.php');
	global $con;
	//company_id 
	$company_id="SELECT * FROM tbl_company WHERE is_default=1";
	$rs_company_id=mysqli_query($con,$company_id);
	$row_company_id=mysqli_fetch_array($rs_company_id);
	
	if(isset($_GET['id']))
	{
		$sql_detail_fetch = "select * from tbl_bank_account where bank_account_id = '".base64_decode($_GET['id'])."'";
		$rs_detail_fetch = mysqli_query($con , $sql_detail_fetch);
		$row_detail_fetch = mysqli_fetch_array($rs_detail_fetch);
	}
	
	if(isset($_POST['btn_save']))
	{		
		if($_POST['bank_account_id'] == '')
		{			
			//INSERT CODE
			$sql_bank_acc_iu="insert into tbl_bank_account (account_name,opening_balance,as_of_date,is_print_upi,is_print_bank_account,account_number,ifsc_code,upi_qr_code,bank_name,account_holder_name) VALUES('".$_POST['txt_acc_display_name']."' , '".$_POST['txt_opening_balance']."' , '".$_POST['txt_as_of_date']."', '".$_POST['chk_print_upi']."' ,'".$_POST['chk_print_bank_acc']."', '".$_POST['txt_account_number']."', '".$_POST['txt_ifsc_code']."', '".$_POST['txt_upi_qr_code']."', '".$_POST['txt_bank_name']."', '".$_POST['txt_account_holder_name']."')";
			$rs_bank_acc_iu = mysqli_query($con,$sql_bank_acc_iu);
			
			$sql_payment_type_iu = "CALL insertPayment_type('".$_POST['txt_bank_name']."' ) ";
			$rs_payment_type_iu = mysqli_query($con,$sql_payment_type_iu);
		}
		else
		{	
			//UPDATE CODE
			$sql_bank_acc_iu = "update tbl_bank_account set account_name = '".$_POST['txt_acc_display_name']."' , opening_balance = '".$_POST['txt_opening_balance']."' , as_of_date = '".$_POST['txt_as_of_date']."' , is_print_upi = '".$_POST['chk_print_upi']."' , is_print_bank_account = '".$_POST['chk_print_bank_acc']."' , account_number = '".$_POST['txt_account_number']."' , ifsc_code = '".$_POST['txt_ifsc_code']."' , upi_qr_code = '".$_POST['txt_upi_qr_code']."' , bank_name = '".$_POST['txt_bank_name']."', account_holder_name = '".$_POST['txt_account_holder_name']."' where bank_account_id = '".base64_decode($_GET['id'])."' ";
			
			$rs_bank_acc_iu = mysqli_query($con,$sql_bank_acc_iu);
		}
		
		
		
		if(!$rs_bank_acc_iu)
		{
			die('User Data Not Inserted/Updated.'.mysqli_error($con));
		}
		else
		{
			echo "<script>window.location = 'bank_view.php';</script>";
		}	
	}
?>

 <!--.row-->
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info">
			<div class="panel-heading">Bank Account Details</div>
			<div class="panel-wrapper collapse in" aria-expanded="true">
				<div class="panel-body">
					<form action="" method="post" name="frm_expence" enctype="multipart/form-data">
						<div class="form-body">								
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label" for="txt_acc_display_name">Account Display Name</label>
										<input type="text" id="txt_acc_display_name" name="txt_acc_display_name" class="form-control" placeholder="Enter Account Display Name" value = "<?php if(isset($_GET['id'])) { echo $row_detail_fetch['account_name']; } ?>">
									</div>
								</div>
								<!-- /span---->
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label" for="txt_opening_balance">Opening Balance</label>
										<input type="text" id="txt_opening_balance" name="txt_opening_balance" class="form-control" placeholder="Enter Opening Balance" value = "<?php if(isset($_GET['id'])) { echo $row_detail_fetch['opening_balance']; } ?>">										
									</div>
								</div>
								<!-- /span---->
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label" for="txt_as_of_date">As Of Date</label>
										<input type="date" id="txt_as_of_date" name="txt_as_of_date" class="form-control" placeholder="Enter As Of Date" value = "<?php if(isset($_GET['id'])) { echo $row_detail_fetch['as_of_date']; } ?>">										
									</div>
								</div>
							</div>
							<!-- /row-->
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<input type="checkbox" id="chk_print_bank_acc" name="chk_print_bank_acc" value="1" <?php if(isset($_GET['id'])) { if($row_detail_fetch['is_print_bank_account'] == 1){ echo "checked";} } ?>>	
										<label class="control-label" for="chk_print_bank_acc">Print this Bank Account Details on Invoice</label>
									</div>
								</div>
								<!-- /span---->
								<div class="col-md-6">
									<div class="form-group">
										<input type="checkbox" id="chk_print_upi" name="chk_print_upi" value="1" <?php if(isset($_GET['id'])) { if($row_detail_fetch['is_print_upi'] == 1){ echo "checked";} } ?>>	
										<label class="control-label" for="chk_print_upi">Print UPI QR Code On Invoice</label>
									</div>
								</div>									
							</div>
							<!-- /row-->
							<div class="row bank">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label ">Account Number</label>
										<input type="text" id="txt_account_number" name="txt_account_number" class="form-control " placeholder="Enter Account Number" value = "<?php if(isset($_GET['id'])) { echo $row_detail_fetch['account_number']; } ?>">						
									</div>
								</div>
								<!-- /span---->
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label ">IFSC Code</label>
										<input type="text" id="txt_ifsc_code" name="txt_ifsc_code" class="form-control " placeholder="Enter IFSC Code" value = "<?php if(isset($_GET['id'])) { echo $row_detail_fetch['ifsc_code']; } ?>">						
									</div>
								</div>
							</div>
							
							<!-- /row-->
							<div class="row bank">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label ">Bank Name</label>
										<input type="text" id="txt_bank_name" name="txt_bank_name" class="form-control " placeholder="Enter Bank Name" value = "<?php if(isset($_GET['id'])) { echo $row_detail_fetch['bank_name']; } ?>">										
									</div>
								</div>
								<!---span--->
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label ">Account Holder Name</label>
										<input type="text" id="txt_account_holder_name" name="txt_account_holder_name" class="form-control" placeholder="Enter Bank Name" value = "<?php if(isset($_GET['id'])) { echo $row_detail_fetch['account_holder_name']; } ?>">
									</div>
								</div>
							</div>
							<!-- /row-->
							<div class="row qr">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label ">UPI ID for QR Code</label>
										<input type="number" id="txt_upi_qr_code" name="txt_upi_qr_code" class="form-control" placeholder="Enter UPI ID for QR Code" value = "<?php if(isset($_GET['id'])) { echo $row_detail_fetch['upi_qr_code']; } ?>">
									</div>
								</div>
							</div>
						</div>
						<div class="form-actions">
							<input type="hidden" name="bank_account_id" id="bank_account_id" value = "<?php if(isset($_GET['id'])) { echo $row_detail_fetch['bank_account_id']; } ?>" /> 
							<button type="submit" id="btn_save" name="btn_save" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
							<button type="reset" name="btn_reset" id="btn_reset" class="btn btn-default">Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!--./row-->

<!-- /row -->
<!-- /.row -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>	
<script>
	$(document).ready(function()
	{	
	$('.qr').hide();
	$('.bank').hide();
	
		$('#chk_print_upi').change(function(){
			if((this).checked == 1)
				$('.qr').show();
			else
			{
				$('.qr').hide();
				$('.qr').val('');
			}
			
		});	
		
		$('#chk_print_bank_acc').change(function(){
			if((chk_print_bank_acc).checked == 1)
				$('.bank').show();
			else
			{
				$('.bank').hide();
				$('.bank').val('');
			}
			
		});
		
		if($('#chk_print_bank_acc').is(':checked'))
			$('.bank').show(); 
		else
			$('.bank').hide();
		
		if($('#chk_print_upi').is(':checked'))
			$('.qr').show(); 
		else
			$('.qr').hide();
		
		
	}); 
	 
</script>
	

<?php
	include_once('footer.php');
?>
