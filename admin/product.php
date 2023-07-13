<?php
$title = "BILL DESK-Product";
	include_once('header.php');
	
	$company_id="SELECT * FROM tbl_company WHERE is_default=1";
	$rs_company_id=mysqli_query( $con ,$company_id);
	
	$row_company_id=mysqli_fetch_array($rs_company_id);
	
	
	if(isset($_POST['btn_save']))
	{		
		if($_POST['product_id'] == '')
		{			
			if(!empty($_FILES["product_image"]["name"]))
			{			
				$img3=$_FILES["product_image"]["name"];
				$img3 = pathinfo($img3, PATHINFO_FILENAME).mt_rand(600000,999999).".".pathinfo($img3, PATHINFO_EXTENSION);				
				$tmp_name3=$_FILES["product_image"]["tmp_name"];
				if(is_uploaded_file($tmp_name3))
				{
					copy($tmp_name3,"../images/product_images/".$img3);
				}
			}
			else
			{
				$img3 = "";
			}
			//INSERT CODE
			$sql_product_iu = "CALL insertProduct_master('".$row_company_id['company_id']."' , '".$_POST['cmb_category']."' , '".$_POST['txt_barcode']."' , '".$_POST['txt_product_code']."' , '".$_POST['txt_product_name']."' , '".$_POST['cmb_gstslab']."' , '".$_POST['txt_hsn_code']."' , '".$_POST['txt_primary_unit']."' , '".$_POST['txt_primary_unit']."' , '".$_POST['txt_secondary_unit']."' ,'".$_POST['txt_purchase_rate']."' , '".$_POST['cmb_purchase_tax']."' , '".$_POST['txt_sales_rate']."' , '".$_POST['cmb_sales_tax']."' , '".$_POST['txt_opening_stock']."' , '".$_POST['txt_unit_per_price']."' ,'".$_POST['txt_description']."' , '".$_POST['txt_min_stock']."' , '".$_POST['txt_location']."' , '".$_POST['txt_product_date']."' , '".$_POST['txt_discount_sale_price']."', '".$_POST['txt_tax_rate']."' , '".$_POST['txt_additional_cess_per_unit']."', '".$_POST['txt_discount_type']."' , '".$img3."' ,'".$_POST['chk_batch']."','".$_POST['chk_serial']."') ";
			
			$rs_product_iu = mysqli_query($con,$sql_product_iu);
			
			//getting latest product_id
			$sql_prd_id = "select max(product_id) 'prd_id' from tbl_product_master";
			$rs_prd_id = mysqli_query($con , $sql_prd_id);
			$latest_product_id = mysqli_fetch_array($rs_prd_id);
			
			//insert in unit conversion
			if($_POST['txt_secondary_unit'] != '')
			{
				$sql_unit_con_iu = "insert into tbl_unit_conversion (product_id,primary_unit,primary_unit_id,secondary_unit,secondary_unit_id,rate,is_default)values('".$latest_product_id['prd_id']."','".$_POST['txt_val_primary']."','".$_POST['txt_primary_unit']."' , '".$_POST['txt_val_secondary']."' , '".$_POST['txt_secondary_unit']."' , '".$_POST['rdb_default']."' , 1)";
				$rs_unit_con_iu = mysqli_query($con , $sql_unit_con_iu);
			}
			
			//insert serial no
			
			$number_serial = count($_POST["txt_serial_no"]); 
			//echo $number_serial;
			if($number_serial > 0)  
			{  
				for($i=0; $i<$number_serial; $i++) 
				{  
					if(trim($_POST["txt_serial_no"][$i] != ''))
					{  
						$sql_serial_no = "INSERT INTO tbl_serial_no(company_id,product_id,serial_no) VALUES('".$row_company_id['company_id']."' ,'".$latest_product_id['prd_id']."','".mysqli_real_escape_string($con, $_POST["txt_serial_no"][$i])."')";
						
						$rs_serial_no = mysqli_query($con,$sql_serial_no);
					}
				}	
			}		
			
			//insert batch no
			
			$number_batch = count($_POST["txt_mrp"]); 
			
			if($number_batch > 0)  
			{  
				for($i=0; $i<$number_batch; $i++) 
				{  
					if(trim($_POST["txt_mrp"][$i] != ''))
					{  
						$sql_batch_tracking = "INSERT INTO tbl_batch_tracking(company_id,product_id,mrp_price,batch_no,exp_date,mfg_date,model_no,size,quantity) VALUES('".$row_company_id['company_id']."' ,'".$latest_product_id['prd_id']."','".mysqli_real_escape_string($con, $_POST["txt_mrp"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_batch_no"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_exp_date"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_mfg_date"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_model_no"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_size"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_batch_qty"][$i])."')";
						//echo $sql_batch_tracking;
						$rs_batch_tracking = mysqli_query($con,$sql_batch_tracking);
					}
				}	
			}
			
			if(!$rs_product_iu)
			{
				die('User Data Not Inserted/Updated.'.mysqli_error($con));
			}
			else
			{
				echo "<script>window.location = 'product.php';</script>";
			}
		
			
		}
		else
		{	
			$sql_image_select = "select product_image from tbl_product_master where product_id = '".$_POST['product_id']."'";
			$run_image_select = mysqli_query($con , $sql_image_select);
			
			if($run_image_select)
			{
				$row_image_select = mysqli_fetch_array($run_image_select);
				$image1=$row_image_select['product_image'];
			}
			
			if(!empty($_FILES["product_image"]["name"]))
			{			
				$img3=$_FILES["product_image"]["name"];
				$img3 = pathinfo($img3, PATHINFO_FILENAME).mt_rand(600000,999999).".".pathinfo($img3, PATHINFO_EXTENSION);				
				$tmp_name3=$_FILES["product_image"]["tmp_name"];
				$path = '../images/product_images/';
			
				if(file_exists($path.$image1))
				{
					copy($tmp_name3,"../images/product_images/".$img3);
					unlink($path.$image1);
				}
			}
			else
			{
				$img3 = $row_image_select['product_image'];
			}
			//UPDATE CODE
			$sql_product_iu = "CALL updateProduct_master('".$_POST['product_id']."' , '".$_POST['cmb_category']."' , '".$_POST['txt_barcode']."' , '".$_POST['txt_product_code']."' , '".$_POST['txt_product_name']."' , '".$_POST['cmb_gstslab']."' , '".$_POST['txt_hsn_code']."' , '".$_POST['txt_primary_unit']."' , '".$_POST['txt_primary_unit']."' , '".$_POST['txt_secondary_unit']."' , '".$_POST['txt_purchase_rate']."' , '".$_POST['cmb_purchase_tax']."' , '".$_POST['txt_sales_rate']."' , '".$_POST['cmb_sales_tax']."' , '".$_POST['txt_opening_stock']."' , '".$_POST['txt_unit_per_price']."' ,'".$_POST['txt_description']."' , '".$_POST['txt_min_stock']."' , '".$_POST['txt_location']."' , '".$_POST['txt_product_date']."','".$_POST['txt_discount_sale_price']."','".$_POST['txt_tax_rate']."','".$_POST['txt_additional_cess_per_unit']."','".$_POST['txt_discount_type']."' , '".$img3."' ) ";
			
			//run upadte query
			$rs_product_iu = mysqli_query($con,$sql_product_iu);
			
			//update conversion_table
			if($_POST['txt_secondary_unit'] != '' && $_POST['conversion_id'] != '')
			{
				//update
				$sql_unit_con_iu = "update tbl_unit_conversion set  primary_unit = '".$_POST['txt_val_primary']."', primary_unit_id = '".$_POST['txt_primary_unit']."', secondary_unit = '".$_POST['txt_val_secondary']."' , secondary_unit_id = '".$_POST['txt_secondary_unit']."', rate = '".$_POST['rdb_default']."' where conversion_id = '".$_POST['conversion_id']."'";
				$rs_unit_con_iu = mysqli_query($con , $sql_unit_con_iu);
			}
			else if($_POST['txt_secondary_unit'] == '' && $_POST['conversion_id'] != '')
			{
				//delete
				$sql_unit_con_iu = "delete from tbl_unit_conversion where conversion_id = '".$_POST['conversion_id']."'";
				$rs_unit_con_iu = mysqli_query($con , $sql_unit_con_iu);
			}
			else if($_POST['txt_secondary_unit'] != '' && $_POST['conversion_id'] == '')
			{
				//insert
				$sql_unit_con_iu = "insert into tbl_unit_conversion (product_id,primary_unit,primary_unit_id,secondary_unit,secondary_unit_id,rate,is_default)values('".$_POST['product_id']."','".$_POST['txt_val_primary']."','".$_POST['txt_primary_unit']."' , '".$_POST['txt_val_secondary']."' , '".$_POST['txt_secondary_unit']."' , '".$_POST['rdb_default']."' , 1)";
				$rs_unit_con_iu = mysqli_query($con , $sql_unit_con_iu);
			}
			
			//update/insert serial_no
			$number_serial = count($_POST["txt_serial_no"]); 
			//echo $number_serial;
			if($number_serial > 0)  
			{  
				for($i=0; $i<$number_serial; $i++) 
				{  
					if($_POST['serial_no_id'][$i] == '')
					{
						if(trim($_POST["txt_serial_no"][$i] != ''))
						{  
							$sql_serial_no = "INSERT INTO tbl_serial_no(company_id,product_id,serial_no) VALUES('".$row_company_id['company_id']."' ,'".$_POST['product_id']."','".mysqli_real_escape_string($con, $_POST["txt_serial_no"][$i])."')";
							
							$rs_serial_no = mysqli_query($con,$sql_serial_no);
						}
					}
					else
					{
						if(trim($_POST["txt_serial_no"][$i] != ''))
						{  
							$sql_serial_no = "UPDATE tbl_serial_no SET serial_no = '".mysqli_real_escape_string($con, $_POST["txt_serial_no"][$i])."' where  serial_no_id = '".$_POST['serial_no_id'][$i]."'";
							
							$rs_serial_no = mysqli_query($con,$sql_serial_no);
						}
					}
				}	
			}
			
			//update/insert batch
			$number_batch = count($_POST["txt_mrp"]); 
			
			if($number_batch > 0)  
			{  
				for($i=0; $i<$number_batch; $i++) 
				{  
					if($_POST['txt_batch_tracking_id'][$i] == '')
					{
						if(trim($_POST["txt_mrp"][$i] != ''))
						{  
							$sql_batch_tracking = "INSERT INTO tbl_batch_tracking(company_id,product_id,mrp_price,batch_no,exp_date,mfg_date,model_no,size,quantity) VALUES('".$row_company_id['company_id']."' ,'".$_POST['product_id']."' , '".mysqli_real_escape_string($con, $_POST["txt_mrp"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_batch_no"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_exp_date"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_mfg_date"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_model_no"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_size"][$i])."','".mysqli_real_escape_string($con, $_POST["txt_batch_qty"][$i])."')";
							//echo $sql_batch_tracking;
							$rs_batch_tracking = mysqli_query($con,$sql_batch_tracking);
						}
					}
					else
					{
						if(trim($_POST["txt_mrp"][$i] != ''))
						{  
							$sql_batch_tracking = "update tbl_batch_tracking set mrp_price =  '".mysqli_real_escape_string($con, $_POST["txt_mrp"][$i])."' , batch_no = '".mysqli_real_escape_string($con, $_POST["txt_batch_no"][$i])."' , exp_date = '".mysqli_real_escape_string($con, $_POST["txt_exp_date"][$i])."' , mfg_date = '".mysqli_real_escape_string($con, $_POST["txt_mfg_date"][$i])."' , model_no = '".mysqli_real_escape_string($con, $_POST["txt_model_no"][$i])."' , size = '".mysqli_real_escape_string($con, $_POST["txt_size"][$i])."' , quantity = '".mysqli_real_escape_string($con, $_POST["txt_batch_qty"][$i])."' where batch_tracking_id  = '".$_POST['txt_batch_tracking_id'][$i]."' ";
							//echo $sql_batch_tracking;
							$rs_batch_tracking = mysqli_query($con,$sql_batch_tracking);
						}
					}
				}	
			}
		
			//check update query
			if(!$rs_product_iu)
			{
				die('User Data Not Inserted/Updated.'.mysqli_error($con));
			}
			else
			{
				echo "<script>window.location = 'product_view.php';</script>";
			}
		}
	}
?>	

<script type="text/javascript" language="javascript">
var swit = 0;
	//RESTRIC FILE SIZE 2 MB
	function ValidateSize(file) {
        var FileSize = file.files[0].size / 1024 / 1024; // in MB
        if (FileSize > 2) {
            alert('File size exceeds 2 MB');
			file.value = '';
			return false;
           // $(file).val(''); //for clearing with Jquery
        }
		return true;
    }
	
	function fnc_popup()
	{
		$("#dynamic_unit").empty();
		var p_unit=$("#txt_primary_unit").val();
		var s_unit=$("#txt_secondary_unit").val();
		var prd_id = $("#product_id").val();
		//console.log(prd_id);
		
		if(p_unit != s_unit && p_unit != '' && s_unit != '')
		{
			//alert(p_unit);
			$('#dynamic_unit').empty();
			$('#dynamic_unit').append('<div class="col-md-12"><div class="form-group"><table border ="0" align="center"><tr><td align="left"><input class ="new_rate_value"type="radio" id="rdb_default" name="rdb_default" ></td><td><h5>&nbsp;&nbsp;&nbsp;1</h5></td><td><input type="text" class="form-control" name="txt_val_primary" id="txt_val_primary" style="background-color:white; color:black;" readonly /></td><td>=&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input type="number" class="form-control" id="txt_rate" name="txt_rate" onkeyup="fnc_rate(this);"></td><td><input type="text" class="form-control" name="txt_val_secondary" id="txt_val_secondary" readonly style="background-color:white; color:black;"/></td></tr></table></div></div>');
			$("#txt_val_primary").val($("#txt_primary_unit option:selected").text());
			$("#txt_val_primary").css("border", "0px");
			$("#txt_val_secondary").css("border", "0px"); 
			$("#txt_val_secondary").val($("#txt_secondary_unit option:selected").text());
			
			//$("#txt_val_primary").val(p_unit);
			
			$.ajax({
				url: 'product_ajax.php',
				data: {'Sid': s_unit,'Pid': p_unit, 'primary_secondary_unit': 1 ,'product_id': prd_id},
				datatype: 'json',
				type: 'post',
				success:function(data)
				{
					$('#unit_list').empty();
					//console.log(data);
					const output = JSON.parse(data);
					//console.log(("#txt_val_primary").text());
					//$('#unit_list').append(data);
					if(output.Fail == 1)
					{
						$('#unit_list').append('<td colspan = "4">No DATA Avaliable</td>');
						//console.log('hello');
						return;
					}
					for(let i = 0; i <output.length ; i++)
					{
						if(output[i].is_chk == 1)
							$('#unit_list').append("<tr><td>"+ (i + 1) +"</td><td><input type='radio' id='rdb_default' name='rdb_default' value = "+output[i].rate+"  checked></td><td>"+output[i].primary_unit+"</td><td>"+output[i].rate+"</td><td>"+output[i].secondary_unit+"</td></tr>");
						else
							$('#unit_list').append("<tr><td>"+ (i + 1) +"</td><td><input type='radio' id='rdb_default' name='rdb_default' value = "+output[i].rate+"></td><td>"+output[i].primary_unit+"</td><td>"+output[i].rate+"</td><td>"+output[i].secondary_unit+"</td></tr>");
					}
					
					//alert("inside success");
					//const obj = JSON.parse(data);
					//alert(obj.unit_name);
					
				}
			});		
		}
	}
	
function fnc_rate(e)
	{
		var value_for_new_rate = e.value; 
		$('.new_rate_value').val(value_for_new_rate) ;
		//console.log(xyz);
	}
	
function fnc_batch(e)
{
	//console.log(e.value);
	if(e.checked == 1)
		$("#link_batch").show();
	else
		$("#link_batch").hide();
}	
function fnc_serial(e)
{
	if(e.checked == 1)
		$("#link_serial").show();
	else
		$("#link_serial").hide();
}
function fnc_serial_batch(e)
{
    let bat = document.getElementById('chk_batch');
    let ser = document.getElementById('chk_serial');
    if(bat == e)
    {
        //console.log('hello');
        ser.checked = 0;
        fnc_serial(ser);
        return;
    }
    if(ser == e)
    {
        //console.log('bye');
        bat.checked = 0;
        fnc_batch(bat);
        return;
    }
}
</script>

<style>
 
.modal-batch {
    max-width: 80%;
}       

</style>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				<form>
					<div class = 'row'>
						<div class = "col-md-6">
							Add New Product
						</div>
						<div class = "col-md-6" style="text-align: right;">
							<label class="control-label">Product&nbsp;<label>
							<input type="checkbox" data-color="#13dafe" data-size="small" data-secondary-color="#6164c1" class="js-switch" id="swt_product">
						<label>&nbsp;Service</label>
						</div>
					</div>
				</form>
			</div>
			<div class="panel-wrapper collapse in" aria-expanded="true">
				<div class="panel-body">
					<form action="" method="post" id = "frm_product" name="frm_product" enctype="multipart/form-data" >
						<div class="form-body">								
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Category Name</label>
										<select id="cmb_category" name="cmb_category" class="form-control">
											<?php 
												$query="SELECT cat.* FROM tbl_category cat LEFT JOIN tbl_company com ON com.company_id = cat.company_id WHERE com.is_default = 1;";
												$rs_cmb=mysqli_query($con,$query);
												while($row_cmb=mysqli_fetch_array($rs_cmb))
												{ 
											?>
												<option value="<?php echo $row_cmb['category_id']; ?>"><?php echo $row_cmb['category_name'];?></option>
											<?php
												} 
											?>
										</select>								
									</div>
								</div>
								<!--/span-->
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Barcode</label>
										<input type="text" id="txt_barcode" name="txt_barcode" class="form-control" placeholder="Enter Barcode.">										
									</div>
								<!--/span-->
								</div>
								<div class="col-md-4">
									<div class="form-group" id="switch_code">
										<label class="control-label">Product Code</label>
										<input type="text" id="txt_product_code" name="txt_product_code" class="form-control" placeholder="Enter Product Code.">										
									</div>
								</div>
								<!--/span-->
							</div>
							<!--/row-->
							<div class="row">
								<div class="col-md-4">
									<div class="form-group" id="switch_name">
										<label class="control-label">Product Name</label>
										<input type="tex" id="txt_product_name" name="txt_product_name" class="form-control" placeholder="Enter Email">										
									</div>
								<!--/span-->
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Gstslab Name</label>
										<select id="cmb_gstslab" name="cmb_gstslab" class="form-control">
											<?php
											
												$query="SELECT gst.* FROM tbl_gstslab_master gst LEFT JOIN  tbl_company com ON com.company_id = gst.company_id WHERE com.is_default = 1;";
												$rs_cmb=mysqli_query($con,$query);
												while($row_cmb=mysqli_fetch_array($rs_cmb))
												{
													
											?>
												<option value="<?php  echo $row_cmb['gstslab_id']; ?>"><?php echo $row_cmb['gstslab_name'];?></option>
											<?php
											
												} 
											?>
										</select>
									</div>
								</div>
								<!--/span-->
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Hsn Code</label>
										<input type="text" id="txt_hsn_code" name="txt_hsn_code" class="form-control" placeholder="Enter Hsn code">										
									</div>
								<!--/span-->
								</div>
							</div>
							<!--/row-->
							<div class="row">
								<div class="col-md-4">
									<label class="control-label">Unit</label>
									<div>
										<button type="button" id="btn_popup_unit" class="btn btn-info" data-toggle="modal" data-target="#unit_model">Select Unit</button>
									</div>
									<div class="modal fade" id="unit_model" role="dialog">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
													<h4>Unit</h4>
												</div>
												<div class="modal-body">
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="control-label">Primary Unit</label>
																<select class="form-control" id="txt_primary_unit" name="txt_primary_unit" onchange="fnc_popup();">
																	<option value = "">Select Primary Unit</option>
																		<?php
																		$sql_unit="SELECT * from tbl_unit";
																		$rs_unit = mysqli_query($con,$sql_unit);
																		while($row_unit=mysqli_fetch_array($rs_unit))
																		{
																		?>
																			<option value="<?php echo $row_unit['unit_id']; ?>"><?php echo $row_unit['unit_name'];?></option>
																		<?php
																		}
																		?>
																</select>
															</div>
														</div>
														<!---/span--->
														<div class="col-md-6">
															<div class="form-group">
																<label class="control-label">Secondary Unit</label>
																<select class="form-control" id="txt_secondary_unit" name="txt_secondary_unit" onchange="fnc_popup();">
																	<option value = "">select secondary unit</option>
																		<?php
																		$sql_unit="SELECT * from tbl_unit ";
																		$rs_unit = mysqli_query($con,$sql_unit);
																		while($row_unit=mysqli_fetch_array($rs_unit))
																		{
																		?>
																			<option value="<?php echo $row_unit['unit_id']; ?>"><?php echo $row_unit['unit_name'];?></option>
																		<?php
																		}
																		?>
																</select>
															</div>
														</div>
													</div>
													<div class="row" id="dynamic_unit">
													</div>
													<div class="row">
														<table class='table table-striped'>
															<thead>
																<th>NO.</th>
																<th>STATUS</th>
																<th>PRIMARY UNIT</th>
																<th>RATE</th>
																<th>SECONDARY UNIT</th>
															</thead>
															<tbody id="unit_list">
																
															</tbody>
														</table>	
													</div>													
												</div>
											</div>
										</div>
									</div>	
								</div>								
								<!--/span-->
								<div class="col-md-2">
									<div class="form-group">
										<label class="control-label">Opening Stock</label>
										<input type="number" id="txt_opening_stock" name="txt_opening_stock" class="form-control" placeholder="Enter Opening Stock">										
									</div>
								<!--/span-->
								</div>
								
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label" >Batch Tracking</label>&nbsp;<input type="checkbox" id="chk_batch" name="chk_batch" value=1 onchange="fnc_batch(this);fnc_serial_batch(this);"></br>
										<label class="control-label" >Serial No Tracking</label>&nbsp;<input type="checkbox" id="chk_serial" name="chk_serial" value=1 onchange="fnc_serial(this);fnc_serial_batch(this);">
									</div>
								<!--/span-->
								</div>
								
								<div class="col-md-1">
									<div class="form-group">
										
										<a href="#" id="link_serial" class="form-control" data-toggle="modal" data-target="#serial">Serial</a>
										<a href="#" id="link_batch" class="form-control"  data-toggle="modal" data-target="#batch">Batch</a>
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
																	<table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle" id = "dynamic_serial">
																		<thead>
																			<th><p align = "center">SERIAL NO</p></th>
																			<th><p align = "center">ACTION</p></th>
																		</thead>
																		<tbody id="serial_row">	
																			<tr id="row_serial">
																				<td align="center">
																					<div class="col-md-16">
																						<div class="form-group">
																							<input type="text" class="form-control" id="txt_serial_no" name="txt_serial_no[]" placeholder="Enter Serial No">
																						</div>
																					</div>
																				</td>
																				<td align="center">
																					<div class="col-md-3">
																						<div class="form-group">
																							<button type="button" id="btn_remove_serial" name="btn_remove_serial" class="btn btn-danger">X</button>
																							<input type="hidden" id="serial_no_id" name="serial_no_id[]">
																						</div>
																					</div>
																				</td>
																			</tr>
																		<tbody>	
																	</table>	
																	<button type="button" id="btn_add_serial" name="btn_add_serial" class="btn btn-success"><i class="fa fa-plus"></i></button>
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
															<table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle" id = "dynamic_field">
																<thead>
																	<th><p align = "center">MRP/PRICE</p></th>
																	<th><p align = "center">BATCH NO</p></th>
																	<th><p align = "center">EXP DATE</p></th>
																	<th><p align = "center">MFG DATE</br>(%)</p></th>
																	<th><p align = "center">MODEL NO</p></th>
																	<th><p align = "center">SIZE</p></th>
																	<th><p align = "center">QUANTITY</p></th>
																	<th><p align = "center">ACTION</p></th>
																</thead> 
																<tbody id="batch_row">
																	<tr id='row_batch'>
																		<td>
																			<div class="form-group">
																				<input type="number" id="txt_mrp" name="txt_mrp[]" class="form-control" placeholder="MRP.">
																			</div>
																		</td>
																		<td>
																			<div class="form-group">
																				<input type="text" id="txt_batch_no" name="txt_batch_no[]"  class="form-control" placeholder="Enter Batch no" >										
																			</div>
																		</td>
																		<td>
																			<div class="form-group">
																				<input type="date" id="txt_mfg_date" name="txt_mfg_date[]"  class="form-control"  >										
																			</div>
																		</td>
																		<td>
																			<div class="form-group">
																				<input type="date" id="txt_exp_date" name="txt_exp_date[]"  class="form-control"  >										
																			</div>
																		</td>
																		<td>
																			<div class="form-group">
																				<input type="text" id="txt_model_no" name="txt_model_no[]"  class="form-control" placeholder="Enter Model No" >										
																			</div>
																		</td>
																		<td>
																			<div class="form-group">
																				<input type="text" id="txt_size" name="txt_size[]"  class="form-control" placeholder="Enter size" >										
																			</div>
																		</td>
																		<td>
																			<div class="form-group">
																				<input type="text" id="txt_batch_qty" name="txt_batch_qty[]"  class="form-control" placeholder="Enter quantity" >										
																			</div>
																		</td>
																		<td>
                                                                            <button type="button" name="btn_remove_batch[]" id="btn_remove_batch" class="btn btn-danger btn_remove">X</button>
                                                                            <input type="hidden" id="txt_batch_tracking_id" name="txt_batch_tracking_id[]">
																		</td>
																	</tr>
																</tbody>
															</table>
															<tr>
																<button type="button" id="btn_add_batch" name="btn_add_batch" class="btn btn-success"><i class="fa fa-plus"></i></button>
															</tr>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								<!--/span-->
								</div>
							</div>
							<!--/row-->
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Purchase Rate</label>
										<input type="number" id="txt_purchase_rate" name="txt_purchase_rate" class="form-control" placeholder="Enter Purchase Rate">										
									</div>
								<!--/span-->
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Purchase Tax Type</label>
										<select id="cmb_purchase_tax" name="cmb_purchase_tax" class="form-control">
											<option value="Including Gst">Including Gst</option>
											<option value="Excluding Gst">Excluding Gst </option>
										</select>									
									</div>
								</div>
								<!--/span-->
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Sales Rate</label>
										<input type="number" id="txt_sales_rate" name="txt_sales_rate" class="form-control" placeholder="Enter Sales Tax.">										
									</div>
								<!--/span-->
								</div>
							</div>
							<!--/row-->
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Sales Tax Type</label>
										<select id="cmb_sales_tax" name="cmb_sales_tax" class="form-control">
											<option value="Including Gst">Including Gst</option>
											<option value="Excluding Gst">Excluding Gst </option>
										</select>
									</div>
								</div>
								<!--/span-->
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Unit Per Price</label>
										<input type="number" id="txt_unit_per_price" name="txt_unit_per_price" class="form-control" placeholder="Enter Unit Per Price.">										
									</div>
								<!--/span-->
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Description</label>
										<textarea id="txt_description" name="txt_description" class="form-control" placeholder="Enter Description."></textarea>									
									</div>
								</div>
								<!--/span-->
							</div>
							<!--/row-->
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Minimum Stock Qty.</label>
										<input type="number" id="txt_min_stock" name="txt_min_stock" class="form-control" placeholder="Enter CST NO.">										
									</div>
								<!--/span-->
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Product Location</label>
										<input type="text" id="txt_location" name="txt_location" class="form-control" placeholder="Enter STAX NO.">																		
									</div>
								</div>
								<!--/span-->
								<div class="col-md-4 col-xs-12">
									<div class="form-group">
										<label class="control-label">Product Date</label>
										<input type="date" id="txt_product_date" name="txt_product_date" class="form-control">		
									</div>
								</div>
							</div>
							<!--/row-->
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Discount Sale Price</label>
										<input type="text" id="txt_discount_sale_price" class="form-control"  name="txt_discount_sale_price" placeholder="Enter Discount Sale Price"/>
									</div>
								<!--/span-->
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Tax Rate</label>
										<input type="text" id="txt_tax_rate" name="txt_tax_rate" class="form-control" placeholder="Enter Tax Rate">										
									</div>
								</div>
								<!--/span-->
								<div class="col-md-4 col-xs-12">
									<div class="form-group">
										<label class="control-label">Additinal Cess Per Unit</label>
										<input type="text" id="txt_additional_cess_per_unit" class="form-control"  name="txt_additional_cess_per_unit" placeholder="Enter Additinal Cess Per Unit"/>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Discount Type</label>
										<input type="text" id="txt_discount_type" name="txt_discount_type" class="form-control" placeholder="Enter Discount Type">									
									</div>
								</div>
								<!--/span-->
								<div class="col-md-4 col-xs-12">
									<div class="form-group">
										<label class="control-label">Product Image </label>
										<input type="file" id="input-file-now-custom-1" class="dropify"  name="product_image" />
									</div>
								</div>
							</div>
						</div>
						<div class="form-actions">
							<input type="hidden" name="product_id" id="product_id" value="<?php if(isset($_GET['id'])){ echo base64_decode($_GET['id']);} ?>" />
							<input type="hidden" name="conversion_id" id="conversion_id" />
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


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>	
<script>
	$(document).ready(function()
	{	
		$("#link_batch").hide();
		$("#link_serial").hide();
		
		$("#btn_add_serial").click(function(){
			//alert("click");
			$("#dynamic_serial").append('<tr id="row_serial"><td align="center"><div class="col-md-16"><div class="form-group"><input type="text" class="form-control" id="txt_serial_no" name="txt_serial_no[]" placeholder="Enter Serial No"></div></div></td><td align="center"><div class="col-md-3"><div class="form-group"><button type="button" id="btn_remove_serial" name="btn_remove_serial" class="btn btn-danger">X</button><input type="hidden" id="serial_no_id" name="serial_no_id[]"></div></div></td></tr>');
			//to move cursor to the newly added row....let user experience no mouse input
			var ser_no = document.getElementsByName('txt_serial_no[]')
			ser_no[ser_no.length - 1].focus();
		});
		
		$(document).on('click', '#btn_remove_serial', function(){ 
			var detail_id = $(this).siblings("#serial_no_id").val();
			//console.log(detail_id);
			if(detail_id != '')
			{
				if(confirm("are you sure you want to delete this"))
				{
					$.ajax({ url: 'product_ajax.php',
							 data: {'id': detail_id, 'serial_delete': 1},
							 type: 'post',
							 success: function(output) {					 			
										  //window.location.reload();
									}
							});
					$(this).closest('tr').remove();
				}
			}
			else
				$(this).closest('tr').remove();
		});
		
		$(document).on('click', '#btn_add_batch', function(){ 
			//alert("click");
			$("#dynamic_field").append('<tr><td><div class="form-group"><input type="number" id="txt_mrp" name="txt_mrp[]" class="form-control" placeholder="MRP."></div></td><td><div class="form-group"><input type="text" id="txt_batch_no" name="txt_batch_no[]"  class="form-control" placeholder="Enter Batch no" ></div></td><td><div class="form-group"><input type="date" id="txt_exp_date" name="txt_exp_date[]"  class="form-control" ></div></td><td><div class="form-group"><input type="date" id="txt_mfg_date" name="txt_mfg_date[]"  class="form-control"  ></div></td><td><div class="form-group"><input type="text" id="txt_model_no" name="txt_model_no[]"  class="form-control" placeholder="Enter Model No" ></div></td><td><div class="form-group"><input type="text" id="txt_size" name="txt_size[]"  class="form-control" placeholder="Enter size" ></div></td><td><div class="form-group"><input type="text" id="txt_batch_qty" name="txt_batch_qty[]"  class="form-control" placeholder="Enter quantity" ></div></td><td><button type="button" name="btn_remove_batch[]" id="btn_remove_batch" class="btn btn-danger btn_remove">X</button><input type="hidden" id="txt_batch_tracking_id" name="txt_batch_tracking_id[]"></td></tr>');
			//to move cursor to the newly added row....let user experience no mouse input
			var mrp = document.getElementsByName('txt_mrp[]')
			mrp[mrp.length - 1].focus();
			
		});
		
		$(document).on('click', '#btn_remove_batch', function(){ 
			var detail_id = $(this).siblings("#txt_batch_tracking_id").val();
			//console.log(detail_id);
			if(detail_id != '')
			{
				if(confirm("are you sure you want to delete this"))
				{
					$.ajax({ url: 'product_ajax.php',
							 data: {'id': detail_id, 'batch_delete': 1},
							 type: 'post',
							 success: function(output) {					 			
										  //window.location.reload();
									}
							});
					$(this).closest('tr').remove();
				}
			}
			else
			{
				$(this).closest('tr').remove();
			}
		});
		
	
		var sec_unit_val = $('#txt_secondary_unit').val();
		if(sec_unit_val == '')
		{
			
		}
		
		
	$(".dropify-clear").click(function()
    {
      var $this = $(this);
      
      if($this.value = 'undefined') 
      {
         $('.dropify-clear').css("display", "none");
         $('.dropify-loader').css("display", "none");
         $('.dropify-preview').css("display", "block");
         $('.dropify-filename-inner').text('');  
      }
      else 
      {  
        
        $('.dropify-clear').css("display", "block");
        $('.dropify-loader').css("display", "none");
        $('.dropify-preview').css("display", "block");
        
      }
    });
    
    $('#product_image').on('change', function() {
      $('.dropify-clear').css("display", "block");
      $('.dropify-loader').css("display", "none");
      $('.dropify-preview').css("display", "block");
    });
    
    $('.dropify-clear').click(function(e)
     {
       e.preventDefault();
       // your statements;
       $('.dropify-filename-inner').text('');    
     });
		
		var product_id = $('#product_id').val();
	
		if(product_id != 0 )
		{
			$('#frm_product').trigger('reset');
			
			var imagePath1 = "../images/product_images/";
			if(confirm("Are you sure you want to edit this?"))
			{
				$.ajax({ url: 'product_ajax.php',
						 data: {'id': product_id, 'edit': 1},
						 type: 'post',
						 dataType :'json',
						 success: function(data) {
											//console.log("inside success");
						 					//console.log(data);
										document.getElementById("product_id").value = product_id;
										document.getElementById("cmb_category").value = data.category_id;
										document.getElementById("txt_barcode").value = data.barcode;
										document.getElementById("txt_product_code").value = data.product_code;
										document.getElementById("txt_product_name").value = data.product_name;
										document.getElementById("cmb_gstslab").value = data.gstslab_id;
										document.getElementById("txt_hsn_code").value = data.hsn_code;
										document.getElementById("txt_primary_unit").value = data.primary_unit_id;
										if(data.num > 0 )
										{
											document.getElementById("txt_secondary_unit").value = data.secondary_unit_id;
											document.getElementById("conversion_id").value = data.conversion_id;
										}
										document.getElementById("txt_purchase_rate").value = data.purchase_rate;
										if(data.is_batch == 1)
										{
											document.getElementById("chk_batch").checked = true;
											fnc_batch(document.getElementById("chk_batch"));
											document.getElementById('row_batch').remove();
											
											$.ajax({ url: 'product_ajax.php',
													 data: {'id': product_id, 'batch_fetch': 1},
													 type: 'post',
													 success: function(data) {		
																const obj = JSON.parse(data);													 
																$('#batch_row').html(obj);
															}
													});	
											
											
										}
										
										if(data.is_serial== 1)
										{
											document.getElementById("chk_serial").checked = true;
											fnc_serial(document.getElementById("chk_serial"));
											
											document.getElementById('row_serial').remove();
											
											$.ajax({ url: 'product_ajax.php',
													 data: {'id': product_id, 'serial_fetch': 1},
													 type: 'post',
													 success: function(data) {		
																const obj = JSON.parse(data);													 
																$('#serial_row').html(obj);
															}
													});	
											
										}
										
										document.getElementById("cmb_purchase_tax").value = data.purchase_tax_type;
										document.getElementById("txt_sales_rate").value = data.sales_rate;
										document.getElementById("cmb_sales_tax").value = data.sales_tax_type;
										document.getElementById("txt_opening_stock").value = data.opening_stock;
										document.getElementById("txt_unit_per_price").value = data.unit_per_price;
										document.getElementById("txt_description").value = data.description;
										document.getElementById("txt_min_stock").value = data.min_stock_qty;
										document.getElementById("txt_location").value = data.product_location;
										document.getElementById("txt_product_date").value = data.product_date;
										document.getElementById("txt_discount_sale_price").value = data.discount_on_sale;
										document.getElementById("txt_tax_rate").value = data.tax_rate;
										document.getElementById("txt_additional_cess_per_unit").value = data.additional_cess_per_unit;
										document.getElementById("txt_discount_type").value = data.discount_type;
										fnc_popup();
										
										
										var imagePath2 = data.product_image;
										//alert(imagePath1 + imagePath2);
										$('#product_image').attr("data-default-file",imagePath1 + imagePath2);
										$('.dropify-preview').css("display","block");
										$('.dropify-render').prepend('<img id = "edit_img"/>');
										$("#edit_img").attr("src", imagePath1 + imagePath2 );
										$('.dropify-filename-inner').text(imagePath2);
										$(".dropify-clear").css("display","initial");
										//$(".dropify-clear").trigger("click");
										//document.getElementById("btn_save").value = "Edit Company";	
										//$('#txt_pwd').attr('disabled', 'disabled');
										//$('#cpassword').attr('disabled', 'disabled');
										$('#product_image').attr('disabled', 'disabled');	
								  },
						error: function(data) {
						 					console.log('my ERROR' + data);								
								  }
				});				
			}
			else
			{
				return false;
			}
		}
		
		$("#swt_product").on('click',function(){
			//alert("clicked");
			var x = $("#swt_party").val();
			swit++;
			//console.log(swit);
			
			if(swit % 2 == 1)
			{
				//console.log("in");
				$("#switch_code").empty();
				$("#switch_code").append('<label class="control-label">Service Code</label><input type="text" id="txt_product_code" name="txt_product_code" class="form-control" placeholder="Enter Service Code.">');
			
				$("#switch_name").empty();
				$("#switch_name").append('<label class="control-label">Service Name</label><input type="text" id="txt_product_name" name="txt_product_name" class="form-control" placeholder="Enter Service Name.">');
				
				$("#txt_purchase_rate").attr("disabled",true);
				$("#cmb_purchase_tax").attr("disabled",true);
			}
			if(swit % 2 == 0)
			{
				//console.log("out");
				$("#switch_code").empty();
				$("#switch_code").append('<label class="control-label">Product Code</label><input type="text" id="txt_product_code" name="txt_product_code" class="form-control" placeholder="Enter Product Code.">');
			
				$("#switch_name").empty();
				$("#switch_name").append('<label class="control-label">Product Name</label><input type="text" id="txt_product_name" name="txt_product_name" class="form-control" placeholder="Enter Product Name.">');
			
				$("#txt_purchase_rate").attr("disabled",false);
				$("#cmb_purchase_tax").attr("disabled",false);
			}
			
			
		});
	}); 
	 
</script>
	

<?php
	include_once('footer.php');
?>

<script src="plugins/bower_components/dropify/dist/js/dropify.min.js"></script>
    <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();

        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove: 'Supprimer',
                error: 'Désolé, le fichier trop volumineux'
            }
        });

        // Used events
        var drEvent = $('#input-file-events').dropify();

        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });

        drEvent.on('dropify.afterClear', function(event, element) {
            alert('File deleted');
        });

        drEvent.on('dropify.errors', function(event, element) {
            //console.log('Has Errors');
        });

        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
		
    });
    </script>