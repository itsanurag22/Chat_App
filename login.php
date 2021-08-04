<?php 
session_start();
include("config.php");
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

$username2 = test_input($_POST['uName2']);
$pass2 = test_input($_POST['PW2']);
$error="";
$err_username2 = $err_pass2 = "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($username2)) $err_username2 = "Field is required";
    if(empty($pass2)) $err_pass2 = "Field is required";
    if ($username2 != "" && $pass2 != ""){
        
        $login_check = "select * from user_data where username='".$username2."'";
        $login_result = mysqli_query($conn, $login_check);
        $row2=mysqli_fetch_array($login_result);
        $login_num = mysqli_num_rows($login_result);
        if($login_num > 0){
            if(password_verify($pass2, $row2['pass'])){
            if(!empty($_POST["remember"])){
                setcookie ("username2",$_POST["uName2"],time() + (3600), "/");
                setcookie ("password2",$_POST["PW2"],time() + (3600), "/");
                echo "Cookies Set Successfuly";
            }
            else{
                setcookie("username2","");
                setcookie("password2","");
                echo "Cookies Not Set";
            }
    
            $_SESSION["username2"] = $username2;
            $_SESSION["user_id"]=$row2['id'];
            $_SESSION["loggedin"] = true;
            // echo $_SESSION["username2"];
            header('location: chat.php');
        }
        else{
            $error="Invalid username or password";
        //     echo '<script>alert("Invalid username or password")</script>';
         }
        }
        
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Login page</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    .errorDiv{
            color: red;
        }
</style>
<body>
<div class="wrapper">
    <div class="form">
    <header>Log In</header>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
    <div class="errorDiv"><?php echo $error ?></div>
    <div class="field">
        <label for="u_name">Username:</label>
        <input type="text" class="input" name="uName2" id="u_name" value="<?php if(isset($_COOKIE["username2"])) { echo $_COOKIE["username2"]; } ?>">
        <div class="errorDiv"><?php echo $err_username2 ?></div>
    </div>
    <div class="field">    
        <label for="pass">Password:</label>
        <input type="password" class="input" name="PW2" id="pass" value="<?php if(isset($_COOKIE["password2"])) { echo $_COOKIE["password2"]; } ?>">
        <div class="errorDiv"><?php echo $err_pass2 ?></div>
        <br>
        <input type="checkbox" onclick="myFunction()">Show Password
        <br>
        <input type="checkbox" name="remember" id="REM">
        <label for="REM">Remember Me</label>
    </div>
    <div class="field ">
        <input type="submit" class="button" value="Log In"/>
    </div>
    </form>
    <p>Don't have an account? <a href="signup.php">Sign up now</a>.</p>
    </div>
    </div>
</body>
<script>
    function myFunction() {
    var x = document.getElementById("pass");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
</script>
</html>