<?php

include_once "../base.php";
$post = $News->find($_GET['id']);
echo "<span style='font-weight:bolder'>" . $post['title'] . "</span>";
echo "<br>";
echo nl2br($post['text']);
// 在字符串中的所有換行符之前插入 HTML 換行符