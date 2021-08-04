<?php
session_start();
include("config.php");
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
$username = $pass = $cpass = $name= $phonenum = $email= $gen = "";
$err_username = $err_pass = $err_cpass = $err_name= $err_phonenum = $err_email= $err_gen = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if(empty($_POST["uName"])){ 
        $err_username = "Field is required";
    }
    else{
        $username = test_input($_POST['uName']);
        if (!preg_match("/^[a-zA-Z 0-9]{2,30}$/",$username)) {
            $err_username = "Username should contain only alphabets, numbers";
          }

    }
    if(empty($_POST['PW'])){ 
        $err_pass = "Field is required";
    }
    else{
        $pass = test_input($_POST['PW']);
        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",$pass)) {
            $err_pass = "Invalid password";
          }
    }
    if(empty($_POST['NAME'])){ 
        $err_name = "Field is required";
    }
    else{
        $name = test_input($_POST['NAME']);
        if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
            $err_name = "Only letters, apostrophes,dashes and white space allowed";
          }
    }
    if(empty($_POST['PN'])){ 
        $err_phonenum = "Field is required";
    }
    else{
        $phonenum = test_input($_POST['PN']);
        
        if (!preg_match("/^(\+91-|91|0)?[6-9]{1}[0-9]{9}$/",$phonenum)) {
            $err_phonenum = "Invalid Phone number";
          }
    }
    if(empty($_POST['gender'])){ 
        $err_gender = "Field is required";
    }
    else{
        $gender = test_input($_POST['gender']);
    }
    if(empty($_POST['emailadd'])){ 
        $err_email = "Field is required";
    }
    else{
        $email = test_input($_POST['emailadd']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $err_email = "Invalid email address";
          }
          
    }
    if(empty($_POST['CPW'])){ 
        $err_cpass = "Field is required";
    }
    else{
        $cpass = test_input($_POST['CPW']);
        if($pass!= $cpass){
            $err_cpass = "Does not match password";
        }
    }
    $user_check = "Select * from user_data where username='$username'";
    $user_result = mysqli_query($conn, $user_check);
    $user_num = mysqli_num_rows($user_result);
    if($user_num>0) 
    {
    $err_username="Username already exists"; 
    }
    else{
        $err_username="";
    }
    if(empty($err_username) && empty($err_pass) && empty($err_cpass) && empty($err_email) && empty($err_gen) && empty($err_phonenum) && empty($err_name)){
        $hashpass = password_hash($pass, PASSWORD_DEFAULT);
        $ins = "INSERT INTO user_data( fullname, phoneno, username, gender, email, pass) VALUES ("."\"".$name."\",\"". $phonenum."\",\"". $username."\",\"". $gender."\",\"". $email."\",\"".$hashpass."\")";
        if(mysqli_query($conn, $ins)){
                    // echo "<script>alert('Sign up successful. Login using your username and password.')</script>";
                    // echo "<script>window.open('login.php', '_self')</script>";
                    $login_check = "select * from user_data where username='".$username."'";
                    $login_result = mysqli_query($conn, $login_check);
                    $row2=mysqli_fetch_array($login_result);
                    $_SESSION["username2"] = $username;
                    $_SESSION["user_id"]=$row2['id'];
                    $_SESSION["loggedin"] = true;
                    header('location: welcome.php');
                } else{
                    echo "ERROR: Could not able to execute" . mysqli_error($conn);
                }
        
    }

}

// $email_check = "Select * from user_data where email='$email'";
// $email_result = mysqli_query($conn, $email_check);
// $email_num = mysqli_num_rows($email_result);
// if($email_num>0) 
// {
//    $err_email="This email already exists"; 
// }
// else{
//     $err_email="";
// }
// $phonenum_check = "Select * from user_data where phoneno='$phonenum'";
// $phonenum_result = mysqli_query($conn, $phonenum_check);
// $phonenum_num = mysqli_num_rows($phonenum_result);
// if($phonenum_num>0) 
// {
//    $err_phonenum="This phone number already exists"; 
// }
// else{
//     $err_phonenum="";
// }
// if(empty($err_username) && empty($err_pass)){
//     $ins="INSERT INTO trial( user_name, pass) VALUES (\"" . $username . "\",\"" . $pass . "\")";
//     echo $ins;

//     if(mysqli_query($conn, $ins)){
//         echo "Records inserted successfully.";
//     } else{
//         echo "ERROR: Could not able to execute";
//     } 
// }

?>




<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="style.css">

</head>
<style>
    h1 {
        padding-bottom: 0.8em;
    }

    br {
        padding: 10px;
    }

    .same {
        display: inline;
    }

    .errorDiv {
        color: red;
        display: inline;

    }

    .notavailable {
        border: 6px #C33 solid !important;
    }

    .available {
        border: 6px #090 solid !important;
    }
</style>

<body>
    <div class="wrapper">
        <div class="form ">
            <header>Sign Up</header>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <div class="field">
                    <label for="name">Full Name:</label>
                    <input class="input" type="text" name="NAME" id="name" value="<?php echo $name;?>">
                    <div id="nameError" class="errorDiv"><?php echo $err_name ?></div>
                    
                </div>
                <div class="field">
                    <label for="phno">Phone number:</label>
                    <input type="text" class="input" name="PN" id="phno" value="<?php echo $phonenum;?>">
                    <div id="phoneError" class="errorDiv"><?php echo $err_phonenum ?></div>
                    
                </div>
                <div class="field">
                    <label for="u_name">Username:</label>
                    <input type="text" name="uName" class="input" id="u_name" value="<?php echo $username;?>">
                    <div>(Remember you cannot change your username later)</div>
                    <div id="unameError" class="errorDiv"><?php echo $err_username ?></div>
                    
                    
                </div>
                <div class="genfield">
                    <label for="gen" class="same">Gender:</label>
                    <input type="radio" name="gender" id="male"
                        <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male">
                    <label for="male" class="same">Male</label>
                    <input type="radio" name="gender" id="female"
                        <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female">
                    <label for="female" class="same">Female</label>
                    <input type="radio" name="gender" id="others"
                        <?php if (isset($gender) && $gender=="others") echo "checked";?> value="others">
                    <label for="others" class="same">Others</label>
                    <div id="genError" class="errorDiv"><?php echo $err_gender ?></div>
                    
                </div>
                <div class="field">
                    <label for="email">Email:</label>
                    <input type="text" name="emailadd" class="input" id="email" value="<?php echo $email;?>">
                    <div id="emailError" class="errorDiv"><?php echo $err_email ?></div>
                    
                </div>
                <div class="field">
                    <label for="pass">Password:</label>
                    <input type="password" name="PW" id="pass" class="input" value="<?php echo $pass;?>">
                    <div id="passError" class="errorDiv"><?php echo $err_pass ?></div>
                    <div id = "instr">(Password should contain minimum eight characters, at least one uppercase letter, one lowercase
                        letter, one number and one special character)</div>
                    
                </div>
                <div class="field">
                    <label for="cpass">Confirm password:</label>
                    <input type="password" name="CPW" id="cpass" class="input" value="<?php echo $cpass;?>">
                    <div id="cpassError" class="errorDiv"><?php echo $err_cpass ?></div>
                    
                </div>
                <div class="field">
                    <input type="submit" name="submit" class="button" value="Signup">
                </div>
            </form>
            <div class="link">Already signed up? <a href="login.php">Login now</a></div>
        </div>
    </div>
</body>
<script>
    var inp = document.getElementById("u_name").value;
    document.getElementById("u_name").onkeyup = function () {
        checkUser(this.value)
    };

    function checkUser(str) {
        if (str.length == 0) {
            document.getElementById("u_name").innerHTML = "";
            return;
        }
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var x = this.responseText;
                if (x == "1") {
                    document.getElementById("u_name").classList.remove("available");
                    document.getElementById("u_name").classList.add("notavailable");
                } else {
                    document.getElementById("u_name").classList.remove("notavailable");
                    document.getElementById("u_name").classList.add("available");
                }

            }
        }
        xmlhttp.open("GET", "usersearch.php?q=" + str, true);
        xmlhttp.send();
    }


    var phoneNo = document.getElementById("phno");
    var emailInput = document.getElementById("email");
    var passWord = document.getElementById("pass");
    var cpassWord = document.getElementById("cpass");
    var nameInput = document.getElementById("name");
    var unameInput = document.getElementById("u_name");

    phoneNo.addEventListener("blur", function () {
        let regex = /^(\+91-|91|0)?[6-9]{1}[0-9]{9}$/;
        let phnoInput = phoneNo.value;
        if (regex.test(phnoInput)) {
            document.getElementById("phoneError").innerHTML = "";
        } else {
            document.getElementById("phoneError").innerHTML = "Invalid Phone number";

        }

    })

    emailInput.addEventListener("blur", function () {
        let regex = /^([0-9a-zA-Z_\-\.]+)@([0-9a-zA-Z_\-\.]+)\.([a-zA-Z]){2,7}$/;
        let emailInputValue = emailInput.value;
        if (regex.test(emailInputValue)) {
            document.getElementById("emailError").innerHTML = "";
        } else {
            document.getElementById("emailError").innerHTML = "Invalid email address";
        }
    });
    passWord.addEventListener("blur", function () {
        let regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        let passInputValue = passWord.value;
        if (regex.test(passInputValue)) {
            document.getElementById("passError").innerHTML = "";
        } else {
            document.getElementById("passError").innerHTML = "Invalid password";
        }
    });
    cpassWord.addEventListener("blur", function () {


        if (cpassWord.value == passWord.value) {
            document.getElementById("cpassError").innerHTML = "";
        } else {
            document.getElementById("cpassError").innerHTML = "Does not match password";
        }
    });
    nameInput.addEventListener("blur", function () {

        let regex = /^[a-zA-Z-' ]*$/;
        let nameInputValue = nameInput.value;
        if (regex.test(nameInputValue)) {
            document.getElementById("nameError").innerHTML = "";
        } else {
            document.getElementById("nameError").innerHTML =
                "Only letters, apostrophes,dashes and white space allowed";
        }
    });
    unameInput.addEventListener("blur", function () {

        let regex = /^[a-zA-Z 0-9]{2,30}$/;
        let unameInputValue = unameInput.value;
        if (regex.test(unameInputValue)) {
            document.getElementById("unameError").innerHTML = "";
        } else {
            document.getElementById("unameError").innerHTML = "Username should contain only alphabets, numbers";
        }
    });
</script>

</html>