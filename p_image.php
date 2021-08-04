<?php
session_start();
include "config.php";
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
    header("location: login.php");
    die();
}

$id2= $_SESSION["user_id"];
$result2 = mysqli_query($conn,"SELECT *FROM user_data WHERE id= '$id2'");
$row2 = mysqli_fetch_array($result2);
$username= $row2["username"];
$pass= $row2["pass"];
$phonenum= $row2["phoneno"];
$email= $row2["email"];
$gender= $row2["gender"];
$name=$row2["fullname"];
$pic=$row2["user_img"]; 
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['btprofile'])){
    header('location: welcome.php');
}

if(isset($_POST["update"])){
    $u_image=$_FILES["u_image"]["name"];
    $image_tmp=$_FILES["u_image"]["tmp_name"];
    $random_number=rand(1, 200);
    $spl = explode('.', $u_image);
    $extension=strtolower(end($spl));
    if($u_image==""){
        echo "Picture not selected";
        
    }
    if($extension=='jpeg'||$extension=='jpg'||$extension=='png'){
        // move_uploaded_file($image_tmp, "images/$u_image.$random_number");
        copy($image_tmp, "images/$u_image.$random_number");
        $move = "UPDATE user_data SET user_img='images/$u_image.$random_number' WHERE id='$id2'";
        $check=mysqli_query($conn, $move);
        if($check){
            echo "<script>alert('Profile picture updated successfully')</script>";
            echo "<script>window.open('p_image.php', '_self')</script>";
            
            exit();
            
        }
        else{
            echo "<script>alert('Error in uploading image')</script>";
            echo "<script>window.open('p_image.php', '_self')</script>";
        }
    }
    else{
        echo "<script>alert('Image should be of jpg, jpeg, png format')</script>";
            echo "<script>window.open('p_image.php', '_self')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update profile picture</title>
</head>
<style>
     #profileimg {
        width: 100%;
        max-height: 300px;
        padding: 5px;

    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        text-decoration: none;
        font-family: Arial, Helvetica, sans-serif;
    }

    body {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background: #dddddd;
        padding: 0 10px;
    }

    .wrapper {

        background: #f9f3f3;
        max-width: 450px;
        width: 100%;
        border-radius: 16px;
        box-shadow: 0 0 128px 0 rgba(0, 0, 0, 0.1),
            0 32px 64px -48px rgba(0, 0, 0, 0.5);
    }

    .form {
        padding: 25px 30px;
    }

    .field {
        margin-top: 5px;
        margin-bottom: 5px;
    }

    .form header {
        font-size: 35px;
        font-weight: 600;
        padding-bottom: 10px;
        border-bottom: 1px solid #e6e6e6;


    }
     .button {
    height: 45px;
    border: none;
    color: #fff;
    font-size: 17px;
    background: #28527a;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 13px;
    width: 100%;
    
  }
  .nav-link{
    float:right;
   
}

</style>
<body>
<div class="wrapper">
<div class="form ">
<div class="field">
    <header>Update profile picture</header>
    <div class="lo"><h3><a class="nav-link" href="logout.php">Logout</a></h3></div>
</div>
<br>
<div class="field">
    <strong>Current profile picture:</strong><br>
    <img src="<?php echo $pic ?>" id="profileimg">
</div>
<div class="field">
    <form action="" method="post" enctype="multipart/form-data">
        <label id="user-pic"><strong>Select file:</strong><br>
        <input type="file" name="u_image" size="60">
        </label>
        <br><br>

        <button id="update_img" class="button" name="update">Update image</button>
    </form>
</div>
<div class="field">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                    <input type="submit" name="btprofile" class="button" value="Back to profile" />
                </form>
            </div>
</div>
</div>
</body>
</html>