<?php 
session_start();
include "config.php";
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
if(isset($_POST['sendmess']))
{
    $toUser = $_SESSION['toUser'];
    $message = test_input($_POST['message']);
    $message=mysqli_real_escape_string($conn,$message);
    $fromUser = $_SESSION['username2'];
    echo $toUser;
    echo $fromUser;
    echo $message;
    $q = "INSERT INTO anurag_chat VALUES ('$toUser','$fromUser','$message', now());";
    $res = mysqli_query($conn,$q);
    
    if($res){
        header("Location: messages.php");
    }

}
else
{
    header("Location: welcome.php");
}
?>