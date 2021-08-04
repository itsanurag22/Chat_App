<?php
if(isset($_POST["update"])){
    $u_image=$_FILES["u_image"]["name"];
    $image_tmp=$_FILES["u_image"]["tmp_name"];
    
    
    copy($image_tmp, "images/$u_image");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
        <label id="user-pic"><strong>Select file:</strong><br>
        <input type="file" name="u_image" size="60">
        </label>
        <br><br>

        <button id="update_img" class="button" name="update">Update image</button>
    </form>
</body>
</html>