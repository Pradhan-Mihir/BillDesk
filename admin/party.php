<?php
$title = "BILL DESK-Party";
	include_once('header.php');
	
	$company_id="SELECT * FROM tbl_company WHERE is_default=1";
	$rs_company_id=mysqli_query($con,$company_id);
	
	$row_company_id=mysqli_fetch_array($rs_company_id);
	
	$sql_party_setting_select="select * from tbl_party_setting where party_setting_id=1";
	$rs_party_setting_select=mysqli_query($con,$sql_party_setting_select);
	
	$row_party_setting_select=mysqli_fetch_array($rs_party_setting_select);
	
	if(isset($_POST['btn_save']))
	{		
		if($_POST['party_id'] == '')
		{			
			//INSERT CODE
			$sql_party_iu = "CALL insertParty_master('".$_POST['cmb_party_type']."' , '".$_POST['txt_pname']."' , '".$_POST['cmb_party_grp']."' , '".$_POST['txt_mobile']."' , '".$_POST['txt_alter_mobile']."' , '".$_POST['txt_email']."' , '".$_POST['txt_bill_address']."' , '".$_POST['txt_ship_address']."' , '".$_POST['txt_gst_type']."' , '".$_POST['txt_gstno']."' , '".$_POST['txt_state']."' ,'".$row_company_id['company_id']."' ,'".$_POST['txt_add_field_1_name']."','".$_POST['txt_add_field_2_name']."','".$_POST['txt_add_field_3_name']."','".$_POST['txt_add_field_4_name']."','".$_POST['txt_opening_balance']."','".implode($_POST['rdb_status'])."','".$_POST['txt_as_of_date']."') ";
		}
		else
		{	
			//UPDATE CODE
			$sql_party_iu = "CALL updateParty_master('".$_POST['party_id']."' ,'".$_POST['cmb_party_type']."' , '".$_POST['txt_pname']."' , '".$_POST['cmb_party_grp']."','".$_POST['txt_mobile']."' , '".$_POST['txt_alter_mobile']."' , '".$_POST['txt_email']."' , '".$_POST['txt_bill_address']."' , '".$_POST['txt_ship_address']."' , '".$_POST['txt_gst_type']."' , '".$_POST['txt_gstno']."' , '".$_POST['txt_state']."' ,'".$_POST['txt_add_field_1_name']."','".$_POST['txt_add_field_2_name']."','".$_POST['txt_add_field_3_name']."','".$_POST['txt_add_field_4_name']."','".$_POST['txt_opening_balance']."','".implode($_POST['rdb_status'])."','".$_POST['txt_as_of_date']."') ";
			
		}
		
		
		$rs_party_iu = mysqli_query($con,$sql_party_iu);
		if(!$rs_party_iu)
		{
			die('User Data Not Inserted/Updated.'.mysqli_error($con));
		}
		else
		{
			echo "<script>window.location = 'party.php';</script>";
		}	
	}
?>
<script>
	function fnc_state()
	{
		var gst_in = $("#txt_gstno").val() ;
		var gst_len = gst_in.length;
		
		if(gst_len > 2)
			return;
		
		if(gst_len > 1)
			if(isNaN(gst_in[1]))
				return;
		
		//alert(gst_len);
		$.ajax({
			url: 'party_state.php',
			data: {'id': gst_in, 'state': 1},
			datatype: 'json',
			type: 'post',
			success: function(out)
			{	
				//console.log("inside success");
				const obj = JSON.parse(out);
				//console.log(obj.state_title);
				$("#txt_state").val(obj.state_title);
			}
		});	
	} 	
	
	function fnc_opening_bal()
	{
		var xd = $("txt_opening_balance").val();
		if(xd != '' )
		{
			//$("#dynamic_balance_status").empty();
			$("#dynamic_balance_status").show();
		}
		if(xd == '')
		{
			$("#dynamic_balance_status").hide();
		}
	}
	
	function fnc_validation()
	{
		var cmb_party_type = document.getElementById('cmb_party_type');
		var txt_pname = document.getElementById('txt_pname').value;
		var txt_opening_balance = document.getElementById('txt_opening_balance').value;
		var txt_mobile = document.getElementById('txt_mobile').value;
		var txt_email = document.getElementById('txt_email').value;
		var txt_bill_address = document.getElementById('txt_bill_address').value;
		var txt_ship_address = document.getElementById('txt_ship_address').value;
		var txt_gstno = document.getElementById('txt_gstno').value;
		var txt_as_of_date = document.getElementById('txt_as_of_date').value;
		
		var pname_valid = /^[A-Za-z ]+$/; 
		var mono_valid = /^\d{10}$/;
		var email_valid = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		var gst_in = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
		var today = new Date();
		var given_date = new Date(txt_as_of_date);
		
		
		
		//validation for party type
		if(cmb_party_type.selectedIndex == 0)
		{
			$('#cmb_party_type').after('<span class="error_company" style="color:red; font-size:15px;">Please Select Party Type!</span>');
			document.getElementById("cmb_party_type").focus();
			return false;
		}
		
		//validation for party name
		if(txt_pname == '')
		{
			$('#txt_pname').after('<span class="error_company" style="color:red; font-size:15px;">Party Name Is Required!</span>');
			document.getElementById("txt_pname").focus();
			return false;
		}
		if(!txt_pname.match(pname_valid))
		{
			$('#txt_pname').after('<span class="error_company" style="color:red; font-size:15px;">Please Enter Valid Party Name !</span>');
			document.getElementById("txt_pname").focus();
			return false;
		}
		
		//validation for opening balance
		if(txt_opening_balance == '')
		{
			$('#txt_opening_balance').after('<span class="error_company" style="color:red; font-size:15px;">Opening Balance Is Required!</span>');
			document.getElementById("txt_opening_balance").focus();
			return false;
		}
		
		//date validatio
		if(given_date > today)
		{
			$('#txt_as_of_date').after('<span class="error_company" style="color:red; font-size:15px;">Please Select Date Properly!</span>');
			document.getElementById("txt_as_of_date").focus();
			return false;
		}
		
		//validation for status
		if(!$('#rdb_status').is(':checked'))
		{
			//$('#rdb_status').after('<span class="error_company" style="color:red; font-size:15px;">Please Select Any One!</span>');
			$('#status').html('Please Choose Status!');
			document.getElementById("rdb_status").focus();
			return false;
		}
		
		//validation for party mobile
		if(txt_mobile == '')
		{
			$('#txt_mobile').after('<span class="error_company" style="color:red; font-size:15px;">Mobile Is Required!</span>');
			document.getElementById("txt_mobile").focus();
			return false;
		}
		if(!txt_mobile.match(mono_valid))
		{
			$('#txt_mobile').after('<span class="error_company" style="color:red; font-size:15px;">Mobile No Must Be 10!</span>');
			document.getElementById("txt_mobile").focus();
			return false;
		}
		
		//validation for party email
		if(txt_email == '')
		{
			$('#txt_email').after('<span class="error_company" style="color:red; font-size:15px;">Email Is Required!</span>');
			document.getElementById("txt_email").focus();
			return false;
		}
		if(!txt_email.match(email_valid))
		{
			$('#txt_email').after('<span class="error_company" style="color:red; font-size:15px;">Please Enter Valid Email!</span>');
			document.getElementById("txt_email").focus();
			return false;
		}
		
		//address validation 
		if(txt_bill_address == '')
		{
			$('#txt_bill_address').after('<span class="error_company" style="color:red; font-size:15px;">Billing Address Is Required!</span>');
			document.getElementById("txt_bill_address").focus();
			return false;
		}
		
		
		//address validation 
		if(txt_ship_address == '')
		{
			$('#txt_ship_address').after('<span class="error_company" style="color:red; font-size:15px;">Shipping Address Is Required!</span>');
			document.getElementById("txt_ship_address").focus();
			return false;
		}
		
		
		//validation of gst
		if(txt_gstno =='')
		{
			$('#txt_gstno').after('<span class="error_company" style="color:red; font-size:15px;">Gst No Is Required!</span>');
			document.getElementById("txt_gstno").focus();
			return false;
		}
		if(!txt_gstno.match(gst_in))
		{
			$("#txt_gstno").after('<span class="error_company" style="color:red; font-size:15px;">Please Enter Valid Gst No!</span>');
			document.getElementById("txt_gstno").focus();
			return false;
		}
		
		
		return true;
	}
</script>

<div class="row">
	<div class="col-sm-12">
		<div class="white-box">
			<div class="panel panel-info">
				<div class="panel-heading"> Add New Party </div>
				<div class="panel-wrapper collapse in" aria-expanded="true">
					<div class="panel-body">
						<form action="" method="post" name="frm_party">
							<div class="form-body">								
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Party Type</label>
											<select id="cmb_party_type" name="cmb_party_type" class="form-control" >
												<option>Select Party Type</option>
												<option value="0" >Purchase Group</option>
												<option value="1" >Sales Group</option>
											</select>
										</div>
									</div>
									<!--/span-->
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Party Name</label>
											<input type="text" id="txt_pname" name="txt_pname" class="form-control" placeholder="Enter Party Name">		
										</div>
									<!--/span-->
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Party Group</label>
											<select id="cmb_party_grp" name="cmb_party_grp" class="form-control">
												<option value="">----- SELECT PARTY GROUP ------</option>
												<?php 
													$sql_party_grp="SELECT * FROM tbl_party_group";
													$rs_party_grp=mysqli_query($con,$sql_party_grp);
													while($row_party_grp=mysqli_fetch_array($rs_party_grp))
													{ 
												?>
													<option value="<?php echo $row_party_grp['party_group_id']; ?>"><?php echo $row_party_grp['party_group_name'];?></option>
												<?php
													}
												?>
											</select>
										</div>
									</div>
								</div>
								<!--/row-->
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Opening balance</label>
											<input type="number" id="txt_opening_balance" name="txt_opening_balance" class="form-control" onkeyup="fnc_opening_bal()" placeholder="Enter Opening Balance">	
											
										</div>
									</div>
									<!--/span-->
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">As Of Date</label>
											<input type="date" id="txt_as_of_date" name="txt_as_of_date" class="form-control">								
										</div>
									<!--/span-->
									</div>
									<div class="col-mg-4" id="dynamic_balance_status">
										<div class="form-group"><label class="control-label">Balance Status</label><div class="radio radio-info"><input type="radio" id="rdb_status" name="rdb_status[]" value="to pay"><label class="control-label">To Pay</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="rdb_status" name="rdb_status[]" value="to recieve"><label class="control-label">To Recieve</label></div></div>
										<span class="error_company" id="status" style="color:red; font-size:15px;"></span>
										
									</div>	
								</div>
								<!--/row-->
								<!--start of tabs-->
								<div class="row">
									<div class="col-md-12 col-xs-12">
										<div class="white-box">
											<ul class="nav customtab nav-tabs" role="tablist">
												<li role="presentation" class="nav-item"><a href="#Contact_info" class="nav-link active" aria-controls="Contact_info" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="fa fa-home"></i></span><span class="hidden-xs"> Contact Info</span></a></li>
												<li role="presentation" class="nav-item"><a href="#Address" class="nav-link" aria-controls="Address" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-user"></i></span> <span class="hidden-xs">Address</span></a></li>
												<li role="presentation" class="nav-item"><a href="#GST_INFO" class="nav-link" aria-controls="GST_INFO" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-envelope-o"></i></span> <span class="hidden-xs">GST Info</span></a></li>
												<li role="presentation" class="nav-item"><a href="#Additional_fields" class="nav-link" aria-controls="Additional_fields" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Additional Fields</span></a></li>
											</ul>
											<div class="tab-content">
												<div class="tab-pane active" id="Contact_info">
													<!-- home set  -->
													<div class="row">
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label">Mobile No</label>
																<input type="number" id="txt_mobile" name="txt_mobile" class="form-control" placeholder="Enter Mobileno.">
															</div>
														</div>
														<!--/span-->
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label">Alter Mobile No</label>
																<input type="number" id="txt_alter_mobile" name="txt_alter_mobile" class="form-control" placeholder="Enter Alter Mobile No">										
															</div>
														<!--/span-->
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label">Email</label>
																<input type="email" id="txt_email" name="txt_email" class="form-control" placeholder="Enter Email">
																
															</div>
														</div>
														<!--/span-->
													</div>
													<!-- home end  -->
												</div>
												<div class="tab-pane" id="Address">
													<!-- Address set  -->
													<div class="row">
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label">Billing Address</label>
																<textarea id="txt_bill_address" name="txt_bill_address" class="form-control" placeholder="Enter Billing Address"></textarea>
															</div>
														<!--/span-->
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label">Shipping Address</label>
																<textarea id="txt_ship_address" name="txt_ship_address" class="form-control" placeholder="Enter Shipping Address"></textarea>
															</div>
														</div>
														<!--/span-->
													</div>
													<!-- profile end  -->
												</div>
												<div class="tab-pane" id="GST_INFO">
													<!-- gst set  -->
													<div class="row">
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label">GSTINNO</label>
																<input type="text" id="txt_gstno" name="txt_gstno" class="form-control" placeholder="Enter GSTINO." onkeyup="fnc_state();">	
															</div>
														</div>
														<!--/span-->
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label">State</label>
																<select id="txt_state" name="txt_state" class="form-control">
																	<option value="NULL">SELECT STATE</option>
																	<option value="ANDAMAN AND NICOBAR ISLANDS">ANDAMAN AND NICOBAR ISLANDS</option>
																	<option value="ANDHRA PRADESH">ANDHRA PRADESH</option>
																	<option value="ARUNACHAL PRADESH">ARUNACHAL PRADESH</option>
																	<option value="ASSAM">ASSAM</option>
																	<option value="BIHAR">BIHAR</option>
																	<option value="CHANDIGARH">CHANDIGARH</option>
																	<option value="CHHATTISGARH">CHHATTISGARH</option>
																	<option value="DAMAN AND DIU">DAMAN AND DIU</option>
																	<option value="DELHI">DELHI</option>
																	<option value="DADRA AND NAGAR HAVELI">DADRA AND NAGAR HAVELI</option>
																	<option value="GOA">GOA</option>
																	<option value="GUJARAT">GUJARAT</option>
																	<option value="HIMACHAL PRADESH">HIMACHAL PRADESH</option>
																	<option value="HARYANA">HARYANA</option>
																	<option value="JAMMU AND KASHMIR">JAMMU AND KASHMIR</option>
																	<option value="JHARKHAND">JHARKHAND</option>
																	<option value="KERALA">KERALA</option>
																	<option value="KARNATAKA">KARNATAKA</option>
																	<option value="LADAKH">LADAKH</option>
																	<option value="LAKSHADWEEP">LAKSHADWEEP</option>
																	<option value="MEGHALAYA">MEGHALAYA</option>
																	<option value="MAHARASHTRA">MAHARASHTRA</option>
																	<option value="MANIPUR">MANIPUR</option>
																	<option value="MAGHYA PRADESH">MAGHYA PRADESH</option>
																	<option value="MIZORAM">MIZORAM</option>
																	<option value="NAGALAND">NAGALAND</option>
																	<option value="ODISHA">ODISHA</option>
																	<option value="PUNJAB">PUNJAB</option>
																	<option value="PUDUCHERRY">PUDUCHERRY</option>
																	<option value="RAJASTHAN">RAJASTHAN</option>
																	<option value="SIKKIM">SIKKIM</option>
																	<option value="TAMIL NADU">TAMIL NADU</option>
																	<option value="TRIPURA">TRIPURA</option>
																	<option value="UTTARAKHAND">UTTARAKHAND</option>
																	<option value="UTTAR PRADESH">UTTAR PRADESH</option>
																	<option value="WEST BENGAL">WEST BENGAL</option>
																	<option value="TELANGANA">TELANGANA</option>
																</select>											
															</div>
														<!--/span-->
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label">GSTType</label>
																<input type="text" id="txt_gst_type" name="txt_gst_type" class="form-control" placeholder="Enter Pincode">										
															</div>
														</div>
														<!--/span-->
													</div>
													<!-- gst end  -->
												</div>
												<div class="tab-pane" id="Additional_fields">
													<!-- Additional_fields set  -->
													<div class="row">
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label"><?php echo $row_party_setting_select['additional_field_1_name'];?></label>
																<input type="text" id="txt_add_field_1_name" name="txt_add_field_1_name" class="form-control" placeholder="">		
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label"><?php echo $row_party_setting_select['additional_field_2_name'];?></label>
																<input type="text" id="txt_add_field_2_name" name="txt_add_field_2_name" class="form-control" placeholder="">										
															</div>
														<!--/span-->
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label"><?php echo $row_party_setting_select['additional_field_3_name'];?></label>
																<input type="text" id="txt_add_field_3_name" name="txt_add_field_3_name" class="form-control" placeholder="">		
															</div>
														</div>
														<!--/span-->
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label"><?php echo $row_party_setting_select['additional_field_4_name'];?></label>
																<input type="date" id="txt_add_field_4_name" name="txt_add_field_4_name" class="form-control" placeholder="">										
															</div>
														<!--/span-->
														</div>
													</div>
													<!-- additional fields end-->
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--end of tabs-->
							</div>
							<div class="form-actions">
								<input type="hidden" name="party_id" id="party_id" /> 
								<button type="submit" id="btn_save" name="btn_save" class="btn btn-success" onclick="return fnc_validation();"> <i class="fa fa-check"></i> Save</button>
								<button type="reset" name="btn_reset" id="btn_reset" class="btn btn-default">Cancel</button>
							</div>
						</form>
					</div>
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
				<div class="panel-heading"> Manage Party List</div>
			</div>																
		
			<div class="table-responsive">
				<table id="myTable" class="table table-striped">
					<thead>
						<tr>
						  <th>SR NO.</th>
						  <th>ACTION</th>
						  <th>PARTY TYPE</th>
						  <th>PARTY NAME</th>
						  <th>PARTY GROUP</th>
						  <th>MOBILE NO</th>
						  <th>ALTER MOBILE NO</th>
						  <th>EMAIL</th>
						  <th>BILLING ADDRESS</th>
						  <th>SHIPPING ADDRESS</th>
						  <th>GST TYPE</th>
						  <th>GST IN</th>
						  <th>STATE</th>
						  <th>ADDED DATE</th>
						  <th>COMPANY NAME</th>
						  <th>ADDITIONAL FIELD 1</th>
						  <th>ADDITIONAL FIELD 2</th>
						  <th>ADDITIONAL FIELD 3</th>
						  <th>ADDITIONAL FIELD 4</th>
						</tr>
				  </thead>
				<tbody>
				  <?php                                        
					$sql = "CALL viewParty_master()";
					$result = mysqli_query($con,$sql);
					$counter = 0;
					  while($row = mysqli_fetch_array($result))
					  {?>
						<tr>
						
						<td><?php echo  ++$counter ?></td>
						<td class="text-nowrap">
						  <a href="" class='btn_edit' id='<?php echo $row['party_id']?>' data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
						  <a href="" class='btn_delete' id='<?php echo $row['party_id']?>' data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
						</td>
						<td><?php if($row['party_type']== 0){ echo "Purchase Group"; } else { echo "Sales Group"; } ?></td>
						<td><?php echo $row['party_name']; ?></td>
						<td><?php echo $row['party_group_name'] ?></td>
						<td><?php echo $row['mobile_no']; ?></td>
						<td><?php echo $row['alter_mobile_no']; ?></td>
						<td><?php echo $row['email']; ?></td>                        
						<td><?php echo $row['billing_address']; ?></td>
						<td><?php echo $row['shipping_address']; ?></td>
						<td><?php echo $row['gst_type']; ?></td>
						<td><?php echo $row['gst_in']; ?></td>
						<td><?php echo $row['state']; ?></td>
						<td><?php echo $row['added_date']; ?></td>
						<td><?php echo $row['company_name']; ?></td>      
						<td><?php echo $row['additional_field_1_name']; ?></td>      
						<td><?php echo $row['additional_field_2_name']; ?></td>      
						<td><?php echo $row['additional_field_3_name']; ?></td>      
						<td><?php echo $row['additional_field_4_name']; ?></td>      
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
		$("#dynamic_balance_status").hide();
		
		$('#rdb_status').click(function(){
			$('#status').empty();
		});
		
		$('#cmb_party_type ,#txt_pname,#txt_opening_balance,#txt_mobile,#txt_email,#txt_bill_address,#txt_ship_address,#txt_gstno,#txt_as_of_date').on('keyup,change', function () {
			$(".error_company").remove();
		});

		$('.btn_delete').click(function(e)
		{
			e.preventDefault();	
			var party_id = $(this).attr("id");
			
			if(confirm("Are you sure you want to delete this?"))
			{
				$.ajax({ url: 'party_ajax.php',
						 data: {'id': party_id, 'delete': 1},
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
			$("#dynamic_balance_status").show();
			e.preventDefault();	
			var party_id = $(this).attr("id");
			if(confirm("Are you sure you want to edit this?"))
			{
				$.ajax({ url: 'party_ajax.php',
						 data: {'id': party_id, 'edit': 1},
						 type: 'post',
						 dataType :'json',
						 success: function(data) {
						 				//console.log(data);
										document.getElementById("party_id").value = party_id;
										document.getElementById("cmb_party_type").value = data.party_type;
										document.getElementById("txt_pname").value = data.party_name;
										document.getElementById("cmb_party_grp").value = data.party_group_id;
										document.getElementById("txt_mobile").value = data.mobile_no;
										document.getElementById("txt_alter_mobile").value = data.alter_mobile_no;
										document.getElementById("txt_email").value = data.email;
										document.getElementById("txt_bill_address").value = data.billing_address;
										document.getElementById("txt_ship_address").value = data.shipping_address;
										document.getElementById("txt_gst_type").value = data.gst_type;
										document.getElementById("txt_gstno").value = data.gst_in;
										fnc_state();
										
										document.getElementById("txt_state").value = data.state;
										document.getElementById("txt_add_field_1_name").value = data.additional_field_1_name;
										document.getElementById("txt_add_field_2_name").value = data.additional_field_2_name;
										document.getElementById("txt_add_field_3_name").value = data.additional_field_3_name;
										document.getElementById("txt_add_field_4_name").value = data.additional_field_4_name;
										document.getElementById("txt_opening_balance").value = data.opening_balance;
										document.getElementById("rdb_status").checked = data.balance_status;
										document.getElementById("txt_as_of_date").value = data.as_of_date;
										//$('#cmb_party_type').val('selectedvalue');
						
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

		$.ajax({  
			url:"party_setting_fetch.php",  
			method:"POST",  
			data:{ 'id' : 1 ,'setting' :1 },
			datatype:'json',
			success:function(out)  
			{  
				const obj = JSON.parse(out);
				//console.log(obj);
				//console.log(obj.additional_field_1_name);
					
				//document.getElementById("").checked = obj.is_additional_field_1;
				//for party group
				if(obj.is_party_grouping == 1)	
				{
					$('#cmb_party_grp').attr('disabled',false);
				}
				else
				{	
					$('#cmb_party_grp').attr('disabled',true);
				}
				
				//for shipping address
				if(obj.is_shipping_address == 1)	
				{
					$('#txt_ship_address').attr('disabled',false);
				}
				else
				{	
					$('#txt_ship_address').attr('disabled',true);
				}
				
				//for  additional field 1
				if(obj.is_additional_field_1 == 1)	
				{
					$('#txt_add_field_1_name').attr('disabled',false);
				}
				else
				{	
					$('#txt_add_field_1_name').attr('disabled',true);
				}
				
				//for  additional field 2
				if(obj.is_additional_field_2 == 1)	
				{
					$('#txt_add_field_2_name').attr('disabled',false);
				}
				else
				{	
					$('#txt_add_field_2_name').attr('disabled',true);
				}
				
				//for  additional field 3
				if(obj.is_additional_field_3 == 1)	
				{
					$('#txt_add_field_3_name').attr('disabled',false);
				}
				else
				{	
					$('#txt_add_field_3_name').attr('disabled',true);
				}
				
				//for  additional field 4
				if(obj.is_additional_field_4 == 1)	
				{
					$('#txt_add_field_4_name').attr('disabled',false);
				}
				else
				{	
					$('#txt_add_field_4_name').attr('disabled',true);
				}
			}  
		});
		
	}); 	
</script>
	

<?php
	include_once('footer.php');
?>
