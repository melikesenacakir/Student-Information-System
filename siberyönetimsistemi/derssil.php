<?php
$db = new PDO("mysql:host=db;dbname=obs", "root", "1");
if(isset($_GET['sorumlu'])) {
    $sql = "DELETE FROM t_exams WHERE lesson_id=?";
    $sonuc = $db->prepare($sql);
    $sonuc->execute([$_GET['id']]);

    $sql = "DELETE FROM t_lessons WHERE teacher_user_id=? and lesson_name=?";
    $sonuc = $db->prepare($sql);
    $sonuc->execute([$_GET['sorumlu'], $_GET['ders_bilgi']]);
}else{
    $sql = "DELETE FROM t_exams WHERE lesson_id=?";
    $sonuc = $db->prepare($sql);
    $sonuc->execute([$_GET['id']]);

    $sql = "DELETE FROM t_lessons WHERE lesson_name=?";
    $sonuc = $db->prepare($sql);
    $sonuc->execute([$_GET['ders_bilgi']]);
}
echo "<script>window.location.href = 'dersler.php';</script>";
