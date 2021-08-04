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
$bio=$row2["bio"];
$err_username = $err_pass = $err_cpass = $err_name= $err_phonenum = $err_email= $err_gen =$err_bio= "";
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['btprofile'])){
    header('location: welcome.php');
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
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
    
    if(!empty($_POST['PW'])){
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
    if(!empty($_POST['CPW'])){
        $cpass = test_input($_POST['CPW']);
        if($pass!= $cpass){
            $err_cpass = "Does not match password";
        }
    }
    if(empty($_POST['bio_txt'])){
        $err_bio= "Field is required";
    } 
    else{
        $bio= test_input($_POST['bio_txt']);
    }
    $user_check = "Select * from user_data where username='$username'";
    $user_result = mysqli_query($conn, $user_check);
    $user_num = mysqli_num_rows($user_result);
    if($user_num>0 && $username!== $row2["username"]) 
    {
    $err_username="Username already exists"; 
    }
    else{
        $err_username="";
    }
    if(empty($err_username) && empty($err_pass) && empty($err_cpass) && empty($err_email) && empty($err_gen) && empty($err_phonenum) && empty($err_name) && empty($err_bio)){
        $hashpass2 = password_hash($pass, PASSWORD_DEFAULT);
        $upd = "UPDATE user_data SET fullname= '$name', phoneno='$phonenum', username='$username', gender='$gender', email='$email', pass='$hashpass2', bio='$bio' WHERE id='$id2'";
        // $ins = "INSERT INTO user_data( fullname, phoneno, username, gender, email, pass) VALUES ("."\"".$name."\",\"". $phonenum."\",\"". $username."\",\"". $gender."\",\"". $email."\",\"".$pass."\")";
        if(mysqli_query($conn, $upd)){
                    echo "Records updated successfully.";
                    header("location: welcome.php");
                    

                } else{
                    echo "ERROR: Could not able to execute" . mysqli_error($conn);
                }
        
    }

}




?>

<!DOCTYPE html>
<html>
<head> 
    <title>Sign up</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
        
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
        .notavailable {
            border: 6px #C33 solid !important;
        }
        .available {
            border: 6px #090 solid !important;
        }
        textarea{
            resize:none;
            width: 100%;
            border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 16px;
    padding: 0 10px;
        }
        .nav-link{
    float:right;
}

</style>
<body>
<div class="wrapper">
<div class="form ">
    <header>Update profile</header>
    <div><h3><a class="nav-link" href="logout.php">Logout</a></h3></div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
    <div class="field">
            <label for="name">Full Name:</label>
            <input type="text" class="input" name="NAME" id="name" value="<?php echo $name;?>">
            <div id="nameError" class="errorDiv"><?php echo $err_name ?></div>
    </div>
    <div class="field">
            <label for="phno">Phone number:</label>
            <input type="text" class="input" name="PN" id="phno" value="<?php echo $phonenum;?>">
            <div id="phoneError" class="errorDiv"><?php echo $err_phonenum ?></div>
    </div>
    <div class="field">
            <label for="u_name">Username:</label>
            <input type="text" class="input" name="uName" id="u_name" value="<?php echo $username;?>">
            <div id="unameError" class="errorDiv"><?php echo $err_username ?></div>
    </div>
    <div class="genfield">   
            <label for="gen" class="same">Gender:</label>
            <input type="radio" name="gender" id="male" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male">
            <label for="male" class="same">Male</label>
            <input type="radio" name="gender" id="female" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female">
            <label for="female" class="same">Female</label>
            <input type="radio" name="gender" id="others" <?php if (isset($gender) && $gender=="others") echo "checked";?> value="others">
            <label for="others" class="same">Others</label>
            <div id="genError" class="errorDiv"><?php echo $err_gender ?></div>
    </div>
    <div class="field">
            <label for="email">Email:</label>
            <input type="text"  class="input" name="emailadd" id="email" value="<?php echo $email;?>">
            <div id="emailError" class="errorDiv"><?php echo $err_email ?></div>
    </div>
    <div class="field">    
            <label for="bio">Bio:</label>
            <textarea id="bio"  name="bio_txt" rows="4" cols="50" ><?php echo $bio;?></textarea>
            <div id="bioError" class="errorDiv"><?php echo $err_bio; ?></div>
    </div>
    <div class="field">
            <label for="pass">New Password:</label>
            <input type="password" class="input" name="PW" id="pass" placeholder="Keep empty if don't want to change" >
            <div id="passError" class="errorDiv"><?php echo $err_pass ?></div>
            <div>(Password should contain minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character)</div>
    </div>
    <div class="field">
            <label for="cpass">Confirm new password:</label>
            <input type="password" class="input" name="CPW" id="cpass" placeholder="Keep empty if don't want to change">
            <div id="cpassError" class="errorDiv"><?php echo $err_cpass ?></div>
    </div>
            <!-- <p>Update profile picture:</p>
            <form action="" method="post"></form>
            <label>Select image
            <input type="file" name="u_image"
            </label>
            <br><br> -->
            <input type="submit" class="button" value="Update"/>
        </form>
        <div class="field">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                    <input type="submit" name="btprofile" class="button" value="Back to profile" />
                </form>
            </div>
    </div>
    </div>
</body>
<script>
    var inp = document.getElementById("u_name").value;
    document.getElementById("u_name").onkeyup = function() {checkUser(this.value)};
    function checkUser(str) {
        if (str.length==0) {
            document.getElementById("u_name").innerHTML="";
            return;
        }
        var xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function() {
            if (this.readyState==4 && this.status==200) {
                var x = this.responseText;
                if(x=="1"){
                    document.getElementById("u_name").classList.remove("available");
                    document.getElementById("u_name").classList.add("notavailable");
                }
                else{
                    document.getElementById("u_name").classList.remove("notavailable");
                    document.getElementById("u_name").classList.add("available"); 
                }
            
            }
        }
        xmlhttp.open("GET","usersearch.php?q="+str,true);
        xmlhttp.send();
    }


    var phoneNo= document.getElementById("phno");
    var emailInput= document.getElementById("email");
    var passWord= document.getElementById("pass");
    var cpassWord= document.getElementById("cpass");
    var nameInput= document.getElementById("name");
    var unameInput= document.getElementById("u_name");

    phoneNo.addEventListener("blur", function(){
        let regex= /^(\+91-|91|0)?[6-9]{1}[0-9]{9}$/;
        let phnoInput=phoneNo.value;
        if(regex.test(phnoInput)){
            document.getElementById("phoneError").innerHTML="";
        }
        else{
            document.getElementById("phoneError").innerHTML="Invalid Phone number";

        }

    })

    emailInput.addEventListener("blur", function(){
        let regex= /^([0-9a-zA-Z_\-\.]+)@([0-9a-zA-Z_\-\.]+)\.([a-zA-Z]){2,7}$/;
        let emailInputValue=emailInput.value;
        if(regex.test(emailInputValue)){
            document.getElementById("emailError").innerHTML="";
        }
        else{
            document.getElementById("emailError").innerHTML="Invalid email address";
        }
    });
    passWord.addEventListener("blur", function(){
        let regex= /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        let passInputValue=passWord.value;
        if(regex.test(passInputValue)){
            document.getElementById("passError").innerHTML="";
        }
        else{
            document.getElementById("passError").innerHTML="Invalid password";
        }
    });
    cpassWord.addEventListener("blur", function(){

        
        if(cpassWord.value==passWord.value){
            document.getElementById("cpassError").innerHTML="";
        }
        else{
            document.getElementById("cpassError").innerHTML="Does not match password";
        }
    });
    nameInput.addEventListener("blur", function(){

        let regex=/^[a-zA-Z-' ]*$/;
        let nameInputValue=nameInput.value;
        if(regex.test(nameInputValue)){
            document.getElementById("nameError").innerHTML="";
        }
        else{
            document.getElementById("nameError").innerHTML="Only letters, apostrophes,dashes and white space allowed";
        }
    });
    unameInput.addEventListener("blur", function(){

        let regex=/^[a-zA-Z 0-9]{2,30}$/;
        let unameInputValue=unameInput.value;
        if(regex.test(unameInputValue)){
            document.getElementById("unameError").innerHTML="";
        }
        else{
            document.getElementById("unameError").innerHTML="Username should contain only alphabets, numbers";
        }
    });
    
</script>
</html>