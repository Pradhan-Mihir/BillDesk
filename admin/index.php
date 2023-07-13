<?php 

	session_start();
	include_once("../connection.php");
	
	if(isset($_POST['btn_login']))
	{
		//$sql_login_select="SELECT * FROM tbl_login WHERE user_name='".$_POST['txt_uname']."' and user_pass='".$_POST['txt_pass']."'";
		
		$sql_login_select = "CALL viewLogin('".$_POST['txt_uname']."', '".$_POST['txt_pass']."')";
		
		//echo $sql_login_select;
		$rs_login_select=mysqli_query($con,$sql_login_select);
		$rows_num=mysqli_num_rows($rs_login_select);
		
		if($rows_num > 0)
		{
			$row_login_select=mysqli_fetch_array($rs_login_select);
			$_SESSION['uname']=$row_login_select['username'];
			echo "<script>window.location.replace('dashboard.php');</script>";
		}
				
	}
?>
<script language="javascript" type="text/javascript">
	//alert("welcome");
	function fnc_validation()
	{
		var txt_uname = document.getElementById('txt_uname').value;
		var txt_pass = document.getElementById('txt_pass').value;
		
		var name_valid=/^\w{5,20}$/; 
		var pass_valid =/^[a-zA-Z][0-9a-zA-Z_!$@#^&]{5,20}$/;
		
		//validation of Name 
		if(txt_uname == '')
		{
			//alert('enter username...!');
			$("#val_username").html("Username is required");
			return false;
		}
		if(!txt_uname.match(name_valid))
		{
			$("#val_username").html("Please enter valid username");
			return false;
		}
		
		
		if(txt_pass == '')
		{
			//alert('enter username...!');
			$("#val_pass").html("Password is required");
			return false;
		}
		return true;
	}
</script>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Bill Desk</title>
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
  <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
    <div class="container">
      <div class="card login-card">
        <div class="row no-gutters">
          <div class="col-md-5">
            <img src="assets/images/login.jpg" alt="login" class="login-card-img">
          </div>
          <div class="col-md-7">
            <div class="card-body">
              <p class="login-card-description">Sign into your account</p>
              <form method="post" id="frm_login" action="" name="frm_login" data-toggle="validator">
                  <div class="form-group">
                    <label for="email" class="sr-only">Email</label>
                    <input type="text" class="form-control" placeholder="Enter Username" name="txt_uname"id="txt_uname">
					<span id="val_username" style="color:red"></span>
                  </div>
                  <div class="form-group mb-4">
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" class="form-control" placeholder="**********" name="txt_pass" id="txt_pass">
					<span id="val_pass" style="color:red"></span>
					<input type="hidden" id="err_email" name="err_email">
                  </div>
                  <input type="submit" name="btn_login" id="btn_login" onclick="return fnc_validation();" class="btn btn-block login-btn mb-4">
                </form>
                <a href="forgot_password.php" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot Password?</a> </div>
                <nav class="login-card-footer-nav">
                  <a href="#!">Terms of use.</a>
                  <a href="#!">Privacy policy</a>
                </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>
<script>
	$(document).ready(function() {
	
	$('#txt_uname,#txt_pass').on('keyup', function() {
		
		$('#btn_login').attr('disabled', false);
        $('#error_password').remove();
		
		var user_name = $('#txt_uname').val();
		var password = $('#txt_pass').val();

		if(user_name != "" && password != "")
		{	
			$.ajax({
				url: 'login_fetch.php',
				data: {
					'user_name': user_name,
					'password': password,
					'loginDetails': 1
				},
				type: 'post',
				dataType: 'json',
				success: function(data) {
					console.log(data);
					if (data.Not_exists == 1)
					{
						$('#err_email').val('Not_exists');
					}
					if(data.exists == 1)
					{
						$('#err_email').val('exists');
					}
				}
			});
		}
	});	
		
		 $('#btn_login').click(function() {
		 
			var user_not_exist = $('#err_email').val();
			
			if (user_not_exist == "Not_exists") 
			{
				$('#btn_login').attr('disabled',true);
                $('#txt_pass').after('<span id="error_password" style="color:red; font-size:12px;">Invalid Username Or Password!</span>');
                return false;
            }
            return true;
		 });
	});
</script>