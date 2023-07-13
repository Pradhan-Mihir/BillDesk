<?php
	include_once('header.php');
	
	if(isset($_POST['btn_update_profile']))
	{
		if(!empty($_FILES["user_img"]["name"]))
		{									
			$image1 = $row_login_select['user_image'];
			$path = '../images/user_images/';
			if (file_exists($path.$image1)) 
			{
				unlink($path.$image1);
			}				
			
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
			$img3 = $row_login_select['user_image'];
		}
		
		
		$sql_user_profile = "CALL updateUserProfile('".$row_login_select['user_id']."','".$_POST['txt_fname']."', '".$_POST['txt_email']."' , '".$_POST['txt_mobile']."' , '".$img3."') ";
			
		//echo $sql_user_profile;
		$rs_user_profile = mysqli_query($con,$sql_user_profile);
		if(!$rs_user_profile)
		{
			die('User Data Not Updated.'.mysqli_error($con));
		}
		else
		{
			echo "<script>window.location = 'my_profile.php';</script>";
		}	
	}	
	
	
?>
<div class="row bg-title">
	<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
		<h4 class="page-title">My Profile</h4>
	</div>
	
</div>

<!-- .row -->
<form class="form-horizontal form-material" name="frmMyProfile" id="frmMyProfile" method="post" enctype="multipart/form-data">
<div class="row">
	
	<div class="col-md-4 col-xs-12">
		
		<div class="white-box">
			<h3 class="box-title">User Profile Upload</h3>
			<input type="file" id="input-file-now-custom-1" class="dropify" data-default-file="../images/user_images/<?php if($row_login_select['user_image']!='') {echo $row_login_select['user_image'];} ?>" name="user_img" />
		</div>
		
	</div>
	<div class="col-md-8 col-xs-12">
		<div class="white-box">
			<ul class="nav customtab nav-tabs" role="tablist">				
				<li role="presentation" class="nav-item"><a href="#settings" class="nav-link active" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">My Profile</span></a></li>
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
							<label class="col-md-12">Full Name</label>
							<div class="col-md-12">
								<input type="text" placeholder="Enter Full Name" class="form-control form-control-line" name="txt_fname" id="txt_fname" value="<?php if(isset($row_login_select['full_name'])){ echo $row_login_select['full_name']; } ?>" >
							</div>
						</div>
						<div class="form-group">
							<label for="example-email" class="col-md-12">Email</label>
							<div class="col-md-12">
								<input type="email" placeholder="Enter Email" class="form-control form-control-line" name="txt_email" id="txt_email" value="<?php echo $row_login_select['email']; ?>" >
							</div>
						</div>						
						<div class="form-group">
							<label class="col-md-12">Mobile No</label>
							<div class="col-md-12">
								<input type="number" placeholder="Enter Mobile No." id="txt_mobile" name="txt_mobile" class="form-control form-control-line" value="<?php echo $row_login_select['mobile']; ?>">
							</div>
						</div>					
						<div class="form-group">
							<div class="col-sm-12">
								<button class="btn btn-success" id="btn_update_profile" name="btn_update_profile" >Update Profile</button>
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
                default: 'Glissez-d�posez un fichier ici ou cliquez',
                replace: 'Glissez-d�posez un fichier ou cliquez pour remplacer',
                remove: 'Supprimer',
                error: 'D�sol�, le fichier trop volumineux'
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