<?php
	include_once('header.php');
	
	if(isset($_POST['btn_save']))
	{
		$sql_update_product_setting ="update tbl_product_setting set is_enable_item='".$_POST['chk_enable_item']."',what_do_you_sell='".$_POST['cmb_what_do_you_sell']."',is_serial_no='".$_POST['chk_serial_no']."',is_barcode_scan='".$_POST['chk_barcode_scan']."',is_stock_maintenance='".$_POST['chk_stock_maintenance']."',is_show_low_stock_dialog='".$_POST['chk_low_stock']."',is_item_unit='".$_POST['chk_item_unit']."',is_default_unit='".$_POST['chk_default_unit']."',is_item_category='".$_POST['chk_item_category']."',is_party_wise_rate='".$_POST['chk_party_wise_item_rate']."',is_description='".$_POST['chk_description']."',is_item_wise_tax='".$_POST['chk_item_wise_tax']."',is_item_wise_discount='".$_POST['chk_item_wise_discount']."',is_update_sale_price='".$_POST['chk_sale_price_from_transaction']."',quantity_upto_decimal='".$_POST['txt_quantity_decimal']."' ,is_seial_no='".$_POST['chk_serial_no']."',is_mrp_price='".$_POST['chk_mrp_price']."',is_batch_no='".$_POST['chk_batch_no']."',is_exp_date='".$_POST['chk_exp_date']."',is_mfg_date='".$_POST['chk_mfg_date']."',is_model_no='".$_POST['chk_model_no']."',is_size='".$_POST['chk_size']."',serial_no='".$_POST['txt_serial_no']."',mrp_price='".$_POST['txt_mrp_price']."',batch_no='".$_POST['txt_batch_no']."',exp_date='".$_POST['txt_exp_date']."',mfg_date='".$_POST['txt_mfg_date']."',model_no='".$_POST['txt_modal_no']."',size='".$_POST['txt_size']."' where product_setting_id =1 ";
		
		//echo $sql_update_party_setting;
		$rs_update_product_setting = mysqli_query($con,$sql_update_product_setting);
		
		if(!$rs_update_product_setting)
		{
			//die('Not Updated...!'.mysqli_error($con));
			echo "Not updated";
		}
		else
		{
			echo "<script>window.location = 'product_setting.php';</script>";
		}
	}
?>
<script>
		
	function fnc_enable_disable_serial_no(chk_serial_no)
	{
		var val_serial = document.getElementById("txt_serial_no");
		val_serial.disabled = chk_serial_no.checked ? false : true;
		if(!val_serial.disabled)
		{
			val_serial.focus();
			//$("#txt_batch_no").attr("disabled",true);
			//$("#chk_batch_no").attr("checked",false);
			
		}
	}
	
	function fnc_enable_disable_mrp(chk_mrp_price)
	{
		var val_mrp = document.getElementById("txt_mrp_price");
		val_mrp.disabled = chk_mrp_price.checked ? false : true;
		if(!val_mrp.disabled)
		{
			val_mrp.focus();
		}
	}
	
	function fnc_enable_disable_batch_no(chk_batch_no)
	{
		var val_batch_no = document.getElementById("txt_batch_no");
		val_batch_no.disabled = chk_batch_no.checked ? false : true;
		if(!val_batch_no.disabled)
		{
			val_batch_no.focus();
			//$("#chk_serial_no").attr("checked",false);
			//$("#txt_serial_no").attr("disabled",true);
		}
		
	}
	
	function fnc_enable_disable_exp_date(chk_exp_date)
	{
		var val_exp_date = document.getElementById("txt_exp_date");
		val_exp_date.disabled = chk_exp_date.checked ? false : true;
		if(!val_exp_date.disabled)
		{
			val_exp_date.focus();
		}
	}
	
	function fnc_enable_disable_mfg_date(chk_mfg_date)
	{
		var val_mfg_date = document.getElementById("txt_mfg_date");
		val_mfg_date.disabled = chk_mfg_date.checked ? false : true;
		if(!val_mfg_date.disabled)
		{
			val_mfg_date.focus();
		}
	}
	
	function fnc_enable_disable_model_no(chk_model_no)
	{
		var val_model_no = document.getElementById("txt_modal_no");
		val_model_no.disabled = chk_model_no.checked ? false : true;
		if(!val_model_no.disabled)
		{
			val_model_no.focus();
		}
	}
	
	function fnc_enable_disable_size(chk_size)
	{
		var val_size = document.getElementById("txt_size");
		val_size.disabled = chk_size.checked ? false : true;
		if(!val_size.disabled)
		{
			val_size.focus();
		}
	}
</script>	
<!--./row--->
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info">
			<div class="panel-heading">Product Setting</div>
			<div class="panel-wrapper collapse in" aria-expanded="true">
				<div class="panel-body">
					<form action="" method="post" name="frm_product_setting" >
						<div class="form-body">		
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<input  type="checkbox" id="chk_enable_item" name="chk_enable_item" checked ><label class="control-label"> &nbsp;Enable Item </label>
									</div>
								</div>
								<!---/span--->
								<div class="col-md-4">
									<div class="form-group">
										<label class="contol-label">what do you sell?</label>
										<select id="cmb_what_do_you_sell" name="cmb_what_do_you_sell"class="form-control">
											<option value="">----- SELECT -----</option>
											<option value="Product">Product</option>
											<option value="Service">Service</option>
											<option value="Product/Service">Product/Service</option>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<div class="form-group m-b-40">
											<input type="checkbox" id="chk_serial_no" name="chk_serial_no" onchange = "fnc_enable_disable_serial_no(this)"  > 
                                            <label for="txt_serial_no" class="control-label">Serial No./ IMEl No.</label>
											<input type="text" class="form-control" id="txt_serial_no" name="txt_serial_no"  ><span class="highlight"></span> <span class="bar"></span>
                                        </div>
									</div>
								</div>
							</div>	
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<input  type="checkbox" id="chk_barcode_scan" name="chk_barcode_scan" ><label class="control-label"> &nbsp;Barcode Scan </label>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<input  type="checkbox" id="chk_stock_maintenance" name="chk_stock_maintenance" ><label class="control-label"> &nbsp;Stock Maintenance </label>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group m-b-40">
										<input type="checkbox" id="chk_mrp_price" name="chk_mrp_price" onchange = "fnc_enable_disable_mrp(this)"  > 
										<label for="txt_mrp_price" class="control-label">MRP/Price</label>
										<input type="text" class="form-control" id="txt_mrp_price" name="txt_mrp_price" >
									</div>
								</div>
							</div>	
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<input  type="checkbox" id="chk_low_stock" name="chk_low_stock" ><label class="control-label"> &nbsp;Show Low Stock Dialog </label>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<input  type="checkbox" id="chk_item_unit" name="chk_item_unit" ><label class="control-label"> &nbsp;Items Unit </label>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group m-b-40">
										<input type="checkbox" id="chk_batch_no" name="chk_batch_no" onchange = "fnc_enable_disable_batch_no(this)"  > 
										<label for="txt_batch_no" class="control-label">Batch No.</label>
										<input type="text" class="form-control" id="txt_batch_no" name="txt_batch_no"  ><span class="highlight"></span> <span class="bar"></span>
									</div>
								</div>
							</div>	
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<input  type="checkbox" id="chk_default_unit" name="chk_default_unit" ><label class="control-label"> &nbsp;Default Unit </label>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<input  type="checkbox" id="chk_item_category" name="chk_item_category" ><label class="control-label"> &nbsp;Item Category</label>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group m-b-40">
										<input type="checkbox" id="chk_exp_date" name="chk_exp_date" onchange = "fnc_enable_disable_exp_date(this)"  > 
										<label for="txt_exp_date" class="control-label">Exp Date</label>
										<input type="date" class="form-control" id="txt_exp_date" name="txt_exp_date">
									</div>
								</div>
							</div>	
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<input  type="checkbox" id="chk_party_wise_item_rate" name="chk_party_wise_item_rate" ><label class="control-label"> &nbsp;Party Wise Item Rate</label>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<input  type="checkbox" id="chk_description" name="chk_description" ><label class="control-label"> &nbsp;Descriptions</label>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group m-b-40">
										<input type="checkbox" id="chk_mfg_date" name="chk_mfg_date" onchange = "fnc_enable_disable_mfg_date(this)"  > 
										<label for="txt_mfg_date" class="control-label">Mfg Date</label>
										<input type="date" class="form-control" id="txt_mfg_date" name="txt_mfg_date">
									</div>
								</div>
							</div>	
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<input  type="checkbox" id="chk_item_wise_tax" name="chk_item_wise_tax" ><label class="control-label"> &nbsp;Item Wise tax</label>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<input  type="checkbox" id="chk_item_wise_discount" name="chk_item_wise_discount" ><label class="control-label"> &nbsp;Item Wise Discount</label>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group m-b-40">
										<input type="checkbox" id="chk_model_no" name="chk_model_no" onchange = "fnc_enable_disable_model_no(this)"  > 
										<label for="txt_modal_no" class="control-label">Model No.</label>
										<input type="text" class="form-control" id="txt_modal_no" name="txt_modal_no">
									</div>
								</div>
							</div>	
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<input  type="checkbox" id="chk_sale_price_from_transaction" name="chk_sale_price_from_transaction" ><label class="control-label"> &nbsp;Update Sale Price from Transaction</label>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Quantity (Upto Decimal Places)</label>
										<input type="number" class="form-control" id="txt_quantity_decimal" name="txt_quantity_decimal">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group m-b-40">
										<input type="checkbox" id="chk_size" name="chk_size" onchange = "fnc_enable_disable_size(this)"  > 
										<label for="txt_size" class="control-label">Size</label>
										<input type="text" class="form-control" id="txt_size" name="txt_size" >
									</div>
								</div>
							</div>	
						</div>
				</div>
						<div class="form-actions">
							<button type="submit" id="btn_save" name="btn_save" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
							<button type="reset" name="btn_reset" id="btn_reset" class="btn btn-default">Cancel</button>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>	
<script>
	$(document).ready(function()
	{
		$.ajax({  
			url:"product_setting_fetch.php",  
			method:"POST",  
			data:{ 'id' : 1 ,'setting' :1 },
			datatype:'json',
			success:function(out)  
			{  
				const obj = JSON.parse(out);
				console.log(obj);
				//console.log(obj.additional_field_1_name);
				document.getElementById("txt_quantity_decimal").value = obj.quantity_upto_decimal;
				document.getElementById("cmb_what_do_you_sell").value = obj.what_do_you_sell;
		
				//for barcode scan
				document.getElementById("chk_barcode_scan").checked = obj.is_barcode_scan;
				if(obj.is_barcode_scan == 1)	
				{
					document.getElementById("chk_barcode_scan").checked = obj.is_barcode_scan;
				}
				else
				{		
					document.getElementById("chk_barcode_scan").checked = false;
				}
				
				//for serial no
				document.getElementById("chk_serial_no").checked = obj.is_serial_no;
				if(obj.is_serial_no == 1)	
				{
					$("#txt_serial_no").attr('disabled',false);
					
					document.getElementById("chk_serial_no").checked = obj.is_serial_no;
				}
				else
				{	
					$("#txt_serial_no").attr('disabled',true);
					
					document.getElementById("chk_serial_no").checked = false;
				}
				
				//for stock maintenance
				document.getElementById("chk_stock_maintenance").checked = obj.is_stock_maintenance;
				if(obj.is_stock_maintenance == 1)	
				{	
					document.getElementById("chk_stock_maintenance").checked = obj.is_stock_maintenance;
				}
				else
				{	
					document.getElementById("chk_stock_maintenance").checked = false;
				}
				
				//for mrp/price
				document.getElementById("chk_mrp_price").checked = obj.is_mrp_price;
				if(obj.is_mrp_price == 1)	
				{	
					$("#txt_mrp_price").attr('disabled',false);
					document.getElementById("chk_mrp_price").checked = obj.is_mrp_price;
				}
				else
				{	
					$("#txt_mrp_price").attr('disabled',true);
					document.getElementById("chk_mrp_price").checked = false;
				}
				
				//for show low stock dialog
				document.getElementById("chk_low_stock").checked = obj.is_show_low_stock_dialog;
				if(obj.is_show_low_stock_dialog == 1)	
				{	
					document.getElementById("chk_low_stock").checked = obj.is_show_low_stock_dialog;
				}
				else
				{	
					document.getElementById("chk_low_stock").checked = false;
				}
				
				//for items unit
				document.getElementById("chk_item_unit").checked = obj.is_item_unit;
				if(obj.is_item_unit == 1)	
				{	
					document.getElementById("chk_item_unit").checked = obj.is_item_unit;
				}
				else
				{	
					document.getElementById("chk_item_unit").checked = false;
				}
				
				//for batch no
				document.getElementById("chk_batch_no").checked = obj.is_batch_no;
				if(obj.is_batch_no == 1)	
				{	
					$("#txt_batch_no").attr('disabled',false);
					
					document.getElementById("chk_batch_no").checked = obj.is_batch_no;
				}
				else
				{	
					$("#txt_batch_no").attr('disabled',true);
					
					document.getElementById("chk_batch_no").checked = false;
				}
				
				//for default unit
				document.getElementById("chk_default_unit").checked = obj.is_default_unit;
				if(obj.is_default_unit == 1)	
				{	
					document.getElementById("chk_default_unit").checked = obj.is_default_unit;
				}
				else
				{	
					document.getElementById("chk_default_unit").checked = false;
				}
				
				//for item category
				document.getElementById("chk_item_category").checked = obj.is_item_category;
				if(obj.is_item_category == 1)	
				{	
					document.getElementById("chk_item_category").checked = obj.is_item_category;
				}
				else
				{	
					document.getElementById("chk_item_category").checked = false;
				}
				
				//for exp date
				document.getElementById("chk_exp_date").checked = obj.is_exp_date;
				if(obj.is_exp_date == 1)	
				{	
					$("#txt_exp_date").attr('disabled',true);
					document.getElementById("chk_exp_date").checked = obj.is_exp_date;
				}
				else
				{	
					$("#txt_exp_date").attr('disabled',true);
					document.getElementById("chk_exp_date").checked = false;
				}
				
				//for party wise item rate
				document.getElementById("chk_party_wise_item_rate").checked = obj.is_party_wise_rate;
				if(obj.is_party_wise_rate == 1)	
				{	
					document.getElementById("chk_party_wise_item_rate").checked = obj.is_party_wise_rate;
				}
				else
				{	
					document.getElementById("chk_party_wise_item_rate").checked = false;
				}
				
				//for description
				document.getElementById("chk_description").checked = obj.is_description;
				if(obj.is_description == 1)	
				{	
					document.getElementById("chk_description").checked = obj.is_description;
				}
				else
				{	
					document.getElementById("chk_description").checked = false;
				}
				
				//for mfg date
				document.getElementById("chk_mfg_date").checked = obj.is_mfg_date;
				if(obj.is_mfg_date == 1)	
				{	
					$("#txt_mfg_date").attr('disabled',true);
					document.getElementById("chk_mfg_date").checked = obj.is_mfg_date;
				}
				else
				{	
					$("#txt_mfg_date").attr('disabled',true);
					document.getElementById("chk_mfg_date").checked = false;
				}
				
				//for item wise tax
				document.getElementById("chk_item_wise_tax").checked = obj.is_item_wise_tax;
				if(obj.is_item_wise_tax == 1)	
				{	
					document.getElementById("chk_item_wise_tax").checked = obj.is_item_wise_tax;
				}
				else
				{	
					document.getElementById("chk_item_wise_tax").checked = false;
				}
				
				//for item wise discount
				document.getElementById("chk_item_wise_discount").checked = obj.is_item_wise_discount;
				if(obj.is_item_wise_discount == 1)	
				{	
					document.getElementById("chk_item_wise_discount").checked = obj.is_item_wise_discount;
				}
				else
				{	
					document.getElementById("chk_item_wise_discount").checked = false;
				}
				
				//for model no
				document.getElementById("chk_model_no").checked = obj.is_model_no;
				if(obj.is_model_no == 1)	
				{	
					$("#txt_modal_no").attr('disabled',true);
					document.getElementById("chk_model_no").checked = obj.is_model_no;
				}
				else
				{	
					$("#txt_modal_no").attr('disabled',true);
					document.getElementById("chk_model_no").checked = false;
				}
				
				//for Update Sale Price from Transaction
				document.getElementById("chk_sale_price_from_transaction").checked = obj.is_update_sale_price;
				if(obj.is_update_sale_price == 1)	
				{	
					document.getElementById("chk_sale_price_from_transaction").checked = obj.is_update_sale_price;
				}
				else
				{	
					document.getElementById("chk_sale_price_from_transaction").checked = false;
				}
				
				//for size
				document.getElementById("chk_size").checked = obj.is_size;
				if(obj.is_size == 1)	
				{	
					$("#txt_size").attr('disabled',true);
					document.getElementById("chk_size").checked = obj.is_size;
				}
				else
				{	
					$("#txt_size").attr('disabled',true);
					document.getElementById("chk_size").checked = false;
				}
			}  
		});
		
	});	
</script>	
<?php
	include_once('footer.php');
?>