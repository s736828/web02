<?php include_once "../base.php";
// 存選項vote
$opt = $Que->find($_POST['opt']);
$opt['vote']++;
$Que->save($opt);
// echo "<pre>";
// print_r($opt);
// echo "</pre>";

// 存主題vote
$subject = $Que->find($opt['subject_id']);
$subject['vote']++;
$Que->save($subject);
// echo "<pre>";
// print_r($subject);
// echo "</pre>";

to("../index.php?do=result&id={$subject['id']}");
