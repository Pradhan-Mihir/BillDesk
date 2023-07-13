<?php
$title = "BILL DESK-Manage User";
	include_once('header.php');
	
	if(isset($_POST['btn_save']))
	{
		if(!empty($_FILES["user_img"]["name"]))
		{			
			$img3=$_FILES["user_img"]["name"];
			$img3 = pathinfo($img3, PATHINFO_FILENAME).mt_rand(600000,999999).".".pathinfo($img3, PATHINFO_EXTENSION);				
			$tmp_name3=$_FILES["user_img"]["tmp_name"];
			if(is_uploaded_file($tmp_name3))
			{
				copy($tmp_name3,"../images/user_images/".$img3);
			}
		}
		else
		{
			$img3 = "";
		}
			
		if($_POST['user_id'] == '')
		{			
		
			//INSERT CODE
			$sql_user_iu = "CALL insertManageUser('".$_POST['txt_uname']."' , '".$_POST['txt_fname']."' , '".$_POST['txt_email']."' , '".$_POST['txt_mobile']."' , '".$_POST['txt_pwd']."' , '".$img3."') ";
			
			
		}
		else
		{	
			//UPDATE CODE
			$sql_user_iu = "CALL updateManageUser('".$_POST['user_id']."','".$_POST['txt_uname']."', '".$_POST['txt_fname']."' , '".$_POST['txt_email']."' , '".$_POST['txt_mobile']."') ";
			
		}
		
		$rs_user_iu = mysqli_query($con,$sql_user_iu);
		if(!$rs_user_iu)
		{
			die('User Data Not Inserted/Updated.'.mysqli_error($con));
		}
		else
		{
			echo "<script>window.location = 'manage_user.php';</script>";
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
	function fnc_validation()
	{
		var txt_uname = document.getElementById('txt_uname').value;
		var txt_fname = document.getElementById('txt_fname').value;
		var txt_email = document.getElementById('txt_email').value;
		var txt_mobile = document.getElementById('txt_mobile').value;
		var txt_pwd = document.getElementById('txt_pwd').value;
		
		var uname_valid=/^\w{5,20}$/; 
		var fname_valid = /^[A-Za-z ]+$/; 
		var email_valid = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		var mono_valid = /^\d{10}$/;
		var pass_valid =/^[a-zA-Z][0-9a-zA-Z_!$@#^&]{5,20}$/;
		var single_valid = /^['";]$/;
		
		//validation of Username 
		if(txt_uname == '')
		{
			$('#txt_uname').after('<span class="error_company" style="color:red; font-size:15px;">User Name Is Required!</span>');
			document.getElementById("txt_uname").focus();
			return false;
		}
		if(!txt_uname.match(uname_valid))
		{
			$('#txt_uname').after('<span class="error_company" style="color:red; font-size:15px;">Please Enter Valid User !</span>');
			document.getElementById("txt_uname").focus();
			return false;
		}
		
		//validation of Full Name 
		if(txt_fname == '')
		{
			$('#txt_fname').after('<span class="error_company" style="color:red; font-size:15px;">Full Name Is Required!</span>');
			document.getElementById("txt_fname").focus();
			return false;
		}
		if(!txt_fname.match(fname_valid))
		{
			$('#txt_fname').after('<span class="error_company" style="color:red; font-size:15px;">Please Enter Valid Full Name!</span>');
			document.getElementById("txt_fname").focus();
			return false;
		}
		
		//validation of Email
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
		
		//validation of Mobile No
		if(txt_mobile == '')
		{
			$('#txt_mobile').after('<span class="error_company" style="color:red; font-size:15px;">Mobile No. Is Required!</span>');
			document.getElementById("txt_mobile").focus();
			return false;
		}
		if(!txt_mobile.match(mono_valid))
		{
			$('#txt_mobile').after('<span class="error_company" style="color:red; font-size:15px;">Mobile No. Must be 10 digit Long!</span>');
			document.getElementById("txt_mobile").focus();
			return false;
		}
		
		//validation for password
		if(txt_pwd == '')
		{
			$('#txt_pwd').after('<span class="error_company" style="color:red; font-size:15px;">Password Is Required!</span>');
			document.getElementById("txt_pwd").focus();
			return false;
		}
		if(!txt_pwd.match(pass_valid))
		{
			$('#txt_pwd').after('<span class="error_company" style="color:red; font-size:15px;">The password Must Contain  Length Between 5 And 20, Start With Character!</span>');
			document.getElementById("txt_pwd").focus();
			return false;
		}
		
		if(txt_uname.match(single_valid) && txt_fname.match(single_valid))
		{
			$('#txt_uname').after('<span class="error_company" style="color:red; font-size:15px;">Username already Exists!</span>');
			document.getElementById("txt_uname").focus();
			return false;
		}
		return true;
	}

	function fnc_is_avaliable(e)
	{
		let which = e.getAttribute('id');
		let txt = e.value;

		$.ajax({
				url: 'manage_user_ajax.php',
				data: {'txt': txt , 'which': which,'val': 1},
				type: 'post',
				dataType: 'json',
				success: function(data) {
					if (data.exists == 1)
					{
						$('#'+which).after('<span class="ok'+which+'" style="color:red; font-size:15px;">Already Exists!</span>');
						e.style.borderColor="#FF0000";
						return false;
					}
					else
					{
						e.style = "none";
						$('.ok'+which).remove();
					}
					
				}
			});
	}
</script>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-info">
				<div class="panel-heading"> Manage User</div>
				<div class="panel-wrapper collapse in" aria-expanded="true">
					<div class="panel-body">
						<form action="" method="post" name="frm_manage_user" enctype="multipart/form-data">
							<div class="form-body">								
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Username</label>
											<input type="text" id="txt_uname" name="txt_uname" oninput="fnc_is_avaliable(this)" class="form-control" placeholder="Enter Username">
										</div>
									</div>
									<!--/span-->
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Full Name</label>
											<input type="text" id="txt_fname" name="txt_fname" class="form-control" placeholder="Enter Full Name">									
										</div>
									<!--/span-->
									</div>
								</div>
								<!--/row-->
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Email</label>
											<input type="email" id="txt_email" name="txt_email" oninput="fnc_is_avaliable(this)" class="form-control" placeholder="Enter Email">	
										</div>
									</div>
									<!--/span-->
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Mobile</label>
											<input type="number" id="txt_mobile" name="txt_mobile" oninput="fnc_is_avaliable(this)" class="form-control" placeholder="Enter Mobile No">
										</div>
									<!--/span-->
									</div>
								</div>
								<!--/row-->
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Password</label>
											<input type="password" id="txt_pwd" name="txt_pwd" class="form-control" placeholder="Enter Passward">
										</div>
									</div>
									<!--/span-->
									<div class="col-md-4">
										<div class="form-group">
											<label>User Profile</label>
											<input type="file" class="form-control" name="user_img" id="user_img" accept="image/*" onchange="ValidateSize(this)">
										</div>
									</div>
									<div class="col-md-2">
                                      	<img id="imgprw" height="80px" width="80px" border="5" style="margin-bottom:15px;" />
									  </div>
								</div>
								<!--/row-->							
							</div>
							<div class="form-actions">
								<input type="hidden" id="err_email" name="err_email">
								<input type="hidden" name="user_id" id="user_id" /> 
								<button type="submit" id="btn_save" name="btn_save" class="btn btn-success" onclick="return fnc_validation();"> <i class="fa fa-check"></i> Save</button>
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
					<div class="panel-heading">User List</div>
				</div>																
			
				<div class="table-responsive">
					<table id="myTable" class="table table-striped">
						<thead>
							<tr>
								<th>SR NO.</th>
								<th>Action</th>
								<th>Username</th>
								<th>Full Name</th>
								<th>Email</th>
								<th>Mobile</th>
								<th>Added date</th>
							</tr>
						</thead>
						<tbody>
						<?php					  					  								
							$sql = "CALL viewManageUser()";
							$result = mysqli_query($con,$sql);
							$counter = 0;
							
								while($row = mysqli_fetch_array($result))
								{?>
									<tr>
									<td><?php echo  ++$counter ?></td>
									<td class="text-nowrap">
										<a href="" class='btn_edit' id='<?php echo $row['user_id']?>' data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
										<a href="" class='btn_delete' id='<?php echo $row['user_id']?>' data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
									</td>
									<td><?php echo $row['username']; ?></td>
									<td><?php echo $row['full_name']; ?></td>
									<td><?php echo $row['email']; ?></td>
									<td><?php echo $row['mobile']; ?></td>
									<td><?php echo date("d-m-Y h:i:sa", strtotime($row['added_date']))?></td>																													
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
		$('#txt_uname,#txt_fname,#txt_email,#txt_mobile,#txt_pwd').on('keyup', function () {
			$(".error_company").remove();
			$('#error_password').remove();
			$('#btn_login').attr('disabled', false);
			//alert('in');
		});
		
		$('#btn_save').click(function() {
		 
			var user_not_exist = $('#err_email').val();
			
			if (user_not_exist == "exists") 
			{
				$('#btn_save').attr('disabled',true);
                $('#txt_pwd').after('<span id="error_password" style="color:red; font-size:12px;">Invalid Username Or Password!</span>');
                return false;
            }
            return true;
		});
		
		$('.btn_delete').click(function(e)
		{
			e.preventDefault();	
			var user_id = $(this).attr("id");
			
			if(confirm("Are you sure you want to delete this?"))
			{
				$.ajax({ url: 'manage_user_ajax.php',
						 data: {'id': user_id, 'delete': 1},
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
			var user_id = $(this).attr("id");						
			if(confirm("Are you sure you want to edit this?"))
			{
				$.ajax({ url: 'manage_user_ajax.php',
						 data: {'id': user_id, 'edit': 1},
						 type: 'post',
						 dataType :'json',
						 success: function(data) {
						 					console.log(data.username);
										document.getElementById("user_id").value = user_id;
										document.getElementById("txt_uname").value = data.username;
										document.getElementById("txt_email").value = data.email;
										document.getElementById("txt_mobile").value = data.mobile;
										//document.getElementById("btn_save").value = "Edit User";	
										$('#txt_pwd').attr('disabled', 'disabled');
										//$('#cpassword').attr('disabled', 'disabled');
										$('#user_img').attr('disabled', 'disabled');									
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