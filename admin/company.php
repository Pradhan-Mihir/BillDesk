<?php
$title = "BILL DESK-Company";
	include_once('header.php');
	
	if(isset($_POST['btn_save']))
	{	

		if($_POST['company_id'] == '')
		{			
			if(!empty($_FILES["company_img"]["name"]))
			{			
			$img3=$_FILES["company_img"]["name"];
			$img3 = pathinfo($img3, PATHINFO_FILENAME).mt_rand(600000,999999).".".pathinfo($img3, PATHINFO_EXTENSION);				
			$tmp_name3=$_FILES["company_img"]["tmp_name"];
			if(is_uploaded_file($tmp_name3))
			{
				copy($tmp_name3,"../images/company_images/".$img3);
			}
			}
			else
			{
				$img3 = "";
			}
			//INSERT CODE
			$sql_company_iu = "CALL insertCompany('".$_POST['txt_company_name']."' , '".$_POST['txt_mobile']."' , '".$_POST['txt_alter_mobile']."' , '".$_POST['txt_email']."' , '".$_POST['txt_address']."' , '".$_POST['txt_city']."' , '".$_POST['cmb_state']."' , '".$_POST['txt_pincode']."' , '".$_POST['txt_gstno']."' , '".$_POST['txt_bank_name']."' , '".$_POST['txt_acno']."' , '".$_POST['txt_ifsc']."' , '".$_POST['txt_panno']."' ,'".$_POST['txt_tinno']."' , '".$_POST['txt_cstno']."' , '".$_POST['txt_staxno']."' , '".$_POST['txt_general_lic_no']."' , '".$img3."' ,'".$_POST['chk_is_default']."') ";
			
		}
		else
		{	
			$sql_image_select = "select company_logo from tbl_company where company_id = '".$_POST['company_id']."'";
			$run_image_select = mysqli_query($con , $sql_image_select);
			
			if($run_image_select)
			{
				$row_image_select = mysqli_fetch_array($run_image_select);
				$image1=$row_image_select['company_logo'];
			}
			
			if(!empty($_FILES["company_img"]["name"]))
			{			
				$img3=$_FILES["company_img"]["name"];
				$img3 = pathinfo($img3, PATHINFO_FILENAME).mt_rand(600000,999999).".".pathinfo($img3, PATHINFO_EXTENSION);				
				$tmp_name3=$_FILES["company_img"]["tmp_name"];
				$path = '../images/company_images/';
			
				if(is_uploaded_file($tmp_name3))
				{
					copy($tmp_name3,"../images/company_images/".$img3);
					unlink($path.$image1);
				}
			}
			else
			{
				$img3 = $row_image_select['company_logo'];
			}
			//UPDATE CODE
			$sql_company_iu = "CALL updateCompany('".$_POST['company_id']."' , '".$_POST['txt_company_name']."' , '".$_POST['txt_mobile']."' , '".$_POST['txt_alter_mobile']."' , '".$_POST['txt_email']."' , '".$_POST['txt_address']."' , '".$_POST['txt_city']."' , '".$_POST['cmb_state']."' , '".$_POST['txt_pincode']."' , '".$_POST['txt_gstno']."' , '".$_POST['txt_bank_name']."' , '".$_POST['txt_acno']."' , '".$_POST['txt_ifsc']."' , '".$_POST['txt_panno']."' ,'".$_POST['txt_tinno']."' , '".$_POST['txt_cstno']."' , '".$_POST['txt_staxno']."' , '".$_POST['txt_general_lic_no']."' , '".$img3."' ,'".$_POST['chk_is_default']."') ";
			
		}
		
		$rs_company_iu = mysqli_query($con,$sql_company_iu);
		if(!$rs_company_iu)
		{
			//echo "<script>fnc_msg('no');</script>";
			die('User Data Not Inserted/Updated.'.mysqli_error($con));
		}
		else
		{
			//echo "<script>fnc_msg('yes');</script>";
			echo "<script>window.location = 'company.php';</script>";
		}	
	}
?>

<script type="text/javascript" language="javascript">

	//RESTRIC FILE SIZE 2 MB
	function ValidateSize(file) {
        var FileSize = file.files[0].size / 1024 / 1024; // in MB
        if (FileSize > 2) {
            alert('File size exceeds 2 MB');
			file.value = '';
			return false;
           // $(file).val(''); //for clearing with Jquery
        }
		else 
		{
			document.getElementById('imgprw').src = window.URL.createObjectURL(file.files[0]);		
        }
		return true;
    }
	function RemoveImage()
	{		
		document.getElementById('imgprw').removeAttribute('src');		
	}
	
	function fnc_state()
	{
		var gst_in = $("#txt_gstno").val() ;
		console.log(gst_in);
		
		var gst_len = gst_in.length;
		console.log(gst_len);
		
		if(gst_len < 3)
		{
			//alert(gst_len);
			$.ajax({
				url: 'company_state.php',
				data: {'id': gst_in, 'state': 1},
				datatype: 'json',
				type: 'post',
				success: function(out)
				{	
					//console.log("inside success");
					const obj = JSON.parse(out);
					console.log(obj.state_title);
					$("#cmb_state").val(obj.state_title);
				}
			});	
		}
	} 
	function fnc_validation()
	{
		var txt_company_name = document.getElementById('txt_company_name').value;
		var txt_email = document.getElementById('txt_email').value;
		var txt_mobile = document.getElementById('txt_mobile').value;
		var txt_gstno = document.getElementById('txt_gstno').value;
		var txt_address = document.getElementById('txt_address').value;
		
		var name_valid = /^[A-Za-z ]+$/; 
		var email_valid = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		var mono_valid = /^\d{10}$/;
		var gst_in = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
		
		
		//validation of Name 
		if(txt_company_name == '')
		{
			$('#txt_company_name').after('<span class="error_company" style="color:red; font-size:12px;">Company Name Is Required!</span>');
			document.getElementById("txt_company_name").focus();
			return false;
		}
		if(!txt_company_name.match(name_valid))
		{
			$('#txt_company_name').after('<span class="error_company" style="color:red; font-size:12px;">Please Enter Valid Name!</span>');
			document.getElementById("txt_company_name").focus();
			return false;
		}
		
		//validation of mobile no
		if(txt_mobile =='')
		{
			$('#txt_mobile').after('<span class="error_company" style="color:red; font-size:12px;">Mobile No Is Required!</span>');
			document.getElementById("txt_mobile").focus();
			return false;
		}
		if(!txt_mobile.match(mono_valid))
		{
			$('#txt_mobile').after('<span class="error_company" style="color:red; font-size:12px;">Please Enter Valid Mobile No!</span>');
			document.getElementById("txt_mobile").focus();
			return false;
		}
		
		//validation of email
		if(txt_email =='')
		{
			$('#txt_email').after('<span class="error_company" style="color:red; font-size:12px;">Email Is Required!</span>');
			document.getElementById("txt_email").focus();
			return false;
		}
		if(!txt_email.match(email_valid))
		{
			$('#txt_email').after('<span class="error_company" style="color:red; font-size:12px;">Please Enter Valid Email!</span>');
			document.getElementById("txt_email").focus();
			return false;
		}
		
		//validation of address
		if(txt_address =='')
		{
			$('#txt_address').after('<span class="error_company" style="color:red; font-size:12px;">Address Is Required!</span>');
			document.getElementById("txt_address").focus();
			return false;
		}
	/*	if(!txt_address.match(address))
		{
			$("#txt_address").after('<span class="error_company" style="color:red; font-size:12px;">Please Enter Valid Address!</span>');
			document.getElementById("txt_address").focus();
			return false;
		}*/
		
		//validation of gst
		if(txt_gstno =='')
		{
			$('#txt_gstno').after('<span class="error_company" style="color:red; font-size:12px;">Gst No Is Required!</span>');
			document.getElementById("txt_gstno").focus();
			return false;
		}
		if(!txt_gstno.match(gst_in))
		{
			$("#txt_gstno").after('<span class="error_company" style="color:red; font-size:12px;">Please Enter Valid Gst No!</span>');
			document.getElementById("txt_gstno").focus();
			return false;
		}
		
		return true;
	}
	/*
	function fnc_msg(action)
	{
		if(action == 'yes')
			$("#success_msg").click();
		else
			$("#danger_msg").click();
	}*/
</script>	
 <!--.row-->
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info">
			<div class="panel-heading"> Add New Company</div>
			<div class="panel-wrapper collapse in" aria-expanded="true">
				<div class="panel-body">
					<form action="" method="post" name="frm_company" enctype="multipart/form-data">
						<div class="form-body">								
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label">Company Name</label>
										<input type="text" id="txt_company_name" name="txt_company_name" class="form-control" placeholder="Enter companyname">
										<input type="hidden" id="val_company_name" name="val_company_name"/>
									</div>
								</div>
								<!--/span-->
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label">Mobile No</label>
										<input type="number" id="txt_mobile" name="txt_mobile" class="form-control" placeholder="Enter Mobileno.">
										<input type="hidden" id="val_mobile" name="val_mobile"/>							
									</div>
								</div>
								<!--/span-->
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label">Alter Mobile No</label>
										<input type="number" id="txt_alter_mobile" name="txt_alter_mobile" class="form-control" placeholder="Enter Altermobileno.">	
										
									</div>
								</div>
								<!--/span-->
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label">Email</label>
										<input type="email" id="txt_email" name="txt_email" class="form-control" placeholder="Enter Email">	
										<input type="hidden" id="val_email" name="val_email"/>										
									</div>
								<!--/span-->
								</div>
							</div>
							<!--/row-->
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Address</label>
										<textarea id="txt_address" name="txt_address" class="form-control" placeholder="Enter Address"></textarea>	
										<input type="hidden" id="val_address" name="val_address"/>	
									</div>
								</div>
								<!--/span-->
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">City</label>
										<input type="text" id="txt_city" name="txt_city" class="form-control" placeholder="Enter City">		
									</div>
								</div>
								<!--/span-->
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Pincode</label>
										<input type="number" id="txt_pincode" name="txt_pincode" class="form-control" placeholder="Enter Pincode">
									</div>
								</div>
							</div>
							<!--/row-->
							<!--start of tabs-->
							<div class="row">
								<div class="col-md-12 col-xs-12">
									<div class="white-box">
										<ul class="nav customtab nav-tabs" role="tablist">
											<li role="presentation" class="nav-item"><a href="#GST_INFO" class="nav-link active" aria-controls="GST_INFO" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-envelope-o"></i></span> <span class="hidden-xs">GST Info</span></a></li>
											<li role="presentation" class="nav-item"><a href="#bank_detail" class="nav-link" aria-controls="bank_detail" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Bank</span></a></li>
											<li role="presentation" class="nav-item"><a href="#Identification_Numbers" class="nav-link" aria-controls="Identification_Numbers" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Identification Numbers</span></a></li>
											<li role="presentation" class="nav-item"><a href="#Address" class="nav-link" aria-controls="Address" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-user"></i></span> <span class="hidden-xs">Other</span></a></li>
										</ul>
										<div class="tab-content">
											<div class="tab-pane active" id="GST_INFO">
												<!-- gst set  -->
												<div class="row">
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label">GSTINNO</label>
															<input type="text" id="txt_gstno" name="txt_gstno" class="form-control" placeholder="Enter GSTINO." onkeyup="fnc_state();">		
															<input type="hidden" id="val_gstin" name="val_gstin"/>	
														</div>
													</div>
													<!--/span-->
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label">State</label>
															<select id="cmb_state" name="cmb_state" class="form-control">
																<option value="">SELECT STATE</option>
																<option value="ANDAMAN AND NICOBAR ISLANDS">ANDAMAN AND NICOBAR ISLANDS</option>
																<option value="ANDHRA PRADESH">ANDHRA PRADESH</option>
																<option value="ARUNACHAL PRADESH">ARUNACHAL PRADESH</option>
																<option value="ASSAM">ASSAM</option>
																<option value="BIHAR">BIHAR</option>
																<option value="CHATTISGARH">CHATTISGARH</option>
																<option value="CHATTISGARH">CHATTISGARH</option>
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
																<option value="LAKSHADWEEP">LAKSHADWEEP</option>
																<option value="MEGHALAYA">MEGHALAYA</option>
																<option value="MAHARASHTRA">MAHARASHTRA</option>
																<option value="MANIPUR">MANIPUR</option>
																<option value="MADHYA PRADESH">MADHYA PRADESH</option>
																<option value="MIZORAM">MIZORAM</option>
																<option value="NAGALAND">NAGALAND</option>
																<option value="ORISSA">ORISSA</option>
																<option value="PUNJAB">PUNJAB</option>
																<option value="PONDICHERRY">PONDICHERRY</option>
																<option value="RAJASTHAN">RAJASTHAN</option>
																<option value="SIKKIM">SIKKIM</option>
																<option value="TAMIL NADU">TAMIL NADU</option>
																<option value="TRIPURA">TRIPURA</option>
																<option value="UTTARAKHAND">UTTARAKHAND</option>
																<option value="UTTAR PRADESH">UTTAR PRADESH</option>
																<option value="WEST BENGAL">WEST BENGAL</option>
																<option value="TELANGANA">TELANGANA</option>
																<option value="FOREIGN COUNTRY">FOREIGN COUNTRY</option>
																<option value="OTHER TERRITORY">OTHER TERRITORY</option>
															</select>		
														</div>
													</div>
												</div>
												<!-- gst end  -->
											</div>
											<div class="tab-pane" id="bank_detail">
												<!-- Additional_fields set  -->
												<div class="row">
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label">Bank Name</label>
															<input type="text" id="txt_bank_name" name="txt_bank_name" class="form-control" placeholder="Enter Bankname">
														</div>
													</div>
													<!--/span-->
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label">AC NO</label>
															<input type="number" id="txt_acno" name="txt_acno" class="form-control" placeholder="Enter ACCOUNT NO.">
														</div>
													</div>
													<!--/span-->
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label">IFSC</label>
															<input type="text" id="txt_ifsc" name="txt_ifsc" class="form-control" placeholder="Enter IFSC">		
														</div>
													</div>
													<!--/span-->
												</div>
												<!-- additional fields end-->
											</div>
											<div class="tab-pane" id="Identification_Numbers">
												<!-- Identification Numbers set  -->
												<div class="row">
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label">PAN NO</label>
															<input type="text" id="txt_panno" name="txt_panno" class="form-control" placeholder="Enter PAN NO.">	
														</div>
													</div>
													<!--/span-->
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label">TIN No</label>
															<input type="text" id="txt_tinno" name="txt_tinno" class="form-control" placeholder="Enter TIN NO.">	
														</div>
													</div>
													<!--/span-->
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label">CST NO</label>
															<input type="text" id="txt_cstno" name="txt_cstno" class="form-control" placeholder="Enter CST NO.">	
														</div>
													</div>
													<!--/span-->
												</div>
												<!-- row -->
												<div class="row">
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label">STax NO</label>
															<input type="text" id="txt_staxno" name="txt_staxno" class="form-control" placeholder="Enter STAX NO.">    
														</div>
													</div>
													<!--/span-->
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label">GeneralLic No</label>
															<input type="text" id="txt_general_lic_no" name="txt_general_lic_no" class="form-control" placeholder="Enter GeneralLic No.">
														</div>
													</div>
												</div>
												<!-- home end  -->
											</div>
											<div class="tab-pane" id="Address">
												<!-- Address set  -->
												<div class="row">
													<div class="col-md-4 col-xs-12">
														<div class="form-group">
															<label class="control-label">Company Image </label>
															<input type="file" id="input-file-now-custom-1" class="dropify"  name="company_img" />
														</div>
													</div>
													<!--/span-->
													<div class="col-md-4">
														<div class="form-group">
															<input type="checkbox" id="chk_is_default" name="chk_is_default" placeholder="Enter Start Date" value="1" >	
															<label class="control-label">Is Default</label>
														</div>
													</div>
												</div>
												<!-- profile end  -->
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--end of tabs-->	
						</div>
						<div class="form-actions">
							<input type="hidden" name="company_id" id="company_id" />
							<button type="button" id="success_msg" class="btn btn-default btn-outline" hidden>Show Top Right</button>
							<button type="button" id="danger_msg" class="btn btn-default btn-outline" hidden>Show Top Right</button>
							<button type="submit" id="btn_save" name="btn_save" class="btn btn-success" onclick="return fnc_validation(); sleep(2);"> <i class="fa fa-check"></i> Save</button>
							<button type="reset" name="btn_reset" id="btn_reset" class="btn btn-default">Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!--./for success alert-->
<div id="success_alerttopright" class="myadmin-alert myadmin-alert-img alert-success myadmin-alert-top-right"> <img src="../images/user_images/<?php if($row_login_select['user_image'] == ''){ echo 'default.png'; } else { echo $row_login_select['user_image']; } ?>" class="img" alt="img"><a href="#" class="closed" id="close">&times;</a>
<h4><?php echo $row_login_select['username'];?></h4>
Inserted/Updated Successfull.</div>

<!--./for danger alert-->
<div id="danger_alerttopright" class="myadmin-alert myadmin-alert-img alert-danger myadmin-alert-top-right"> <img src="../images/user_images/<?php if($row_login_select['user_image'] == ''){ echo 'default.png'; } else { echo $row_login_select['user_image']; } ?>" class="img" alt="img"><a href="#" class="closed" id="close">&times;</a>
<h4><?php echo $row_login_select['username'];?></h4>
Inserted/Updated Fail.</div>
<!-- /row -->
<div class="row">
	
	<div class="col-sm-12">			
		<div class="white-box">
			<div class="panel panel-info">
				<div class="panel-heading"> Manage User List</div>
			</div>																
		
			<div class="table-responsive">
				<table id="myTable" class="table table-striped">
					<thead>
						<tr>
							<th>SR NO.</th>
							<th>ACTION</th>
							<th>STATUS</th>
							<th>COMPANY LOGO</th>
							<th>COMPANY NAME</th>
							<th>MOBILE NO</th>
							<th>ALTER MOBILE NO</th>
							<th>EMAIL</th>
							<th>ADDRESS</th>
							<th>CITY</th>
							<th>STATE</th>
							<th>PINCODE</th>
							<th>GSTINNO</th>
							<th>BANK NAME</th>
							<th>AC NO</th>
							<th>IFSC</th>
							<th>PAN NO</th>
							<th>TIN NO</th>
							<th>CST NO</th>
							<th>STAXNO</th>
							<th>GENERAL LIC NO</th>
						</tr>
					</thead>
					<tbody>
					<?php					  					  								
						$sql = "CALL viewCompany()";
						$result = mysqli_query($con,$sql);
						$counter = 0;
							while($row = mysqli_fetch_array($result))
							{?>
								<tr>
								
								<td><?php echo  ++$counter ?></td>
								<td class="text-nowrap">
									<a href="" class='btn_edit' id='<?php echo $row['company_id']?>' data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
									<a href="" class='btn_delete' id='<?php echo $row['company_id']?>' data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
								</td>
								<td><span class="label label-success"><?php if($row['is_default']==1){echo "Active";} ?></span>
									<span class="label label-danger"><?php if($row['is_default']!=1){echo "Not Active";} ?></span>
								</td>
								<td><img src="../images/company_images/<?php echo $row['company_logo']; ?>" height ="50px" width = "50px"></td>					
								<td><?php echo $row['company_name']; ?></td>
								<td><?php echo $row['mobile_no']; ?></td>
								<td><?php echo $row['alter_mobile_no']; ?></td>
								<td><?php echo $row['email']; ?></td>
								<td><?php echo $row['address']; ?></td>												
								<td><?php echo $row['city']; ?></td>
								<td><?php echo $row['state']; ?></td>
								<td><?php echo $row['pincode']; ?></td>
								<td><?php echo $row['gst_in_no']; ?></td>
								<td><?php echo $row['bank_name']; ?></td>
								<td><?php echo $row['ac_no']; ?></td>
								<td><?php echo $row['ifsc']; ?></td>
								<td><?php echo $row['pan_no']; ?></td>
								<td><?php echo $row['tin_no']; ?></td>
								<td><?php echo $row['cst_no']; ?></td>
								<td><?php echo $row['stax_no']; ?></td>
								<td><?php echo $row['general_lic_no']; ?></td>
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
		
		$('#txt_company_name,#txt_mobile,#txt_email,#txt_gstno,#txt_address').on('keyup', function () {
			$(".error_company").remove();
		});
		
		//popup close
		$(".myadmin-alert .closed").click(function(event) {
			$(this).parents(".myadmin-alert").fadeToggle(350);

			return false;
		});
		
		//popup msg button click
		$("#success_msg").click(function() {
			$("#success_alerttopright").fadeToggle(350);
		});
		
		//popup msg button click
		$("#danger_msg").click(function() {
			$("#danger_alerttopright").fadeToggle(350);
		});
		
		
		$('.btn_delete').click(function(e)
		{
			e.preventDefault();	
			var company_id = $(this).attr("id");
			
			if(confirm("Are you sure you want to delete this?"))
			{
				$.ajax({ url: 'company_ajax.php',
						 data: {'id': company_id, 'delete': 1},
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
    
    $('#company_img').on('change', function() {
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
		
		$('.btn_edit').click(function(e)
		{
			e.preventDefault();	
			var company_id = $(this).attr("id");
			var imagePath1 = "../images/company_images/";
			if(confirm("Are you sure you want to edit this?"))
			{
				$.ajax({ url: 'company_ajax.php',
						 data: {'id': company_id, 'edit': 1},
						 type: 'post',
						 dataType :'json',
						 success: function(data) {
						 					//console.log(data.company_id);
										document.getElementById("company_id").value = company_id;
										document.getElementById("txt_company_name").value = data.company_name;
										document.getElementById("txt_mobile").value = data.mobile_no;
										document.getElementById("txt_alter_mobile").value = data.alter_mobile_no;
										document.getElementById("txt_email").value = data.email;
										document.getElementById("txt_address").value = data.address;
										document.getElementById("txt_city").value = data.city;
										document.getElementById("cmb_state").value = data.state;
										document.getElementById("txt_pincode").value = data.pincode;
										document.getElementById("txt_gstno").value = data.gst_in_no;
										document.getElementById("txt_bank_name").value = data.bank_name;
										document.getElementById("txt_acno").value = data.ac_no;
										document.getElementById("txt_ifsc").value = data.ifsc;
										document.getElementById("txt_panno").value = data.pan_no;
										document.getElementById("txt_tinno").value = data.tin_no;
										document.getElementById("txt_cstno").value = data.cst_no;
										document.getElementById("txt_staxno").value = data.stax_no;
										document.getElementById("txt_general_lic_no").value = data.general_lic_no;
										var imagePath2 = data.company_logo;
										//alert(imagePath1 + imagePath2);
										$('#company_img').attr("data-default-file",imagePath1 + imagePath2);
										$('.dropify-preview').css("display","block");
										$('.dropify-render').prepend('<img id = "edit_img"/>');
										$("#edit_img").attr("src", imagePath1 + imagePath2 );
										$('.dropify-filename-inner').text(imagePath2);
										$(".dropify-clear").css("display","initial");
										//$(".dropify-clear").trigger("click");
										//document.getElementById("btn_save").value = "Edit Company";	
										//$('#txt_pwd').attr('disabled', 'disabled');
										//$('#cpassword').attr('disabled', 'disabled');
										$('#company_img').attr('disabled', 'disabled');	
										document.getElementById("chk_is_default").checked = data.is_default;
										if(data.is_default==1)
										{
											document.getElementById("chk_is_default").checked = data.is_default;
										}
										else
										{
											document.getElementById("chk_is_default").checked = false;
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
            console.log('Has Errors');
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