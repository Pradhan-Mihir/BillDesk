<?php
$title = "BILL DESK-Expence";
	include_once('header.php');
	
	$detail_row_num = 0;
	$expence_id = 0;
	
	//fetch data for update
	if(isset($_GET['id']))
	{
		$expence_id = base64_decode($_GET['id']);
		$sql_expence_select = "select * from tbl_expence where expence_id = '".$expence_id."' ";
		$rs_expence_select = mysqli_query($con,$sql_expence_select);
		$row_expence_select = mysqli_fetch_array($rs_expence_select);
		//fetch data for invoice detail
		$sql_expence_detail_select = "select * from tbl_expence_detail where expence_id = '".$expence_id."'";
		$rs_expence_detail_select = mysqli_query($con , $sql_expence_detail_select);
		$detail_row_num = mysqli_num_rows($rs_expence_detail_select);
		
	}
	
	//fetch active financial year
	$financial="SELECT financial_id from tbl_financial_master WHERE is_default=1";
	$rs_financial=mysqli_query($con,$financial);
	$row_financial=mysqli_fetch_array($rs_financial);
	
	//fetch active company id
	$company_id="SELECT * FROM tbl_company WHERE is_default=1";
	$rs_company_id=mysqli_query($con,$company_id);
	$row_company_id=mysqli_fetch_array($rs_company_id);
	
	
	if(isset($_POST['btn_save']))
	{
		if($_POST['expence_id'] == '')
		{
			//INSERT CODE
			$sql_expence_iu = "insert into tbl_expence(company_id,financial_id,expense_id,date,payment_type_id,cheque_ref_no,is_round_off,round_off,total,description) values('".$row_company_id['company_id']."','".$row_financial['financial_id']."','".$_POST['txt_expense_type']."','".$_POST['txt_date']."','".$_POST['cmb_payment_type']."','".$_POST['txt_cheque_ref']."','".$_POST['chk_is_round_off']."','".$_POST['txt_round_off']."','".$_POST['txt_total']."','".$_POST['txt_description']."')";
			
			$rs_expence_iu =  mysqli_query($con , $sql_expence_iu);
			$last_id =  mysqli_insert_id($con);
			
			if(!$rs_expence_iu)
			{
				die("data not inserted".mysqli_error($con));
			}
			else
			{
				echo "<script>window.location.href='invoice.php?expence_id=$last_id';</script>";
			}
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
	}
	if(isset($_POST['btn_edit']))
	{
		$sql_expence_iu = "update tbl_expence set company_id = '".$row_company_id['company_id']."',financial_id = '".$row_financial_id['financial_id']."',expense_id = '".$_POST['txt_expense_type']."',date = '".$_POST['txt_date']."',payment_type_id = '".$_POST['cmb_payment_type']."',cheque_ref_no='".$_POST['txt_cheque_ref']."',is_round_off = '".$_POST['chk_is_round_off']."',round_off = '".$_POST['txt_round_off']."',total = '".$_POST['txt_total']."' ,description = '".$_POST['txt_description']."' where expence_id = '".$_POST['expence_id']."' "; 
		$rs_expence_update = mysqli_query($con,$sql_expence_iu);
		
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
					$sql_expence_detail = "update tbl_expence_detail set expence_id = '".$_POST['expence_id']."',item_name = '".mysqli_real_escape_string($con, $_POST["txt_item"][$i])."',price = '".mysqli_real_escape_string($con, $_POST["txt_price"][$i])."',quantity = '".mysqli_real_escape_string($con, $_POST["txt_quantity"][$i])."',total = '".mysqli_real_escape_string($con, $_POST["txt_amount"][$i])."' where expence_detail_id = '".mysqli_real_escape_string($con, $_POST["expence_detail_id"][$i])."'  ";
					echo $sql_expence_detail;
					
					mysqli_query($con,$sql_expence_detail);
				}
			}
			echo "updated";
		}
		if(!$rs_expence_update)
		{
			die("data not updated".mysqli_error($con));
		}
		else
		{
			echo "<script>window.location.href='invoice.php?expence_id=$expence_id';</script>";
		}
	}
?>
<script>
var no_of_detail_row = "<?php echo $detail_row_num; ?>";
//console.log(no_of_detail_row);
//for total amount
function tot()
{
	var qty = document.getElementsByName("txt_quantity[]");
	var price = document.getElementsByName("txt_price[]");
	
	for(i=0; i < qty.length ; i++)
	{	
		if(qty[i].value != '' && price[i].value !='')
		{
			total_val = qty[i].valueAsNumber * price[i].valueAsNumber ;
			document.getElementsByName("txt_amount[]")[i].valueAsNumber = total_val.toFixed(2);
			console.log(i);
			//fnc_calculate_total();
		}
		
	}
	
	fnc_calculate_total();
}

//for total inv 
function fnc_calculate_total()
{
	let total_value=0;
	let total = document.getElementById('txt_total');
	let chk_round = document.getElementById('chk_is_round_off');
	let round_off = document.getElementById('txt_round_off');
	let amt = document.getElementsByName("txt_amount[]");

	for(i=0; i < amt.length ; i++)
	{	
		total_value += amt[i].valueAsNumber;
	}
	if(chk_round.checked == 1)
	{
		let abc = Math.round(total_value);
		total.value = abc;
		abc = abc - total_value;
		round_off.value = abc.toFixed(2);
	}
	else
	{
		total.value = total_value;
		round_off.value = 0;
	}
}

function fnc_add_expense_select(elm)
{
	if(elm.value == 'expense_type')
	{
	  if(confirm("Are you sure you want to add new expense type?"))  
		window.location = elm.value+".php";
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

</script>

 <!--.row-->
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info">
			<div class="panel-heading"> Add Your Expence Details</div>
			<div class="panel-wrapper collapse in" aria-expanded="true">
				<div class="panel-body">
					<form method="post" name="frm_expence" id="frm_expence" enctype="multipart/form-data">
						<div class="form-body">								
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Expense Type</label>
										<select id = "txt_expense_type" name = "txt_expense_type" class="form-control" onchange="javascript:fnc_add_expense_select(this);">
										<option value="">----Select----</option>
										<option value="expense_type">Add new</option>
										<?php
											$expense_typ="SELECT * FROM tbl_expense_type";
											$rs_expense_typ=mysqli_query($con , $expense_typ);
											while($row_expense_typ = mysqli_fetch_array($rs_expense_typ))
											{
										?>
											<option  value="<?php echo $row_expense_typ['expense_id'];?>" ><?php echo $row_expense_typ['expense_name'];?></option>
										<?php
											}
										?>	
										</select>
									</div>
								</div>
								<!-- /span---->
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Date</label>
										<input type="date" id="txt_date" name="txt_date" class="form-control" value = "<?php if(isset($_GET['id'])){echo $row_expence_select['date'];}?>" >										
									</div>
								</div>
							</div>
							<!--/row-->
							<div class = "row">
								<table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle" id = "dynamic_field">
									<thead>
										<th><p align = "center">Item</p></th>
										<th><p align = "center">Price/Unit</p></th>
										<th><p align = "center">Qty.</p></th>
										<th><p align = "center">Amount</p></th>
										<th><p align = "center">action</p></th>
									</thead> 
									<tbody>
									
								<?php	if(!isset($_GET['id']))
									{ ?>
									<tr id='row0'>
										<td>
											<div class="form-group">
												<input type="text" class="form-control" id="txt_item" name="txt_item[]" placeholder="Enter Item" >
											</div>
										</td>
										<td>
											<div class="form-group">
												<input type="number" id="txt_price" name="txt_price[]" onchange="tot();" class="form-control" placeholder="Enter Price" >				
											</div>
										</td>
										<td>
											<div class="form-group">
												<input type="number" id="txt_quantity" name="txt_quantity[]" onchange="tot();" value = 1 class="form-control" placeholder="Enter QUANTITY" >										
											</div>
											
										</td>
										<td>
											<div class="form-group">
												<input type="number" id="txt_amount" name="txt_amount[]" class="form-control" placeholder="Enter Amount" readonly>										
											</div>
										</td>
										<td>
											<input type="hidden" name="expence_detail_id[]" id="expence_detail_id" />
											<button type="button" name="btn_remove" id="btn_remove" class="btn btn-danger btn_remove">X</button>
										</td>
										
									</tr> <?php }?>
									</tbody>
								</table>
							</div>
							<!--/row-->
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<button type="button" name="btn_add" id="btn_add" class="btn btn-success">Add More</button>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label">Payment Type</label>
										<select id="cmb_payment_type" name="cmb_payment_type" class="form-control" onchange="fnc_payment_type_text()">
											<?php 
												$sql_payment="SELECT * FROM tbl_payment_type";
												$rs_payment=mysqli_query($con,$sql_payment);
												while($row_payment=mysqli_fetch_array($rs_payment))
												{ 
											?>
												<option value="<?php echo $row_payment['payment_type_id']; ?>" ><?php echo $row_payment['payment_type'];?></option>
											<?php
												}
											?>
										</select>								
									</div>
								</div>
								<!-- /span---->
								<div class="col-md-3" >
									<div class="form-group" id="dynamic_ref">
										<label class="control-label">Refrence No.</label>
										<input type="number" id="txt_cheque_ref" name="txt_cheque_ref" class="form-control" >
									</div>
								</div>
								<!-- /span---->
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label">Description</label>
										<textarea id="txt_description" name="txt_description" class="form-control" placeholder="Add Description"></textarea> 																		
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<input type="checkbox" id="chk_is_round_off" name="chk_is_round_off" onchange = "fnc_calculate_total();">	
										<label class="control-label">Is Round Off</label>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group" style="">
										<label class="control-label">Round Off</label>
										<input type="number" id="txt_round_off" name="txt_round_off" class="form-control" value=0.00 placeholder="" readonly>																			
									</div>
								</div>
								<!-- /span---->
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label">Total</label>
										<input type="number" id="txt_total" readonly name="txt_total" class="form-control" value=0.00 placeholder="" >																			
									</div>
								</div>
								<!-- /span---->	
							</div>
						</div>
						<div class="form-actions">
							<input type="hidden" name="expence_id" id="expence_id" value="<?php if(isset($_GET['id'])){ echo base64_decode($_GET['id']); }?>"> 
							<?php	if(isset($_GET['id']))
									{ ?>
							<button type="submit" id="btn_edit" name="btn_edit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
									<?php }else{?>
							<button type="submit" id="btn_save" name="btn_save" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
									<?php }?>
							<button type="reset" name="btn_reset" id="btn_reset" class="btn btn-default .reset">Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!--./row-->

<!-- /row -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>	
<script>
	$(document).ready(function()
	{	
		$("#dynamic_ref").hide();
		
		//alert(no_of_detail_row);
		$(document).on('click', '#btn_add', function() {
		  
		   $('#dynamic_field').append('<tr id="row"><td><div class="form-group"><input type="text" class="form-control" id="txt_item" name="txt_item[]" placeholder="Enter Item"></div></td><td><div class="form-group"><input type="number" id="txt_price" name="txt_price[]" onchange="tot();" class="form-control" placeholder="Enter Price" ></div></td><td><div class="form-group"><input type="number" id="txt_quantity" name="txt_quantity[]" onchange="tot();" value = 1 class="form-control" placeholder="Enter QUANTITY" ></div></td><td><div class="form-group"><input type="number" id="txt_amount" name="txt_amount[]" readonly class="form-control" placeholder="Enter Amount" ></div></td><td><input type="hidden" name="expence_detail_id[]" id="expence_detail_id" /><button type="button" name="btn_remove" id="btn_remove" class="btn btn-danger btn_remove">X</button></td></tr>');
		 
		});
		
		$(document).on('click', '.btn_remove', function()
		{  
			var detail_id = $(this).siblings("#expence_detail_id").val();
			if(confirm("Are you sure you want to delete this?"))
			{
				if(detail_id != '')
				{
					$.ajax({  
						url:"expence_ajax.php",
						method:"POST",  
						data:{ 'id' : detail_id , 'edit_delete_detail' : 1 },
						success:function(data)  
						{  
							//$( this ).closest("tr").css( "color", "red" );
							//$(this).closest("tr").remove();
						}  
					});
				}
				$(this).closest("tr").remove();	
			}
		}); 
		
		/*--------------------------------------------------Edit Fetch--------------------------------------------------------*/
		var expence_id= $('#expence_id').val();
		//alert(expence_id);
		if(expence_id != 0 )
		{
			$.ajax({
				url:"expence_ajax.php",
				method:"POST",  
				data:{ 'id' : expence_id , 'edit' : 1 },
				success:function(data)  
				{  
					
					
					const obj = JSON.parse(data);
					console.log(obj);
					
					document.getElementById("expence_id").value = expence_id;
					document.getElementById("txt_expense_type").value = obj.expense_id;
					document.getElementById("txt_date").value = obj.date;
					document.getElementById("cmb_payment_type").value = obj.payment_type_id;
					
					var cheque = document.getElementById("txt_cheque_ref").value = obj.cheque_ref_no;
					if(cheque != '' && cheque !=0 && val_payment == 'cheque')
					{
						$("#dynamic_ref").show();
					}
					else
					{
						$("#dynamic_ref").hide();
					}
					
					if(obj.is_round_off==1)
						document.getElementById("chk_is_round_off").checked = obj.is_round_off;
					else
						document.getElementById("chk_is_round_off").checked = false;
					
					document.getElementById("txt_round_off").value = obj.round_off;
					document.getElementById("txt_total").value = obj.total;
					document.getElementById("txt_description").value = obj.description;
				}  
			});
		}
		
		if(no_of_detail_row > 0)
		{
			$('.reset').attr("disabled" , "disabled");
			for(i=0;i<no_of_detail_row;i++)
			{
				 $('#dynamic_field').append('<tr id="unique"><td><div class="form-group"><input type="text" class="form-control" id="txt_item" name="txt_item[]" placeholder="Enter Item"></div></td><td><div class="form-group"><input type="number" id="txt_price" name="txt_price[]" onchange="tot();" class="form-control" placeholder="Enter Price" ></div></td><td><div class="form-group"><input type="number" id="txt_quantity" name="txt_quantity[]" onchange="tot();" value = 1 class="form-control" placeholder="Enter QUANTITY" ></div></td><td><div class="form-group"><input type="number" id="txt_amount" name="txt_amount[]" readonly class="form-control" placeholder="Enter Amount" ></div></td><td><input type="hidden" name="expence_detail_id[]" id="expence_detail_id" /><button type="button" name="btn_remove" id="btn_remove" class="btn btn-danger btn_remove">X</button></td></tr>');
				 
			}
		}	
		var inv_id = "<?php echo $expence_id; ?>";
		$.ajax({ 
			url: 'expence_ajax.php',
			data: {'id': inv_id, 'edit_fetch': 1},
			type: 'post',
			dataType :'json',
			success: function(data) 
			{
				
				for(i=0;i<no_of_detail_row;i++)
				{
					
					document.getElementsByName('txt_item[]')[i].value =  data[i].item_name;
					document.getElementsByName('txt_price[]')[i].value =  data[i].price;
					document.getElementsByName('txt_quantity[]')[i].value =  data[i].quantity;
					document.getElementsByName('txt_amount[]')[i].value =  data[i].total;
					document.getElementsByName('expence_detail_id[]')[i].value =  data[i].expence_detail_id;
				}
				tot();
			},
			error: function(data)
			{
				console.log('my ERROR' + data.d);								
			}
		});
	}); 
	 
</script>
	

<?php
	include_once('footer.php');
?>

