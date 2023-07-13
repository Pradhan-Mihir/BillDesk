<?php
$title = "BILL DESK-Barcode";
	include_once('header.php');
	
	$company_id="SELECT * FROM tbl_company WHERE is_default=1";
	$rs_company_id=mysqli_query($con,$company_id);
	
	$row_company_id=mysqli_fetch_array($rs_company_id);
	
	if(isset($_POST['btn_save']))
	{		
		if($_POST['barcode_id'] == '')
		{			
			//INSERT CODE
			$sql_barcode_iu = "CALL insertBarcode_master('".$row_company_id['company_id']."' , '".$_POST['txt_barcode']."' , '".$_POST['txt_product_name']."' , '".$_POST['txt_product_code']."' , '".$_POST['cmb_gstslab']."' , '".$_POST['txt_sales_rate']."' , '".$_POST['txt_mfg_date']."' , '".$_POST['txt_exp_date']."'  , '".$_POST['txt_print_barcode']."' ,'".$_POST['chk_is_show_barcode']."') ";
			//echo $sql_party_iu;
		}
		else
		{	
			//UPDATE CODE
			$sql_barcode_iu = "CALL updateBarcode_master('".$_POST['barcode_id']."' , '".$_POST['txt_barcode']."' , '".$_POST['txt_product_name']."' , '".$_POST['txt_product_code']."' , '".$_POST['cmb_gstslab']."' , '".$_POST['txt_sales_rate']."' , '".$_POST['txt_mfg_date']."' , '".$_POST['txt_exp_date']."' , '".$_POST['txt_print_barcode']."' ,'".$_POST['chk_is_show_barcode']."') ";
			echo $sql_barcode_iu;
		}
		
		
		$rs_barcode_iu = mysqli_query($con,$sql_barcode_iu);
		if(!$rs_barcode_iu)
		{
			die('User Data Not Inserted/Updated.'.mysqli_error($con));
		}
		else
		{
			echo "<script>window.location = 'barcode.php';</script>";
		}	
	}
?>
	<script src="JsBarcode.all.min.js"></script>
<script> 
	function fnc_barcode(e)
	{
		console.log(e.value.length);
		if(e.value.length != 12)
		{	
			$('#code').hide();
			return; 
		}
		$('#code').show();
		let barcodeValue = $("#txt_barcode").val();
		let showText = $("#showText").val();			
		if(JsBarcode("#barcode", barcodeValue, {
			format: 'EAN13',
			displayValue: showText,
			lineColor: "#24292e",
			width:2,
			height:40,	
			fontSize: 20
		}))
		{check_it(); }
	}

	function generate() {
      return Math.floor(100000000 + Math.random() * 900000000);
}

	function check_it()
	{
		let code = document.getElementById('barcode');
		let num = document.getElementsByTagName('text');
		var valo = '';
		for(i=0;i<num.length;i++)
		{
			if(code.contains(num[i]))
				valo += num[i].textContent;
		}
		console.log(valo);
		//alert(val);
		$('#txt_barcode').val(valo);
	}

	
</script>
	
 <!--.row-->
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info">
			<div class="panel-heading"> Add Your Barcode  Details</div>
			<div class="panel-wrapper collapse in" aria-expanded="true">
				<div class="panel-body">
					<form action="" method="post" name="frm_expence" enctype="multipart/form-data">
						<div class="form-body">								
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Barcode</label>
										<input type="text" id="txt_barcode" name="txt_barcode" oninput="fnc_barcode(this)" class="form-control" placeholder="Enter Barcode">										
									</div>
								</div>
								<!-- /span---->
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Product Name</label>
										<select class="form-control"  id="txt_product_name" name="txt_product_name" placeholder = "select Product" >
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
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Product Code</label>
										<input type="text" id="txt_product_code" name="txt_product_code" class="form-control" placeholder="Enter Product Code" >										
									</div>
								</div>
							</div>
							<!-- /row-->
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">GSTSLAB Id</label>
										<select id="cmb_gstslab" name="cmb_gstslab" class="form-control" placeholder="Enter Sales Rate" >
											<?php
												$query="SELECT * FROM tbl_gstslab_master";
												$rs_cmb=mysqli_query($con,$query);
												while($row_cmb=mysqli_fetch_array($rs_cmb))
												{
											?>
												<option id="txt_gstslab_id" name="txt_gstslab_id" value="<?php echo $row_cmb['gstslab_id']; ?>"><?php echo $row_cmb['gstslab_name'];?></option>
											<?php
												}
											?>
										</select>										
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Sales Rate</label>
										<input type="text" id="txt_sales_rate" name="txt_sales_rate" class="form-control" placeholder="Enter Sales Rate" >										
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">MFGDate</label>
										<input type="date" id="txt_mfg_date" name="txt_mfg_date" class="form-control" placeholder="Enter MFGDate" >										
									</div>
								</div>
							</div>
							<!-- /row-->
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">EXPDate</label>
										<input type="date" id="txt_exp_date" name="txt_exp_date" class="form-control" placeholder="Enter EXPDate" >										
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Print Barcode At</label>
										<input type="number" id="txt_print_barcode" name="txt_print_barcode" class="form-control" placeholder="Enter Print Barcode At" >										
									</div>
								</div>
							</div>
							<!-- /row-->
							
							<div class="row">
								
								<div class="col-md-2">
									<div class="form-group">
										<input type="checkbox" id="chk_is_show_barcode" name="chk_is_show_barcode"  placeholder="Enter Start Date" value="1" >	
										<label class="control-label">Is Show Barcode</label>
									</div>
								</div>
								<div class="col-md-4" id="code">
									<svg id="barcode"></svg>
								</div>
								
							</div>
						</div>
						<div class="form-actions">
							<input type="hidden" name="barcode_id" id="barcode_id" /> 
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
<div class="row">
	
	<div class="col-sm-12">			
		<div class="white-box">
			<div class="panel panel-info">
				<div class="panel-heading"> Manage Barcode List</div>
			</div>																
		
			<div class="table-responsive">
				<table id="myTable" class="table table-striped">
					<thead>
						<tr>
						  <th>SR NO.</th>
						  <th>ACTION</th>
						  <th>STATUS</th>
						  <th>COMPANY NAME</th>
						  <th>BARCODE</th>
						  <th>PRODUCT NAME</th>
						  <th>PRODUCT CODE</th>
						  <th>GSTSLAB ID</th>
						  <th>SALES RATE</th>
						  <th>MFG DATE</th>
						  <th>EXP DATE</th>
						  <th>PRINT BARCODE AT</th>
						</tr>
				  </thead>
				<tbody>
				  <?php                                        
					$sql = "CALL viewBarcode_master()";
					$result = mysqli_query($con,$sql);
					$counter = 0;
					  while($row = mysqli_fetch_array($result))
					  {?>
						<tr>
						
						<td><?php echo  ++$counter ?></td>
						<td class="text-nowrap">
						  <a href="" class='btn_edit' id='<?php echo $row['barcode_id']?>' data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
						  <a href="" class='btn_delete' id='<?php echo $row['barcode_id']?>' data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
						</td>
						<td><span class="label label-success"><?php if($row['is_show_barcode']==1){echo "Show";} ?></span>
							<span class="label label-danger"><?php if($row['is_show_barcode']!=1){echo "Not Show";} ?></span>
						</td>
						<td><?php echo $row['company_id']; ?></td>
						<td><?php echo $row['barcode']; ?></td>
						<td><?php echo $row['product_name']; ?></td>
						<td><?php echo $row['product_code']; ?></td>
						<td><?php echo $row['gstslab_id']; ?></td>                        
						<td><?php echo $row['sales_rate']; ?></td>
						<td><?php echo $row['mfg_date']; ?></td>
						<td><?php echo $row['exp_date']; ?></td>
						<td><?php echo $row['print_barcode_at']; ?></td>
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
<!-- /.row -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>	
<script>
	$(document).ready(function()
	{			
		$("#txt_barcode").val('890'+generate());
		fnc_barcode(document.getElementById('txt_barcode'));
		$('.btn_delete').click(function(e)
		{
			e.preventDefault();	
			var barcode_id = $(this).attr("id");
			
			if(confirm("Are you sure you want to delete this?"))
			{
				$.ajax({ url: 'barcode_ajax.php',
						 data: {'id': barcode_id, 'delete': 1},
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
		
		
		$('.btn_edit').click(function(e)
		{
			e.preventDefault();	
			var barcode_id = $(this).attr("id");
			if(confirm("Are you sure you want to edit this?"))
			{
				$.ajax({ url: 'barcode_ajax.php',
						 data: {'id': barcode_id, 'edit': 1},
						 type: 'post',
						 dataType :'json',
						 success: function(data) {
						 					//console.log(data.barcode_id);
										document.getElementById("barcode_id").value = barcode_id;
										document.getElementById("txt_barcode").value = data.barcode;
										document.getElementById("txt_product_name").value = data.product_name;
										document.getElementById("txt_product_code").value = data.product_code;
										document.getElementById("cmb_gstslab").value = data.gstslab_id;
										document.getElementById("txt_sales_rate").value = data.sales_rate;
										document.getElementById("txt_mfg_date").value = data.mfg_date;
										document.getElementById("txt_exp_date").value = data.exp_date;
										document.getElementById("txt_print_barcode").value = data.print_barcode_at;
										document.getElementById("chk_is_show_barcode").checked = data.is_show_barcode;
										if(data.is_show_barcode==1)
										{
											document.getElementById("chk_is_show_barcode").checked = data.is_show_barcode;
										}
										else
										{
											document.getElementById("chk_is_show_barcode").checked = false;
										}
						
								  },
						error: function(data) {
						 					console.log('my ERROR' + data.d);								
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
