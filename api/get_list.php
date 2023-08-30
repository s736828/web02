<?php

include_once "../base.php";
$posts=$News->all(['type'=>$_GET['type']]);
// dd($posts);
foreach($posts as $post){
    echo "<div>";
    echo "<a href='javascript:getPost({$post['id']})'>";
    echo $post['title'];
    echo "</a>";
    echo "</div>";
}