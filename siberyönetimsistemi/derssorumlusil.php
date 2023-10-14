<?php
$db = new PDO("mysql:host=db;dbname=obs", "root", "1");
$sql = "UPDATE t_lessons SET teacher_user_id=? WHERE teacher_user_id=? and lesson_name=?";
$sonuc = $db->prepare($sql);
$sonuc->execute([null,$_GET['id'],$_GET['ders_bilgi']]);
echo "<script>window.location.href = 'dersler.php';</script>";
