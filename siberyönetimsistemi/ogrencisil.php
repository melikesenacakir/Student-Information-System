<?php
$db = new PDO("mysql:host=db;dbname=obs", "root", "1");

$sql = "DELETE FROM t_classes_students WHERE student_id=?";
$sonuc = $db->prepare($sql);
$sonuc->execute([$_GET['id']]);

$sql = "DELETE FROM t_exams WHERE student_id=?";
$sonuc = $db->prepare($sql);
$sonuc->execute([$_GET['id']]);

$sql = "DELETE FROM t_users WHERE id=?";
$sonuc = $db->prepare($sql);
$sonuc->execute([$_GET['id']]);
echo "<script>window.location.href = 'ogrenciler.php';</script>";
