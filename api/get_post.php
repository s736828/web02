<?php

include_once "../base.php";
$post = $News->find($_GET['id']);
echo "<span style='font-weight:bolder'>" . $post['title'] . "</span>";
echo "<br>";
echo n12br($post['text']);