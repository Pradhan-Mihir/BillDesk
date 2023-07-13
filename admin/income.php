<?php
	$title="BILL DESK-Income";
	include_once('header.php');
	
	$detail_row_num = 0;
	$income_id = 0;
	
	//fetch data for update
	if(isset($_GET['id']))
	{	
		$income_id=base64_decode($_GET['id']);
		$sql_income_select = "select * from tbl_income where income_id = '".$income_id."' ";
		$rs_income_select = mysqli_query($con,$sql_income_select);
		$row_income_select = mysqli_fetch_array($rs_income_select);
		//fetch data for invoice detail
		$sql_income_detail_select = "select * from tbl_income_detail where income_id = '".$income_id."'";
		$rs_income_detail_select = mysqli_query($con , $sql_income_detail_select);
		$detail_row_num = mysqli_num_rows($rs_income_detail_select);
		
	}
	
	//fetch active financial year
	$financial="SELECT financial_id from tbl_financial_master WHERE is_default=1";
	$rs_financial=mysqli_query($con,$financial);
	$row_financial_id=mysqli_fetch_array($rs_financial);
	
	//fetch active company id
	$company_id="SELECT * FROM tbl_company WHERE is_default=1";
	$rs_company_id=mysqli_query($con,$company_id);
	$row_company_id=mysqli_fetch_array($rs_company_id);
	
	//insert code
	if(isset($_POST['btn_save']))
	{
		if($_POST['income_id'] == '')
		{
			//INSERT CODE
			$sql_income_iu = "insert into tbl_income(company_id,financial_id,income_type_id,date,payment_type_id,cheque_ref_no,is_round_off,round_off,total,description) values('".$row_company_id['company_id']."','".$row_financial_id['financial_id']."','".$_POST['txt_income_type']."','".$_POST['txt_date']."','".$_POST['cmb_payment_type']."','".$_POST['txt_cheque_ref']."','".$_POST['chk_is_round_off']."','".$_POST['txt_round_off']."','".$_POST['txt_total']."','".$_POST['txt_description']."')";
			
			$rs_income_iu =  mysqli_query($con , $sql_income_iu);
			$last_id =  mysqli_insert_id($con);
			
			if(!$rs_income_iu)
			{
				die("data not inserted".mysqli_error($con));
			}
			else
			{
				echo "<script>window.location.href='invoice.php?income_id=$last_id';</script>";
				//echo "<script>window.location='income_view.php';</script>";
			}
			
			
			$sql_inv_id = "select max(income_id) 'inv_id' from tbl_income";
			$rs_inv_id = mysqli_query($con , $sql_inv_id);
			$inv_id = mysqli_fetch_array($rs_inv_id);
			
			//company_ledger
			$objname = "income";
			$debit=0.00;
			$party_id = "0";
			
			$sql_company_ledger="insert into tbl_company_ledger(company_id , related_id , related_obj_name,party_id, date, details, credit, debit, financial_id, new_invoice_no) values('".$row_company_id['company_id']."' , '".$inv_id["inv_id"]."' ,'".$objname."','".$party_id."' , '".$_POST['txt_date']."' , '".$_POST['txt_description']."' , '".$_POST['txt_total']."','".$debit."','".$row_financial_id['financial_id']."','".$_POST['txt_new_invoice_no']."')";
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
					$sql_income_detail = "insert into tbl_income_detail(income_id,item_name,price,quantity,total) values('".$inv_id["inv_id"]."','".$_POST["txt_item"][$i]."','".$_POST["txt_price"][$i]."','".$_POST["txt_quantity"][$i]."','".$_POST["txt_amount"][$i]."')";
					
					mysqli_query($con,$sql_income_detail);
				}
			}
		}
	}
	if(isset($_POST['btn_edit']))
	{
		//update tbl_income
		$sql_income_iu = "update tbl_income set company_id = '".$row_company_id['company_id']."',financial_id = '".$row_financial_id['financial_id']."',income_type_id = '".$_POST['txt_income_type']."',date = '".$_POST['txt_date']."',payment_type_id = '".$_POST['cmb_payment_type']."',cheque_ref_no='".$_POST['txt_cheque_ref']."',is_round_off = '".$_POST['chk_is_round_off']."',round_off = '".$_POST['txt_round_off']."',total = '".$_POST['txt_total']."' ,description = '".$_POST['txt_description']."' where income_id = '".$_POST['income_id']."' "; 
		$rs_income_iu = mysqli_query($con,$sql_income_iu);
		
		//company ledger update...
		$objname = "income";
		$debit=0.00;
		$party_id = 0;
		
		$sql_update_company_ledger = "update tbl_company_ledger set company_id = '".$row_company_id['company_id']."',related_id = '".$_POST['income_id']."',related_obj_name='".$objname."',party_id = '".$party_id."',date = '".$_POST['txt_date']."' ,details = '".$_POST['txt_description']."' , credit = '".$_POST['txt_total']."' , debit = '".$debit."',financial_id = '".$row_financial_id['financial_id']."' where related_id = '".$_POST['income_id']."' and related_obj_name = '".$objname."' ";
		$rs_update_company_ledger = mysqli_query($con,$sql_update_company_ledger);
		
		if(isset($_POST["txt_price"][1]))
			$number = count($_POST["txt_price"]);
		else
			$number = 1;
		
		if($number > 0)  
		{  
			for($i=0; $i<$number; $i++)  
			{
				if(trim($_POST["income_detail_id"][$i] == ''))		   
				{
					$sql_income_detail = "insert into tbl_income_detail(income_id,item_name,price,quantity,total) values('".$_POST['income_id']."','".mysqli_real_escape_string($con, $_POST["txt_item"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_price"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_quantity"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_amount"][$i])."')";
					
					mysqli_query($con,$sql_income_detail);
				}
				else
				{
					$sql_income_detail = "update tbl_income_detail set income_id = '".$_POST['income_id']."',item_name = '".mysqli_real_escape_string($con, $_POST["txt_item"][$i])."',price = '".mysqli_real_escape_string($con, $_POST["txt_price"][$i])."',quantity = '".mysqli_real_escape_string($con, $_POST["txt_quantity"][$i])."',total = '".mysqli_real_escape_string($con, $_POST["txt_amount"][$i])."' where income_detail_id = '".mysqli_real_escape_string($con, $_POST["income_detail_id"][$i])."'  ";
					echo $sql_income_detail;
					
					mysqli_query($con,$sql_income_detail);
				}
			}
			echo "updated";
		}
		
		if(!$rs_update_company_ledger)
		{
			die("data not updated".mysqli_error($con));
		}
		else
		{
			echo "<script>window.location.href='invoice.php?income_id=$income_id';</script>";
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

	//to check for round off
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

function fnc_add_income_select(elm)
{
	if(elm.value == 'income_type')
	{
	  if(confirm("Are you sure you want to add new income type?"))  
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
			<div class="panel-heading"> Add Your Income Details</div>
			<div class="panel-wrapper collapse in" aria-expanded="true">
				<div class="panel-body">
					<form action="" method="post" name="frm_income" id="frm_income" enctype="multipart/form-data">
						<div class="form-body">								
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Income Type</label>
										<select id = "txt_income_type" name = "txt_income_type" class="form-control" onchange="javascript:fnc_add_income_select(this);">
										<option value="">----Select----</option>
										<option value="income_type">Add new</option>
										<?php
											$income_typ="SELECT * FROM tbl_income_type";
											$rs_income_typ=mysqli_query($con , $income_typ);
											while($row_income_typ = mysqli_fetch_array($rs_income_typ))
											{
										?>
											<option  value="<?php echo $row_income_typ['income_type_id'];?>"><?php echo $row_income_typ['income_type_name'];?></option>
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
										<input type="date" id="txt_date" name="txt_date" class="form-control" >										
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
											<input type="hidden" name="income_detail_id[]" id="income_detail_id" />
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
										<input type="number" id="txt_cheque_ref" name="txt_cheque_ref" class="form-control">		
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
										<input type="checkbox" id="chk_is_round_off" name="chk_is_round_off" onchange = "fnc_calculate_total()">	
										<label class="control-label">Is Round Off</label>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label">Round Off</label>
										<input type="number" id="txt_round_off" name="txt_round_off" class="form-control" value=0.00 placeholder="" readonly>																			
									</div>
								</div>
								<!-- /span---->
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label">Total</label>
										<input type="number" id="txt_total" name="txt_total" readonly class="form-control" value=0.00 placeholder="" >																			
									</div>
								</div>
								<!-- /span---->
									
							</div>
						</div>
						<div class="form-actions">
							<input type="hidden" name="income_id" id="income_id" value="<?php if(isset($_GET['id'])){ echo base64_decode($_GET['id']); }?>"> 
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
		  
		   $('#dynamic_field').append('<tr id="row"><td><div class="form-group"><input type="text" class="form-control" id="txt_item" name="txt_item[]" placeholder="Enter Item"></div></td><td><div class="form-group"><input type="number" id="txt_price" name="txt_price[]" onchange="tot();" class="form-control" placeholder="Enter Price" ></div></td><td><div class="form-group"><input type="number" id="txt_quantity" name="txt_quantity[]" onchange="tot();" value = 1 class="form-control" placeholder="Enter QUANTITY" ></div></td><td><div class="form-group"><input type="number" id="txt_amount" name="txt_amount[]" readonly class="form-control" placeholder="Enter Amount" ><td><input type="hidden" name="income_detail_id[]" id="income_detail_id"><button type="button" name="btn_remove" id="btn_remove" class="btn btn-danger btn_remove">X</button></td></tr>');
		 
		});
		
		$(document).on('click', '.btn_remove', function()
		{  
			 var detail_id = $(this).siblings("#income_detail_id").val();
			if(confirm("Are you sure you want to delete this?"))
			{
				if(detail_id != '')
				{
					$.ajax({  
						url:"income_ajax.php",
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
		var income_id= $('#income_id').val();
	
		if(income_id != 0 )
		{
			$.ajax({
				url:"income_ajax.php",
				method:"POST",  
				data:{ 'id' : income_id , 'edit' : 1 },
				success:function(data)  
				{  
					const obj = JSON.parse(data);
					console.log(obj);
					
					document.getElementById("income_id").value = income_id;
					document.getElementById("txt_income_type").value = obj.income_type_id;
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
				 $('#dynamic_field').append('<tr id="unique"><td><div class="form-group"><input type="text" class="form-control" id="txt_item" name="txt_item[]" placeholder="Enter Item"></div></td><td><div class="form-group"><input type="number" id="txt_price" name="txt_price[]" onchange="tot();" class="form-control" placeholder="Enter Price" ></div></td><td><div class="form-group"><input type="number" id="txt_quantity" name="txt_quantity[]" onchange="tot();" value = 1 class="form-control" placeholder="Enter QUANTITY" ></div></td><td><div class="form-group"><input type="number" id="txt_amount" name="txt_amount[]" readonly class="form-control" placeholder="Enter Amount" ></div></td><td><input type="hidden" name="income_detail_id[]" id="income_detail_id" /><button type="button" name="btn_remove" id="btn_remove" class="btn btn-danger btn_remove">X</button></td></tr>');
				 
			}
		}	
		var inv_id = "<?php echo $income_id; ?>";
		$.ajax({ 
			url: 'income_ajax.php',
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
					document.getElementsByName('income_detail_id[]')[i].value =  data[i].income_detail_id;
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