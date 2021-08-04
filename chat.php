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
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['btprofile'])){
    header('location: welcome.php');
}
$id= $_SESSION["user_id"];
$result = mysqli_query($conn,"SELECT * FROM user_data WHERE id= '$id'");
$row = mysqli_fetch_array($result);
if(empty($row['user_img']) || empty($row["username"]) || empty($row["phoneno"]) || empty($row["email"]) || empty($row["gender"]) || empty($row["bio"]) ){
    echo "<script>alert('Complete your profile first to access the chat page.')</script>";
    echo "<script>window.open('welcome.php', '_self')</script>";
}

// $show_user.="<tr><td><img src='" .  $row2['user_img'] . "'</td><td>" . $row2['username'] . "</td><td>" . $row2['fullname'] . "</td><td><button>Chat</button></td></tr>";
// }
// $show_user2="<tr><th>Profile image</th><th>Username</th><th>Full name</th><th>Chat</th></tr>" . $show_user;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat page</title>
</head>
<style>
    img {
        width: 50px;

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
        padding: 30px 30px;
    }

    .wrapper {

        background: #f9f3f3;
        max-width: 600px;
        width: 100%;
        border-radius: 16px;
        box-shadow: 0 0 128px 0 rgba(0, 0, 0, 0.1),
            0 32px 64px -48px rgba(0, 0, 0, 0.5);
    }

    table {
        width: 100%;
        border-collapse: collapse;

    }

    header {
        font-size: 25px;
        font-weight: 600;
        padding: 10px;
        border-bottom: 1px solid #e6e6e6;
        text-align: center;
    }

    #show {
        display: block;
    }

    th,
    td {
        padding: 10px;
        text-align: center;
        border-bottom: 1px solid #ddd;
        width: 100px;
    }

    #show {
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

    .nav-link {
        float: right;
    }
</style>

<body>
    <div class="wrapper">
        <header>User List</header>
        <div>
            <h3><a class="nav-link" href="logout.php">Logout</a></h3>
        </div>
        <form action="messages.php" method="post">
            <table>
                <tr>
                    <th>Profile image</th>
                    <th>Username</th>
                    <th>Full name</th>
                    <th>Chat</th>
                </tr>

                <?php
        $result2 = mysqli_query($conn,"SELECT * FROM user_data WHERE id!= '$id'");
        while($row2 = mysqli_fetch_array($result2)){
    ?>
                <tr>
                    <td><img src="<?php echo $row2['user_img']; ?>"></td>
                    <td><?php echo $row2['username'];?></td>
                    <td><?php echo $row2['fullname'];?></td>
                    <td><input type="radio" name="toUser" id="<?php echo $row2['username']; ?>"
                            value="<?php echo $row2['username']; ?>"></td>
                </tr>
                <?php
    }
    ?>


            </table>
            <input type="submit" value="Messages" name="send" id="show">
        </form>
        <div class="field">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <input type="submit" name="btprofile" id="show" value="Back to profile" />
            </form>
        </div>
    </div>
    <!-- <table id="show">
        <tr>
            <th>Profile image</th>
            <th>Username</th>
            <th>Full name</th>
            <th>Chat</th>
        </tr>

    </table>
    </div>
    <div class="wrapper">
        Hello
    </div> -->
</body>

</html>