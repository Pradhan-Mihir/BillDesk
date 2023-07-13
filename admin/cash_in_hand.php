<?php
$title = "BILL DESK- Cash In Hand";
	include_once('header.php');
	
	$sum = "select sum(credit)  -  sum(debit) 'cash_in_hand' from tbl_company_ledger ";
	$rs_sum = mysqli_query($con,$sum);
	$row_sum = mysqli_fetch_array($rs_sum);
	
	//company id sql
	$company_id="SELECT * FROM tbl_company WHERE is_default=1";
	$rs_company_id=mysqli_query($con,$company_id);
	$row_company_id=mysqli_fetch_array($rs_company_id);
	
	//current financial year
	$sql_financial_id="SELECT * FROM tbl_financial_master WHERE is_default=1";
	$rs_financial_id=mysqli_query($con,$sql_financial_id);
	$row_financial_id=mysqli_fetch_array($rs_financial_id);
	
	$objname="company ledger";
	$party_id="";
	
	if(isset($_POST['btn_save']))
	{
		if($_POST['company_ledger_id'] == '')
		{
			if($_POST['txt_adjustment_val'] == 'Cash Increase')
			{
				$debit = 0.00;
				$credit = $_POST['txt_amount'];
			}
			else
			{
				$credit = 0.00;
				$debit = $_POST['txt_amount'];
			}
			$sql_company_ledger = "insert into tbl_company_ledger(company_id,related_id,related_obj_name,party_id,date,details,credit,debit,financial_id,new_invoice_no) values('".$row_company_id['company_id']."','".$party_id."','".$_POST['cmb_adjustment']."','".$party_id."','".$_POST['txt_adjustment_date']."','".$_POST['txt_description']."','".$credit."','".$debit."','".$row_financial_id['financial_id']."','".$party_id."')";
			
			$rs_company_ledger=mysqli_query($con,$sql_company_ledger);
		}
		if(!$rs_company_ledger)
		{
			die('Not inserted'.mysqli_error($con));
		}
		else
		{
			echo "<script>window.location = 'cash_in_hand.php';</script>";
		}
	}
?>
<script type="text/javascript" language="javascript">
function fnc_adjustment()
{
	var val = $('#cmb_adjustment').val();
	document.getElementById("txt_adjustment_val").value = val;
}
</script>
<div class="row bg-title">
	<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
		<h4 class="page-title">Cash In Hand <?php if($row_sum['cash_in_hand'] > 0 ) {echo "<span style='color:#25e90d'>".$row_sum['cash_in_hand']."</span>"; } else {echo "<span style='color:red'>".$row_sum['cash_in_hand']* (-1)."</span>" ;}?> </h4>
	</div>		
	<!-- /.col-lg-12 -->
</div>	
<div class="row">
	<div class="col-sm-12">			
		<div class="white-box">
			<div class="panel panel-info">
				<div class="panel-heading">Cash In Hand</div>
			</div>	
				<div class="row">
					<div class="col-md-12">
						<div class="panel-body">
							<form name="add_new" id="add_new" method="post">
								<div class="form-actions">
									<p align="right">
										<button type="button" id="btn_popup_cash_in_hand" name="btn_popup_cash_in_hand" class="fcbtn btn btn-info btn-outline btn-1e" data-toggle="modal" data-target="#model"> <i class="fa fa-plus"> &nbsp; Add new</i></button>
									</p>
								</div>
								<div class="modal fade" id="model" role="dialog">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
												<h4>Cash In Hand</h4>
											</div>
											<div class="modal-body">
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Adjustment</label>
															<select class="form-control" id="cmb_adjustment" name="cmb_adjustment" onchange = "fnc_adjustment();">
																<option value = "">----- select adjustment -----</option>
																<option value = "Cash Increase">Add Cash</option>
																<option value = "Reduce Cash">Reduce Cash</option>										
															</select>
															<input type="hidden" id="txt_adjustment_val" name="txt_adjustment_val" />
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Enter Amount</label>
															<input type="number" class="form-control" id="txt_amount" name="txt_amount" placeholder="Enter Amount">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Enter Adjustment Date</label>
															<input type="date" class="form-control" id="txt_adjustment_date" name="txt_adjustment_date">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Description</label>
															<textarea class="form-control" id="txt_description" name="txt_description"></textarea>
														</div>
													</div>
												</div>
												<div class="form-actions">
													<input type="hidden" name="company_ledger_id" id="company_ledger_id" />
													<button type="submit" id="btn_save" name="btn_save" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>	
					</div>	
				</div>	
			<div class="table-responsive">
				<table id="myTable" class="table table-striped">
					<thead>
						<tr>
							<th>SR NO.</th>
							<th>RELATED OBJ NAME</th>
							<th>PARTY NAME</th>
							<th>DETAILS</th>
							<th>DATE</th>
							<th>AMOUNT</th>
						</tr>
				  </thead>
				<tbody>
				  <?php                                        
					$sql = "SELECT cl.*,par.party_name FROM tbl_company_ledger cl
	LEFT JOIN tbl_company com ON com.company_id = cl.company_id
	LEFT JOIN tbl_party_master par ON par.party_id = cl.party_id
    LEFT JOIN tbl_financial_master fi ON fi.financial_id = cl.financial_id
	WHERE com.is_default = 1 and fi.is_default=1 ORDER BY cl.date DESC";
					$result = mysqli_query($con,$sql);
					$counter = 0;
					  while($row = mysqli_fetch_array($result))
					  {?>
						<tr>
							<td><?php echo  ++$counter ?></td>
							<td><?php echo $row['related_obj_name'];?></td>
							<td><?php if($row['party_id'] == 0){ echo $row['related_obj_name'];} else{ echo $row['party_name']; } ?></td>
							<td><?php echo $row['details']; ?></td>
							<td><?php echo $row['date']; ?></td>
							<td><b><span <?php if($row['credit'] == 0 && $row['debit'] != 0){echo "style='color:red;'";}else{echo "style='color:#25e90d;'";}?>><?php 
									if($row['credit'] == 0){echo $row['debit'];} 
									if($row['debit'] == 0){echo $row['credit'];} 
								?></span></b>
							</td>
						</tr>
					<?php  
						}
					?>                            
				</tbody>
				</table>
			</div>
		</div>
	</div>		
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>	
<script>
	$(document).ready(function()
	{				
		$('.btn_delete').click(function(e)
		{
			e.preventDefault();	
			var payment_in_id = $(this).attr("id");
			
			if(confirm("Are you sure you want to delete this?"))
			{
				$.ajax({ url: 'payment_in_delete.php',
						 data: {'id': payment_in_id, 'delete': 1},
						 type: 'post',
						 success: function(output) {					 			
									  //window.location.reload();
									  window.location.reload();
								  }
				});				
			}
			else
			{
				return false;
			}
		});
		
	
		
	}); 
	 
</script>
<?php
	include_once('footer.php');
?>