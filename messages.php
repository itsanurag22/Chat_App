<?php
session_start();
include "config.php";
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['btprofile'])){
    header('location: welcome.php');
}
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['btuserlist'])){
    header('location: chat.php');
}
if(isset($_POST['send'])||isset($_SESSION['toUser']))
    {
        $fromUser = $_SESSION['username2'];
        if(isset($_SESSION['toUser']))
        {
            $toUser = $_SESSION['toUser'];
        }
        else
        {
            $toUser = $_POST['toUser'];
        }
        if(isset($_POST['send'])){
            $_SESSION['toUser'] = $toUser;
        }
         echo $toUser;
         echo $fromUser;
        // echo $_SESSION['toUser'];
        $query = "SELECT * FROM anurag_chat WHERE (toUser = '$toUser' AND fromUser = '$fromUser') OR (toUser = '$fromUser' AND fromUser = '$toUser');";
        $result = mysqli_query($conn,$query);
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with users</title>
</head>
<style>
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
    header {
        font-size: 25px;
        font-weight: 600;
        padding: 10px;
        border-bottom: 1px solid #e6e6e6;
        text-align: left;
    }
    .container {
  border: 2px solid #dedede;
  background-color: #f1f1f1;
  border-radius: 5px;
  padding: 10px;
  margin: 10px 0;
}
.time-right {
  float: right;
  color: #aaa;
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
#sendmess{
    height: 45px;
        margin-right: 10px;
        border: none;
        color: #fff;
        font-size: 17px;
        background: #28527a;
        border-radius: 5px;
        cursor: pointer;
        
        float:right;
        width:60px;
}
#message {
    margin:0;
    height: 45px;
    width: 100%;
    font-size: 16px;
    padding: 0 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
  }
  #labelmess{
      margin-left:10px;
  }
  .nav-link {
        float: right;
    }
</style>
<body>
    <div class="wrapper">
    <header>Chatbox</header>
    <div>
            <h3><a class="nav-link" href="logout.php">Logout</a></h3>
        </div><br>
    <?php 
        if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_array($result)){
    ?>
    <div class="container ">
    <span class="time-right"><?php echo $row['storeDate']; ?></span>
    <p>Sender: <?php echo $row['fromUser']; ?></p>
    <p>Receiver: <?php echo $row['toUser']; ?></p>
    <p>Message content: <?php echo $row['message']; ?></p>
    
    </div>
        <?php 
            }
        }
        
    }
    ?>
    <form action="sendmessages.php" method="post">
        <label for = "message" id="labelmess">Type here</label>
        <input id = "message" name = "message" style="width:70%; ">
        <span><input type = "submit" name = "sendmess" id = "sendmess" value="Send" ></span>
    </form>
    <div class="field">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <input type="submit" name="btuserlist" id="show" value="Back to user list" />
            </form>
    </div>
    <div class="field">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <input type="submit" name="btprofile" id="show" value="Back to profile" />
            </form>
    </div>
    </div>
</body>
</html>
