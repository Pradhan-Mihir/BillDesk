<?php
	include_once('header.php');
	
	if(isset($_POST['btn_change_password']))
	{	
		$sql_user_password = "CALL updateUserPassword('".$row_login_select['user_id']."','".$_POST['txt_pass']."' ) ";
			
		//echo $sql_user_profile;
		$rs_user_password = mysqli_query($con,$sql_user_password);
		if(!$rs_user_password)
		{
			die('User Data Not Updated.'.mysqli_error($con));
		}
		else
		{
			echo "<script>window.location = 'change_password.php';</script>";
		}	
	}	
	
	
?>
<div class="row bg-title">
	<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
		<h4 class="page-title">Change Password</h4>
	</div>
	<!--<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">		
		<ol class="breadcrumb">
			<li><a href="#">Dashboard</a></li>
			<li><a href="#">Sample Pages</a></li>
			<li class="active">Profile page</li>
		</ol>
	</div>-->
</div>

<!-- .row -->
<form class="form-horizontal form-material" name="frmMyProfile" id="frmMyProfile" method="post" enctype="multipart/form-data">
<div class="row">
	
	<div class="col-md-8 col-xs-12">
		<div class="white-box">
			<ul class="nav customtab nav-tabs" role="tablist">				
				<li role="presentation" class="nav-item"><a href="#settings" class="nav-link active" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Change Password</span></a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="profile">
					
						<div class="form-group">
							<label class="col-md-12">Username</label>
							<div class="col-md-12">
								<input type="text" placeholder="Enter Username" class="form-control form-control-line" name="txt_uname" id="txt_uname" value="<?php echo $row_login_select['username']; ?>" disabled="disabled">
							</div>
						</div>
						<div class="form-group">
							<label for="example-email" class="col-md-12">Email</label>
							<div class="col-md-12">
								<input type="email" placeholder="Enter Email" class="form-control form-control-line" name="txt_email" id="txt_email" value="<?php echo $row_login_select['email']; ?>" disabled="disabled">
							</div>
						</div>						
						<div class="form-group">
							<label class="col-md-12">Password</label>
							<div class="col-md-12">
								<input type="password" placeholder="Enter New Password" class="form-control form-control-line" name="txt_pass" id="txt_pass" >
							</div>
						</div>				
						<div class="form-group">
							<div class="col-sm-12">
								<button class="btn btn-success" id="btn_change_password" name="btn_change_password" >Change Password</button>
							</div>
						</div>
					
				</div>
			</div>
		</div>
	</div>
</div>
</form>
<!-- /.row -->
<?php
	include_once('footer.php');
?>

<!-- jQuery file upload -->
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