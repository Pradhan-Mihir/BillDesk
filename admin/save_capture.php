<?php
    $image = $_POST["image"];
    $image = explode(";",$image)[1];
    $image = explode(",",$image)[1];
    $image = str_replace(" ","+",$image);

    $image = base64_decode($image);

    $filename = $_POST['filename'];
    file_put_contents("../invoice/".$filename.".png",$image);

    echo "DONE";
?>