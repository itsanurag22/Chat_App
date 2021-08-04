<?php

include("config.php");
$q = $_GET["q"];
$find= "SELECT * FROM user_data WHERE username = '" . $q . "'";
// $result = mysqli_query($conn,$find);
$response = mysqli_query($conn, $find);
    $num = mysqli_num_rows($response);
    if($num>0){
        echo "1";
    }
    else{
        echo "0";
    }

    // "<span style="color:red;">". $q . "</span>"; 
?>