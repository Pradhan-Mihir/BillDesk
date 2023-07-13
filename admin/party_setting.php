<?php
	include_once('header.php');
	
	if(isset($_POST['btn_save']))
	{
		$sql_update_party_setting ="update tbl_party_setting set is_party_grouping='".$_POST['chk_party_grp']."',is_shipping_address='".$_POST['chk_shipping_address']."',is_print_shipping_address='".$_POST['chk_print_shipping_address']."',is_enable_payment_reminder='".$_POST['chk_payment_reminder']."',reminder_in_days='".$_POST['txt_reminder_days']."',reminder_message='".$_POST['txt_additional_msg']."',is_additional_field_1='".$_POST['chk_additional_field_1']."',additional_field_1_name='".$_POST['txt_additional_field_1']."',is_additional_field_2='".$_POST['chk_additional_field_2']."',additional_field_2_name='".$_POST['txt_additional_field_2']."',is_additional_field_3='".$_POST['chk_additional_field_3']."',additional_field_3_name='".$_POST['txt_additional_field_3']."',is_additional_field_4='".$_POST['chk_additional_field_4']."',additional_field_4_name='".$_POST['txt_additional_field_4']."',date='".$_POST['txt_date']."' where party_setting_id =1 ";
		
		//echo $sql_update_party_setting;
		$rs_update_party_setting = mysqli_query($con,$sql_update_party_setting);
		
		if(!$rs_update_party_setting)
		{
			//die('Not Updated...!'.mysqli_error($con));
			echo "Not updated";
		}
		else
		{
			echo "<script>window.location = 'party.php';</script>";
		}
	}

	$sql_party_setting = "select * from tbl_party_setting";
	$rs_party_setting = mysqli_query($con,$sql_party_setting);
	$row = mysqli_fetch_array($rs_party_setting);

	$is_party_grouping = $row['is_party_grouping'];
	$is_shipping_address = $row['is_shipping_address'];
	$is_print_shipping_address = $row['is_print_shipping_address'];
	$is_enable_payment_reminder = $row['is_enable_payment_reminder'];
	$reminder_in_days = $row['reminder_in_days'];
	$reminder_message = $row['reminder_message'];
	$is_additional_field_1 = $row['is_additional_field_1'];
	$additional_field_1_name = $row['additional_field_1_name'];
	$is_a_f_1_show_in_print = $row['is_a_f_1_show_in_print'];
	$is_additional_field_2 = $row['is_additional_field_2'];
	$additional_field_2_name = $row['additional_field_2_name'];
	$is_a_f_2_show_in_print = $row['is_a_f_2_show_in_print'];
	$is_additional_field_3 = $row['is_additional_field_3'];
	$additional_field_3_name = $row['additional_field_3_name'];
	$is_a_f_3_show_in_print = $row['is_a_f_3_show_in_print'];
	$is_additional_field_4 = $row['is_additional_field_4'];
	$additional_field_4_name = $row['additional_field_4_name'];
	$is_a_f_4_show_in_print = $row['is_a_f_4_show_in_print'];
	
?>
<script>
		
	function fnc_enable_disable_add1(chk_additional_field_1)
	{
		var val_add_1 = document.getElementById("txt_additional_field_1");
		val_add_1.disabled = chk_additional_field_1.checked ? false : true;
		if(!val_add_1.disabled)
		{
			val_add_1.focus();
		}
		
		var show_print_1 = document.getElementById("chk_show_in_print_add1");
		show_print_1.disabled = chk_additional_field_1.checked ? false : true;
		if(!show_print_1.disabled)
		{
			show_print_1.focus();
		}
	}
	
	function fnc_enable_disable_add2(chk_additional_field_2)
	{
		var val_add_2 = document.getElementById("txt_additional_field_2");
		val_add_2.disabled = chk_additional_field_2.checked ? false : true;
		if(!val_add_2.disabled)
		{
			val_add_2.focus();
		}
		
		var show_print_2 = document.getElementById("chk_show_in_print_add2");
		show_print_2.disabled = chk_additional_field_2.checked ? false : true;
		if(!show_print_2.disabled)
		{
			show_print_2.focus();
		}
	}
	
	function fnc_enable_disable_add3(chk_additional_field_3)
	{
		var val_add_3 = document.getElementById("txt_additional_field_3");
		val_add_3.disabled = chk_additional_field_3.checked ? false : true;
		if(!val_add_3.disabled)
		{
			val_add_3.focus();
		}
		
		var show_print_3 = document.getElementById("chk_show_in_print_add3");
		show_print_3.disabled = chk_additional_field_3.checked ? false : true;
		if(!show_print_3.disabled)
		{
			show_print_3.focus();
		}
	}
	
	function fnc_enable_disable_add4(chk_additional_field_4)
	{
		var val_add_4 = document.getElementById("txt_additional_field_4");
		val_add_4.disabled = chk_additional_field_4.checked ? false : true;
		if(!val_add_4.disabled)
		{
			val_add_4.focus();
		}
		
		var val_date = document.getElementById("txt_date");
		val_date.disabled = chk_additional_field_4.checked ? false : true;
		if(!val_date.disabled)
		{
			val_date.focus();
		}
		
		var show_print_4 = document.getElementById("chk_show_in_print_add4");
		show_print_4.disabled = chk_additional_field_4.checked ? false : true;
		if(!show_print_4.disabled)
		{
			show_print_4.focus();
		}
	}
	
	function fnc_enable_disable_print_shipping(chk_shipping_address)
	{
		var val_print_shipping = document.getElementById("chk_print_shipping_address");
		val_print_shipping.disabled = chk_shipping_address.checked ? false : true;
		if(!val_print_shipping.disabled)
		{
			val_print_shipping.focus();
		}
	}
	
	function fnc_enable_disable_reminder(chk_payment_reminder)
	{
		var val_days = document.getElementById("txt_reminder_days");
		val_days.disabled = chk_payment_reminder.checked ? false : true;
		if(!val_days.disabled)
		{
			val_days.focus();
		}
		
		var val_msg = document.getElementById("txt_additional_msg");
		val_msg.disabled = chk_payment_reminder.checked ? false : true;
		if(!val_msg.disabled)
		{
			val_msg.focus();
		}
	}
</script>
<div class="row bg-title">
	<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
		<h4 class="page-title">Party Setting</i></h4>
	</div>
	<!--./right sidebar-->
</div>	
<!--./row--->
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info">
			<div class="panel-heading"> Add New Party</div>
			<div class="panel-wrapper collapse in" aria-expanded="true">
				<div class="panel-body">
					<form action="" method="post" name="frm_party_setting" >
						<div class="form-body">		
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label"></label>
										<input  type="checkbox" id="chk_party_grp" name="chk_party_grp" ><label class="control-label"> &nbsp;Party Grouping </label>
									</div>
								</div>
								<!---/span--->
								<div class="col-md-1">
									<input type="checkbox" id="chk_additional_field_1" name="chk_additional_field_1" onchange = "fnc_enable_disable_add1(this)"  > 
								</div>	
								<div class="col-md-5">
									<div class="form-group">
										<div class="form-group m-b-40">
                                            <label for="txt_additional_field_1" class="control-label">Additional Field 1</label>
											<input type="text" class="form-control" id="txt_additional_field_1" name="txt_additional_field_1"  ><span class="highlight"></span> <span class="bar"></span>
                                        </div>
									</div>
									<div class="form-group">
										<input type="checkbox" data-color="#13dafe" data-size="small"  data-secondary-color="#6164c1" name="chk_show_in_print_add1" id="chk_show_in_print_add1">
										<label>&nbsp;Show In Print</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<input type="checkbox" id="chk_shipping_address"  name="chk_shipping_address" onchange="fnc_enable_disable_print_shipping(this)" ><label class="control-label"> &nbsp;Shipping Address </label>
									</div>
								</div>
								<!---/span--->
								<div class="col-md-1">
									<div class="form-group">
										<input  type="checkbox" id="chk_additional_field_2" name="chk_additional_field_2" onchange="fnc_enable_disable_add2(this)"> 
									</div>
								</div>	
								<div class="col-md-5">
									<div class="form-group">
										<div class="form-group m-b-40">
                                            <label for="txt_additional_field_2" class="control-label">Additional Field 2</label>
											<input type="text" class="form-control" id="txt_additional_field_2" name="txt_additional_field_2" ><span class="highlight"></span> <span class="bar"></span>
                                        </div>
									</div>
									<div class="form-group">
										<input type="checkbox" data-color="#13dafe" data-size="small"  data-secondary-color="#6164c1" name="chk_show_in_print_add2" id="chk_show_in_print_add2">
										<label>&nbsp;Show In Print</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<input type="checkbox" id="chk_print_shipping_address" name="chk_print_shipping_address" ><label class="control-label"> &nbsp;Print Shipping Address </label>	
									</div>
								</div>
								<!---/span--->
								<div class="col-md-1">
									<div class="form-group">
										<input  type="checkbox" id="chk_additional_field_3" name="chk_additional_field_3" onchange="fnc_enable_disable_add3(this)"> 
									</div>
								</div>	
								<div class="col-md-5">
									<div class="form-group">
										<div class="form-group m-b-40">
                                            <label for="txt_additional_field_3" class="control-label">Additional Field 3</label>
											<input type="text" class="form-control" id="txt_additional_field_3" name="txt_additional_field_3" ><span class="highlight"></span> <span class="bar"></span>
                                        </div>
									</div>
									<div class="form-group">
										<input type="checkbox" data-color="#13dafe" data-size="small"  data-secondary-color="#6164c1" name="chk_show_in_print_add3" id="chk_show_in_print_add3">
										<label>&nbsp;Show In Print</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<input type="checkbox" id="chk_payment_reminder" name="chk_payment_reminder" onchange="fnc_enable_disable_reminder(this)" ><label class="control-label"> &nbsp;Enable Payment Reminder </label>
									</div>
								</div>
								<!---/span--->
								<div class="col-md-1">
									<div class="form-group">
										<input  type="checkbox" id="chk_additional_field_4" name="chk_additional_field_4" onchange="fnc_enable_disable_add4(this)"> 
									</div>
								</div>	
								<div class="col-md-3">
									<div class="form-group">
										<div class="form-group m-b-40">
                                            <label for="txt_additional_field_4" class="control-label">Additional Field 4</label>
											<input type="text" class="form-control" id="txt_additional_field_4" name="txt_additional_field_4" ><span class="highlight"></span> <span class="bar"></span>
                                        </div>
									</div>
									<div class="form-group">
										<input type="checkbox" data-color="#13dafe" data-size="small"  data-secondary-color="#6164c1" name="chk_show_in_print_add4" id="chk_show_in_print_add4">
										<label>&nbsp;Show In Print</label>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="txt_date" class="control-label">Date</label>
										<input type="date" class="form-control" id="txt_date" name="txt_date">
									</div>
								</div>	
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group m-b-40">
										<label for="txt_reminder_days" class="control-label"> Remind Me For Payment Due In (Days)</label>
										<input type="number" class="form-control" id="txt_reminder_days" name="txt_reminder_days" ><span class="highlight"></span> <span class="bar"></span>
									</div>
								</div>	
								<!---./span--->
								<div class="col-md-6">	
									<div class="form-group">
										<label for="txt_additional_msg" class="control-label">Type Additional Message</label>
										<textarea class="form-control" rows="3" id="txt_additional_msg" name="txt_additional_msg" ></textarea><span class="highlight"></span> <span class="bar"></span>
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
		
		$("chk_show_in_print_add1").removeClass("js-switch").addClass("js");
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
				document.getElementById("txt_additional_field_1").value = obj.additional_field_1_name;
				document.getElementById("txt_additional_field_2").value = obj.additional_field_2_name;
				document.getElementById("txt_additional_field_3").value = obj.additional_field_3_name;
				document.getElementById("txt_additional_field_4").value = obj.additional_field_4_name;
				document.getElementById("txt_additional_msg").value = obj.reminder_message;
				document.getElementById("txt_reminder_days").value = obj.reminder_in_days;
				document.getElementById("txt_date").value = obj.date;
				
				//for party grouping
				document.getElementById("chk_party_grp").checked = obj.is_party_grouping;
				if(obj.is_party_grouping == 1)	
				{
					document.getElementById("chk_party_grp").checked = obj.is_party_grouping;
				}
				else
				{	
					document.getElementById("chk_party_grp").checked = false;
				}
				
				//for shipping address
				document.getElementById("chk_shipping_address").checked = obj.is_shipping_address;
				if(obj.is_shipping_address == 1)	
				{
					$('#chk_print_shipping_address').attr('disabled',false);
					document.getElementById("chk_shipping_address").checked = obj.is_shipping_address;
				}
				else
				{		
					$('#chk_print_shipping_address').attr('disabled',true);
					document.getElementById("chk_shipping_address").checked = false;
				}
				
				//for print shipping address
				document.getElementById("chk_print_shipping_address").checked = obj.is_print_shipping_address;
				if(obj.is_print_shipping_address == 1)	
				{	
					document.getElementById("chk_print_shipping_address").checked = obj.is_print_shipping_address;
				}
				else
				{	
					document.getElementById("chk_print_shipping_address").checked = false;
				}
				
				//for enable payment reminder
				document.getElementById("chk_payment_reminder").checked = obj.is_enable_payment_reminder;
				if(obj.is_enable_payment_reminder == 1)	
				{	
					document.getElementById("chk_payment_reminder").checked = obj.is_enable_payment_reminder;
				}
				else
				{	
					document.getElementById("chk_payment_reminder").checked = false;
				}
				
				//for readonly Reminder Days or reminder message
				if(obj.is_enable_payment_reminder == 1)	
				{	
					$('#txt_reminder_days').attr('disabled',false);
					$('#txt_additional_msg').attr('disabled',false);
				}
				else
				{	
					$('#txt_reminder_days').attr('disabled',true);
					$('#txt_additional_msg').attr('disabled',true);
				}
				
				//for additional field 1
				document.getElementById("chk_additional_field_1").checked = obj.is_additional_field_1;
				if(obj.is_additional_field_1 == 1)	
				{
					$('#txt_additional_field_1').attr('disabled',false);
					$('#chk_show_in_print_add1').attr('disabled',false);
					document.getElementById("chk_additional_field_1").checked = obj.is_additional_field_1;
				}
				else
				{	
					$('#txt_additional_field_1').attr('disabled',true);
					$('#chk_show_in_print_add1').attr('disabled',true);
					document.getElementById("chk_additional_field_1").checked = false;
				}
				
				//for additional field 2
				document.getElementById("chk_additional_field_2").checked = obj.is_additional_field_2;
				if(obj.is_additional_field_2 == 1)	
				{
					$('#txt_additional_field_2').attr('disabled',false);
					$('#chk_show_in_print_add2').attr('disabled',false);
					document.getElementById("chk_additional_field_2").checked = obj.is_additional_field_2;
				}
				else
				{	
					$('#txt_additional_field_2').attr('disabled',true);
					$('#chk_show_in_print_add2').attr('disabled',true);
					document.getElementById("chk_additional_field_2").checked = false;
				}
				
				//for additional field 3
				document.getElementById("chk_additional_field_3").checked = obj.is_additional_field_3;
				if(obj.is_additional_field_3 == 1)	
				{
					$('#txt_additional_field_3').attr('disabled',false);
					$('#chk_show_in_print_add3').attr('disabled',false);
					document.getElementById("chk_additional_field_3").checked = obj.is_additional_field_3;
				}
				else
				{	
					$('#txt_additional_field_3').attr('disabled',true);
					$('#chk_show_in_print_add3').attr('disabled',true);
					document.getElementById("chk_additional_field_3").checked = false;
				}
				
				//for additional field 4
				document.getElementById("chk_additional_field_4").checked = obj.is_additional_field_4;
				if(obj.is_additional_field_4 == 1)	
				{
					$('#txt_additional_field_4').attr('disabled',false);
					$('#txt_date').attr('disabled',false);
					$('#chk_show_in_print_add4').attr('disabled',false);
					document.getElementById("chk_additional_field_4").checked = obj.is_additional_field_4;
				}
				else
				{	
					$('#txt_additional_field_4').attr('disabled',true);
					$('#txt_date').attr('disabled',true);
					$('#chk_show_in_print_add4').attr('disabled',true);
					document.getElementById("chk_additional_field_4").checked = false;
				}
				
				//for show in print additional field 1
				document.getElementById("chk_show_in_print_add1").checked = obj.is_a_f_1_show_in_print;
				if(obj.is_a_f_1_show_in_print == 1)	
				{
					$('#chk_show_in_print_add1').attr('checked',true);
					//document.getElementById("chk_show_in_print_add1").checked = obj.is_a_f_1_show_in_print;
				}
				else
				{	
					$('#chk_show_in_print_add1').attr('checked',false);
					//document.getElementById("chk_show_in_print_add1").checked = false;
				}
				
				//for show in print additional field 2
				document.getElementById("chk_show_in_print_add2").checked = obj.is_a_f_2_show_in_print;
				if(obj.is_a_f_2_show_in_print == 1)	
				{
					$('#chk_show_in_print_add2').attr('checked',true);
					//document.getElementById("chk_show_in_print_add1").checked = obj.is_a_f_2_show_in_print;
				}
				else
				{	
					$('#chk_show_in_print_add2').attr('checked',false);
					//document.getElementById("chk_show_in_print_add1").checked = false;
				}
				
				//for show in print additional field 3
				document.getElementById("chk_show_in_print_add3").checked = obj.is_a_f_3_show_in_print;
				if(obj.is_a_f_3_show_in_print == 1)	
				{
					$('#chk_show_in_print_add3').attr('checked',true);
					//document.getElementById("chk_show_in_print_add1").checked = obj.is_a_f_2_show_in_print;
				}
				else
				{	
					$('#chk_show_in_print_add3').attr('checked',false);
					//document.getElementById("chk_show_in_print_add1").checked = false;
				}
				
				//for show in print additional field 4
				document.getElementById("chk_show_in_print_add4").checked = obj.is_a_f_4_show_in_print;
				if(obj.is_a_f_4_show_in_print == 1)	
				{
					$('#chk_show_in_print_add4').attr('checked',true);
					//document.getElementById("chk_show_in_print_add1").checked = obj.is_a_f_2_show_in_print;
				}
				else
				{	
					$('#chk_show_in_print_add4').attr('checked',false);
					//document.getElementById("chk_show_in_print_add1").checked = false;
				}
			}  
		});
		
	});	
</script>	
<?php
	include_once('footer.php');
?>