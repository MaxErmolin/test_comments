<?php
session_start();
include("config.php");
$months = array("января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");
$time = date('d')." ".$months[date('m')-1]." ".date('Y')." в ".date('H:i');
$name = htmlspecialchars($_POST['name'], ENT_QUOTES);
$comment = htmlspecialchars($_POST['comment'], ENT_QUOTES);
$captcha = $_POST['captcha'];

if ($captcha != strval($_SESSION['captcha'])){
    $_SESSION['captcha'] = rand(1000, 9999);
    echo json_encode(array("added"=>false,
                        "error"=>"Неверно введена капча!"
));
}
elseif ($comment == null || $name == null){
    $_SESSION['captcha'] = rand(1000, 9999);
    echo json_encode(array("added"=>false,
                        "error"=>"Имя и комментарий не могут быть пустыми!"
)); 
}
else{
    $_SESSION['captcha'] = rand(1000, 9999);
    $link = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME);
    if ( !$link ) die();
    $query = "INSERT INTO ".COMMENTS_TABLE."(`name`, `comment`, `time`) VALUES('$name', '$comment', '$time')";
    if (!mysqli_query($link,$query)) die();
    $id = mysqli_insert_id($link);
    $query = "SELECT `name`,`comment`,`time` FROM ".COMMENTS_TABLE." WHERE `id`='$id'";
    $result = mysqli_query($link,$query);
    $comment = mysqli_fetch_assoc($result);
    if(!is_dir("img/")) 
        mkdir("img/");
    if (isset($_FILES['img']))
    move_uploaded_file($_FILES['img']['tmp_name'], 'img/'.$id.'.jpg');
    if (file_exists("img/".$id.".jpg")){
        $size = getimagesize("img/".$id.".jpg");
        if ($size[0] > 350)
            $width = 350;
        else
            $width = $size[0];
        $comment_block = "<div class='comment' id='comm".$id."'>
		<span class='comment_author'>".$comment['name']."</span>
		<span class='comment_time'>".$comment['time']."</span><br>
		<span class='comment_text'>".$comment['comment']."</span><br>
		<img width='".$width."' src='img/".$id.".jpg'><br>
		<a href='#' class='del_comment' data-id='".$id."'><img src='del.png'></a>
		</div>";
    }
    else
        $comment_block = "<div class='comment' id='comm".$id."'>
		<span class='comment_author'>".$comment['name']."</span>
		<span class='comment_time'>".$comment['time']."</span><br>
		<span class='comment_text'>".$comment['comment']."</span><br>
		<a href='#' class='del_comment' data-id='".$id."'><img src='del.png'></a>
		</div>";
    $query = "SELECT `id` FROM `comm`";
    $result = mysqli_query($link,$query);
    $count = mysqli_num_rows($result);
    echo json_encode(array("added"=>true,
                        "id"=>$id,
                        "comment_block"=>$comment_block,
                        "count"=>$count
));
mysqli_close($link);
}
?>
