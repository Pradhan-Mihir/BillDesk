<?php
require_once('../connection.php');
require_once('geoplugin.class.php');

$response = array();
$SixDigitRandomNumber = mt_rand(100000,999999);

$geoplugin = new geoPlugin();
 
$geoplugin->locate();

if(isset($_POST['send_mail']))
{
    $sql_password_select="SELECT * FROM manage_user_tbl WHERE username='".$_POST['txt_id']."' OR email='".$_POST['txt_id']."' OR mobile='".$_POST['txt_id']."' ";

    $rs_password_select=mysqli_query($con,$sql_password_select);
    $rows_num=mysqli_num_rows($rs_password_select);
    
    if($rows_num > 0)
    {      
        $row_password_select=mysqli_fetch_array($rs_password_select);

        $to = $row_password_select['email'];
        $subject = "OTP for Change Password Request";
        $message = "Your 6 digit Verification code for Username:".$row_password_select['username']." is  ".$SixDigitRandomNumber.". This password change request has been done from IP:".$geoplugin->ip." at ".$geoplugin->city." , ".$geoplugin->region.",".$geoplugin->countryName.". If not done by you please dont reply or try to take action coz we dont support that kinda thing yet...";
        //echo $message;
        $header = "From:billdesk657@gmail.com";
        
        if(@mail($to,$subject,$message,$header))
        {
            $response['success'] = 1;
            $response['SixDigitRandomNumber'] = $SixDigitRandomNumber;
            $response['email'] = $row_password_select['email'];
        }
        else
        {
            $response['success'] = 0;
        }
    }
    else
    {
        $response['success'] = 0;
    }
}
else if(isset($_POST['change_password']))
{
    
    $sql_password_select="update manage_user_tbl set passward = '".$_POST['txt_id']."' WHERE email='".$_POST['email']."' ";

    $rs_password_select=mysqli_query($con,$sql_password_select);
    
    $response['success'] = 0;
    if($rs_password_select)
    {     

        $response['success'] = 1;

        $to = $_POST['email'];
        $subject = "Password Change Notification";
        $message = "Your Password has been changed. This password change request has been done from IP:".$geoplugin->ip." at ".$geoplugin->city." , ".$geoplugin->region.",".$geoplugin->countryName.". If not done by you please dont reply or try to take action coz we dont support that kinda thing yet...";
        //echo $message;
        $header = "From:billdesk657@gmail.com";
        
        if(@mail($to,$subject,$message,$header))
        {
            $response['mail_not_send'] = 0;
        }
        else
        {
            $response['mail_not_send'] = 1;
        }
    }
    else
    {
        $response['success'] = 0;
    }
}
echo json_encode($response);
?>