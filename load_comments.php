<?php
include("config.php");

$link = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME);
if ( !$link ) die("Error");
$query = "SELECT `id` FROM ".COMMENTS_TABLE;
$result = mysqli_query($link,$query);
$count = mysqli_num_rows($result);
for ($i = $count-1; $i >= 0; $i--){
    $query = "SELECT `id`,`name`,`comment`,`time` FROM ".COMMENTS_TABLE." LIMIT ".$i.",1";
    $result = mysqli_query($link,$query);
    $arr = mysqli_fetch_assoc($result);
    if (file_exists("img/".$arr['id'].".jpg")){
        $size = getimagesize("img/".$arr['id'].".jpg");
        if ($size[0] > 350)
            $width = 350;
        else
            $width = $size[0];
        echo "<div class='comment' id='comm".$arr['id']."'>
		<span class='comment_author'>".$arr['name']."</span>
		<span class='comment_time'>".$arr['time']."</span><br>
		<span class='comment_text'>".$arr['comment']."</span><br>
		<img width='".$width."' src='img/".$arr['id'].".jpg'><br>
		<a href='#' class='del_comment' data-id='".$arr['id']."'><img src='del.png'></a>
		</div>";
    }
    else
        echo "<div class='comment' id='comm".$arr['id']."'>
	<span class='comment_author'>".$arr['name']."</span>
	<span class='comment_time'>".$arr['time']."</span><br>
	<span class='comment_text'>".$arr['comment']."</span><br>
	<a href='#' class='del_comment' data-id='".$arr['id']."'><img src='del.png'></a>
	</div>";
}
mysqli_close($link);
?>