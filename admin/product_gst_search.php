<?php
  require_once('../connection.php');
  
  $response = array();
  
  if(isset($_POST['search']))
  {
    if(isset($_POST['id']))
    {
      $party = "select * from tbl_gstslab_master where gstslab_id='".$_POST['id']."' ";
      $result = mysqli_query($con,$party);        
      while($row = mysqli_fetch_array($result))
      {
        $response["igst"] = $row["igst"];
      }
    }    
  }
  else
  {
    $response["Fail"] = 1;
  }
  echo json_encode($response);
?>