<?php
$db = new PDO("mysql:host=db;dbname=obs", "root", "1");
$sql = "DELETE FROM t_exams WHERE student_id=? and lesson_id=? and exam_date=?";
$sonuc = $db->prepare($sql);
$sonuc->execute([htmlspecialchars($_GET['ogrid']),htmlspecialchars($_GET['dersid']),htmlspecialchars($_GET['tarih'])]);
echo "<script>window.location.href = 'sinavlar.php';</script>";
