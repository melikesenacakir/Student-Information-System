<?php
 $db = new PDO("mysql:host=db;dbname=obs", "root", "1");

$sql = "UPDATE t_lessons SET teacher_user_id=? WHERE teacher_user_id=?";
$sonuc = $db->prepare($sql);
$sonuc->execute([null,htmlspecialchars($_GET['id'])]);

$sql = "UPDATE t_classes SET class_teacher_id=? WHERE class_teacher_id=?";
$sonuc = $db->prepare($sql);
$sonuc->execute([null,htmlspecialchars($_GET['id'])]);

$sql = "DELETE FROM t_users WHERE id=?";
$sonuc = $db->prepare($sql);
$sonuc->execute([htmlspecialchars($_GET['id'])]);
echo "<script>window.location.href = 'ogretmenler.php';</script>";
