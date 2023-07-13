<?php 
	include_once("../connection.php");
	
	
?>
<script>
	var code_of_verification_be = 000000 ;
	var email = '';
	function get_data(code , mail)
	{
		code_of_verification_be = code;
		email = mail;
		return true;
	}
</script>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    .loader {
        display: none;
        top: 50%;
        right: 0%;
        position: absolute;
        transform: translate(-50%, -50%);
    }

    .loading {
        border: 2px solid #ccc;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border-top-color: #1ecd97;
        border-left-color: #1ecd97;
        animation: spin 1s infinite ease-in;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/login.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
              <p class="login-card-description" id="id_text">Enter Username , Mobile or Email</p>
              <form method="post" id="frm_login" action="" name="frm_login" data-toggle="validator">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Enter Username , Mobile or Email" name="txt_id"id="txt_id">

					</div>
                  <button type="button" name="btn_submit" id="btn_submit"  class="btn btn-block login-btn mb-4">Continue</button>
				  <button type="button" name="btn_second" id="btn_second" hidden class="btn btn-block login-btn mb-4">Continue</button>
				  <button type="button" name="btn_change_password" id="btn_change_password" hidden class="btn btn-block login-btn mb-4">Confirm</button>
                  <div class="loader" style="display: block;" hidden>
                      <div class="loading">
                      </div>
                  </div>
                </form>
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

$('#btn_submit').on('click' , function(){

	let txt_id = $('#txt_id').val();
    if(txt_id == '') {
        if(document.getElementById('error_company') == '' || document.getElementById('error_company') == undefined)
            $('#txt_id').after("<span id='error_company' style='color:red; font-size:15px;'>Please Enter ID!</span>");

        return false;


    }
    document.getElementsByClassName("loader")[0].hidden= false;
	$.ajax({  
			url:"forgot_password_ajax.php",
			type:"POST",  
			data:{ 'txt_id' : txt_id , 'send_mail' : 1 },
			//async:false,
			dataType:'JSON',
			success:function(data)  
			{
                if(document.getElementById('error_company') != '' && document.getElementById('error_company') != undefined)
                    $('#error_company').remove();

				if(data.success == 0)
					$('#txt_id').after("<span id='error_company' style='color:red; font-size:15px;'>Account Does'nt Exists!</span>");
				else
				{

					$('#id_text').html("Enter the 6 digit Verification code");
					document.getElementById('txt_id').placeholder = "Enter Verification Code";
					document.getElementById('txt_id').value = '';
					document.getElementById('btn_submit').hidden = true;
					document.getElementById('btn_second').hidden = false;
					get_data(data.SixDigitRandomNumber , data.email);

				}
                document.getElementsByClassName("loader")[0].hidden= true;
			}  
		});
});

$('#btn_second').on('click' , function(){
	let txt_id = $('#txt_id').val();
    if(document.body.contains(document.getElementById('error_company')))
        $('#error_company').remove();
	if(code_of_verification_be == 000000 || code_of_verification_be != txt_id)
	{
		if(!document.body.contains(document.getElementById('error_company')))
			$('#txt_id').after("<span id='error_company' style='color:red; font-size:15px;'>Enter correct Verification Code!</span>");
	}
	else
	{
		$('#id_text').html("Enter New Password");
		document.getElementById('txt_id').placeholder = "Enter New Password";
		document.getElementById('txt_id').type = "password";
		$('#txt_id').after('<input type="password" class="form-control" placeholder="Confirm Password" name="txt_id_confirm"id="txt_id_confirm">');
		document.getElementById('txt_id').value = '';
		document.getElementById('btn_second').hidden = true;
		document.getElementById('btn_change_password').hidden = false;

	}
});

$('#btn_change_password').on('click' , function(){
	let txt_id = $('#txt_id').val();
    if($('#txt_id').val() == '' || $('#txt_id_confirm').val() == ''  )
    {
        if(document.body.contains(document.getElementById('error_company')))
            $('#error_company').remove();
        if($('#txt_id').val() != $('#txt_id_confirm').val())
            $('#txt_id_confirm').after("<span id='error_company' style='color:red; font-size:15px;'>Password Doesnt Match!</span>");
        else
            $('#txt_id_confirm').after("<span id='error_company' style='color:red; font-size:15px;'>Enter Password!</span>");
        return false;
    }
	$.ajax({  
			url:"forgot_password_ajax.php",
			type:"POST",  
			data:{ 'email' : email , 'change_password' : 1  , 'txt_id' : txt_id},
			//async:false,
			dataType:'JSON',
			success:function(data)  
			{  
				if(data.success == 0)
					$('#txt_id').after("<span id='error_company' style='color:red; font-size:15px;'>Something validation typ of thing here!</span>");
				else
				{
					window.location  ='index.php';

					/*
					$('#id_text').html("Enter the 6 digit Verification code");
					document.getElementById('txt_id').placeholder = "Enter Verification Code";
					code_of_verification_be = data.SixDigitRandomNumber;
					email = data.email;
					document.getElementById('btn_submit').hidden = true;
					document.getElementById('btn_second').hidden = false;
					*/
				}
			}  
		});
});
  
</script>
