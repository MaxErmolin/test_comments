<?php
include("config.php");

$id = $_POST['id'];
$link = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME);
if ( !$link ) die("Error");
$query = "DELETE FROM ".COMMENTS_TABLE." WHERE `id` = '$id'";
if (mysqli_query($link,$query)) 
    echo $id;
else 
    echo "Error!";
mysqli_close($link);
?>