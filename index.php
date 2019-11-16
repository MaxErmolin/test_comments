<?php
session_start();
$_SESSION['captcha'] = rand(1000, 9999);
?>
<html>
 <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Comments</title>
  <script src="http://code.jquery.com/jquery-latest.js"></script>
  <script>
$(document).ready(function(){
    $("#button").click(function(){
        var fd = new FormData();
        fd.append('name', $("#name").val());
        fd.append('comment', $("#comment").val());
        fd.append('captcha', $("#captcha").val());
        fd.append('img', $("#img")[0].files[0]);
        $.ajax({
            type: "POST",
            url: "add_comment.php",
            contentType: false,
            processData: false,
            dataType: 'json',
            data: fd,
            success: function(data){
                if (data.added){
                    $("#comments_start").after(data.comment_block);
                    $("#name").val("");
                    $("#comment").val("");
                    $("#img").val("");
                    $("#captcha").val("");
                    $("#captcha_img").html("<img src='captcha.php?"+Math.random()+"'>");
                }
                else{
                    $("#captcha").val("");
                    alert(data.error);
                    $("#captcha_img").html("<img src='captcha.php?"+Math.random()+"'>");
                }
            }
        });
    });
    $(document).on("click", ".del_comment" , function(){
        var id = $(this).data('id');
        $.ajax({
            type: "POST",
            url: "del_comment.php",
            data: {"id": id},
            success: function(data) {
                $("#comm"+id).detach();
            }
        });
        return false;
    });
});
</script>
  <style type="text/css">
   .comment { 
    position: relative;
    width: 400px; 
    background: #FFFFFF; 
    padding: 17px; 
    border: solid 1px #BFBFBF;
    margin: 5px;
    border-radius: 5px
   }
   .del_comment{
       position: absolute;
       right: 10px;
       bottom: 5px;
   }
   .comment_time{
       position: absolute;
       right: 10px;
       top: 7px;
       font-size: 14;
       color: #444749;
   }
   .comment_author{
       position: absolute;
       left: 10px;
       top: 4px;
       font-size: 19;
       color: #181818;
       font: Tahoma;
       font-weight: 500;
   }
   .comment_text{
       font-size: 15;
       color: #181818;
       font: Tahoma;
   }
   .comment_title{
       color: #282828;
   }
    #comment_form{
    padding: 4px;
    line-height: 1.7;
   }
   #comments_block{
    margin: 2;
   }
   #captcha{
       width:50px;
   }
   #button{
       height: 35px;
   }
   
  </style> 
 </head>
 <body>
<img src="default.jpg">
<div id="comment_form">
<form action="" method="post" id="form_comment">
  <span class="comment_title">Имя:</span><br>
  <input type="text" id="name"><br>
  <span class="comment_title">Текст комментария:</span><br>
  <textarea rows="10" cols="45" id="comment"></textarea><br>
  <span class="comment_title">Вставить картинку: </span>
  <input type="file" id="img" accept="image/*"><br>
  <span class="comment_title">Введите число: </span>
  <input type="text" id="captcha">
 <span id="captcha_img"><img  src="captcha.php"></span>
  <br>
  <input type="button" id="button" value="Добавить комментарий">
</form>
</div>
<p id="comments_start"></p>
<?php
include("load_comments.php");
?>
<p id="comments_end"></p>
</div>
 </body>
</html>