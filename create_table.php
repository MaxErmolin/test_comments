<?php
include("config.php");
$link = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME);
if ( !$link ) die();
$query = "CREATE TABLE `".DB_NAME."`.`".COMMENTS_TABLE."` ( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `name` VARCHAR(30) , `comment` VARCHAR(5000), `time` VARCHAR(50), PRIMARY KEY (`id`))";
if (!mysqli_query($link,$query)) die();
else echo "OK";
?>
