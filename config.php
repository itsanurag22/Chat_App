<?php
   define('mysql_server', 'localhost');
   define('mysql_username', 'anurag');
   define('mysql_password', 'password');
   define('mysql_database', 'db');
   $conn = mysqli_connect(mysql_server,mysql_username,mysql_password,mysql_database);
   if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
   //  echo "Connected successfully";
?>