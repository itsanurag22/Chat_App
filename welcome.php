<?php
session_start();
include "config.php";
// echo "Welcome " . $_SESSION["username2"];
// echo $_SESSION["loggedin"];
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
    header("location: login.php");
    die();
}
if(isset($_SESSION['username2'])){
    if(isset($_SESSION['toUser'])){
        unset($_SESSION['toUser']);
    }
}
$id= $_SESSION["user_id"];
$result = mysqli_query($conn,"SELECT *FROM user_data WHERE id= '$id'");
$row = mysqli_fetch_array($result);

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['update_profile'])){
    header('location: update.php');
}
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['update_image'])){
    header('location: p_image.php');
}
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['chat'])){
    if(empty($row['user_img']) || empty($row["username"]) || empty($row["phoneno"]) || empty($row["email"]) || empty($row["gender"]) || empty($row["bio"]) ){
        echo "<script>alert('Complete your profile first.')</script>";
        echo "<script>window.open('welcome.php', '_self')</script>";
    }
    else{
        header('location: chat.php');
    }
}
// if(!isset($_SESSION['username2']) || $_SESSION['username2'] !==true)
// {
//     header("location: login.php");
//     session_unset();
//     session_destroy();
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    

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
  table{
      width:100%;
      table-layout: fixed;
  }
  th,td {
    border-style: solid;
    border-width: 1px;
    border-color: #BCBCBC;
    word-wrap: break-word;
}
.nav-link{
    float:right;
}

</style>

<body>
    <div class="nav-bar">
        
    </div>
    <div class="wrapper">
        <div class="form ">
            <div class="field">
                <header>Hi there, <?php echo $row["fullname"];?></header>
                <div><h3><a class="nav-link" href="logout.php">Logout</a></h3></div>
            </div>
            <div class="field">
                <img id="profileimg" src="<?php echo $row['user_img']; ?>">
            </div>
            <div class="field">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                    <input type="submit" name="update_image" class="button" value="Update profile picture" />
                </form>
            </div>
            <div class="field">
                <table>
                    <tr>
                        <td>Username</td>
                        <td><?php echo $row["username"]; ?></td>
                    </tr>
                    <tr>
                        <td>Phone No.</td>
                        <td><?php echo $row["phoneno"]; ?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><?php echo $row["email"]; ?></td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td><?php if($row["gender"]=="male") {echo "Male";} if($row["gender"]=="female") {echo "Female";} if($row["gender"]=="others") {echo "Other";}?>
                        </td>
                    </tr>
                    <tr>
                        <td>Bio:</td>
                        <td><?php echo $row['bio'];?></td>
                    </tr>
                </table>
            </div>
            <div class="field">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                    <input type="submit" name="update_profile" class="button" value="Update profile info" />
                </form>
            </div>
            <div class="field">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                    <input type="submit" name="chat" class="button" value="Chat with others" />
                </form>
            </div>
            
        </div>
    </div>
</body>

</html>