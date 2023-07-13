<?php
    require_once('../connection.php');
    global $con;

    if(isset($_POST['fetch']))
    {
        $fetchSql = "select * from tbl_invoice_setting ";
        $result = mysqli_query($con,$fetchSql);
        $row = mysqli_fetch_array($result);

        $is_show_serial = $row["is_show_serial"];
        $is_show_batch = $row["is_show_batch"];
        $is_show_party = $row["is_show_party"];
        $condition_1 = $row["condition_1"];
        $condition_2 = $row["condition_2"];
        $condition_3 = $row["condition_3"];
        $condition_4 = $row["condition_4"];
        $condition_5 = $row["condition_5"];
        $condition_6 = $row["condition_6"];

        $response = array("is_show_serial" => $is_show_serial ,"is_show_batch" => $is_show_batch ,"is_show_party" => $is_show_party , "condition_1" => $condition_1 ,"condition_2" => $condition_2 ,"condition_3" => $condition_3 ,"condition_4" => $condition_4 , "condition_5" => $condition_5 ,"condition_6" => $condition_6  );

    }
    else if(isset($_POST['update_chk']))
    {
        $sql = "UPDATE tbl_invoice_setting SET ".$_POST['id']." = ".$_POST['data']." ";
        $result = mysqli_query($con,$sql);
        if($result)
            $response['Fail'] = 0;
        else
            $response['Fail'] = 1;
    }
    else if(isset($_POST['update']))
    {
        $sql = "UPDATE tbl_invoice_setting SET ".$_POST['id']." = '".$_POST['data']."' ";
        $result = mysqli_query($con,$sql);
        if($result)
            $response['Fail'] = 0;
        else
            $response['Fail'] = 1;
    }
    else if(isset($_POST['check']))
    {
        $sql = "select ".$_POST['id']." from  tbl_invoice_setting ";
        $result = mysqli_query($con,$sql);
        $row = mysqli_fetch_array($result);

        $response['inside_check'] = $row[$_POST['id']];
        $response['inside'] = $_POST['data'] ;
        if($row[$_POST['id']] == $_POST['data'] )
            $response['Fail'] = 0;
        else
            $response['Fail'] = 1;
    }
    else
        $response['Fail'] = 1;

    echo json_encode($response);
?>